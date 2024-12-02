<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


// Product CRUD routes

$routes->get('product-list','Products');
$routes->get('create-product','Products::create_product');
$routes->post('create-product','Products::create_product');
$routes->get('update-product/(:num)','Products::update_product/$1');
$routes->post('update-product/(:num)','Products::update_product/$1');
$routes->get('delete-product/(:num)','Products::delete_product/$1');