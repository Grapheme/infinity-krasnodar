<?php

class AdminProductionGalleryController extends BaseController {

    public static $name = 'products_gallery';
    public static $group = 'production';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {

        $class = __CLASS__;
        Route::group(array('before' => 'auth', 'prefix' => $prefix), function() use ($class) {
            Route::get("production/product/edit/{product_id}/gallery",array('as'=> 'product_gallery_index','uses' => $class.'@index'));
            Route::post("production/product/edit/{product_id}/gallery/store",array('as'=> 'product_gallery_store','uses' => $class.'@store'));
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
            'tpl'  => static::returnTpl('admin/' . self::$name),
            'gtpl' => static::returnTpl(),
        );
        View::share('module', $this->module);
    }

    public function index(){

        Allow::permission($this->module['group'], 'product_view');

        $product = $this->product;
        #$galleries = $this->product->gallery()->get();

        $product_galleries = ProductGallery::where('product_id', $product->id)
            ->with('gallery.photos')
            ->get();
        #Helper::tad($product_galleries);

        #$galleries = Rel_mod_gallery::where('module', 'products')->where('unit_id', $product->id)->with('photos')->get();
        #Helper::tad($galleries);

        return View::make($this->module['tpl'].'index', compact('product', 'galleries', 'product_galleries'));
    }

    public function store(){

        if(!Request::ajax())
            return App::abort(404);

        Allow::permission($this->module['group'], 'product_edit');

        $json_request = array(
            'status'=>TRUE,
            'responseText'=>'Галереи обновлены',
            'responseErrorText'=>'',
            //'redirect' => link::auth('production/products'),
            'redirect' => '?',
            #'redirect' => false,
            'gallery' => false,
        );

        if (0) {
            $json_request['status'] = FALSE;
            $json_request['responseText'] = "<pre>" . print_r(Input::all(), 1) . "</pre>";
            return Response::json($json_request, 200);
        }

        #Helper::d(Input::get('gallery'));

        for ($i = 0; $i < 5; $i++):
            $json_request['gallery'][$i] = self::saveProductsGallery($i);
        endfor;

        return Response::json($json_request, 200);
    }

    private function saveProductsGallery($i){

        $gallery_id = FALSE;

        if(Allow::action('admin_galleries','edit')):

            $gallery_id = ExtForm::process('gallery', array(
                'module'  => 'products',
                'unit_id' => $this->product->id,
                'gallery' => Input::get('gallery.'.$i),
            ));

            #Helper::dd(Input::get('gallery.'.$i));
            #Helper::d($gallery_id);

            if ($gallery_id > 0) {
                $product_gallery = ProductGallery::firstOrNew(array('gallery_id' => $gallery_id));
                $product_gallery->title = Input::get('title.'.$i);
                $product_gallery->desc = Input::get('desc.'.$i);
                $product_gallery->product_id = $this->product->id;
                $product_gallery->save();
            }

        endif;

        return $gallery_id;
    }
}