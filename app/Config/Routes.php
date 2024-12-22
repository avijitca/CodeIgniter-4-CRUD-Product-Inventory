<?php

//use App\Controllers\Users;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Users::login');


// Product CRUD routes
$routes->get('product-list','Products');
$routes->get('create-product','Products::create_product');
$routes->post('create-product','Products::create_product');
$routes->get('update-product/(:num)','Products::update_product/$1');
$routes->post('update-product/(:num)','Products::update_product/$1');
$routes->get('delete-product/(:num)','Products::delete_product/$1');
$routes->match(['get','post'],'bulk-add','Products::bulk_add');
$routes->get('products/pdf','Products::downloadPdf');
$routes->get('products/excel','Products::downloadExcel');

//Users
$routes->match(['get','post'],'login','Users::login');
$routes->get('logout','Users::logout');
$routes->match(['get','post'],'add-user','Users::add_user');
$routes->get('all-users','Users');
$routes->match(['get','post'],'update-user/(:num)','Users::update_user/$1');
$routes->get('delete-user/(:num)','Users::delete_user/$1');


// API 
$routes->resource('products_api');
// $routes->get('product_api', 'Products_api::index');