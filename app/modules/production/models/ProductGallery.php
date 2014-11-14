<?php

class ProductGallery extends BaseModel {

    protected $guarded = array();
    protected $table = 'products_galleries';

    public static $rules = array();

    public function gallery() {
        return $this->belongsTo('Gallery', 'gallery_id');
    }

    public function product() {
        return $this->belongsTo('Product', 'product_id');
    }

}