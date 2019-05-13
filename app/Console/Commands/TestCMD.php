<?php

namespace App\Console\Commands;

use App\Models\Categories;
use App\Models\CategoriesSimilar;
use App\Models\Compares;
use App\Models\Products;
use App\Models\RelatedLinks;
use App\Models\RelatedLinksProducts;
use Illuminate\Console\Command;

class TestCMD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tst:run';

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
        foreach(Compares::all() as $c){
            $p1 = Products::find($c->product_left_id);
            $p2 = Products::find($c->product_right_id);
            $c->slug = str_slug($p1->id.'-'.$p1->title.'-'.$p2->id.'-'.$p2->title);
            $c->save();
            $this->info($c->id);
        }

        $this->info('DONE!');

    }
}
