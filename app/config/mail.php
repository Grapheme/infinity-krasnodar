<?php

return array(

    'feedback_mail' => 'support@grapheme.ru',
    'feedback_name' => 'grapheme.ru',

	'driver' => 'sendmail',
	'host' => '',
	'port' => 587,
	'from' => array('address' => 'info@infiniti-krasnodar.ru', 'name' => 'Infiniti'),
	'encryption' => 'tls',
	'username' => '',
	'password' => '',
	'sendmail' => '/usr/sbin/sendmail -bs',
	'pretend' => false,
);