<?php

$loader = new Phalcon\Loader();

// We're a registering a set of directories taken from the configuration file
$loader->registerDirs(
    [
        //APP_PATH . $config->application->libraryDir,
        APP_PATH . $config->application->controllersDir,
        APP_PATH . $config->application->modelsDir
    ]
);

// $loader->registerClasses([
//     'Services' => APP_PATH . 'app/Services.php'
// ]);

$loader->register();
