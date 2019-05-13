<?php

namespace App\Admin\Extensions\Nav;

class Links
{
    public function __toString()
    {

        $host = request()->server('HTTP_HOST');
        $prot = request()->server("REQUEST_SCHEME");

        $reviews = \App\Models\Reviews::where('status','0')->whereHas('product')->get();
        $reviews2 = \App\Models\Reviews::where('status','2')->whereHas('product')->get();

        $new = count($reviews) ? "<li><a href=\"/admin/reviews?status=0&_sort%5Bcolumn%5D=created_at&_sort%5Btype%5D=desc\">Новые отзывы <i class=\"fa fa-comments\"></i><span class=\"label label-warning\">".count($reviews)."</span></a></li>" : "";
        $new .= count($reviews2) ? "<li><a href=\"/admin/reviews?status=2&_sort%5Bcolumn%5D=created_at&_sort%5Btype%5D=desc\">Отредактированные отзывы <i class=\"fa fa-comments\"></i><span class=\"label label-warning\">".count($reviews2)."</span></a></li>" : "";
        /*$new .= count($feedback) ? "<li><a href=\"/admin/feedback\"><i class=\"fa fa-feed\"></i><span class=\"label label-warning\">".count($feedback)."</span></a></li>" : "";
        $new .= count($reviews) ? "<li><a href=\"/admin/reviews\"><i class=\"fa fa-wechat\"></i><span class=\"label label-warning\">".count($reviews)."</span></a></li>" : "";*/

        return <<<HTML

{$new}
<!---        
<li>
    <a href="{$prot}://{$host}/" target="_blank">
        <span class="label label-success"></span>
        Web site <i class="fa fa-external-link" aria-hidden="true"></i>
    </a>
</li> --->

HTML;
    }
}