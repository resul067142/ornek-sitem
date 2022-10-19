<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use nokogiri;
use App\Models\News;

class NewsDetectorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $domain;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $http = Http::withHeaders([
            'User-Agent' => Arr::random(config('crawler.user_agents')),
            // 'proxy' => '110.238.74.184:8080'
        ])->get($this->domain);

        $saw = new nokogiri($http->body());

        $items = array_map(function($item) {
            $href = @$item['href'];

            if (Str::contains($href, ['javascript:', 'foo']))
                return false;

            if (!$href)
                return false;

            $href = str_replace([ 'https', 'http', '://', 'www.' ], '', $href);

            if (strlen($href) < 20)
                return false;

            if (Str::contains($href, '.'.$this->domain))
                return false;
            else if (Str::contains($href, '.'))
                return false;
            else
                $href = Str::start($href, $this->domain);

            return $href;
        }, $saw->get('a')->toArray());

        $items = array_unique($items);
        $items = array_filter($items);
        $items = array_values($items);

        $items = array_map(function($item) {
            return [
                'url' => $item,
                'hash' => md5($item)
            ];
        }, $items);

        News::upsert(
            $items,
            [
                'hash'
            ]
        );
    }
}
