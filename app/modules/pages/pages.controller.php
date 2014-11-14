<?php

class PagesController extends BaseController {

    public static $name = 'pages_public';
    public static $group = 'pages';

    /****************************************************************************/
    /**
     * @author Alexander Zelensky
     * @todo Возможно, в будущем здесь нужно будет добавить проверку параметра, использовать ли вообще мультиязычность по сегментам урла, или нет. Например, удобно будет отключить мультиязычность по сегментам при использовании разных доменных имен для каждой языковой версии.
     */
    public static function returnRoutes($prefix = null) {
        
        ## УРЛЫ С ЯЗЫКОВЫМИ ПРЕФИКСАМИ ДОЛЖНЫ ИДТИ ПЕРЕД ОБЫЧНЫМИ!
        ## Если в конфиге прописано несколько языковых версий...
        if (is_array(Config::get('app.locales')) && count(Config::get('app.locales'))) {
            ## Для каждого из языков...
            foreach(Config::get('app.locales') as $locale) {
            	## ...генерим роуты с префиксом (первый сегмент), который будет указывать на текущую локаль.
            	## Также указываем before-фильтр i18n_url, для выставления текущей локали.
                Route::group(array('before' => 'i18n_url', 'prefix' => $locale), function(){
                    Route::any('/{url}', array('as' => 'page',     'uses' => __CLASS__.'@showPageByUrl')); ## I18n Pages
                    Route::any('/',      array('as' => 'mainpage', 'uses' => __CLASS__.'@showPageByUrl')); ## I18n Main Page
                });
            }
        }

        ## Генерим роуты без префикса, и назначаем before-фильтр i18n_url.
        ## Это позволяет нам делать редирект на урл с префиксом только для этих роутов, не затрагивая, например, /admin и /login
        Route::group(array('before' => 'i18n_url'), function(){
            
            ## I18n Pages
            Route::any('/{url}', array('as' => 'page', 'uses' => __CLASS__.'@showPageByUrl'));
            ## I18n Main Page
            Route::any('/', array('as' => 'mainpage', 'uses' => __CLASS__.'@showPageByUrl'));

        });
    }
    
    ## Shortcodes of module
    public static function returnShortCodes() {
        /**
         * @todo Сделать шорткод для страниц (вставка страницы внутрь другой страницы, OMG). Да и нужно ли.. Уточнить у Андрея
         */
        #$tpl = static::returnTpl();
    	#shortcode::add("page",
        #    function($params = null) use ($tpl) {}
        #);
    }

    ## Actions of module (for distribution rights of users)
    ## return false;   # for loading $default_actions from config
    ## return array(); # no rules will be loaded
    /*
    public static function returnActions() {
        return array();
    }
    */

    ## Info about module (now only for admin dashboard & menu)
    /*
    public static function returnInfo() {
    }
    */
    
    /****************************************************************************/

	public function __construct(){

        View::share('module_name', self::$name);

        $this->tpl = $this->gtpl = static::returnTpl();
        View::share('module_tpl', $this->tpl);
        View::share('module_gtpl', $this->gtpl);
	}

    ## Функция для просмотра мультиязычной страницы
    public function showPageByUrl($url = ""){

		if(I18nPage::count() == 0) return View::make('guests.welcome');

        /*
        *   автор: Харсеев В.А.
        *  Переопределяю $page изходя из связей с таблицей мета
        */
        if (!empty($url)):
            if($page = I18nPageMeta::where('seo_url',$url)->first()):
                $page = $page->page()->where('publication', 1)->with('metas')->first();
            else:
                return App::abort(404);
            endif;
        else:
            $page = I18nPage::where('start_page', '1')->where('publication', 1)->with('metas')->first();
        endif;

        Config::set('page.slug', $url);

        return View::make(
		    $this->tpl.$page->template,
		    array(
                'page_name' =>$page->metas->first()->name,
		        'page_title' => $page->metas->first()->seo_title,
		        'page_description' => $page->metas->first()->seo_description,
				'page_keywords' => $page->metas->first()->seo_keywords,
				'page_author' => '',
				'page_h1' => $page->metas->first()->seo_h1,
				'menu' => I18nPage::getMenu($page->template),
				'content' => self::content_render($page->metas->first()->content),
                'url' => $url,
			)
        );
	}
    

	public static function content_render($page_content, $page_data = NULL){

		$regs = $change = $to = array();
		preg_match_all('~\[([^\]]+?)\]~', $page_content, $matches);

        #dd($page_content);
        #dd($matches);

		for($j=0; $j<count($matches[0]); $j++) {
			$regs[trim($matches[0][$j])] = trim($matches[1][$j]);
		}
        
        #dd($regs);
        
		if(!empty($regs)) {
			foreach($regs as $tochange => $clear):
                
                #echo "$tochange => $clear"; die;
                
				if(!empty($clear)):
					$change[] = $tochange;
					$tag = explode(' ', $clear);

                    #dd($tag);
                    
					if(isset($tag[0]) && $tag[0] == 'view') {
						$to[] = self::shortcode($clear, $page_data);
					} else {
						$to[] = self::shortcode($clear);
					}
				endif;
			endforeach;
		}
        
        #dd($change);
        
		return str_replace($change, $to, $page_content);
	}

	private static function shortcode($clear, $data = NULL){

        ## $clear - строка шорткода без квадратных скобок []
        #dd($clear);

		$str = explode(" ", $clear);
		#$type = $str[0]; ## name of shortcode
        $type = array_shift($str);
		$options = NULL;
		if(count($str)) {
			#for($i=1; $i<count($str); $i++) {
            foreach ($str as $expr) {
                if (!strpos($expr, "="))
                    continue;
				#preg_match_all("~([^\=]+?)=['\"]([^'\"\s\t\r\n]+?)['\"]~", $str[$i], $rendered);
                #dd($rendered);
                list($key, $value) = explode("=", $expr);
                $key = trim($key);
                $value = trim($value, "'\"");
				if($key != '' && $value != '') {
					$options[$key] = $value;
				}
			}
		}

        #dd($type);
        #dd($options);

		return shortcode::run($type, $options);
	}

}