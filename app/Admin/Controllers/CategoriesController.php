<?php

namespace App\Admin\Controllers;

use App\Models\Categories;

use App\Models\CategoriesSimilar;
use App\Models\CategoryType;
use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;

class CategoriesController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        /*foreach (Categories::all() as $cat){
            $cat->type = rand(1,6);
            $cat->save();
        }*/

        return Admin::content(function (Content $content) {

            $content->header('Категории');
            $content->description('список');

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

            $content->header('Категории');
            $content->description('редактировать');

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

            $content->header('Категории');
            $content->description('добавить');

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
        return Admin::grid(Categories::class, function (Grid $grid) {

            $grid->disableFilter();
            $grid->disableExport();

            $grid->id('ID')->sortable();

            $grid->img('Изображение')->display(function ($img) {
                return "<img src='".$img."' width='50px' />";
            })->sortable();

            $grid->title('Название');
            //$grid->slug('Подпись');

            $grid->column('slug', 'Подпись')->display(function($slug){
                return '<a href="'.route('category', ['categories' => $slug]).'" target="_blank">'.$slug.' <i class="fa fa-external-link"></i></a>';
            });

            $grid->home('Приоритет')->switch([
                'on'  => ['value' => 1, 'text' => 'Yes', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'No', 'color' => 'default'],
            ])->sortable();

            $grid->active('Status')->switch([
                'on'  => ['value' => 1, 'text' => 'On', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'Off', 'color' => 'default'],
            ])->sortable();


            $grid->actions(function($actions){
               $actions->append("<a href='".route('related_links.index', ['category_id' => $actions->getKey()])."' class=\"btn btn-success btn-xs\" title='Related Links'><i class='fa fa-link'></i></a>");
            });


            $grid->created_at()->sortable();
            $grid->updated_at()->sortable();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id=false)
    {
        return Admin::form(Categories::class, function (Form $form) use ($id) {

            if($id) $form->setAction(route('categories.update', ['category' => $id]));
            else $form->setAction(route('categories.store'));

            $form->tab('General', function($form){
                $form->display('id', 'ID');

                $form->text('title', 'Название')->rules('required');
                $types = CategoryType::where('active',1)->get()->pluck('title', 'id')->toArray();
                $form->select('type', 'Классификация категории')->options($types)->rules('required')->default(array_first(array_keys($types)));
                $form->text('slug', 'Подпись');

                $form->image('img', 'Изображение категории');

                $form->ckeditor('header_description', 'Описание')->rules('required');

                $form->switch('home', 'Приоритет')->states([
                    'on'  => ['value' => 1, 'text' => 'Yes', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => 'No', 'color' => 'danger'],
                ])->default(0);

                $form->switch('active')->states([
                    'on'  => ['value' => 1, 'text' => 'On', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => 'Off', 'color' => 'danger'],
                ])->default(1);

                $form->display('created_at', 'Created At');
                $form->display('updated_at', 'Updated At');
            })->tab('Похожие категории', function(Form $form){

                $form->hasMany('similar', '', function (Form\NestedForm $form) {
                    $form->select('category_id', 'Категория')->options(Categories::all()->pluck('title', 'id'));
                });

            })->tab('Функциональные особенности', function($form){
                $form->hasMany('categories_ff', 'List', function (Form\NestedForm $form) {
                    $form->text('title')->rules('required');
                });
            })/*->tab('Фильтр', function(Form $form){
                $form->embeds('filter', function ($form) {
                    $form->switch('user_review', 'User Review')->attribute('onchange', '$(\'.filter_auto.la_checkbox\').bootstrapSwitch(\'state\', false)');
                    $form->switch('business_size', 'Business size')->attribute('onchange', '$(\'.filter_auto.la_checkbox\').bootstrapSwitch(\'state\', false)');
                    $form->switch('features', 'Features')->attribute('onchange', '$(\'.filter_auto.la_checkbox\').bootstrapSwitch(\'state\', false)');
                    $form->switch('deployment', 'Deployment')->attribute('onchange', '$(\'.filter_auto.la_checkbox\').bootstrapSwitch(\'state\', false)');
                    $form->switch('desktop_client', 'Desktop client')->attribute('onchange', '$(\'.filter_auto.la_checkbox\').bootstrapSwitch(\'state\', false)');
                    $form->switch('mobile_version', 'Mobile version')->attribute('onchange', '$(\'.filter_auto.la_checkbox\').bootstrapSwitch(\'state\', false)');
                    $form->switch('price', 'Price')->attribute('onchange', '$(\'.filter_auto.la_checkbox\').bootstrapSwitch(\'state\', false)');
                });

                $form->switch('filter_auto')->states([
                    'on'  => ['value' => 1, 'text' => 'On', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => 'Off', 'color' => 'danger'],
                ])->default(1);

            })*/->tab('SEO', function($form){
                $form->text('meta_title')->attribute('onkeyup', '$(\'.meta_auto.la_checkbox\').bootstrapSwitch(\'state\', false)');
                $form->textarea('meta_keywords');
                $form->textarea('meta_description')->attribute('onkeyup', '$(\'.meta_auto.la_checkbox\').bootstrapSwitch(\'state\', false)');
                $form->switch('meta_auto')->states([
                    'on'  => ['value' => 1, 'text' => 'On', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => 'Off', 'color' => 'danger'],
                ])->default(1);
                $form->ckeditor('seo_header_description', 'Контент SEO (в шапке сайта)');
            });

            if($id) $form->tools(function(Form\Tools $tools) use ($id){

                $rl_link = route('related_links.index', ['category_id' => $id]);

                $tools_btn = <<<EOT
<div class="btn-group pull-right" style="margin-right: 10px">
    <a href="$rl_link" class="btn btn-sm btn-primary"><i class="fa fa-link"></i>&nbsp;&nbsp;Related Links</a>
</div>
EOT;
                $tools->add($tools_btn);
            });

            $form->saving(function (Form $form){
                $title = $form->title;
                $slug = $form->slug;
                if(!is_null($form->title) && !empty($title)){
                    if(empty($slug) && !empty($title)) $form->slug = str_slug($title);
                }
            });

            $form->saved(function (Form $form) {
                //dd($form->model()->id, $form->similar);
                $parent_id = $form->model()->id;
                if(count($form->similar)){
                    foreach($form->similar as $s){
                        $test = CategoriesSimilar::where('parent_id', $s['category_id'])->where('category_id', $parent_id)->first();
                        if($test){
                           if($s['_remove_']!='0') $test->delete();
                        }else{
                            CategoriesSimilar::create([
                                'parent_id' => $s['category_id'],
                                'category_id' => $parent_id
                            ]);
                        }
                    }
                }
            });
        });
    }
}
