<?php
	
	$w_routes = array(
		['GET', '/', 'Pictures#getAllPictures', 'default_home'],
		['GET', '/page', 'Pictures#getAllPictures', 'default_page_home'],
		['GET', '/page/[i:page]', 'Pictures#getAllPictures', 'pictures_getall'],
		['GET|POST',	'/login',									'Default#login',			'default_login'],
		['GET',			'/logout',									'Default#logout',			'default_logout'],
		['GET|POST',	'/signin',									'Default#signin',				'default_signin'],
		['GET|POST',	'/user/password-recovery',					'Default#passwordRecovery',
				'default_password_recovery'],
		['GET|POST',	'/user/reset-password/[:token]',			'Default#resetPassword',	'default_reset_password'],
		['GET|POST',	'/confirm-account/[:token]',				'default#confirm',
				'default_confirm_account']
	);