<?php
use Phalcon\Loader;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Url;
use Phalcon\Mvc\Application;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Register an autoloader
$loader = new Loader();
$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
    ]
);
$loader->registerNamespaces(
    [
        'MyApp\Models' => '../app/models/',
    ]
);
$loader->register();

// Create a dependency injector
$container = new FactoryDefault();

// Start a session
$container->set(
    'session',
    function () {
        $session = new Manager();

        $files = new Stream(
            [
                'savePath' => 'tmp',
            ]
        );
        $session->setAdapter($files);

        $session->start();

        return $session;
    }
);

// Register the view service
$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');

        return $view;
    }
);

// Register a base URI for all generated URIs
$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/phalcon_test/');

        return $url;
    }
);

// Set the database service
$container->set(
    'db',
    function () {
        return new Mysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname'   => 'house_lister',
            ]
        );
    }
);

// Accept requests, detect the routes, dispatch the controller and render the view
$app = new Application($container);

try {
    // Handle the request

    // Original code is bugged
//    $response = $application->handle(
//        $_SERVER["REQUEST_URI"]
//    );
    $response =  $app->handle(
        str_replace('phalcon_test/','',$_SERVER['REQUEST_URI'])
    );

    $response->send();
} catch (Exception $e) {
    echo 'Exception: ', $e->getMessage();
}