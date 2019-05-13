<?php

namespace App\Admin\Controllers;

use App\Models\Pages;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;

class PagesController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Страницы');
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

            $content->header('Страницы');
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

            $content->header('Страницы');
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
        return Admin::grid(Pages::class, function (Grid $grid) {

            $grid->disableExport();
            $grid->disableFilter();

            $grid->id('ID')->sortable();

            $grid->name('Название')->sortable();
            $grid->column('rout_name', 'Страница')->display(function($name){
                if($name=='0') return 'Dynamic page';
                else return $name;
            })->sortable();

            $grid->created_at()->sortable();
            $grid->updated_at()->sortable();

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if ($actions->getKey() == 1) {
                    $actions->disableDelete();
                }
                $page = Pages::find($actions->getKey());
                if($page->rout_name=='0')
                    $actions->append('<a href="'.route('page', ['page' => $page->uri]).'" class="btn btn-xs btn-success" target="_blank"><i class="fa fa-external-link"></i></a>');
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id=false)
    {
        return Admin::form(Pages::class, function (Form $form) use ( $id ) {

            $form->tab('General', function($form) use ($id){

                $form->text('name', 'Название');

                $form->select('rout_name', 'Страница')->options(function ($id) {
                    $return = [0 => 'Dynamic page'];
                    foreach (array_reverse(app()->routes->getRoutes()) as $route) {
                        if($route->methods()[0]=='GET')
                            $return[$route->getName()] = '[' . $route->getName() . '] ' . $route->uri();
                    }

                    return $return;
                })->rules('required')->default('0');

                if(!$id || $id && Pages::find($id)->rout_name=='0')
                    $form->text('uri', 'Slug');

                $form->display('created_at', 'Created At');
                $form->display('updated_at', 'Updated At');

            });

            if(!$id || $id && Pages::find($id)->rout_name=='0')
                $form->tab('Template', function(Form $form) use ( $id ){

                    $data = '';
                    if($id) {
                        $page = Pages::find($id);
                        $relPath = resource_path('/views/dynamic_pages/'.$page->uri.'.blade.php');
                        if(is_file($relPath))
                            $data = \File::get($relPath);
                    }

                    $form->ckeditor('shape', 'Файл')->default($data);
                });

            $form->tab('SEO', function($form){

                $form->text('meta_title');
                $form->textarea('meta_keywords');
                $form->textarea('meta_description');

            });

            $form->ignore('shape');

            $form->saving(function (Form $form) {
                $form->model()->uri = $slug = empty(request()->uri) ? str_slug(request()->name) : str_slug(request()->uri);
                $relPath = resource_path('/views/dynamic_pages/'.$slug.'.blade.php');
                file_put_contents($relPath, str_replace(['&#39;'],["'"],htmlspecialchars_decode(request()->shape)));
            });

            /*->tab('Дополнительные атрибуты', function($form){
                $form->hasMany('additional_attributes', function (Form\NestedForm $form) {
                    $form->select('property')->options([
                        'og:title' => 'og:title',
                        'og:type' => 'og:type',
                        'og:image' => 'og:image',
                        'og:url' => 'og:url',
                        'og:locale' => 'og:locale',
                        'og:description' => 'og:description',
                        'og:site_name' => 'og:site_name'
                    ])->rules('required');
                    $form->textarea('content')->rules('required');
                });
            });*/
        });
    }
}
