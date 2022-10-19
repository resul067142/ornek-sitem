<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Domain;
use App\Jobs\NewsDetectorJob;
use DB;

class NewsDetector extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:detector';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Haber sitelerine girer ve haber linklerini tespit eder.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $domains = Domain::where(
            'control_date',
            '<=',
            DB::raw("NOW() - INTERVAL '1 minutes' * control_interval")
        )->get();

        if (!count($domains))
        {
            $this->error('Kontrol zamanı gelmiş domain bulunamadı.');
            return false;
        }

        foreach ($domains as $domain)
        {
            $domain->update(['control_date' => now()]);

            $this->info($domain->domain.' istek gönderildi.');

            NewsDetectorJob::dispatch($domain->domain)->onQueue('news-detectors');
        }
    }
}
