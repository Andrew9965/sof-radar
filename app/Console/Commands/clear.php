<?php

namespace App\Console\Commands;

use App\Models\RelatedLinks;
use Illuminate\Console\Command;

class clear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xs:clear';

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
     * @return mixed
     */
    public function handle()
    {
        foreach(RelatedLinks::with('category')->get() as $r){
            if(is_null($r->category)) {
                $this->info($r->id. ' - Remove!');
                $r->delete();
            }
        }
    }
}
