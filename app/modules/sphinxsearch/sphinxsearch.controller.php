<?php

class SearchController extends \BaseController {

    public static $name = 'search';
    public static $group = 'production';

    public function __construct(){

        $this->module = array(
            'name' => self::$name,
            'group' => self::$group,
            'rest' => self::$group . "/" . self::$name,
            'tpl'  => static::returnTpl(),
            'gtpl' => static::returnTpl(),
        );
        View::share('module', $this->module);
    }

    public static function returnRoutes($prefix = null) {

        $class = __CLASS__;
        Route::post('search/request',$class.'@headerSearch');
        Route::post('search/request/{text}',$class.'@headerSearch');
    }

    public static function returnExtFormElements() {

        return null;
    }

    public static function returnActions() {

        return null;
    }

    public static function returnInfo() {

        return null;
    }

    public function headerSearch($text = null){

        if(is_null($text)):
            $text = Input::get('search_request');
        endif;
        if(!empty($text)):
            return Redirect::to('/search?query='.$text);
        else:
            return Redirect::back();
        endif;
    }

    public static function search($searchText){

        return self::readIndexes($searchText);
    }

    private static function readIndexes($searchText){

        $channels = SphinxSearch::search($searchText, 'channelsIndexInfinity')->setFieldWeights(array('title' => 10, 'short' => 8, 'desc' => 6, 'category_title' => 1))
            ->setMatchMode(\Sphinx\SphinxClient::SPH_MATCH_EXTENDED)
            ->SetSortMode(\Sphinx\SphinxClient::SPH_SORT_RELEVANCE, "@weight DESC")
            ->limit(6)->get();

        $products = SphinxSearch::search($searchText, 'productsIndexInfinity')->setFieldWeights(array('title' => 10, 'preview' => 8, 'content' => 6,'specifications'=>8, 'category_title' => 1))
            ->setMatchMode(\Sphinx\SphinxClient::SPH_MATCH_EXTENDED)
            ->SetSortMode(\Sphinx\SphinxClient::SPH_SORT_RELEVANCE, "@weight DESC")
            ->limit(6)->get();

        $accessories = SphinxSearch::search($searchText, 'productsAccessibilityIndexInfinity')->setFieldWeights(array('title' => 10, 'description' => 8))
            ->setMatchMode(\Sphinx\SphinxClient::SPH_MATCH_EXTENDED)
            ->SetSortMode(\Sphinx\SphinxClient::SPH_SORT_RELEVANCE, "@weight DESC")
            ->limit(6)->with('product.meta')->get();

        $news = SphinxSearch::search($searchText, 'newsIndexInfinity')->setFieldWeights(array('title' => 10, 'preview' => 8, 'content' => 6))
            ->setMatchMode(\Sphinx\SphinxClient::SPH_MATCH_EXTENDED)
            ->SetSortMode(\Sphinx\SphinxClient::SPH_SORT_RELEVANCE, "@weight DESC")
            ->limit(6)->get();

        $pages = SphinxSearch::search($searchText, 'pagesIndexInfinity')->setFieldWeights(array('seo_title' => 10, 'seo_description' => 10, 'seo_h1' => 10, 'content' => 8))
            ->setMatchMode(\Sphinx\SphinxClient::SPH_MATCH_EXTENDED)
            ->SetSortMode(\Sphinx\SphinxClient::SPH_SORT_RELEVANCE, "@weight DESC")
            ->limit(6)->get();

        return compact('channels','products','accessories','news','pages');
    }
}