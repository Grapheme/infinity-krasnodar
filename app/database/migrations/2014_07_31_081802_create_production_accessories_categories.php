<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductionAccessoriesCategories extends Migration {

    private $table = 'products_accessory_categories';

    public function up(){
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function(Blueprint $table) {
                $table->increments('id');
                $table->string('title',128)->nullable();
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
