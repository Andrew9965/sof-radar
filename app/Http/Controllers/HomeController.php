<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        /*$routes = \Route::getRoutes();
        $ro = [];
        $test = [];
        foreach ($routes as $route){
            if($route->getName()){
                $sort = $route->getAction()['namespace'];
                $middle = isset($route->getAction()['middleware']) ? implode('.', $route->getAction()['middleware']) : 'none';
                $ro[$sort][$middle][$route->getName()]['name'] = $route->getName();
                $ro[$sort][$middle][$route->getName()]['uri'] = $route->uri();
                $ro[$sort][$middle][$route->getName()]['methods'] = $route->methods();
                $ro[$sort][$middle][$route->getName()]['prefix'] = $route->getPrefix();
                $ro[$sort][$middle][$route->getName()]['actionName'] = $route->getActionName();
                $ro[$sort][$middle][$route->getName()]['actionMethod'] = $route->getActionMethod();
                $ro[$sort][$middle][$route->getName()]['action'] = $route->getAction();
            }
        }*/


        $categories = collect(\App\Models\Categories::where('active',1)->where('count', '!=', 0)->get());
        $top_categories = \App\Models\Categories::where('home', 1)->where('active', 1)->where('count', '!=', 0)->orderby('count', 'desc')->get();

        $cats = [];
        $iteration = 0;
        foreach ($top_categories as $cat){
            if(!isset($cats[$iteration]))
                $cats[$iteration][] = $cat;
            elseif (count($cats[$iteration]) < 4)
                $cats[$iteration][] = $cat;
            else
                $cats[++$iteration][] = $cat;

        }

        $top_soft = \App\Models\Products::where('active', 1)->where('top',1)->orderby('review_rait_total', 'desc')->take(8)->get();
        if($request->dump) dd($top_soft->toArray());

        return view('home', [
            'top_categories' => $cats,
            'top_soft' => $top_soft,
            'categories' => $categories
        ]);
    }

    public function test()
    {
        \Artisan::call('filter:find');
    }
}
