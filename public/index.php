<?php
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Config\Adapter\Ini as ConfigIni;
use Phalcon\Session\Adapter\Files as Session;

// ...

// Read the configuration
$config = new ConfigIni(
    APP_PATH . "app/config/config.ini"
);

/**
 * Auto-loader configuration
 */
require APP_PATH . "app/config/loader.php";

$loader = new Phalcon\Loader();

// We're a registering a set of directories taken from the configuration file
$loader->registerDirs(
    [
        APP_PATH . $config->application->controllersDir,
        APP_PATH . $config->application->pluginsDir,
        APP_PATH . $config->application->libraryDir,
        APP_PATH . $config->application->modelsDir,
        APP_PATH . $config->application->formsDir,
    ]
);

$loader->register();
// ...

define(
    "APP_PATH",
    realpath("..") . "/"
);

/**
 * Load application services
 */
require APP_PATH . "app/config/services.php";

// Create a DI
$di = new FactoryDefault();

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

$application = new Application($di);

$response = $application->handle();

$response->send();

// Start the session the first time a component requests the session service
$di->set(
    "session",
    function () {
        $session = new Session();

        $session->start();

        return $session;
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
                "password" => $config->database->password,
                "dbname"   => $config->database->name,
            ]
        );
    }
);
