<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CalculateStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Пересчет статистики';

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
        foreach (\App\Models\Products::where('active',1)->with('reviews')->get() as $product){
            $save = false;
            $rev_count = 0;
            $easy_of_use = 0;
            $functionality = 0;
            $product_quality = 0;
            $customer_support = 0;
            $value_for_money = 0;
            foreach ($product->reviews as $review){
                $easy_of_use += $review->easy_of_use;
                $functionality += $review->functionality;
                $product_quality += $review->product_quality;
                $customer_support += $review->customer_support;
                $value_for_money += $review->value_for_money;
                $rev_count++;
            }
            $total_all = $easy_of_use+$functionality+$product_quality+$customer_support+$value_for_money;
            $total_all_isset = $product->easy_of_use+$product->functionality+$product->product_quality+$product->customer_support+$product->value_for_money;
            $rait_total = $rev_count ? ($total_all/$rev_count)/5 : 0;
            if($total_all!=$total_all_isset) {
                $product->easy_of_use = $easy_of_use;
                $product->functionality = $functionality;
                $product->product_quality = $product_quality;
                $product->customer_support = $customer_support;
                $product->value_for_money = $value_for_money;
                $product->review_count = $rev_count;
                $product->review_rait_total = $rait_total;
                $save = true;
            }
            if(isset($product->categories[1]) && $product->categories[1]!=$product->category_1){
                $product->category_1 = $product->categories[1];
                $save = true;
            }
            if(isset($product->categories[2]) && $product->categories[2]!=$product->category_2){
                $product->category_2 = $product->categories[2];
                $save = true;
            }
            if(isset($product->categories[3]) && $product->categories[3]!=$product->category_3){
                $product->category_3 = $product->categories[3];
                $save = true;
            }
            if($product->business_size != $product->details['business_size']){
                $product->business_size = $product->details['business_size'];
                $save = true;
            }
            if($product->deployment != $product->details['deployment']){
                $product->deployment = $product->details['deployment'];
                $save = true;
            }
            if($product->desc_client != $product->details['desc_client']){
                $product->desc_client = $product->details['desc_client'];
                $save = true;
            }

            if($product->mobile_version != $product->details['mobile_version']){
                $product->mobile_version = $product->details['mobile_version'];
                $save = true;
            }

            if(isset($product->pricing['starting_price']['price']) && $product->pricing['starting_price']['price'] != $product->pricing_starting_price){
                $product->pricing_starting_price = $product->pricing['starting_price']['price'];
                $save = true;
            }

            if(isset($product->pricing['starting_price']['onsubmit']) && $product->pricing['starting_price']['onsubmit'] != $product->pricing_starting_price_onsubmit){
                $product->pricing_starting_price_onsubmit = $product->pricing['starting_price']['onsubmit'];
                $save = true;
            }

            if(isset($product->pricing['starting_price']['link']) && $product->pricing['starting_price']['link'] != $product->pricing_starting_price_link){
                $product->pricing_starting_price_link = $product->pricing['starting_price']['link'];
                $save = true;
            }

            if(isset($product->pricing['pricing_model']) && $product->pricing['pricing_model'] != $product->pricing_pricing_model){
                $product->pricing_pricing_model = $product->pricing['pricing_model'];
                $save = true;
            }

            if(isset($product->pricing['training']) && $product->pricing['training'] != $product->pricing_training){
                $product->pricing_training = $product->pricing['training'];
                $save = true;
            }

            if(isset($product->pricing['license_price']['price']) && $product->pricing['license_price']['price'] != $product->pricing_license_price){
                $product->pricing_license_price = $product->pricing['license_price']['price'];
                $save = true;
            }

            if(isset($product->pricing['license_price']['onsubmit']) && $product->pricing['license_price']['onsubmit'] != $product->pricing_license_price_onsubmit){
                $product->pricing_license_price_onsubmit = $product->pricing['license_price']['onsubmit'];
                $save = true;
            }

            if(isset($product->pricing['license_price']['link']) && $product->pricing['license_price']['link'] != $product->pricing_license_price_link){
                $product->pricing_license_price_link = $product->pricing['license_price']['link'];
                $save = true;
            }

            if(isset($product->pricing['free_trial']['active']) && $product->pricing['free_trial']['active'] != $product->pricing_free_trial_active){
                $product->pricing_free_trial_active = $product->pricing['free_trial']['active'];
                $save = true;
            }

            if(isset($product->pricing['free_trial']['link']) && $product->pricing['free_trial']['link'] != $product->pricing_free_trial_link){
                $product->pricing_free_trial_link = $product->pricing['free_trial']['link'];
                $save = true;
            }


            if($product->meta_title!=$product->title && !empty($product->title) && $product->meta_auto){
                $product->meta_title = $product->title;
                $save = true;
            }
            if($product->meta_description!=strip_tags($product->short_description) && !empty($product->short_description) && $product->meta_auto){
                $product->meta_description = strip_tags($product->short_description);
                $save = true;
            }
            if($save) $product->save();
        }

        foreach(\App\Models\Categories::all() as $cat){
            $save = false;
            if($cat->meta_description!=strip_tags($cat->header_description) && ! empty($cat->header_description) && $cat->meta_auto){
                $cat->meta_description = strip_tags($cat->header_description);
                $save = true;
            }
            if($cat->meta_title!=strip_tags($cat->title) && !empty($cat->title) && $cat->meta_auto){
                $cat->meta_title = strip_tags($cat->title);
                $save = true;
            }
            $count = $cat->prods_1->count()+$cat->prods_2->count()+$cat->prods_3->count();
            if($cat->count!=$count){
                $cat->count=$count;
                $save = true;
            }
            if($save) $cat->save();
        }

        foreach(\App\Models\Reviews::all() as $rev){
            $save = false;
            if($rev->meta_description!=strip_tags($rev->comment) && ! empty($rev->comment) && $rev->meta_auto){
                $rev->meta_description = strip_tags($rev->comment);
                $save = true;
            }
            if($rev->meta_title!=strip_tags($rev->headline) && !empty($rev->headline) && $rev->meta_auto){
                $rev->meta_title = strip_tags($rev->headline);
                $save = true;
            }
            if($save) $rev->save();
        }

        foreach(\App\Models\RelatedLinks::all() as $rl){
            $save = false;
            if($rl->meta_description!=strip_tags($rl->header_description) && ! empty($rl->header_description) && $rl->meta_auto){
                $rl->meta_description = strip_tags($rl->header_description);
                $save = true;
            }
            if($rl->meta_title!=strip_tags($rl->title) && !empty($rl->title) && $rl->meta_auto){
                $rl->meta_title = strip_tags($rl->title);
                $save = true;
            }
            if($save) $rl->save();
        }

        foreach(\App\Models\Compares::where('meta_auto', 1)->get() as $cm){
            $save = false;
            if(empty($cm->meta_title) && $cm->meta_auto){
                $cm->meta_title = $cm->left->title . ' vs ' . $cm->right->title;
                $save = true;
            }
            if($save) $cm->save();
        }

        //\Artisan::call('filter:find');

        $this->info('Done!');
    }
}
