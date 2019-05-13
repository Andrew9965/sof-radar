<?php

namespace App\Admin\Controllers;

use App\Models\Categories;
use App\Models\Compares;

use App\Models\Products;
use Lia\Auth\Database\Administrator;
use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;

class ComparesController extends Controller
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

            $content->header('Срвнения');
            $content->description('list');

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

            $content->header('Срвнения');
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

            $content->header('Срвнения');
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

        $categories = Categories::all();
        $products = Products::all();

        return Admin::grid(Compares::class, function (Grid $grid) use ($categories, $products) {
            $grid->model()->whereHas('category')->whereHas('left')->whereHas('right');
            $grid->disableExport();
            $grid->disableFilter();
            $grid->disableCreation();

            $grid->column('category_id', 'Category')->display(function($id) use ($categories){
                return $categories->firstWhere('id', $id)->title;
            })->sortable();

            //$grid->category_id('Category')->editable('select', $categories->pluck('title', 'id'));

            $grid->column('product_left_id', 'Product 1')->display(function($id) use ($products){
                return $products->firstWhere('id', $id)->title;
            })->sortable();

            $grid->column('vs')->display(function(){ return 'VS'; });

            $grid->column('product_right_id', 'Product 2')->display(function($id) use ($products){
                return $products->firstWhere('id', $id)->title;
            })->sortable();

            $grid->id('ID')->sortable();

            $grid->created_at()->sortable();

            $grid->filter(function($filter) use ($products, $categories){
                $filter->equal('category_id', 'Category')->select($categories->pluck('title', 'id'));
                $filter->equal('product_left_id', 'Product 1')->select($products->pluck('title', 'id'));
                $filter->equal('product_right_id', 'Product 2')->select($products->pluck('title', 'id'));
            });

            $grid->actions(function ($actions){
                $actions->append('<a href="'.route('compare', ['compare' => Compares::find($actions->getKey())->slug]).'" target="_blank" class="btn btn-success btn-xs"><i class="fa fa-link"></i></a>');
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
        $categories = Categories::all();
        $products = Products::all();
        $users = Administrator::all();

        //elixir();

        return Admin::form(Compares::class, function (Form $form) use ($categories, $products, $users, $id) {

            $form->tab('General', function(Form $form) use ($categories, $products, $users, $id){
                if($id) $form->display('id', 'ID');

                $form->text('slug');

                $form->select('user_id')->options($users->pluck('username', 'id'));
                $form->select('category_id')->options($categories->pluck('title', 'id'));
                $form->select('product_left_id')->options($products->pluck('title', 'id'));
                $form->select('product_right_id')->options($products->pluck('title', 'id'));

                if($id) $form->display('created_at', 'Created At');
                if($id) $form->display('updated_at', 'Updated At');
            })->tab('SEO', function(Form $form){

                $form->text('meta_title')->attribute('onkeyup', '$(\'.meta_auto.la_checkbox\').bootstrapSwitch(\'state\', false)');
                $form->textarea('meta_keywords');
                $form->textarea('meta_description')->attribute('onkeyup', '$(\'.meta_auto.la_checkbox\').bootstrapSwitch(\'state\', false)');

                $form->switch('meta_auto')->states([
                    'on'  => ['value' => 1, 'text' => 'On', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => 'Off', 'color' => 'danger'],
                ])->default(1);

            });
        });
    }
}
