<?php

return array(

    'feedback_mail' => 'support@grapheme.ru',
    'feedback_name' => 'grapheme.ru',

    #'sendto_mail' => 'support@grapheme.ru',
    'sendto_mail' => 'kr.infiniti-sales@gedon.ru',

	'driver' => 'smtp',
	'host' => 'in.mailjet.com',
	'port' => 587,
	'from' => array(
		'address' => 'no-reply@infiniti-krasnodar.ru',
		'name' => 'INFINITI'
	),
	'username' => '0d8dd8623bd38b41c43683c41c0558eb',
	'password' => '465c500abd5f680f0b20405deb967b36',
	'sendmail' => '/usr/sbin/sendmail -bs',
	'encryption' => 'tls',
	'pretend' => false,
);