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
$routes->post('/auth/login', 'Auth::login');//ruta para filtros

//rutas del grupo api
//http://localhost:8080/api
$routes->group('api',['namespace'=> 'App\Controllers\API', 'filter' => 'authFilter'], function($routes){
	
	//	 -->Rutas de Estudiantes
	$routes->group('estudiantes', function($routes){
		
		$routes->get('estudiantes', 'Estudiantes::index');//http://localhost:8080/api/estudiantes
		$routes->post('estudiantes/create', 'Estudiantes::create');//http://localhost:8080/api/estudiantes/create
		$routes->get('estudiantes/edit/(:num)', 'Estudiantes::edit/$1');//http://localhost:8080/api/estudiantes/edit/1
		$routes->put('estudiantes/update/(:num)', 'Estudiantes::update/$1');//http://localhost:8080/api/estudiantes/update/1
		$routes->put('estudiantes/delete/(:num)', 'Estudiantes::delete/$1');//http://localhost:8080/api/estudiantes/delete/1
	});
	
	//	 -->Rutas de Profesores
	$routes->group('profesores', function($routes){
		
		$routes->get('profesores', 'Profesores::index');//http://localhost:8080/api/profesores
		$routes->post('profesores/create', 'Profesores::create');//http://localhost:8080/api/profesores/create
		$routes->get('profesores/edit/(:num)', 'Profesores::edit/$1');//http://localhost:8080/api/profesores/edit/1
		$routes->put('profesores/update/(:num)', 'Profesores::update/$1');//http://localhost:8080/api/profesores/update/1
		$routes->put('profesores/delete/(:num)', 'Profesores::delete/$1');//http://localhost:8080/api/profesores/delete/1
	});
	//	 -->Rutas de Grados
	$routes->group('grados', function($routes){
		
		$routes->get('grados', 'Grados::index');//http://localhost:8080/api/grados
		$routes->post('grados/create', 'Grados::create');//http://localhost:8080/api/grados/create
		$routes->get('grados/edit/(:num)', 'Grados::edit/$1');//http://localhost:8080/api/grados/edit/1
		$routes->put('grados/update/(:num)', 'Grados::update/$1');//http://localhost:8080/api/grados/update/1
		$routes->put('grados/delete/(:num)', 'Grados::delete/$1');//http://localhost:8080/api/grados/delete/1
	});

	//Rutas finales endpoint pedido
	$routes->group('conjuntos', function($routes){
		
		$routes->get('conjuntos/show/(:num)', 'Conjuntos::show/$1');//http://localhost:8080/api/conjuntos/show/1
	});

		//RUTAS de ROLES

		$routes->group('roles', function($routes){
			$routes->get('roles', 'Roles::index');//http://localhost:8080/api/roles
			$routes->post('roles/create', 'Roles::create');//http://localhost:8080/api/roles/create
			$routes->get('roles/edit/(:num)', 'Roles::edit/$1');//http://localhost:8080/api/roles/edit/1
			$routes->put('roles/update/(:num)', 'Roles::update/$1');//http://localhost:8080/api/roles/update/1
			$routes->put('roles/delete/(:num)', 'Roles::delete/$1');//http://localhost:8080/api/roles/delete/1
		});
		//RUTAS de Usuarios
	
		$routes->group('usuarios', function($routes){
			$routes->get('usuarios', 'Usuarios::index', ['filter' => 'authFIlter']);//http://localhost:8080/api/usuarios
			$routes->post('usuarios/create', 'Usuarios::create');//http://localhost:8080/api/usuarios/create
			$routes->get('usuarios/edit/(:num)', 'Usuarios::edit/$1');//http://localhost:8080/api/usuarios/edit/1
			$routes->put('usuarios/update/(:num)', 'Usuarios::update/$1');//http://localhost:8080/api/usuarios/update/1
			$routes->put('usuarios/delete/(:num)', 'Usuarios::delete/$1');//http://localhost:8080/api/usuarios/delete/1
		});
	
});

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
