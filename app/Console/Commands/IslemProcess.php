<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Uyeler;

class IslemProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'islem:process {tur}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->line('İşlem başatılıyor...');
        $this->newLine(5);
        $this->line('İşlem başatılıyor...');
        echo 'test';
        exit;
        $name = $this->choice(
            'What is your name?',
            ['Taylor', 'Dayle'],
            0,
            3,
            true
        );

        print_r($name);

        exit;

        $name = $this->anticipate('What is your name?', ['Taylor', 'Dayle']);

        $this->info("Adınız: $name");

        exit;

        $onay = $this->confirm('İşlemi onaylıyor musunuz?', true);

        if ($onay)
        {
            $this->info('İşlem onaylandı');
        }
        else
            $this->error('İşlem reddedildi');

        exit;

        $name = $this->ask('Adınız nedir?');

        if ($name)
        {
            $this->info("Tanıştığıma memnun oldum $name");

            $sifre = $this->secret('Şifrenizi girer misiniz?');

            $this->info("Girdiğiniz şifre: $sifre");
        }
        else
            $this->error('İsim zorunludur.');

        exit;

        // $this->info($this->option('tur'));
        $this->info($this->argument('tur'));

        switch ($this->argument('tur')) {
            case 'x':
            $this->info('x türüne başlandı.');
                break;
            
            default:
            $this->info('başka türüne başlandı.');
                break;
        }

        exit;

        $this->table(
            ['Name', 'Email'],
            [
                [ 'Alper', 'alper@alper.com' ]
            ]
        );

        // Progress işlemi
        // $uyeler = Uyeler::all();

        // $bar = $this->output->createProgressBar(count($uyeler));
         
        // $bar->start();

        // foreach ($uyeler as $user) {
        //     // $this->performTask($user);

        //     $bar->advance();
        // }

        // $bar->finish();
    }
}
