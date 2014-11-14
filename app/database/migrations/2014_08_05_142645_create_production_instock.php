<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductionInstock extends Migration {

    private $table = 'products_instock';

    public function up(){
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function(Blueprint $table) {
                $table->increments('id');
                $table->string('title',128)->nullable();

                $table->integer('image_id')->default(0)->unsigned()->nullable();
                $table->integer('product_id')->default(0)->unsigned()->nullable();
                $table->integer('color_id')->default(0)->unsigned()->nullable();

                $table->string('interior', 256)->nullable();
                $table->string('year', 64)->nullable();

                $table->string('engine', 256)->nullable();
                $table->string('transmission', 256)->nullable();

                $table->integer('status_id')->unsigned()->nullable();
                $table->integer('action_id')->unsigned()->nullable();

                $table->string('price', 64)->nullable();

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
