<?php

/**
 * Generate a full url for a link on this site (or just the base url if you must)
 * @param str $url default empty string
 * @return str
 */
function baseUrl($url=''){
	$config = sConfig::getInstance();
	//if someone prefixes the url with a slash, remove it!
	if(strpos($url,'/') === 0){
		$url = substr($url, 1, strlen($url)-1);
	}
	return sEscape::html($config->base_url.$config->index_file.$url);
}
/**
 * Redirect within the site
 * @param str $url
 * @param long $header
 */
function redirect($url, $header=null){
	die(header('Location: '.baseUrl($url), true, $header));
}

/**
 * Returns the current url, or a part of the url at a specific position
 * @param int $position
 */
function currentUrl($position=''){
	$url = $_SERVER['PHP_SELF'];
	$url = str_replace($_SERVER['SCRIPT_NAME'], '', $url);
	if($position !== ''){
		$url = explode('/', $url);
		return $url[$position];
	}
	return $url;
}