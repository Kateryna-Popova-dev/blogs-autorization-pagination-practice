<?php

if (!defined('DB_USER')) {
    define('DB_USER', 'root');
}
if (!defined('DB_PASSWORD')) {
    define('DB_PASSWORD', '');
}
if (!defined('DB_NAME')) {
    define('DB_NAME', 'blogsdb');
}
if (!defined('LOCATION')) {
    define('LOCATION', $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER["SERVER_NAME"]);
}
if (!defined('BASE_PATH')) {
    define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);
}

