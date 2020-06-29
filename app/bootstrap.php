<?php
    // Load Config File
    require_once 'config/config.php';
    // Load Helpers
    require_once 'helpers/url_helpers.php';   
    require_once 'helpers/session_helpers.php';
    // Load Libraries Files
    // require_once 'libraries/core.php';
    // require_once 'libraries/controller.php';
    // require_once 'libraries/database.php';

    // Autoload Core Libraries

    spl_autoload_register(function($className){
        require_once 'libraries/' . $className . '.php';
    });
?>