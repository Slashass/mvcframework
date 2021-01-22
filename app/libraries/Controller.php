<?php

// Load the model and the view

class Controller
{
    // Core model file which will look for the right model file
    public function model($model)
    {
        // require model file
        require_once '../app/models/' . $model . '.php';
        // Instantiate model
        return new $model();
    }

    // Load the view (check for the file)
    public function view($view, $data = [])
    {
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            die("View does not exist.");
        }
    }
}
