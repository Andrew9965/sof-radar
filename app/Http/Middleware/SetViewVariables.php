<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class SetViewVariables
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        $user = $this->auth->user();
        $useds = collect([]);
        if($user) $useds = collect($user->uses);
        $products = collect(\App\Models\Products::where('active', 1)->get());
        $product_categories = [];
        foreach ($products as $product){
            foreach ($product->categories as $cat) $product_categories[] = [
                'category_id' => $cat,
                'product' => $product
            ];
        }
        //dd($product_categories);

        view()->share([
            'categories' => collect(\App\Models\Categories::where('active', 1)->where('count', '!=', 0)->with('categories_ff')->get()),
            //'products' => collect(),
            'product_categories' => collect($product_categories),
            'used' => $useds,
            'params_after_auth' => session('params_after_auth')
        ]);

        return $next($request);
    }

}