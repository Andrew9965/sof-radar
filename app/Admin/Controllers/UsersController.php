<?php

namespace App\Admin\Controllers;

use App\User;

use Illuminate\Http\Request;
use Lia\Auth\Database\Administrator;
use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;

class UsersController extends Controller
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

            $content->header('Users');
            $content->description('List');

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

            $content->header('Users');
            $content->description('Edit');

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

            $content->header('Users');
            $content->description('Create');

            $content->body($this->form());
        });
    }

    public function auth(Request $request, User $user)
    {
        if(!$user->moderator_id) {
            admin_toastr('Пользователю не присвоен Модератор!', 'error');
            return back();
        }
        if(!\Auth::guest()) \Auth::logout();
        \Auth::login($user, true);
        return redirect()->route('user.index');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(User::class, function (Grid $grid) {

            $grid->disableExport();

            $grid->id('ID')->sortable();

            $grid->name()->sortable();
            $grid->email()->sortable();

            $grid->created_at()->sortable();
            $grid->updated_at();

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->append('<div class="btn-group">');
                $actions->append('<a class="btn btn-success btn-xs" title="Авторизоваться этим пользователем" href="'.route('admin.user.auth', ['user' => $actions->getKey()]).'" target="_blank"><i class="fa fa-sign-in"></i></a>');
                $actions->append('<a class="btn btn-warning btn-xs" title="Статистика пользователя" href="'.route('users.edit', ['user' => $actions->getKey(), 'stat' => true]).'"><i class="fa fa-area-chart"></i></a>');
                $actions->append('</div>');
            });

            $grid->filter(function($filter){

                $filter->like('name', 'Name');
                $filter->like('email', 'E-Mail');
                $filter->equal('moderator_id', 'Moderator')->select(Administrator::all()->pluck('username', 'id'));

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
        // Admin::js(vue_scripts_url('app2'));

        return Admin::form(User::class, function (Form $form) use ($id) {
            $general = function ($form) {
                $form->display('id', 'ID');

                $form->select('moderator_id', 'Moderator')->options(Administrator::all()->pluck('username', 'id'));
                $form->text('name');
                $form->display('email');
                $form->currency('click_cost')->symbol('$');

                $form->display('created_at', 'Created At');
                $form->display('updated_at', 'Updated At');

                return $form;
            };

            if($id){
                $form->tab('General', function (Form $form) use ($general) {
                    $form = $general($form);

                    $form->display('created_at', 'Created At');
                    $form->display('updated_at', 'Updated At');
                })->tab('Statistic', function (Form $form) use ($id) {
                    $form->html(view('admin.statistic', ['user' => User::find($id)]));
                }, request()->stat ? true : false);
            }else{
                $form = $general($form);
            }

            $form->saving(function (Form $form) {
                $form->click_cost = $form->click_cost == config('default.cost.click') ? '0.00' : $form->click_cost;
            });
        });
    }
}
