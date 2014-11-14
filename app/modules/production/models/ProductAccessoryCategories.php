<?php

class ProductAccessoryCategories extends BaseModel {

    protected $guarded = array();
    protected $table = 'products_accessory_categories';

    public static $rules = array(
        'title' => 'required',
    );

}