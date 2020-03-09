<?php

/**
 * Base Controller
 * Loads the modals and views
 */

class Controller {

    /**
     * Loads Model
     *
     * Checks if model file exists and requires this file if so.
     * Then Instantiates the Class for whichever model is required e.g. return new Post();
     *
     * @param string $model name of the model Class
     * @return object
     */
    public function model($model)
    {
        require_once '../app/models/' . $model . '.php';
        return new $model(); //
    }

    /**
     * Loads View
     *
     * Checks if view file exists and requires this file if so.
     *
     * @param string $view name of the view file
     * @param array $data dynamic values that we pass into the view
     */
    public function view($view, $data = []) {

        if(file_exists('../app/views/' .$view. '.php')) {
            require_once '../app/views/' .$view. '.php';
        } else {
            die('View not found');
        }
    }

}