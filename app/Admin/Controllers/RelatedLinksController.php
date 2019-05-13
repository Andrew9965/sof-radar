<?php

namespace App\Admin\Controllers;

use App\Models\Categories;
use App\Models\Products;
use App\Models\RelatedLinks;

use Illuminate\Support\Facades\Artisan;
use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;
use Lia\Form\Field\Select;

class RelatedLinksController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        /*$test = [];
        foreach (Artisan::all() as $command){
            $test[] = [
                'description' => $command->getDescription(),
                'name' => $command->getName()
            ];
        }

        dump($test);

        $commands = array_keys(Artisan::all());
        dd(Artisan::all(), $commands);*/

        return Admin::content(function (Content $content) {

            $content->header('Related Links');
            $content->description(!request()->category_id ? 'All list' : Categories::find(request()->category_id)->title);

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('Related Links');
            $content->description('edit');

            $content->body($this->form($id)->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('Related Links');
            $content->description('create');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        //dd((new Select('category_id'))->render());
        return Admin::grid(RelatedLinks::class, function (Grid $grid) {
            $grid->addHeaderElement(
                (new Select('category_id'))->attribute(['onchange' => 'location="'.route('related_links.index').'?category_id="+$(this).val()'])->offLabel()->options(
                    Categories::all()->pluck('title', 'id')
                )->default(request()->category_id)->disableHorizontal()->render()
            );

            $grid->addTool('<a href="'.route('categories.index').'" class="btn btn-sm btn-primary"><i class="fa fa-bars"></i>&nbsp;&nbsp;Categories</a>');

            if(request()->category_id){
                $cat = Categories::find(request()->category_id);
                $grid->addTool('<a href="'.route('categories.edit', ['category' => request()->category_id]).'" class="btn btn-sm btn-success" title="Edit category"><i class="fa fa-edit"></i>&nbsp;&nbsp; '.$cat->title.'</a>');
            }

            $grid->id('ID')->sortable();
            $grid->disableFilter();
            $grid->disableExport();

            $grid->title('Название');
            $grid->slug('Подпись');

            $grid->active('Status')->switch([
                'on'  => ['value' => 1, 'text' => 'On', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'Off', 'color' => 'default'],
            ])->sortable();

            $grid->filter(function($filter){
                $filter->like('category_id', 'Category')->select(Categories::all()->pluck('title', 'id'));
            });

            $grid->created_at()->sortable();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id=false)
    {
        return Admin::form(RelatedLinks::class, function (Form $form) use ($id) {

            $form->tab('General', function($form) use ($id){

                if($id) $form->display('id', 'ID');

                $form->text('title', 'Название')->rules('required');
                $form->select('category_id', 'Категория')->options(Categories::where('active',1)->get()->pluck('title', 'id'))->rules('required');
                $form->text('slug', 'Подпись');

                $form->ckeditor('header_description', 'Описание');

                $form->switch('active')->states([
                    'on'  => ['value' => 1, 'text' => 'On', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => 'Off', 'color' => 'danger'],
                ])->default(1);

                if($id) $form->display('created_at', 'Created At');
                if($id) $form->display('updated_at', 'Updated At');

            })->tab('Products', function(Form $form){

                $form->hasMany('products', function (Form\NestedForm $form) {
                    $form->select('p_id', 'Product')->options(Products::all()->pluck('title', 'id'));
                    $form->switch('active')->default(1);
                });

            })->tab('Фильтр', function(Form $form){
                $form->embeds('filter', function ($form) {
                    $form->switch('user_review', 'User Review');
                    $form->switch('business_size', 'Business size');
                    //$form->switch('features', 'Features');
                    $form->switch('deployment', 'Deployment');
                    $form->switch('desktop_client', 'Desktop client');
                    $form->switch('mobile_version', 'Mobile version');
                    $form->switch('price', 'Price');
                });
            })->tab('SEO', function($form){
                $form->text('meta_title')->attribute('onkeyup', '$(\'.meta_auto.la_checkbox\').bootstrapSwitch(\'state\', false)');
                $form->textarea('meta_keywords');
                $form->textarea('meta_description')->attribute('onkeyup', '$(\'.meta_auto.la_checkbox\').bootstrapSwitch(\'state\', false)');
                $form->switch('meta_auto')->states([
                    'on'  => ['value' => 1, 'text' => 'On', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => 'Off', 'color' => 'danger'],
                ])->default(1);
                $form->ckeditor('seo_header_description', 'Контент SEO (в шапке сайта)');
            });

            $form->saving(function (Form $form){
                $title = $form->title;
                $slug = $form->slug;
                if(!is_null($form->title) && !empty($title)){
                    if(empty($slug) && !empty($title)) $form->slug = str_slug($title);
                }
            });
        });
    }
}
