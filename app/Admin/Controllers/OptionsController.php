<?php

namespace App\Admin\Controllers;

use App\Models\Options;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;

class OptionsController extends Controller
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

            $content->header('Опции');

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

            $content->header('Опции');
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

            $content->header('Опции');
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
        $script = <<<EOT
            $(function () {
              $('.option_info').popover({
                trigger: 'hover'
              });
              $('.option_variable').popover()
            });
EOT;

        Admin::script($script);


        return Admin::grid(Options::class, function (Grid $grid) {
            $grid->model()->orderBy('order', 'asc');
            $grid->disableExport();
            $grid->disableFilter();

            $grid->name('Переменная')->display(function ($name) {
                return "<a class=\"btn btn-xs btn-success option_variable\" role=\"button\" data-html=true title=\"Usage\" data-content=\"<code>config('$name');</code>\">$name</a>";
            });
            $grid->description('Описание');

            $grid->value()->display(function ($value) {
                return iconv_strlen($value) >= 150 ?
                    "<a tabindex=\"0\" class=\"btn btn-xs btn-twitter option_info\" role=\"button\" data-html=true title=\"Value\" data-content=\"$value\"><i class='fa fa-eye'></i></a>" :
                    $value;
            });

            $grid->actions(function($actions){
                $actions->disableDelete();
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
    protected function form($id=false)
    {
        return Admin::form(Options::class, function (Form $form) use ( $id ) {

            $stt = function(&$form){
                $form->text('name', 'Имя переменной');
                $form->textarea('description', 'Описание');
                $form->select('type', 'Тип переменной')->options([
                    'text' => 'Text',
                    'textarea' => 'Big Text',
                    'ckeditor' => 'HTML Text',
                    'number' => 'Number',
                    'switch' => 'Switch',
                    'color' => 'Color',
                    'date' => 'Date',
                    'datetime' => 'Date Time',
                    'lfm' => 'File',
                    'icon' => 'Icon',
                    'tags' => 'Tags'
                ]);

                $form->number('order', 'Порядковый номер')->default(Options::all()->count()+1);

                $form->switch("active","Status")->default("1")->rules('required');
                $form->display('created_at', 'Created At');
                $form->display('updated_at', 'Updated At');
            };

            if(!$id){
                $stt($form);
            }else{

                $form->tab('Значение', function(Form $form) use ( $id ){

                    $option = Options::find($id);
                    $form->{$option->type}('value', $option->name)->help($option->description);

                    $form->display('updated_at', 'Updated At');

                })->tab('Variable config', function(Form $form) use ( $stt ){
                    $stt($form);
                });

            }

            $form->saving(function (Form $form) {
                $request = request()->all();
                $request['active'] = $request['active']=='on' ? 1 : 0;
                if($request['type']=='switch')
                    $request['value'] = $request['value']=='on' ? 1 : 0;

                if($form->model()->id) $model = Options::find($form->model()->id)->update($request);
                else $model = (new Options())->create($request);
                if($model)
                    admin_toastr('Saved!');
                else
                    admin_toastr('Error!', 'error');

                return redirect()->route('options.index');
            });


        });
    }
}
