<?php

class AdminProductionColorController extends BaseController {

    public static $name = 'product_colors';
    public static $group = 'production';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {

        $class = __CLASS__;
        Route::group(array('before' => 'auth', 'prefix' => $prefix), function() use ($class) {
            Route::get("production/product/edit/{product_id}/color",array('as'=> 'product_color_index','uses' => $class.'@index'));
            Route::get("production/product/edit/{product_id}/color/create",array('as'=> 'product_color_create','uses' => $class.'@create'));
            Route::post("production/product/edit/{product_id}/color/store",array('as'=> 'product_color_store','uses' => $class.'@store'));
            Route::get("production/product/edit/{product_id}/color/{color_id}/edit",array('as'=> 'product_color_edit','uses' => $class.'@edit'));
            Route::post("production/product/edit/{product_id}/color/{color_id}/update",array('as'=> 'product_color_update','uses' => $class.'@update'));
            Route::delete("production/product/edit/{product_id}/color/{color_id}/delete",array('as'=> 'product_color_delete','uses' => $class.'@destroy'));
        });
    }

    public static function returnExtFormElements() {}

    public static function returnActions() {}

    public static function returnInfo() {}
    /****************************************************************************/

    protected $product;
    protected $color;

    public function __construct(Product $product, ProductColors $color){

        $this->product = $product->findOrFail(Request::segment(5));
        $this->color = $color;
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
        $colors = $this->product->colors()->get();
        return View::make($this->module['tpl'].'index', compact('product', 'colors'));
	}

    /****************************************************************************/

    public function create(){

        Allow::permission($this->module['group'], 'product_create');
        $product = $this->product;
        return View::make($this->module['tpl'].'create', compact('product'));
    }

    public function store(){

        if(!Request::ajax()) return App::abort(404);
        Allow::permission($this->module['group'], 'product_create');
        $json_request = array('status'=>FALSE, 'responseText'=>'', 'responseErrorText'=>'', 'redirect'=>FALSE, 'gallery'=>0);
        $validation = Validator::make(Input::all(), ProductColors::$rules);
        if($validation->passes()) {
            self::saveProductColorModel();
            $json_request['responseText'] = "Цвет продукта добавлен";
            $json_request['redirect'] = URL::route('product_color_index',array('product_id'=>$this->product->id));
            $json_request['status'] = TRUE;
        } else {
            $json_request['responseText'] = 'Неверно заполнены поля';
            $json_request['responseErrorText'] = implode($validation->messages()->all(),'<br />');
        }
        return Response::json($json_request, 200);
    }

    /****************************************************************************/

    public function edit($product_id,$color_id){

        Allow::permission($this->module['group'], 'product_edit');
        $color = $this->color->where('id',$color_id)->with('images')->first();
        $product = $this->product;
        return View::make($this->module['tpl'].'edit', compact('product', 'color'));
    }

    public function update($product_id,$color_id){

        if(!Request::ajax()) return App::abort(404);
        Allow::permission($this->module['group'], 'product_edit');
        $json_request = array('status'=>FALSE, 'responseText'=>'', 'responseErrorText'=>'', 'redirect'=>FALSE, 'gallery'=>0);
        $validation = Validator::make(Input::all(), ProductColors::$rules);
        if($validation->passes()):
            $color = $this->color->find($color_id);
            self::saveProductColorModel($color);
            $json_request['responseText'] = 'Цвет продукта обновлен';
            $json_request['status'] = TRUE;
        else:
            $json_request['responseText'] = 'Неверно заполнены поля';
            $json_request['responseErrorText'] = implode($validation->messages()->all(), '<br />');
        endif;

        return Response::json($json_request, 200);
    }

    /****************************************************************************/

    public function destroy($product_id,$color_id){

        if(!Request::ajax()) return App::abort(404);
        Allow::permission($this->module['group'], 'product_delete');
        $json_request = array('status'=>FALSE, 'responseText'=>'');
        if(Request::ajax()):
            $color = $this->color->find($color_id);
            if($image = $color->images()->first()):
                if (!empty($image->name) && File::exists(public_path('uploads/galleries/thumbs/'.$image->name))):
                    File::delete(public_path('uploads/galleries/thumbs/'.$image->name));
                    File::delete(public_path('uploads/galleries/'.$image->name));
                    Photo::find($image->id)->delete();
                endif;
            endif;
            $color->delete();
            $json_request['responseText'] = 'Цвет продукта удален';
            $json_request['status'] = TRUE;
        else:
            return App::abort(404);
        endif;
        return Response::json($json_request,200);
    }

    private function saveProductColorModel($color = NULL){

        if(is_null($color)):
            $color = $this->color;
        endif;

        $color->product_id = $this->product->id;
        $color->title = Input::get('title');
        $color->color = Input::get('color');
        $color->image_id =  Input::get('image');

        ## Сохраняем в БД
        $color->save();
        $color->touch();

        return $color;
    }

}