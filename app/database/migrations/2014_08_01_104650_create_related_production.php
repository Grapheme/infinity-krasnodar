<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRelatedProduction extends Migration {


    private $table = 'related_production';

    public function up(){
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function(Blueprint $table) {
                $table->increments('id');
                $table->integer('product_id')->default(0)->unsigned()->nullable();
                $table->integer('related_product_id')->default(0)->unsigned()->nullable();
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
