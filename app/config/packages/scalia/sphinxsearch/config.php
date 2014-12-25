<?php

return array (
    'host'    => '127.0.0.1',
    'port'    => 3312,
    'indexes' => array (
        'channelsIndexInfinityKrasnodar' => array('table'=>'channels','column'=>'id','modelname'=>'Channel'),
        'productsIndexInfinityKrasnodar' => array('table'=>'products_meta','column'=>'product_id','modelname'=>'ProductsMeta'),
        'productsAccessibilityIndexInfinityKrasnodar' => array('table'=>'products_accessories','column'=>'id','modelname'=>'ProductAccessory'),
        'newsIndexInfinityKrasnodar' => array('table'=>'i18n_news_meta','column'=>'news_id','modelname'=>'I18nNewsMeta'),
        'pagesIndexInfinityKrasnodar' => array('table'=>'i18n_pages_meta','column'=>'page_id','modelname'=>'I18nPageMeta')
    )
);
