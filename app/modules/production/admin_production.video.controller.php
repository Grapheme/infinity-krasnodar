<?php

class AdminProductionVideoController extends BaseController {

    public static $name = 'products_video';
    public static $group = 'production';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {

        $class = __CLASS__;
        Route::group(array('before' => 'auth', 'prefix' => $prefix), function() use ($class) {
            Route::get("production/product/edit/{product_id}/video",array('as'=> 'product_video_index','uses' => $class.'@index'));
            Route::post("production/product/edit/{product_id}/video/store",array('as'=> 'product_video_store','uses' => $class.'@store'));
        });
    }

    public static function returnExtFormElements() {}

    public static function returnActions() {}

    public static function returnInfo() {}
    /****************************************************************************/

    protected $product;

    public function __construct(Product $product){

        $this->product = $product->findOrFail(Request::segment(5));
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
        $videos = $this->product->videos()->get();
        return View::make($this->module['tpl'].'index', compact('product', 'videos'));
	}

	public function store(){

        if(!Request::ajax()) return App::abort(404);
        Allow::permission($this->module['group'], 'product_edit');
        $json_request = array('status'=> TRUE, 'responseText'=>"Видео сохранено", 'responseErrorText'=>'', 'redirect'=>link::auth('production/products'), 'gallery'=>0);
        $this->product->videos()->delete();
        foreach (Input::get('content') as $index => $content):
            if (!empty($content)):
                $video = new ProductVideos(array('content' => $content));
                $this->product->videos()->save($video);
            endif;
        endforeach;
        return Response::json($json_request, 200);
	}

}