<?php
$root  = dirname(__FILE__).'/';
var_dump($root);
$root = str_replace('tests'.DIRECTORY_SEPARATOR.'library', '', $root);
define('ROOT', $root);
set_include_path(
	$root
	.PATH_SEPARATOR
	.ini_get("include_path")
);

require_once('PHPUnit/Framework.php');
require_once('tests/application/config/config.php');
require_once('tests/application/config/database.php');
require_once('tests/application/config/user.php');
require_once('library/classes/sroot.class.php');
require_once('library/classes/sconfig.class.php');
require_once('library/classes/sescape.class.php');
$configVars = $config;
$config = sConfig::getInstance();
$config->load($configVars);