<?php

/**
 * App Core Class
 * Creates URL & Loads Core controller
 * URL FORMAT - /controller/method/params
 * Mapping of Controllers, Methods and Params
 */

class Core {

    protected $currentController = 'Pages'; // If there are no other controllers this is what will load.
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->getUrl(); // FORMAT: controller[0], method[1], params[2]

        /**
         * GET CONTROLLER
         *
         *  - Check if the controller file specified in the URL exists.
         *  - If exists, set as current controller, also unset [0] Index.
         *  - Require the controller file.
         *  - Instantiate controller class. So example: $pages = new Pages;
         */
        if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {

            $this->currentController = ucwords($url[0]); // ucwords will capitalise the first letter (which matches our Class Names)
            unset($url[0]);
        }

        require_once '../app/controllers/'. $this->currentController . '.php';

        $this->currentController = new $this->currentController;

        /**
         *  GET METHOD
         *
         *  - Check if method exists in current controller.
         *  - If exists, set as current method, also unset [1] Index
         */
        if(isset($url[1])) {

            if(method_exists($this->currentController, $url[1])) {

                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        /**
         * GET PARAMETERS
         *
         * If there are parameters in the URL they will be added to $params prop, otherwise this will be and empty array.
         * Task could be explained as: Open the Pages Controller and Run the Method call index(), passing in $id and $count params.
         */
        $this->params = $url ? array_values($url) : [];

        //                  ([ControllerName: Pages   , MethodName: index   ], [$id, $count]);
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);

    }


    /**
     * Get the current URL
     *
     * Strip whitespace and '/' from the end of the URL.
     * Remove all non valid URL characters.
     * Explode the srting to an Array on each '/'.
     *
     * @return array
     */
    public function getUrl()
    {
        if(isset($_GET['url'])) {

            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            return $url;
        }

    }


}