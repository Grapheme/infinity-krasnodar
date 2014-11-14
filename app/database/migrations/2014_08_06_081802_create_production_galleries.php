<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductionGalleries extends Migration {

    private $table = 'products_galleries';

    public function up(){
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function(Blueprint $table) {
                $table->increments('id');
                $table->integer('product_id')->unsigned()->nullable()->index();
                $table->integer('gallery_id')->unsigned()->nullable()->index();
                $table->string('title', 256)->nullable();
                $table->text('desc')->nullable();
                $table->timestamps();
            });
            echo(' + ' . $this->table . PHP_EOL);
        } else {
            echo('...' . $this->table . PHP_EOL);
        }
    }


    public function down(){
        Schema::dropIfExists($this->table);
        echo(' - ' . $this->table . PHP_EOL);
    }
}
