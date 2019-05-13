<?php


if (! function_exists('banner')) {

    function banner($type=false){
        $banner = \App\Models\Banners::where('active', 1);
        if($type) $banner->where('type', $type);
        $obj = $banner->inRandomOrder()->first();
        if(!$obj) return '';
        $obj->show_num +=1;
        $obj->save();
        return "<a href='{$obj->link}' target='{$obj->target}'><img src='{$obj->img}' alt='{$obj->alt}' /></a>";
    }

}