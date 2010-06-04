<?php
if(floatval(phpversion()) < 5){
    die('ShoestringPHP requires PHP Version 5.x');
}
require_once (ROOT . DS . 'config' . DS . 'config.php');
require_once (ROOT . DS . 'config' . DS . 'database.php');
require_once (ROOT . DS . 'config' . DS . 'user.php');
$config = (object)$config;
require_once (ROOT .  DS . 'library' . DS . 'errors.php');
require_once (ROOT . DS . 'library' . DS . 'shared.php');