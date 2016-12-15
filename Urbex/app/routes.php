<?php
	
	$w_routes = array(
		['GET', '/', 'Pictures#getAllPictures', 'default_home'],
		['GET', '/page', 'Pictures#getAllPictures', 'default_page_home'],
		['GET', '/page/[i:page]', 'Pictures#getAllPictures', 'pictures_getall'],
	);