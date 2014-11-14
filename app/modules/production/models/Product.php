<?php

class Product extends BaseModel {

	protected $guarded = array();
	protected $table = 'products';
    #public $timestamps = false;

	public static $rules = array(
		'category_id' => 'required|min:1',
	);

	public function photo() {

        return Photo::where('id', $this->image_id)->first();
	}

    public  function images(){
        return $this->belongsTo('Photo','image_id');
    }

    public  function menu_image(){
        return $this->belongsTo('Photo','image_menu_id');
    }

    public  function gallery(){
        return $this->belongsTo('Gallery', 'gallery_id');
    }

    public  function colors(){
        return $this->hasMany('ProductColors','product_id');
    }

    public  function complections(){
        return $this->hasMany('ProductComplections','product_id');
    }

    public  function instocks(){
        return $this->hasMany('ProductInstock','product_id');
    }

    public  function accessories(){
        return $this->hasMany('ProductAccessory','product_id');
    }

    public  function galleries(){
        return $this->hasMany('Rel_mod_gallery','unit_id');
    }

    public  function product_galleries(){
        return $this->hasMany('ProductGallery', 'product_id');
    }

    public  function meta(){
        return $this->hasMany('ProductsMeta','product_id');
    }

    public  function videos(){
        return $this->hasMany('ProductVideos','product_id');
    }

    public function related_products(){
        return $this->belongsToMany('Product','related_production','product_id','related_product_id');
    }

    /*
	public function group(){
		return $this->hasOne('Group', 'group_id', 'id');
	}

	public function module(){
		return $this->hasOne('Modules', 'module', 'name');
	}
    */

}