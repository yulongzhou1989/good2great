<?php
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Config\Adapter\Ini as ConfigIni;
use Phalcon\Session\Adapter\Files as Session;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\Model\Manager as ModelsManager;

define('APP_PATH', realpath('..') . '/');

// Read the configuration
$config = new ConfigIni(APP_PATH . 'app/config/config.ini');

/**
 * Auto-loader configuration
 */
require APP_PATH . "app/config/loader.php";
// The FactoryDefault Dependency Injector automatically registers the
// right services providing a full-stack framework
$di = new FactoryDefault();
// Setup the view component
$di->set(
    "view",
    function () {
        $view = new View();
        $view->setViewsDir(
             "../app/views/"
        );
        return $view;
    }
);
/**
 * The URL component is used to generate all kind of URLs in the application
 */
$di->set(
    "url",
    function () use ($config) {
        $url = new UrlProvider();
        $url->setBaseUri(
            $config->application->baseUri
        );
        return $url;
    }
);
// Database connection is created based on parameters defined in the configuration file
$di->set(
    "db",
    function () use ($config) {
        return new DbAdapter(
            [
                "host"     => $config->database->host,
                "username" => $config->database->username,
                "password" => "0115051",
                "dbname"   => $config->database->name,
            ]
        );
    }
);

$di->set(
    "config",
    function() use ($config) {
        return $config;
    }
);

$di->set(
    "modelsManager",
    function() {
        return new ModelsManager();
    }
);

$application = new Application($di);
try {
    // Handle the request
    $response = $application->handle();
    $response->send();

} catch (\Exception $e) {
    echo "Exception: ", $e->getMessage();
}
