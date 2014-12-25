<?php

class AdminProductionAccessoriesController extends BaseController {

    public static $name = 'product_accessories';
    public static $group = 'production';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {

        $class = __CLASS__;
        Route::group(array('before' => 'auth', 'prefix' => $prefix), function() use ($class) {
            Route::get("production/product/edit/{product_id}/accessories",array('as'=> 'product_accessory_index','uses' => $class.'@index'));
            Route::get("production/product/edit/{product_id}/accessories/create",array('as'=> 'product_accessory_create','uses' => $class.'@create'));
            Route::post("production/product/edit/{product_id}/accessories/store",array('as'=> 'product_accessory_store','uses' => $class.'@store'));
            Route::get("production/product/edit/{product_id}/accessories/{accessory_id}/edit",array('as'=> 'product_accessory_edit','uses' => $class.'@edit'));
            Route::post("production/product/edit/{product_id}/accessories/{accessory_id}/update",array('as'=> 'product_accessory_update','uses' => $class.'@update'));
            Route::delete("production/product/edit/{product_id}/accessories/{accessory_id}/delete",array('as'=> 'product_accessory_delete','uses' => $class.'@destroy'));
        });
    }

    public static function returnExtFormElements() {}

    public static function returnActions() {}

    public static function returnInfo() {}
    /****************************************************************************/

    protected $product;
    protected $accessory;

    public function __construct(Product $product, ProductAccessory $accessory){

        $this->product = $product->findOrFail(Request::segment(5));
        $this->accessory = $accessory;
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
        $accessories = $this->product->accessories()->with('category')->with('accessibility')->with('images')->get();
        return View::make($this->module['tpl'].'index', compact('product','accessories'));
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
        $validation = Validator::make(Input::all(), ProductAccessory::$rules);
        if($validation->passes()) {
            self::saveProductAccessoryModel();
            $json_request['responseText'] = "Аксуссуар продукта добавлен";
            $json_request['redirect'] = URL::route('product_accessory_index',array('product_id'=>$this->product->id));
            $json_request['status'] = TRUE;
        } else {
            $json_request['responseText'] = 'Неверно заполнены поля';
            $json_request['responseErrorText'] = implode($validation->messages()->all(),'<br />');
        }
        return Response::json($json_request, 200);
    }

    /****************************************************************************/

    public function edit($product_id,$accessory_id){

        Allow::permission($this->module['group'], 'product_edit');
        $accessory = $this->accessory->where('id',$accessory_id)->with('images')->first();
        $product = $this->product;
        return View::make($this->module['tpl'].'edit', compact('product', 'accessory'));
    }

    public function update($product_id,$accessory_id){

        if(!Request::ajax()) return App::abort(404);
        Allow::permission($this->module['group'], 'product_edit');
        $json_request = array('status'=>FALSE, 'responseText'=>'', 'responseErrorText'=>'', 'redirect'=>FALSE, 'gallery'=>0);
        $validation = Validator::make(Input::all(), ProductAccessory::$rules);
        if($validation->passes()):
            $accessory = $this->accessory->find($accessory_id);
            self::saveProductAccessoryModel($accessory);
            $json_request['responseText'] = 'Аксуссуар продукта обновлен';
            $json_request['status'] = TRUE;
        else:
            $json_request['responseText'] = 'Неверно заполнены поля';
            $json_request['responseErrorText'] = implode($validation->messages()->all(), '<br />');
        endif;

        return Response::json($json_request, 200);
    }

    /****************************************************************************/

    public function destroy($product_id,$accessory_id){

        if(!Request::ajax()) return App::abort(404);
        Allow::permission($this->module['group'], 'product_delete');
        $json_request = array('status'=>FALSE, 'responseText'=>'');
        if(Request::ajax()):
            $accessory = $this->accessory->find($accessory_id);
            if($image = $accessory->images()->first()):
                if (!empty($image->name) && File::exists(public_path('uploads/galleries/thumbs/'.$image->name))):
                    File::delete(public_path('uploads/galleries/thumbs/'.$image->name));
                    File::delete(public_path('uploads/galleries/'.$image->name));
                    Photo::find($image->id)->delete();
                endif;
            endif;
            $accessory->delete();
            $json_request['responseText'] = 'Аксуссуар продукта удален';
            $json_request['status'] = TRUE;
        else:
            return App::abort(404);
        endif;
        return Response::json($json_request,200);
    }

    private function saveProductAccessoryModel($accessory = NULL){

        if(is_null($accessory)):
            $accessory = $this->accessory;
        endif;

        $accessory->product_id = $this->product->id;
        $accessory->title = Input::get('title');
        $accessory->price = Input::get('price');
        $accessory->description = Input::get('description');
        $accessory->category_id = Input::get('category_id');
        $accessory->accessibility_id = Input::get('accessibility_id');
        $accessory->image_id =  Input::get('image');

        ## Сохраняем в БД
        $accessory->save();
        $accessory->touch();

        return $accessory;
    }

}