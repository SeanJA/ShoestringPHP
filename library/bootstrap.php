<?php
if(floatval(phpversion()) < 5){
    throw new Exception('ShoestringPHP requires PHP Version 5.x');
}
require_once (ROOT . DS . 'application' . DS . 'config' . DS . 'config.php');
require_once (ROOT . DS . 'application' . DS . 'config' . DS . 'database.php');
require_once (ROOT . DS . 'application' . DS . 'config' . DS . 'user.php');
require_once (ROOT . DS . 'library' . DS . 'classes' . DS .'sconfig.class.php');
$configVars = $config;
$config = sConfig::getInstance();
$config->load($configVars);
require_once (ROOT .  DS . 'library' . DS . 'errors.php');
require_once (ROOT . DS . 'library' . DS . 'shared.php');