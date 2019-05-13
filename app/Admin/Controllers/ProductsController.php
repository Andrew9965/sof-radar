<?php

namespace App\Admin\Controllers;

use App\Console\Commands\importMassCategory;
use App\Models\Products;
use App\Models\ProductMedia;

use App\User;
use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;
use Lia\Widgets\Box;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Storage;
use Lia\Layout\Row;
use Lia\Widgets\Form as wForm;


class ProductsController extends Controller
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
            $content->header('Продукты');
            $content->description('список');
            $content->body($this->grid());
        });
    }

    public function media_index(Products $product, ProductMedia $productMedia)
    {
        return Admin::content(function (Content $content) use ($product, $productMedia) {
            $content->header('Медиа файлы продукта');
            $content->description($product->title);
            $content->row(function(Row $row) use ($product, $productMedia) {
                $row->column(6, $this->media_grid($product, $productMedia));
                $row->column(6, $this->myForm($product, $productMedia));
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

            $content->header('Продукты');
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

            $content->header('Продукты');
            $content->description('добавить');

            $content->body($this->form());
        });
    }

    public function formEvent(Request $request)
    {
        dd($request->all());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        if (!file_exists(public_path('storage'))) {
            \Artisan::call('storage:link');
        }

        return Admin::grid(Products::class, function (Grid $grid) {

            $grid->disableExport();
            if(Admin::user()->isRole('vendor'))
                $grid->model()->where('user_id', Admin::user()->id)->orderBy('created_at', 'desc');
            else
                $grid->model()->orderBy('created_at', 'desc');

            $grid->id('ID')->sortable();


            $grid->title('Название')->sortable();
            $grid->column('slug')->display(function($slug){
                return '<a href="'.route('product', ['product' => $slug]).'" target="_blank" title="'.$slug.'" class="btn btn-success btn-xs">Open <i class="fa fa-external-link"></i></a>';
            });

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $p = Products::find($actions->getKey());
                $actions->append('<div class="btn-group">');
                $actions->append(' <a href="'.route('lia_media.index', ['relate_id' => $actions->getKey()]).'" title="Media" class="btn btn-primary btn-xs"><i class="fa fa-folder-o"></i> ('.$p->media->count().')</a> ');
                $actions->append(' <a href="'.route('admin.product.news', ['product' => $p->slug]).'" title="News" class="btn btn-success btn-xs"><i class="fa fa-newspaper-o"></i> ('.$p->news->count().')</a> ');
                $actions->append('</div>');
            });

            $grid->filter(function($filter){
                $filter->like('title', 'Название');
            });

            if(Admin::user()->isAdministrator())
                $grid->top('Top')->switch([
                    'on'  => ['value' => 1, 'text' => 'On', 'color' => 'primary'],
                    'off' => ['value' => 0, 'text' => 'Off', 'color' => 'default'],
                ])->sortable();

            $grid->created_at()->sortable();
            $grid->updated_at()->sortable();
        });
    }

    private function media_grid($product, $productMedia)
    {
        return Admin::grid(ProductMedia::class, function (Grid $grid) use ($product) {
            $grid->disableExport();
            $grid->disableFilter();
            $grid->disableCreateButton();
            $grid->model()->where('product_id', $product->id);

            $grid->id('ID')->sortable();
            $grid->type()->sortable();
            $grid->title()->sortable();

            $grid->actions(function (Grid\Displayers\Actions $actions) use ($product) {
                $actions->disableEdit();
                $actions->append('<a href="'.route('admin.product.media', ['product' => $product->slug, 'product_media' => $actions->getKey()]).'"><i class="fa fa-edit"></i></a>');
            });

            $grid->created_at();
            $grid->updated_at();
        });
    }

    public function myForm($product, $productMedia)
    {
        $form = new wForm($productMedia);
        $form->action(route('admin.product.media.post', ['product' => $product->slug, 'product_media' => $productMedia->id]));

        $form->hidden('_token')->default(csrf_token());
        $form->select('type')->options(['feature' => 'Image', 'video' => 'Video'])->default('feature');
        $form->image('img');
        $form->text('title');
        $form->ckeditor('description')->disableHorizontal();
        $form->switch('slider')->states([
            'on'  => ['value' => 1, 'text' => 'Yes', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => 'No', 'color' => 'danger'],
        ]);
        $form->switch('active')->default(1)->states([
            'on'  => ['value' => 1, 'text' => 'On', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => 'Off', 'color' => 'danger'],
        ]);


        $box = (new Box($productMedia->id ? 'Edit "'.$productMedia->title.'"' : 'New', $form->render()))->style('info');
        return $box;
    }

    public function mediaSave(Products $product, ProductMedia $productMedia, Request $request)
    {
        $data = $request->all();
        $data['product_id'] = $product->id;
        $data['slider'] = $data['active']=='on' ? 1 : 0;
        $data['active'] = $data['active']=='on' ? 1 : 0;
        if(request()->img) $request['logo'] = request()->img->store('public/uploads');

        if(ProductMedia::updateOrCreate(['id' => $productMedia->id ? $productMedia->id : 0], $data)) {
            $success = new MessageBag([
                'title' => 'Success!',
            ]);
            return redirect()->route('admin.product.media', ['product' => $product->slug])->with(compact('success'));
        }else{
            $error = new MessageBag([
                'title'   => 'Error',
            ]);
            return redirect()->route('admin.product.media', ['product' => $product->slug])->with(compact('error'));
        }
    }

    public function mediaDelete(Products $product, ProductMedia $productMedia, Request $request)
    {
        if ($productMedia->delete()) {
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

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id=false)
    {
        return Admin::form(Products::class, function (Form $form) use ($id) {

            if($id) $form->setAction(route('products.update', ['product' => $id]));
            else $form->setAction(route('products.store'));

            $form->tab('General', function($form) use ($id){

                if($id) $form->display('id', 'ID');
                if($id) $form->hidden('product_id', $id);

                $form->text('title')->rules('required|min:3');
                $form->text('slug');
                $form->select('author_id', 'User author')->options([0 => 'none']+User::all()->pluck('name', 'id')->toArray());
                $form->text('company');
                //$form->lfm('logo')->prev()->rules('required');
                $form->image('logo')->setPreviewOriginalPath();
                $form->text('web_site');

                $form->ckeditor('short_description')->rules('required');
                $form->ckeditor('fool_description', 'Full description')->rules('required');

                if($id)
                    $intgrs = \App\Models\Products::where('active', 1)->where('id','!=',$id)->get()->pluck('title', 'id');
                else
                    $intgrs = \App\Models\Products::where('active', 1)->get()->pluck('title', 'id');

                $form->multipleSelect('integrations_programs')->options($intgrs)->setNoRelated();

                $form->switch('active')->states([
                    'on'  => ['value' => 1, 'text' => 'On', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => 'Off', 'color' => 'danger'],
                ])->default(1);

                if($id) $form->display('created_at', 'Created At');
                if($id) $form->display('updated_at', 'Updated At');

            })->tab('Categories', function($form) use ($id){

                $categories = \App\Models\Categories::where('active', 1)->get()->pluck('title', 'id');
                if($id){
                    $prod = \App\Models\Products::find($id);
                    $ff1 = \App\Models\CategoriesFF::whereIn('title', $prod->features[1])->get()->pluck('title')->toArray();
                    $ff2 = \App\Models\CategoriesFF::whereIn('title', $prod->features[2])->get()->pluck('title')->toArray();
                    $ff3 = \App\Models\CategoriesFF::whereIn('title', $prod->features[3])->get()->pluck('title')->toArray();
                }

                $form->select('categories.1', 'Категория 1')->options($categories)->load('features.1', route('remote.get', ['name' => 'cat']))->rules('required');
                $form->multipleSelect('features.1', 'Функциональные особенности 1')->rules('required')
                    ->options(
                        $id ?
                            \App\Models\CategoriesFF::where('category_id', old('categories.1', $prod->categories[1]))->pluck('title', 'title') :
                            (old('categories.1') ? \App\Models\CategoriesFF::where('category_id', old('categories.1'))->pluck('title', 'title') : [])
                        )
                    ->attribute('data-auto-select', $id ? implode(',',$ff1) : implode(old('features.1', [])));

                $form->divide();

                $form->select('categories.2', 'Категория 2')->options($categories)->load('features.2', route('remote.get', ['name' => 'cat']));
                $form->multipleSelect('features.2', 'Функциональные особенности 2')
                    ->options(
                        $id && isset($prod->categories[2]) ?
                            \App\Models\CategoriesFF::where('category_id', $prod->categories[2])->pluck('title', 'title') :
                            (old('categories.2') ? \App\Models\CategoriesFF::where('category_id', old('categories.2'))->pluck('title', 'title') : [])
                        )
                    ->attribute('data-auto-select', $id ? implode(',',$ff2) : implode(old('features.2', [])));

                $form->divide();

                $form->select('categories.3', 'Категория 3')->options($categories)->load('features.3', route('remote.get', ['name' => 'cat']));
                $form->multipleSelect('features.3', 'Функциональные особенности 3')
                    ->options(
                        $id && isset($prod->categories[3]) ?
                            \App\Models\CategoriesFF::where('category_id', $prod->categories[3])->pluck('title', 'title') :
                            (old('categories.3') ? \App\Models\CategoriesFF::where('category_id', old('categories.3'))->pluck('title', 'title') : [])
                        )
                    ->attribute('data-auto-select', $id ? implode(',',$ff3) : implode(old('features.3', [])));

            })->tab('Product Details', function($form){

                $form->multipleSelect('details.deployment', 'Deployment')->options(['SaaS'=>'SaaS', 'InHouse'=>'InHouse']);
                $form->multipleSelect('details.desc_client', 'Desktop client')->options(['Windows'=>'Windows', 'Linux'=>'Linux', 'Mac'=>'Mac', 'Web-browser'=>'Web-browser']);
                $form->multipleSelect('details.mobile_version', 'Mobile version')->options(['Android'=>'Android', 'IOS'=>'IOS', 'Windows phone'=>'Windows phone', 'Web-browser'=>'Web-browser']);
                $form->multipleSelect('details.business_size', 'Business size')->options(['Small'=>'Small', 'Medium'=>'Medium', 'Enterprise'=>'Enterprise'])->rules('required');
                $form->ckeditor('details.vendor_detalis', 'Vendor Details')->rules('required');

            })->tab('Pricing', function($form) use ($id){

                $form->divide();
                $form->html('<h3>Starting price</h3>');

                $form->currency('pricing.starting_price.price', 'Price')->symbol('$');
                $form->text('pricing.starting_price.link', 'Link');
                $form->switch('pricing.starting_price.onsubmit', 'On submit')->states([
                    'on'  => ['value' => 1, 'text' => 'Yes', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => 'No', 'color' => 'danger'],
                ])->default(0);

                $form->divide();
                $form->html('<h3>Pricing model</h3>');

                $form->multipleSelect('pricing.pricing_model', 'Parameters')->options([
                    'Freemium' => 'Freemium',
                    'Subscription' => 'Subscription',
                    'One-time license' => 'One-time license',
                    'Open-source' => 'Open-source',
                ]);

                $form->divide();
                $form->html('<h3>Training</h3>');

                $form->multipleSelect('pricing.training', 'Parameters')->options(['Documenation'=>'Documenation', 'Webinars'=>'Webinars', 'In person'=>'In person', 'Live courses'=>'Live courses']);

                $form->divide();
                $form->html('<h3>License price</h3>');

                $form->currency('pricing.license_price.price', 'Price')->symbol('$');
                $form->text('pricing.license_price.link', 'Link');
                $form->switch('pricing.license_price.onsubmit', 'On submit')->states([
                    'on'  => ['value' => 1, 'text' => 'Yes', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => 'No', 'color' => 'danger'],
                ])->default(0);

                $form->divide();
                $form->html('<h3>Free trial</h3>');

                $form->switch('pricing.free_trial.active', 'Trial')->states([
                    'on'  => ['value' => 1, 'text' => 'Enabled', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => 'Disabled', 'color' => 'danger'],
                ])->default(0);
                $form->switch('pricing.free_trial.button', 'Button')->states([
                    'on'  => ['value' => 1, 'text' => 'On', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => 'Off', 'color' => 'danger'],
                ])->default(0);
                $form->text('pricing.free_trial.link', 'Link');

                $form->divide();

                $form->ckeditor('pricing_desc', 'Pricing description');

            })->tab('SEO', function(Form $form){

                $form->text('meta_title')->attribute('onkeyup', '$(\'.meta_auto.la_checkbox\').bootstrapSwitch(\'state\', false)');
                $form->textarea('meta_keywords');
                $form->textarea('meta_description')->attribute('onkeyup', '$(\'.meta_auto.la_checkbox\').bootstrapSwitch(\'state\', false)');

                $form->switch('meta_auto')->states([
                    'on'  => ['value' => 1, 'text' => 'On', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => 'Off', 'color' => 'danger'],
                ])->default(1);

            });

            if($id){
                $product = Products::findOrFail($id);
                $form->tools(function (Form\Tools $tools) use ($product) {

                    $tools->add('<a href="'.route('product', ['product' => $product->slug]).'" target="_blank" class="btn btn-success btn-sm">Open <i class="fa fa-external-link"></i></a>');
                    $tools->add('<div class="btn-group">');
                    $tools->add(' <a href="'.route('lia_media.index', ['relate_id' => $product->id]).'" title="Media" class="btn btn-primary btn-sm"><i class="fa fa-folder-o"></i> Media ('.$product->media->count().')</a> ');
                    $tools->add(' <a href="'.route('admin.product.news', ['product' => $product->slug]).'" title="News" class="btn btn-success btn-sm"><i class="fa fa-newspaper-o"></i> News ('.$product->news->count().')</a> ');
                    $tools->add('</div>&nbsp;&nbsp;&nbsp;');
                });
            }

            $form->saving(function($form){
                //dd(request()->product);
                $id = request()->product ? request()->product : false;
                $request = request()->all();
                if(isset($request['top'])){
                    $top = [];
                    $top['top'] = $request['top']=='on' ? 1 : 0;
                    Products::find(request()->product)->update($top);
                    return true;
                }
                $logo = request()->file('logo');

                if(!is_null($logo))
                    $request['logo'] = '/storage/'.$logo->store('uploads', 'public');

                if(is_null($logo) && isset($request['logo'])) unset($request['logo']);

                /*if(!empty($request['logo'])){
                    Storage::put($request['logo']->getClientOriginalName(), file_get_contents($request['logo']));
                }*/

                //if(request()->logo) $request['logo'] = request()->logo->store('upload/products');
                $request['active'] = $request['active']=='on' ? 1 : 0;
                $request['meta_auto'] = $request['meta_auto']=='on' ? 1 : 0;

                $request['slug'] = !empty($request['slug']) ? str_slug($request['slug']) : str_slug($request['title']);

                $request['user_id'] = Admin::user()->id;

                if($id)
                    $test_sug = Products::where('slug', $request['slug'])->where('id', '!=', $id)->first();
                else
                    $test_sug = Products::where('slug', $request['slug'])->first();

                if ($test_sug) $request['slug'] = str_slug($request['slug'] . ' ' . now());

                $request['integrations_programs'] = array_diff($request['integrations_programs'], array(null));
                $request['categories'] = array_diff($request['categories'], array(null));
                $request['features']['1'] = array_diff($request['features']['1'], array(null));
                $request['features']['2'] = array_diff($request['features']['2'], array(null));
                $request['features']['3'] = array_diff($request['features']['3'], array(null));

                $request['details']['deployment'] = is_array($request['details']['deployment']) ? array_diff($request['details']['deployment'], array(null)) : [];
                $request['details']['desc_client'] = is_array($request['details']['desc_client']) ? array_diff($request['details']['desc_client'], array(null)) : [];
                $request['details']['mobile_version'] = is_array($request['details']['mobile_version']) ? array_diff($request['details']['mobile_version'], array(null)) : [];
                $request['details']['business_size'] = is_array($request['details']['business_size']) ? array_diff($request['details']['business_size'], array(null)) : [];

                $request['pricing']['pricing_model'] = array_diff($request['pricing']['pricing_model'], array(null));
                $request['pricing']['training'] = array_diff($request['pricing']['training'], array(null));

                if($id) $result = Products::find($id)->update($request);
                else $result = Products::create($request);

                if($result){
                    $success = new MessageBag([
                        'title'   => $id ? 'Update' : 'Create',
                        'message' => $id ? 'Product updated' : 'Product created',
                    ]);
                    return redirect()->route('products.edit', ['product' => isset($result->id) ? $result->id : $id])->with(compact('success'));
                    //return back()->with(compact('success'));
                }else{
                    $error = new MessageBag([
                        'title'   => 'Error',
                        'message' => $result,
                    ]);
                    return back()->with(compact('error'));
                }

                return;
            });

        });
    }
}



















