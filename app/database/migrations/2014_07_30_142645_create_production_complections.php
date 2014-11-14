<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductionComplections extends Migration {

    private $table = 'products_complections';

    public function up(){
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function(Blueprint $table) {
                $table->increments('id');
                $table->string('title',128)->nullable();
                $table->string('price',20)->nullable();
                $table->string('brochure',256)->nullable();
                $table->text('description')->nullable();
                $table->text('dynamics')->nullable();
                $table->text('exterior')->nullable();
                $table->text('interior')->nullable();
                $table->integer('image_id')->default(0)->unsigned()->nullable();
                $table->integer('product_id')->default(0)->unsigned()->nullable();
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
