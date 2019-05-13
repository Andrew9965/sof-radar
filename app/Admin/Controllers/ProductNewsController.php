<?php

namespace App\Admin\Controllers;

use App\Models\ProductNews;
use App\Models\Products;

use Lia\Widgets\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;
use Lia\Layout\Row;
use Lia\Widgets\Box;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class ProductNewsController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Products $product, ProductNews $productNews)
    {
        return Admin::content(function (Content $content) use ($product, $productNews) {
            $content->header('Новости продукта');
            $content->description($product->title);
            $content->row(function(Row $row) use ($product, $productNews) {
                $row->column(6, $this->grid($product, $productNews));
                $row->column(6, $this->form($product, $productNews));
            });
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

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
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

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid($product, $productNews)
    {
        return Admin::grid(ProductNews::class, function (Grid $grid) use ($product, $productNews) {
            $grid->model()->where('product_id', $product->id);
            $grid->disableCreateButton();
            $grid->disableFilter();
            $grid->disableExport();

            $grid->id('ID')->sortable();

            $grid->title()->sortable();

            $grid->active()->switch();

            $grid->actions(function (Grid\Displayers\Actions $actions) use ($product) {
                $actions->setResource(route('admin.product.news.delete', ['product' => $product->slug, 'product_news' => '']));
                $actions->disableEdit();

                $actions->append('<div class="btn-group" style="min-width: 50px;">');
                $actions->append('<a href="'.route('admin.product.news', ['product' => $product->slug, 'product_new' => $actions->getKey()]).'" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>');
                $actions->append('</div>');
            });

            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($product, $productNews)
    {
        $form = new Form($productNews);
        $form->action(route('admin.product.news.post', ['product' => $product->slug, 'product_new' => $productNews->id]));

        if($productNews->id)
            $form->display('id', 'ID');

        $form->hidden('product_id')->default($product->id);
        $form->hidden('_token')->default(csrf_token());

        $form->text('title');
        $form->ckeditor('text', 'Short description')->disableHorizontal();
        $form->ckeditor('description', 'Description')->disableHorizontal();

        $form->switch('active')->default(1);

        if($productNews->id){
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        }

        $box = (new Box($productNews->id ? 'Edit "'.$productNews->title.'"' : 'New', $form->render()))->style('info');
        return $box;
    }

    public function save(Products $product, ProductNews $productNews, Request $request)
    {
        $data = $request->all();
        $data['active'] = $data['active']=='on' ? 1 : 0;

        if(ProductNews::updateOrCreate(['id' => $productNews->id ? $productNews->id : 0], $data)) {
            $success = new MessageBag([
                'title' => 'Success!',
            ]);
            return redirect()->route('admin.product.news', ['product' => $product->slug])->with(compact('success'));
        }else{
            $error = new MessageBag([
                'title'   => 'Error',
            ]);
            return redirect()->route('admin.product.news', ['product' => $product->slug])->with(compact('error'));
        }
    }

    public function delete(Products $product, ProductNews $productNews, Request $request)
    {
        if ($productNews->delete()) {
            return response()->json([
                'status'  => true,
                'message' => trans('admin.delete_succeeded'),
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => trans('admin.delete_failed'),
            ]);
        }
    }
}
