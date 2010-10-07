<?php

/**
 * Generate a url (<a href="$url" $attributes>$title</a>)
 * @param str $url the url being linked to
 * @param str $title will appear between the <a>[$title]</a>
 * @param array $attributes other attributes that will be added to the element
 * @param boolean $echo Whether or not to echo out the string at the end, default true
 * @return if the string is not echoed, return the string
 */
function href($url, $title, $attributes=array(), $echo=true) {
	$config = sConfig::getInstance();
	$attributeString = '';
	foreach($attributes as $attribute=>$value) {
		if(strtolower($attribute) != 'href'){
			$attributeString .= h($attribute,false).'="'.h($value,false).'" ';
		}
	}
	$linkTypes = array('https?:\/\/','mailto:','git:\/\/','git@','ftps?:\/\/');
	if(!preg_match('/^('.implode('|', $linkTypes).')/', $url)) {
		$url = $config->base_url.$config->index_file.$url;
	}
	$return = '<a '.$attributeString.'href="'.h($url,false).'">'.h($title,false).'</a>';
	if($echo){
		echo $return;
	} else {
		return $return;
	}
}

/**
 * Generate a url for an html link (<a href="mailto:$email" $attributes>$email</a>)
 * @param str $email the email being linked to
 * @param array $attributes other attributes that will be added to the element
 * @param boolean $echo Whether or not to echo out the string at the end, default true
 * @return if the string is not echoed, return the string
 */
function email_link($email, $attributes=array(), $echo=true) {
	return href('mailto:'.$email, $email, $attributes, $echo);
}

/**
 * Generate the doctype tag
 * xhtml1_strict
 * xhtml1_trans
 * html4_strict
 * html4_trans
 * html5
 * @param str $type
 * @param boolean $echo Whether or not to echo out the string at the end, default true
 * @return if the string is not echoed, return the string
 */
function docType($type = 'html4_trans', $echo=true) {
	$docType = '';
	switch ($type) {
		case 'xhtml1_strict':
			$docType = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
			break;
		case 'xhtml1_trans':
			$docType = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
			break;
		case 'html4_strict':
			$docType = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">';
			break;
		case 'html4_trans':
			$docType = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
  "http://www.w3.org/TR/html4/loose.dtd">';
			break;
		case 'html5':
			$docType = '<!DOCTYPE html>';
			break;
		default:
			throw new Exception('Unknown Doctype "'.$type.'".');
	}
	if($echo){
		echo $docType;
	} else {
		return $docType;
	}
}

/**
 * Generate a meta tag
 * @param array $attributes
 * @param boolean $echo Whether or not to echo out the string at the end, default true
 * @return if the string is not echoed, return the string
 */
function metaTag(array $attributes, $echo=true) {
	$attributeList = ' ';
	foreach($attributes as $attribute=>$value) {
		$attributeList .= h($attribute, false) .'="'.h($value, false).'" ';
	}
	$meta = '<meta'.$attributeList.'/>';
	if($echo){
		echo $meta;
	} else {
		return $meta;
	}
}

/**
 * Generate the charset meta tag
 * @param boolean $echo Whether or not to echo out the string at the end, default true
 * @return if the string is not echoed, return the string
 */
function charset($echo=true) {
	$config = sConfig::getInstance();
	$attributes = array(
		'http-equiv'=>'Content-Type',
		'content'=>'text/html; charset='.$config->char_encoding,
	);
	return metaTag($attributes, $echo);
}

/**
 * Generate the css include string
 * @param str $file The css file that you are linking to
 * @param array $media The media types that you want to use this css file for
 * @param boolean $echo Whether or not to echo out the string at the end, default true
 * @return if the string is not echoed, return the string
 */
function css($file, array $media=array('all'), $echo) {
	if(preg_match('/^(https?:\/\//)', $file)) {
		$str = '<link rel="stylesheet" type="text/css" href="'.h($file, false).'"';
	} else {
		$config = sConfig::getInstance();
		$str = '<link rel="stylesheet" type="text/css" href="'.h($config->base_url.'public/css/'.$file, false).'"';
	}
	$str .= ' media = "'.h(implode(',', $media), false).'" />';
	if($echo){
		echo $str;
	} else {
		return $str;
	}
}

/**
 * Generate the js include string
 * @param string $file the js file being linked to
 * @param boolean $echo Whether or not to echo out the string at the end, default true
 * @return if the string is not echoed, return the string
 */
function js($file) {
	if(preg_match('/^(https?:\/\//)', $file)) {
		$str = '<script type="text/javascript" src="'.h($file, false).'" ></script>';
	} else {
		$config = sConfig::getInstance();
		$str = '<script type="text/javascript" src="'.h($config->base_url."public/js/$file", false).'" ></script>';
	}
	if($echo){
		echo $str;
	} else {
		return $str;
	}
}

/**
 * Short code to escape a variable for html
 * @param string $var the string being escaped
 * @param boolean $echo Whether or not to print to the screen (default true)
 */
function h($var, $echo=true){
	$config = sConfig::getInstance();
	if($echo){
		echo sEscape::html($var);
	} else {
		return sEscape::html($var);
	}
}

/**
 * Add an image to the page
 * @param string $image
 * @param string $alt
 * @param array $attributes
 */
function image($image, $alt, $attributes=array()){
	$config = sConfig::getInstance();
	$attributes['alt']= $alt;
	$attributeString = '';
	foreach($attributes as $key=>$value){
		$attributeString .= ' '.h($key, false) .'="'.h($value, false).'" ';
	}
	echo '<img '.$attributeString.' src="'.$config->base_url.'/public/images/'.$image.'" />';
}

/**
 * Add a twitter link to the page
 * @param string $image
 * @param string $alt
 * @param array $attributes
 */
function twitter_link($account, $attributes=array(), $echo = true){
	return href('http://twitter.com/'.$account, '@'.$account, $attributes);
}

/**
 * Process the text and return it marked down
 * @staticvar parser_class $parser
 * @param string $text
 * @return string
 */
function markdown($text) {
	// Setup static parser variable.
	static $parser;
	if (!isset($parser)) {
		$parser = new Markdown();
	}
	//Transform text using parser.
	echo $parser->transform($text);
}