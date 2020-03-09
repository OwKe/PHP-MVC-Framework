<?php

// Need to require other files from our "/App" folder

require_once '../app/bootstrap.php';

// You can include all the required files here but it cleaner to have a
// separate file ("/app/bootstrap.php") for that purpose.


// Init Core Library

/*
 * The will instantiate the Core Class
 * Which will run the constructor
 * Which in turn executes the getUrl() method.
 */

$init = new Core;