<?php

class Helper {

	/*
	| Функция возвращает 2х-мерный массив который формируется из строки.
	| Строка сперва разбивается по запятой, потом по пробелам.
	| Используется пока для разбора строки сортировки model::orderBy() в ShortCodes
	*/
    ## from BaseController
	public static function stringToArray($string){

		$ordering = array();
		if(!empty($string)):
			if($order_by = explode(',',$string)):
				foreach($order_by as $index => $order):
					if($single_orders = explode(' ',$order)):
						foreach($single_orders as $single_order):
							$ordering[$index][] = strtolower($single_order);
						endforeach;
					endif;
				endforeach;
			endif;
		endif;
		return $ordering;
	}
    
    public static function d($array) {
        echo "<pre style='text-align:left'>" . print_r($array, 1) . "</pre>";
    }

    public static function dd($array) {
        self::d($array);
        die;
    }

    public static function d_($array) {
        return false;
    }

    public static function dd_($array) {
        return false;
    }

    public static function ta($object) {
        self::d($object->toArray());
    }

    public static function tad($object) {
        self::dd($object->toArray());
    }

    public static function layout($file = '') {
        $layout = Config::get('app.template');
        #Helper::dd(Config::get('app'));
        if (!$layout)
            $layout = 'default';
        #Helper::dd("templates." . $layout . ($file ? '.'.$file : ''));
        return "templates." . $layout . ($file ? '.'.$file : '');
    }

    public static function acclayout($file = '') {
        $layout = AuthAccount::getStartPage();
        if (!$layout)
            $layout = 'default';
        return "templates." . $layout . ($file ? '.'.$file : '');
    }

    public static function inclayout($file) {
        if (!$file)
            return false;

        $layout = Config::get('app.template');

        if (!$layout)
            $layout = 'default';

        $full = base_path() . "/app/views/templates/" . $layout . '/' . $file;

        if(!file_exists($full))
            $full .= ".blade.php";

        #if (!file_exists($full))
        #    return false;

        return $full;
    }

    public static function rdate($param = "j M Y", $time=0, $lower = true) {
        if (!is_int($time) && !is_numeric($time))
            $time = strtotime($time);
    	if (intval($time)==0)
            $time=time();
    	$MonthNames=array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
    	if(strpos($param,'M')===false)
            return date($param, $time);
    	else {
            $month = $MonthNames[date('n', $time)-1];
            if ($lower)
                $month = mb_strtolower($month);
            return date(str_replace('M', $month, $param), $time);
        }
    }

    public static function preview($text, $count = 10, $threedots = true) {

        $words = array();
        $temp = explode(" ", strip_tags($text));

        foreach ($temp as $t => $tmp) {
            #$tmp = trim($tmp, ".,?!-+/");
            if (!$tmp)
                continue;
            $words[] = $tmp;
            if (count($words) >= $count)
                break;
        }

        $preview = trim(implode(" ", $words));

        if (mb_strlen($preview) < mb_strlen(trim(strip_tags($text))) && $threedots)
            $preview .= "...";

        return $preview;
    }

    public static function firstletter($text, $dot = true) {

        return trim($text) ? mb_substr(trim($text), 0, 1) . ($dot ? '.' : '') : false;
    }


public static function arrayForSelect($object, $key = 'id', $val = 'name') {

        if (!isset($object) || (!is_object($object) && !is_array($object)))
            return false;

        #Helper::d($object); return false;

        $array = array();
        #$array[] = "Выберите...";
        foreach ($object as $o => $obj) {
            $array[@$obj->$key] = @$obj->$val;
        }

        #Helper::d($array); #return false;

        return $array;
    }

    public static function valuesFromDic($object, $key = 'id') {

        if (!isset($object) || (!is_object($object) && !is_array($object)))
            return false;

        #Helper::d($object); return false;

        $array = array();
        foreach ($object as $o => $obj) {
            $array[] = is_object($obj) ? @$obj->$key : @$obj[$key];
        }

        #Helper::d($array);

        return $array;
    }

    /**
     * Изымает значение из массива по ключу, возвращая это значение. Работает по аналогии array_pop()
     * @param $array
     * @param $key
     * @return mixed
     */
    public static function withdraw(&$array, $key) {
        $val = @$array[$key];
        unset($array[$key]);
        return $val;
    }

    public static function classInfo($classname) {
        echo "<pre>";
        Reflection::export(new ReflectionClass($classname));
        echo "</pre>";
    }

    public static function nl2br($text) {
        $text = preg_replace("~[\r\n]+~is", "\n<br/>\n", $text);
        return $text;
    }

    /**************************************************************************************/

    public static function cookie_set($name = false, $value = false, $lifetime = 86400) {
        if(is_object($value) || is_array($value))
            $value = json_encode($value);

        #Helper::dd($value);

        setcookie($name, $value, time()+$lifetime, "/");
        if ($lifetime > 0)
            $_COOKIE[$name] = $value;
    }

    public static function cookie_get($name = false) {
        #Helper::dd($_COOKIE);
        $return = @isset($_COOKIE[$name]) ? $_COOKIE[$name] : false;
        $return2 = @json_decode($return, 1);
        #Helper::dd($return2);
        if (is_array($return2))
            $return = $return2;
        return $return;
    }

    public static function cookie_drop($name = false) {
        self::cookie_set($name, false, 0);
        $_COOKIE[$name] = false;
    }

}

