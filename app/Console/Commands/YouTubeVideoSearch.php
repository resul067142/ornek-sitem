<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Alaouy\Youtube\Facades\Youtube;

class YouTubeVideoSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:video:search {--keyword=}? {--video_id=}?';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Youtube üzerinden video arar.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $keyword = $this->option('keyword');
        $video_id = $this->option('video_id');

        if ($keyword)
            $results = Youtube::search($keyword, 2);
        else if ($video_id)
            $results = Youtube::getCommentThreadsByVideoId($video_id, 2);
        else
            $results = Youtube::getPopularVideos('tr', 2);

        foreach ($results as $item)
        {
            print_r($item);
        }
    }
}
