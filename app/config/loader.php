
<?php

$loader = new Phalcon\Loader();

// We're a registering a set of directories taken from the configuration file
$loader->registerDirs(
    [
      // "../app/controllers/",
      // "../app/models/",
        APP_PATH . $config->application->controllersDir,
        APP_PATH . $config->application->modelsDir,
    ]
);


$loader->register();
