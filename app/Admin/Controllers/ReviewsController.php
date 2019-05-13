<?php

namespace App\Admin\Controllers;

use App\Models\Products;
use App\Models\Reviews;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;

class ReviewsController extends Controller
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

            $content->header('Отзывы');
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

            $content->header('Отзывы');
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

            $content->header('Отзывы');
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
        $users = collect(\App\User::all());
        $prods = collect(Products::all());
        return Admin::grid(Reviews::class, function (Grid $grid) use ($users, $prods) {
            $grid->model()->whereHas('product');

            $grid->disableExport();

            $grid->id('ID')->sortable();

            $grid->column('user_id', 'Пользователь')->display(function($id) use ($users){
                if($id) return $users->where('id', $id)->first()->name;
                else 'none';
            });

            $grid->column('product_id', 'Product')->display(function($id) use ($prods){
                $p = $prods->where('id', $id)->first();
                $return = '<a href="'.route('product', ['product' => $p->slug]).'" target="_blank">'.$p->title.' <i class="fa fa-external-link"></i></a>';
                return $return;
            });

            $grid->headline()->sortable();
            $grid->column('status')->select([
                -1    => 'Bead',
                2     => 'Updated by the user',
                1     => 'Public',
                0     => 'New'
            ])->sortable();
            $grid->created_at()->sortable();

            $grid->filter(function($filter) use ($prods){
                $filter->equal('product_id', 'Продукт')->select($prods->pluck('title', 'id'));
                $filter->equal('status', 'Статус')->select(['-1' => 'Bead', '2' => 'Updated by the user', '1' => 'Public', '0' => 'New']);
            });

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $r = Reviews::find($actions->getKey());
                $actions->append('<div class="btn-group">');
                $actions->append(' <a href="'.route('product.review', ['product' => $r->product->slug, 'review' => $actions->getKey()]).'" title="News" class="btn btn-success btn-xs" target="_blank"><i class="fa fa-external-link"></i></a> ');
                $actions->append('</div>');
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
        return Admin::form(Reviews::class, function (Form $form) use ($id) {
            $form->tab('General', function(Form $form) use ($id){

                if($id) $edit = Reviews::find($id);
                if($id) $form->display('id', 'ID');
                if($id) $form->display('', 'Программа')->default('<a href="'.route('product', ['product' => $edit->slug]).'" target="_blank">'.\App\Models\Products::find($edit->product_id)->title.'</a>');
                $form->select('user_id', 'Пользователь')->options(\App\User::all()->pluck('name', 'id'));

                $form->text('headline', 'Заголовок')->rules('required');
                $form->text('used', 'Используется')->rules('required');
                $form->number('easy_of_use', 'Easy of use')->attribute(['max' => 5, 'min' => 1])->default(1);
                $form->number('functionality', 'Functionality')->attribute(['max' => 5, 'min' => 1])->default(1);
                $form->number('product_quality', 'Product quality')->attribute(['max' => 5, 'min' => 1])->default(1);
                $form->number('customer_support', 'Customer support')->attribute(['max' => 5, 'min' => 1])->default(1);
                $form->number('value_for_money', 'Value for money')->attribute(['max' => 5, 'min' => 1])->default(1);

                $form->textarea('like_best', 'Like best')->rules('required');
                $form->textarea('like_least', 'Like least')->rules('required');
                $form->textarea('comment', 'Comment')->rules('required');

                $form->number('like')->attribute(['min' => 1]);
                $form->number('dislike')->attribute(['min' => 1]);
                $form->select('status')->options([
                    -1    => 'Bead',
                    2     => 'Updated by the user',
                    1     => 'Public',
                    0     => 'New'
                ])->rules('required');

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
