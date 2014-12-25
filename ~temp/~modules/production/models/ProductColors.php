<?php

class ProductColors extends BaseModel {

    protected $guarded = array();
    protected $table = 'products_colors';

    public static $rules = array(
        'title' => 'required',
        'color' => 'required',
    );

    public  function images(){
        return $this->belongsTo('Photo','image_id');
    }
}