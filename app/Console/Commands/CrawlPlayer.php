<?php

namespace App\Console\Commands;

use App\Http\Controllers\PlayerController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CrawlPlayer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:crawlPlayer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl one player from pesmaster.com';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        for ($i = 0; $i < 1000; $i++) {
//            sleep(5);
            Log::info('Start crawler!');
            $player = app(PlayerController::class)->crawl();
            if ($player) {
                Log::info('Crawled id = ' . $player->id . ', ' . $player->full_name_default .' as ' . $player->full_name_web . '!');
            } else {
                Log::info('Player not found!');
            }
        }
    }
}
