<?php
class sValidate{
	/**
	 * Validate a string against some pattern
	 * @param string $string
	 * @param regex $pattern
	 * @return boolean
	 */
	static function regex($string, $pattern){
		if(is_array($pattern)){
			$pattern = $pattern[0];
		}
		$return = array('valid'=>true, 'error'=>'');
		if(preg_match($pattern, $string)){
			$return['valid'] = true;
		} else {
			$return['valid'] = false;
			$return['error'] = ' is invalid';
		}
		return $return;
	}
	/**
	 * Validate a url
	 * @param url $url
	 * @return bool
	 */
	static function url($url){
		$return = array('valid'=>true, 'error'=>'');
		$regex = '/((?:https?|ftp)(?::\\/{2}[\\w]+)(?:[\\/|\\.]?)(?:[^\\s"]*))/is';
		// check
		$return = self::regex($url, $regex);
		if($return['valid'] === false){
			$return['error']=' is not a valid url';
		}
		return $return;
	}
	/**
	 * Validate the maximum length of a string
	 * @param string $string
	 * @param int $maxLength
	 * @return bool
	 */
	static function maxLen($string, $maxLength){
		if(is_array($maxLength)){
			$maxLength = $maxLength[0];
		}
		$return = array('valid'=>true, 'error'=>'');
		if(!is_int($maxLength) && !is_numeric($maxLength)){
			throw new Exception('$maxLength is not an integer');
		}
		if($maxLength < 0){
			throw new Exception('$minLength must be >= 0');
		}
		if(!is_string($string)){
			throw new Exception('$string is not a string');
		}
		if(isset($string[$maxLength+1])){
			$return['valid'] = false;
			$return['error'] = ' is too long';
		} else {
			$return['valid'] = true;
		}
		return $return;
	}
	/**
	 * Validate the minimum length of a string
	 * @param string $string
	 * @param int $minLength
	 * @return bool
	 */
	static function minLen($string, $minLength){
		$return = array('valid'=>true, 'error'=>'');
		if(is_array($minLength)){
			$minLength = $minLength[0];
		}
		$minLength -= 1;
		if(is_null($string)){
			$return['valid'] = false;
			$return['error'] = ' does not appear to have any content';
		}
		if(!is_int($minLength) && !is_numeric($minLength)){
			throw new Exception('$minLength is not an integer');
		}
		if($minLength < 0){
			throw new Exception('$minLength must be >= 0');
		}
		if(!is_string($string)){
			$return['valid'] = false;
			$return['error'] = ' does not appear to be a string';
		}
		if(!isset($string[$minLength])){
			$return['valid'] = false;
			$return['error'] = ' is too short';
		}
		return $return;
	}
	/**
	 * Validate the maximum value of an int
	 * @param string $value
	 * @param int $max
	 * @return bool
	 */
	static function max($value, $max){
		if(is_array($max)){
			$max = $max[0];
		}
		$return = array('valid'=>true, 'error'=>'');
		if(is_null($value)){
			return false;
		}
		if(!is_numeric($max)){
			throw new Exception('$max is not numeric');
		}
		if(!is_numeric($value)){
			throw new Exception('$value is not numeric');
		}
		if($value <= $max){
			$return['valid'] = true;
		} else {
			$return['valid'] = false;
			$return['error'] = ' is too large';
		}
		return $return;
	}
	/**
	 * Validate the minimum value of a number
	 * @param string $value
	 * @param int $min
	 * @return bool
	 */
	static function min($value, $min){
		if(is_array($min)){
			$min = $min[0];
		}
		$return = array('valid'=>true, 'error'=>'');
		if(is_null($value)){
			return false;
		}
		if(!is_numeric($min)){
			throw new Exception('$min is not numeric');
		}
		if(!is_numeric($value)){
			throw new Exception('$value is not numeric');
		}
		if($value >= $min){
			$return['valid'] = true;
		} else {
			$return['valid'] = false;
			$return['error'] = ' is too small';
		}
		return $return;
	}
	/**
	 * Validate an email address
	 * @param email $email
	 * @return bool
	 */
	static function email($email){
		$return = self::regex($email, '/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU');
		if(!$return['valid']){
			$return['message'] = ' does not appear to be a valid email address';
		}
		return $return;
	}
	static function required($var){
		$return = array(
			'valid'=>true,
			'error'=>''
		);
		if(is_null($var) || $var === ''){
			$return['valid'] = false;
			$return['error'] = ' is required';
		}
		return $return;
	}
}