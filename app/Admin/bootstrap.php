<?php
use Lia\Form;
use App\Admin\Extensions\Form\CKEditor;

use Lia\Facades\Admin;

/*if(env('APP_DEBUG'))
    Admin::js('packages/webix/codebase/webix_debug.js');
else
    Admin::js('packages/webix/codebase/webix.js');

Admin::js('packages/jquery.steps.min.js');

Admin::css('packages/webix/codebase/webix.css');
Admin::css('packages/webix/codebase/skins/web.css');
Admin::css('packages/jquery.steps.css');*/

$routeCollection = \Route::getRoutes(); $routes = []; foreach ($routeCollection as $value) { if(!empty($value->getName())) $routes[$value->getName()] = str_replace('?','',$value->uri()); }
$routes = json_encode($routes);

$script = <<<EOT
var routList = {$routes};
EOT;

Admin::script($script);

Admin::js('packages/forms/productMasterForm.js');


Lia\Form::forget(['map', 'editor']);
Form::extend('ckeditor', CKEditor::class);

Admin::navbar(function (\Lia\Widgets\Navbar $navbar) {
    $navbar->right(new \App\Admin\Extensions\Nav\Links());
});