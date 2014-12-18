<?php
return array(
	'_root_'                => 'user/index',    // The default route
	'_404_'                 => 'welcome/404',   // The main 404 route
    'admin/course/(:any)'   => 'course/$1',
    'fonts/(:any)'          => 'assets/fonts/$1',

	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
);