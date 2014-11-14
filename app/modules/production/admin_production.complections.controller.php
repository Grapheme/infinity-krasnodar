<?php

class AdminProductionComplectionsController extends BaseController {

    public static $name = 'product_complections';
    public static $group = 'production';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {

        $class = __CLASS__;
        Route::group(array('before' => 'auth', 'prefix' => $prefix), function() use ($class) {
            Route::get("production/product/edit/{product_id}/complections",array('as'=> 'product_complection_index','uses' => $class.'@index'));
            Route::get("production/product/edit/{product_id}/complections/create",array('as'=> 'product_complection_create','uses' => $class.'@create'));
            Route::post("production/product/edit/{product_id}/complections/store",array('as'=> 'product_complection_store','uses' => $class.'@store'));
            Route::get("production/product/edit/{product_id}/complections/{complection_id}/edit",array('as'=> 'product_complection_edit','uses' => $class.'@edit'));
            Route::post("production/product/edit/{product_id}/complections/{complection_id}/update",array('as'=> 'product_complection_update','uses' => $class.'@update'));
            Route::delete("production/product/edit/{product_id}/complections/{complection_id}/delete",array('as'=> 'product_complection_delete','uses' => $class.'@destroy'));
        });
    }

    public static function returnExtFormElements() {}

    public static function returnActions() {}

    public static function returnInfo() {}
    /****************************************************************************/

    protected $product;
    protected $complection;

    public function __construct(Product $product, ProductComplections $complection){

        $this->product = $product->findOrFail(Request::segment(5));
        $this->complection = $complection;
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
        $complections = $this->product->complections()->get();
        return View::make($this->module['tpl'].'index', compact('product','complections'));
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
        $validation = Validator::make(Input::all(), ProductComplections::$rules);
        if($validation->passes()) {
            self::saveProductComplectionModel();
            $json_request['responseText'] = "Комплектация продукта добавлена";
            $json_request['redirect'] = URL::route('product_complection_index',array('product_id'=>$this->product->id));
            $json_request['status'] = TRUE;
        } else {
            $json_request['responseText'] = 'Неверно заполнены поля';
            $json_request['responseErrorText'] = implode($validation->messages()->all(),'<br />');
        }
        return Response::json($json_request, 200);
    }

    /****************************************************************************/

    public function edit($product_id,$complection_id){

        Allow::permission($this->module['group'], 'product_edit');
        $complection = $this->complection->where('id',$complection_id)->with('images')->first();
        $product = $this->product;
        return View::make($this->module['tpl'].'edit', compact('product', 'complection'));
    }

    public function update($product_id,$complection_id){

        if(!Request::ajax()) return App::abort(404);
        Allow::permission($this->module['group'], 'product_edit');
        $json_request = array('status'=>FALSE, 'responseText'=>'', 'responseErrorText'=>'', 'redirect'=>FALSE, 'gallery'=>0);
        $validation = Validator::make(Input::all(), ProductComplections::$rules);
        if($validation->passes()):
            $complection = $this->complection->find($complection_id);
            self::saveProductComplectionModel($complection);
            $json_request['responseText'] = 'Комплектация продукта обновлена';
            $json_request['status'] = TRUE;
        else:
            $json_request['responseText'] = 'Неверно заполнены поля';
            $json_request['responseErrorText'] = implode($validation->messages()->all(), '<br />');
        endif;

        return Response::json($json_request, 200);
    }

    /****************************************************************************/

    public function destroy($product_id,$complection_id){

        if(!Request::ajax()) return App::abort(404);
        Allow::permission($this->module['group'], 'product_delete');
        $json_request = array('status'=>FALSE, 'responseText'=>'');
        if(Request::ajax()):
            $complection = $this->complection->find($complection_id);
            if($image = $complection->images()->first()):
                if (!empty($image->name) && File::exists(public_path('uploads/galleries/thumbs/'.$image->name))):
                    File::delete(public_path('uploads/galleries/thumbs/'.$image->name));
                    File::delete(public_path('uploads/galleries/'.$image->name));
                    Photo::find($image->id)->delete();
                endif;
            endif;
            $complection->delete();
            $json_request['responseText'] = 'Комплектация продукта удалена';
            $json_request['status'] = TRUE;
        else:
            return App::abort(404);
        endif;
        return Response::json($json_request,200);
    }

    private function saveProductComplectionModel($complection = NULL){

        if(is_null($complection)):
            $complection = $this->complection;
        endif;

        $complection->product_id = $this->product->id;
        $complection->title = Input::get('title');
        $complection->price = Input::get('price');
        $complection->description = Input::get('description');
        $complection->dynamics = Input::get('dynamics');
        $complection->exterior = Input::get('exterior');
        $complection->interior = Input::get('interior');
        $complection->image_id = Input::get('image');

        if ($newFileName = $this->getUploadedFile(Input::get('file'))):
            File::delete(public_path($complection->brochure));
            $complection->brochure = $newFileName;
        endif;

        ## Сохраняем в БД
        $complection->save();
        $complection->touch();

        return $complection;
    }

}