<?php

class sEscape{
	/**
	 * Escape some html for output
	 * @param str $var
	 * @return str escaped var
	 */
	static function html($var){
		//I hate doing this, but we need the char_encoding variable, and it
		//will not work if it extends it (seeing as it is a static function)
        $config = sConfig::getInstance();
		return htmlspecialchars($var, ENT_QUOTES, $config->char_encoding);
	}
	/**
	 * Escape input for use in javascript
	 * @param str $var
	 * @return str escape("$var") 
	 */
	static function js($var){
		return strtr($var, array('\\'=>'\\\\',"'"=>"\\'",'"'=>'\\"',"\r"=>'\\r',"\n"=>'\\n','</'=>'<\/'));
	}
	/**
	 * Escape something that would be part of a url
	 * @param str $var
	 * @return str escaped var
	 */
	static function url($var){
		return rawurlencode($var);
	}
	/**
	 * Escape something to prevent xss attacks (not implemented!!!)
	 * @param str $var
	 * return str cleaned var
	 */
	static function xss($var){
		return $var;
	}
}
