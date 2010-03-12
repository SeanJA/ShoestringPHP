<?php


/**
 * Check if environment is development and display errors
 */
function setReporting() {
	$config = sConfig::getInstance();
	ini_set('log_errors', 'On');
	ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'error.log');
	if ($config->development_environment == true) {
		error_reporting(E_ALL|E_STRICT);
		ini_set('display_errors','On');
	} else {
		error_reporting(E_ALL|E_STRICT);
		ini_set('display_errors','Off');
	}
}

/**
 * Check for Magic Quotes and remove them
 */

function stripSlashesDeep($value) {
	$value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
	return $value;
}

/**
 * 
 */
function removeMagicQuotes() {
	if ( get_magic_quotes_gpc() ) {
		$_GET    = stripSlashesDeep($_GET   );
		$_POST   = stripSlashesDeep($_POST  );
		$_COOKIE = stripSlashesDeep($_COOKIE);
	}
}

/**
 * Check register globals and remove them
 */
function unregisterGlobals() {
	if (ini_get('register_globals')) {
		$array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
		foreach ($array as $value) {
			foreach ($GLOBALS[$value] as $key => $var) {
				if ($var === $GLOBALS[$key]) {
					unset($GLOBALS[$key]);
				}
			}
		}
	}
}

/**
 * Main Call Function everything goes through here!
 */
function callHook() {
	$url = isset($_SERVER['PATH_INFO'])? $_SERVER['PATH_INFO']:null;
	$config = sConfig::getInstance();

	if($url == '/'){
		$url = null;
	}
	if(is_null($url)){
		die(header('Location: '.$config->base_url.$config->index_file.$config->default_location));
	} else {
		//code igniter style
//		if ( ! preg_match("|^[".preg_quote($config->allowed_uri_characters)."]+$|i", $url)){
//			var_dump(preg_quote($config->allowed_uri_characters));
//			die(header('Location: '.$config->base_url.$config->index_file.'errors/invalid-characters/'));
//		}
		$urlArray = array();
		$urlArray = explode("/",$url);
		if($urlArray[0] == ''){
			array_shift($urlArray);
		}
		$controller = $urlArray[0];
		if(!isset($urlArray[1]) || empty($urlArray[1])){
			$action = 'index';
		} else {
			$action = $urlArray[1];
		}
		array_shift($urlArray);
		array_shift($urlArray);
		$queryString = $urlArray;
	}
	if(strpos($action, '_') !== false){
		error404($url);
	}
	$controllerName = $controller;
	$controller = ucwords($controller);
	$model = $controller;
	$controller .= '_Controller';
	$action = str_replace('-', '_', $action);
	$dispatch = new $controller($model,$controllerName,$action);
	if ($action[0] !== '_' && in_array($action, get_class_methods( $controller ))) {
		$action = str_replace('-', '_', $action);
		call_user_func_array(array($dispatch,$action),$queryString);
	} else {
		error404($url);
	}
}

/**
 * Autoload any classes that are required
 */
function shoestringAutoload($className) {
	$url = isset($_SERVER['PATH_INFO'])? $_SERVER['PATH_INFO']:null;
	$config = sConfig::getInstance();
	//echo "auto_load $className";
	//autoload helpers (load the users helpers, then load ours so functions can be overridden)
	foreach($config->auto_load['helpers'] as $helper){
		if(file_exists(ROOT . DS . 'application' . DS . 'helpers' . DS . strtolower($helper) .$config->helper_prefix. '.php')){
			include_once(ROOT . DS . 'application' . DS . 'helpers' . DS . strtolower($helper) .$config->helper_prefix. '.php');
		}
		if(file_exists(ROOT . DS . 'library' . DS . 'helpers' . DS . strtolower($helper).'.helper.php')){
			include_once(ROOT . DS . 'library' . DS . 'helpers' . DS . strtolower($helper).'.helper.php');
		}
	}
	//controllers
	if(strpos($className, '_Controller') !== false){
		$className = str_replace('_Controller','',$className);
		if (file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php')) {
			include_once(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php');
		} else {
				  error404($url);
				}
	}
	//library classes
	else if (file_exists(ROOT . DS . 'application' . DS . 'library' . DS . strtolower($className) . '.class.php')) {
		include_once(ROOT . DS . 'application' . DS . 'library' . DS . strtolower($className) . '.class.php');
	}
	else if (file_exists(ROOT . DS . 'library' . DS . 'classes' . DS . strtolower($className) . '.class.php')) {
		include_once(ROOT . DS . 'library' . DS . 'classes' . DS . strtolower($className) . '.class.php');
	}
	//models
	else if (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php')) {
		include_once(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php');
	} else {
		error404($url);
		//throw new Exception('Class not found '. strtolower($className));
	}
}
spl_autoload_register('shoestringAutoload');

// set to the user defined error handler

setReporting();
removeMagicQuotes();
unregisterGlobals();
callHook();




