<?php
define("ROOT_PATH", realpath(dirname(__FILE__) . '/../'));

// Verify the path exists
if (!file_exists(ROOT_PATH)) {
    die("Fatal Error: Root path not found - " . ROOT_PATH);
}

spl_autoload_register(function ($class_name) {
    include ROOT_PATH . '/models/' . $class_name . '.php';
    include ROOT_PATH . '/controllers/' . $class_name . '.php';
    include ROOT_PATH . '/routes/' . $class_name . '.php';
});

require_once ROOT_PATH . '/configs/database.php';
?>