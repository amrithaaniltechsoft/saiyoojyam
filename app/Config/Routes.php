<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setAutoRoute(true);

service('auth')->routes($routes, ['except' => ['login', 'logout', 'auth-actions']]);

$routes->get('login', '\App\Controllers\Admin\Auth::index', ['as' => 'login']);
$routes->post('login', '\App\Controllers\Admin\Auth::login');
$routes->get('logout', '\App\Controllers\Admin\Auth::logout');
//$routes->get('/', 'Home::index');

$routes->match(['get', 'post'], 'Checkout', 'Rooms::Checkout');

$routes->get('Room/(:any)', 'Rooms::Detail/$1');

$routes->get('Mission-Vision', 'About::Mission');

$routes->get('terms-and-conditions', 'Terms::index');

$routes->get('rules-and-procedures', 'Rules::index');

$routes->get('kitchen-and-dining', 'Kitchen::index');

$routes->get('Category/(:any)', 'Rooms::Category/$1');

$routes->get('Categories/(:any)', 'Rooms::Categories/$1');

$routes->get('dashboard', 'Dashboard::index', ['filter' => 'session']); 

