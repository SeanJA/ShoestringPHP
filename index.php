<?php

//shorten the directory separator
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd());
$url = isset($_SERVER['PATH_INFO'])? $_SERVER['PATH_INFO']:null;
require_once (ROOT . DS . 'library' . DS . 'bootstrap.php');