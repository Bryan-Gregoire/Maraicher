<?php

namespace App\Console\Commands;

use App\Models\Offer;
use Illuminate\Console\Command;

class ClearExpiredOffersFromDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:clearExpiredOffers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     *
     */
    public function handle()
    {
        Offer::where('expirationDate', '<', today())->delete();
    }
}
