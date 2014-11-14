<?php

class ProductAccessoriesTableSeeder extends Seeder{

	public function run(){
		
		#DB::table('products_accessory_accessibility')->truncate();
		#DB::table('products_accessory_categories')->truncate();

        ProductAccessoryCategories::create(array('title' => 'интерьер'));

        ProductAccessoryCategories::create(array('title' => 'аксессуары внешнего дизайна'));

        ProductAccessoryCategories::create(array('title' => 'для багажа'));

        ProductAccessoryCategories::create(array('title' => 'аксессуары в багажник'));

        ProductAccessoryCategories::create(array('title' => 'противоугонные системы'));

        ProductAccessoryCategories::create(array('title' => 'другие аксессуары'));

        /***************************************************************************/

        ProductAccessoryAccessibility::create(array('title' => 'в наличии'));

        ProductAccessoryAccessibility::create(array('title' => 'под заказ'));
	}

}