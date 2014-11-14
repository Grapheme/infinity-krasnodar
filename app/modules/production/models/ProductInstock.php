<?php

class ProductInstock extends BaseModel {

    protected $guarded = array();
    protected $table = 'products_instock';

    public static $rules = array(
        'title' => 'required',
        'price' => 'required',
    );

    public function image(){
        return $this->belongsTo('Photo', 'image_id');
    }

    public function images(){
        return $this->belongsTo('Photo', 'image_id');
    }

    public function product(){
        return $this->belongsTo('Product', 'product_id');
    }

    public function color(){
        return $this->belongsTo('ProductColors', 'color_id');
    }

    public function action(){
        return $this->belongsTo('Channel', 'action_id');
    }

}