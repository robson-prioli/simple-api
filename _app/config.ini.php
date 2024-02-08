<?php

// autoload
spl_autoload_register(function ($class) {
    $directories = ['classes']; 

    foreach ($directories as $directory) {
        $classFile = __DIR__ . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . $class . '.class.php';

        if (file_exists($classFile)) {
            require_once($classFile);
        }
    }
});
