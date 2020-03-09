<?php

/** Load Config */
require_once 'config/config.php';

// Load Libraries

//require_once 'libraries/Core.php';
//require_once 'libraries/Controller.php';
//require_once 'libraries/Database.php';

/**
 * Autoload Libraries
 *
 * Libraries wil automatically be required once added to the libraries folder.
 */

spl_autoload_register(function ($className) {

//  An autoloader is a function that takes a class name as an argument
//  and then includes the file that contains the corresponding class:

//  An autoloader is a strategy for finding a PHP class, interface, or trait
//  and loading it into the PHP interpreter on-demand at run-time,
//  without explicitly including files.

    require_once 'libraries/' . $className . '.php';

});