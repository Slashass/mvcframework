<?php
/*
   * App Core Class
   * Creates URL & loads core controller
   * URL FORMAT - /controller/method/params
*/
class Core
{
    // if there is no other controlers this page will be auto reloaded
    protected $currentController = 'Pages';
    // instide pages it will load index 
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->getUrl();

        // Look in controllers for first value ucwords will capitalize first letter
        if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            // will set a new controller
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        }
        // Require the controller
        require_once '../app/controllers/' . $this->currentController . '.php';
        // Instantiate controller class
        $this->currentController = new $this->currentController;

        // Check for second part of the URL
        if (isset($url[1])) {
            // Check to see if method exists in controller
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                // Unset 1 index
                unset($url[1]);
            }
        }

        // Get parameters
        //Check if there is any params and if not keep it empty
        $this->params = $url ? array_values($url) : [];

        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }



    public function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');

            // we are not allowing char which are not allowed in url
            // allows you to filter variables as string/number
            $url = filter_var($url, FILTER_SANITIZE_URL);
            // Break  in into an array
            $url = explode('/', $url);
            return $url;
        }
    }
}
