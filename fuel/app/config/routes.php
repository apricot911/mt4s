<?php
return array(
	'_root_'                => 'index/index',    // The default route
	'_404_'                 => 'welcome/404',   // The main 404 route
    'fonts/(:any)'          => 'assets/fonts/$1',

	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
);