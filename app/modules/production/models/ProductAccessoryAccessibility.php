<?php

class ProductAccessoryAccessibility extends BaseModel {

    protected $guarded = array();
    protected $table = 'products_accessory_accessibility';

    public static $rules = array(
        'title' => 'required',
    );

}