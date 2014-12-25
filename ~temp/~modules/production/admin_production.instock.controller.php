<?php

class AdminProductionInstockController extends BaseController {

    public static $name = 'product_instock';
    public static $group = 'production';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {

        $class = __CLASS__;
        Route::group(array('before' => 'auth', 'prefix' => $prefix), function() use ($class) {

            Route::resource("production/product/edit/{product_id}/instock", $class,
                array(
                    'except' => array('show'),
                    'names' => array(
                        'index'   => 'instock.index',
                        'create'  => 'instock.create',
                        'store'   => 'instock.store',
                        'edit'    => 'instock.edit',
                        'update'  => 'instock.update',
                        'destroy' => 'instock.destroy',
                    )
                )
            );

            /*
            Route::get("production/product/edit/{product_id}/complections",array('as'=> 'product_complection_index','uses' => $class.'@index'));
            Route::get("production/product/edit/{product_id}/complections/create",array('as'=> 'product_complection_create','uses' => $class.'@create'));
            Route::post("production/product/edit/{product_id}/complections/store",array('as'=> 'product_complection_store','uses' => $class.'@store'));
            Route::get("production/product/edit/{product_id}/complections/{complection_id}/edit",array('as'=> 'product_complection_edit','uses' => $class.'@edit'));
            Route::post("production/product/edit/{product_id}/complections/{complection_id}/update",array('as'=> 'product_complection_update','uses' => $class.'@update'));
            Route::delete("production/product/edit/{product_id}/complections/{complection_id}/delete",array('as'=> 'product_complection_delete','uses' => $class.'@destroy'));
            */
        });
    }

    public static function returnExtFormElements() {}

    public static function returnActions() {}

    public static function returnInfo() {}

    /****************************************************************************/

    protected $product;
    protected $instock;

    public function __construct(Product $product, ProductInstock $instock){

        $this->product = $product->findOrFail(Request::segment(5));
        $this->instock = $instock;
        $this->module = array(
            'name' => self::$name,
            'group' => self::$group,
            'rest' => NULL,
            'tpl'  => static::returnTpl('admin.' . self::$name),
            'gtpl' => static::returnTpl(),
        );
        View::share('module', $this->module);
    }

	public function index(){

        Allow::permission($this->module['group'], 'product_view');
        $product = $this->product;
        $instocks = $this->product->instocks()->get();

        return View::make($this->module['tpl'].'index', compact('product', 'instocks'));
	}

    /****************************************************************************/

    public function create($product_id){

        Allow::permission($this->module['group'], 'product_create');
        $product = $this->product;
        $colors = ProductColors::where('product_id', $this->product->id)->orderBy('title', 'ASC')->get();
        #Helper::tad($colors);

        return View::make($this->module['tpl'].'create', compact('product', 'colors'));
    }

    public function store(){

        if(!Request::ajax()) return App::abort(404);
        Allow::permission($this->module['group'], 'product_create');
        $json_request = array('status'=>FALSE, 'responseText'=>'', 'responseErrorText'=>'', 'redirect'=>FALSE, 'gallery'=>0);
        $validation = Validator::make(Input::all(), ProductInstock::$rules);
        if($validation->passes()) {
            self::saveProductComplectionModel();
            $json_request['responseText'] = "Добавлено";
            $json_request['redirect'] = URL::route('instock.index',array('product_id'=>$this->product->id));
            $json_request['status'] = TRUE;
        } else {
            $json_request['responseText'] = 'Неверно заполнены поля';
            $json_request['responseErrorText'] = implode($validation->messages()->all(),'<br />');
        }
        return Response::json($json_request, 200);
    }

    /****************************************************************************/

    public function edit($product_id, $instock_id){

        Allow::permission($this->module['group'], 'product_edit');
        $instock = $this->instock->where('id', $instock_id)->with('images')->first();
        $colors = ProductColors::where('product_id', $this->product->id)->orderBy('title', 'ASC')->get();
        $product = $this->product;

        return View::make($this->module['tpl'].'edit', compact('product', 'colors', 'instock'));
    }

    public function update($product_id, $instock_id){

        if(!Request::ajax()) return App::abort(404);
        Allow::permission($this->module['group'], 'product_edit');
        $json_request = array('status'=>FALSE, 'responseText'=>'', 'responseErrorText'=>'', 'redirect'=>FALSE, 'gallery'=>0);
        $validation = Validator::make(Input::all(), ProductInstock::$rules);
        if($validation->passes()):
            $instock = $this->instock->find($instock_id);
            self::saveProductComplectionModel($instock);
            $json_request['responseText'] = 'Обновлено';
            $json_request['status'] = TRUE;
        else:
            $json_request['responseText'] = 'Неверно заполнены поля';
            $json_request['responseErrorText'] = implode($validation->messages()->all(), '<br />');
        endif;

        return Response::json($json_request, 200);
    }

    /****************************************************************************/

    public function destroy($product_id, $instock_id){

        if(!Request::ajax()) return App::abort(404);
        Allow::permission($this->module['group'], 'product_delete');
        $json_request = array('status'=>FALSE, 'responseText'=>'');
        if(Request::ajax()):
            $instock = $this->instock->find($instock_id);
            if($image = $instock_id->images()->first()):
                if (!empty($image->name) && File::exists(public_path('uploads/galleries/thumbs/'.$image->name))):
                    File::delete(public_path('uploads/galleries/thumbs/'.$image->name));
                    File::delete(public_path('uploads/galleries/'.$image->name));
                    Photo::find($image->id)->delete();
                endif;
            endif;
            $instock->delete();
            $json_request['responseText'] = 'Удалено';
            $json_request['status'] = TRUE;
        else:
            return App::abort(404);
        endif;
        return Response::json($json_request,200);
    }

    private function saveProductComplectionModel($instock = NULL){

        if(is_null($instock)):
            $instock = $this->instock;
        endif;

        $instock->title = Input::get('title');
        $instock->image_id = Input::get('image_id');
        $instock->product_id = $this->product->id;
        $instock->color_id = Input::get('color_id');
        $instock->interior = Input::get('interior');
        $instock->year = Input::get('year');
        $instock->engine = Input::get('engine');
        $instock->transmission = Input::get('transmission');
        $instock->status_id = Input::get('status_id');
        $instock->action_id = Input::get('action_id');
        $instock->price = Input::get('price');

        ## Сохраняем в БД
        $instock->save();
        $instock->touch();

        return $instock;
    }

}