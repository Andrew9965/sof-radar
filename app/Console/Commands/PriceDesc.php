<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PriceDesc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'go:desc';

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
        $faker = \Faker\Factory::create();

        foreach(\App\Models\Products::all() as $prod){
            $prod->pricing_desc = $faker->text(rand(200,500));
            $prod->save();
            $this->line($prod->id.' - Save!');
        }
        $this->line('Done!');
    }
}
