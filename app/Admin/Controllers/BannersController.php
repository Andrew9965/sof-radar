<?php

namespace App\Admin\Controllers;

use App\Models\Banners;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;

class BannersController extends Controller
{
    use ModelForm;

    protected $targets = [
        '_self' => 'Self',
        '_blank' => 'Blank',
        '_parent' => 'Parent',
        '_top' => 'Top',
    ];

    protected $types = [
        'category' => 'Category',
        'product' => 'Product',
    ];

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Banners');
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

            $content->header('Banners');
            $content->description('edit');

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

            $content->header('Banners');
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
        return Admin::grid(Banners::class, function (Grid $grid) {

            $grid->disableExport();

            $grid->id('ID')->sortable();

            $grid->show_num('Показано раз')->sortable();

            $grid->column('img', 'Изображение')->display(function($img){
                return '<img src="'.$img.'" style="max-width: 150px" />';
            });

            $grid->type()->editable('select', $this->types)->sortable();

            $grid->target()->editable('select', $this->targets)->sortable();

            $grid->link()->sortable()->editable();
            $grid->active('Status')->switch([
                'on'  => ['value' => 1, 'text' => 'On', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'Off', 'color' => 'default'],
            ])->sortable();

            $grid->created_at()->sortable();

            $grid->filter(function($filter){
                $filter->equal('link');
                $filter->equal('type')->select($this->types);
                $filter->equal('target')->select($this->targets);
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Banners::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->select('type')->options($this->types)->rules('required')->default(array_first(array_keys($this->types)));

            $form->lfm('img')->rules('required')->prev();
            $form->text('link')->rules('required')->default('#');

            $form->select('target', 'Target')->options($this->targets)->rules('required')->default(array_first(array_keys($this->targets)));

            $form->text('alt');

            $form->switch("active","Status")->default("1")->rules('required');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
