<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);
/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->add('/error403', 'Home::error403',['filter'=>'error403']);
$routes->add('/register', 'Users::register',['filter'=>'Noauth']);
$routes->add('/login', 'Users::login',['filter'=>'Noauth']);
$routes->add('/forgot_password', 'Users::forgot_password',['filter'=>'Noauth']);
$routes->add('/profile', 'Users::profile', ['filter'=>'auth']);
$routes->add('/dashboard', 'Dashboard::index', ['filter'=>'auth']);
$routes->add('/logout', 'Users::logout',['filter'=>'auth']);
$routes->add('/activate/(:any)', 'Users::activate/$1',['filter'=>'Noauth']);
$routes->add('/reset/(:any)', 'Users::reset/$1',['filter'=>'Noauth']);
$routes->add('/admin', 'Admin::index', ['filter'=>'authAdmin']);
$routes->add('/admin/users', 'Admin::users', ['filter'=>'authAdmin']);
$routes->add('/admin/subjects', 'Admin::subjects', ['filter'=>'authAdmin']);
$routes->add('/admin/organizations', 'Admin::organizations', ['filter'=>'authAdmin']);
$routes->add('/admin/groups_classes', 'Admin::groups_classes', ['filter'=>'authAdmin']);
$routes->add('/test_list', 'Tests::index');
$routes->add('/test_create', 'Tests::create');
/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
