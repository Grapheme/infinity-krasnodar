<?php

class ProductComplections extends BaseModel {

    protected $guarded = array();
    protected $table = 'products_complections';

    public static $rules = array(
        'title' => 'required',
        'price' => 'required',
    );

    public  function images(){
        return $this->belongsTo('Photo','image_id');
    }
}