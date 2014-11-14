<?php

return array (
    'host'    => '127.0.0.1',
    'port'    => 3312,
    'indexes' => array (
        'channelsIndexInfinity' => array('table'=>'channels','column'=>'id','modelname'=>'Channel'),
        'productsIndexInfinity' => array('table'=>'products_meta','column'=>'product_id','modelname'=>'ProductsMeta'),
        'productsAccessibilityIndexInfinity' => array('table'=>'products_accessories','column'=>'id','modelname'=>'ProductAccessory'),
        'newsIndexInfinity' => array('table'=>'i18n_news_meta','column'=>'news_id','modelname'=>'I18nNewsMeta'),
        'pagesIndexInfinity' => array('table'=>'i18n_pages_meta','column'=>'page_id','modelname'=>'I18nPageMeta')
    )
);
