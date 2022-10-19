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

class NewsTakerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $news;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(News $news)
    {
        $this->news = $news;
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
        ])->get($this->news->url);

        $saw = new nokogiri($http->body());

        $this->news->title = $saw->get('h1')->toText();

        if (strlen($this->news->title) >= 200)
        {
            $this->news->title = null;
        }

        $schema = preg_match_all("/(?<=<script type=\"application\/ld\+json\">)(.*?)(?=<\/script>)/s", $http->body(), $matched);
        $schema = @$matched[0];

        if (!$matched[0] && count($matched[0]) < 1)
        {
            // bu sitenin schema.org yapısı yok
        }

        $schema = array_map(function($item) {
            $item = json_decode(Str::endsWith($item, ';') ? Str::replaceLast(';', '', $item) : $item);

            return $item->articleBody ?? null;
        }, $schema);

        $schema = array_filter($schema);
        $schema = @array_values($schema)[0];

        if (!$schema)
        {
            $schema = @$saw->get('meta[property=og:description]')->toArray()[0]['content'];
        }

        if (!$schema)
        {
            $schema = @$saw->get('meta[property=twitter:description]')->toArray()[0]['content'];
        }

        if (!$schema)
        {
            $schema = @$saw->get('meta[name=description]')->toArray()[0]['content'];
        }

        if (!$schema)
        {
            $schema = $saw->get('p')->toText();
        }

        $this->news->body = $schema;

        $image = @$saw->get('meta[property=og:image]')->toArray()[0]['content'];
        $image = $image ?? @$saw->get('meta[property=twitter:image]')->toArray()[0]['content'];
        $image = $image ?? @$saw->get('link[rel=image_src]')->toArray()[0]['href'];

        $this->news->image = $image;

        $this->news->status = $this->news->title && $this->news->body ? 'ok' : 'fail';

        $this->news->save();
    }
}
