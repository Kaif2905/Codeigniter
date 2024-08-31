<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/user', 'UserController::index');
$routes->post('/user/store', 'UserController::store');
$routes->post('/user/update', 'UserController::update');
$routes->post('/user/delete', 'UserController::delete');
$routes->get('/user/success', 'UserController::success');
$routes->get('/user/list', 'UserController::list');  // Add this line


