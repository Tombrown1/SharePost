<?php
/*
 *  Base Controller
 *  Loads the models and Views
 */

    class Controller {
        // Load Models
        public function model($model){
            // Require Model File
            require_once '../app/models/' . $model . '.php';

            // Instantiate model
            return new $model();
        }

        // Load Views
        public function view($view, $data = []){
            if(file_exists('../app/views/' . $view . '.php')){
                require_once '../app/views/' . $view . '.php';
        
        }else{
            // The view does not exist
            die('View does not exist');
        }
    }
}

?>