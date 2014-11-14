<?php

class ProductAccessory extends BaseModel {

    protected $guarded = array();
    protected $table = 'products_accessories';

    public static $rules = array(
        'title' => 'required',
        'category_id' => 'required',
        'accessibility_id' => 'required',
    );

    public function images(){
        return $this->belongsTo('Photo','image_id');
    }

    public function category(){
        return $this->hasOne('ProductAccessoryCategories','id','category_id');
    }

    public function accessibility(){
        return $this->hasOne('ProductAccessoryAccessibility','id','accessibility_id');
    }

    public function product(){

        return $this->belongsTo('Product');
    }
}