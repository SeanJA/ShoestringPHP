<?php

/**
 * Generate a url (<a href="$url" $attributes>$title</a>)
 * @param str $url
 * @param str $title
 * @param array $attributes
 */
function href($url, $title, $attributes=array()) {
	$config = sConfig::getInstance();
	$attributeString = '';
	foreach($attributes as $attribute=>$value) {
		$attributeString .= h($attribute,false).'="'.h($value,false).'"';
	}
	if(strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
		$url = $config->base_url.$config->index_file.$url;
	}
	echo '<a '.$attributeString.' href="'.h($url,false).'">'.h($title,false).'</a>';
}

/**
 * Generate a url for an html link (<a href="mailto:$email" $attributes>$email</a>)
 * @param str $email
 * @param str $title
 * @param array $attributes
 */
function email_link($email, $attributes=array()) {
	$config = sConfig::getInstance();
	$attributes['href'] = 'mailto:'.$email;
	$attributeString = '';
	foreach($attributes as $attribute=>$value) {
		$attributeString .= h($attribute,false).'="'.h($value,false).'"';
	}
	echo '<a '.$attributeString.'">'.h($email,false).'</a>';
}

/**
 * Generate the doctype tag
 * xhtml1_strict
 * xhtml1_trans
 * html4_strict
 * html4_trans
 * html5
 * @param str $type
 * @return str
 */
function docType($type = 'html_trans') {
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
	}
	echo $docType;
}

/**
 * Generate a meta tag
 * @param array $attributes
 */
function metaTag($attributes) {
	if(!is_array($attributes)) {
		throw new Exception('Attributes must be provided in array format');
	}
	$attributeList = ' ';
	foreach($attributes as $attribute=>$value) {
		$attributeList .= h($attribute, false) .'="'.h($value, false).'" ';
	}
	echo '<meta'.$attributeList.'/>';
}

/**
 * Generate the charset meta tag
 * @param str $set
 * @return str
 */
function charset() {
	$config = sConfig::getInstance();
	$attributes = array(
		'http-equiv'=>'Content-Type',
		'content'=>'text/html; charset='.$config->char_encoding,
	);
	metaTag($attributes);
}

/**
 * Generate the css include string
 * @param str $file
 * @param str
 * @return <type>
 */
function css($file, $media=array('all')) {
	$config = sConfig::getInstance();
	if(!is_array($media)) {
		throw new Exception('media must be provided in array format');
	}
	if(strpos($file, 'http://') === 0 || strpos($file, 'https://') === 0) {
		$str = '<link rel="stylesheet" type="text/css" href="'.h($file, false).'"';
	} else {
		$str = '<link rel="stylesheet" type="text/css" href="'.h($config->base_url.'public/css/'.$file, false).'"';
	}
	$str .= ' media = "'.h(implode(',', $media), false).'" />';
	echo $str;
}

/**
 * Generate the js include string
 * @param <type> $file
 * @return <type>
 */
function js($file) {
	$config = sConfig::getInstance();
	if(strpos($file, 'http://') === 0 || strpos($file, 'https://') === 0) {
		echo '<script type="text/javascript" src="'.h($file, false).'" ></script>';
	} else {
		echo '<script type="text/javascript" src="'.h($config->base_url."public/js/$file", false).'" ></script>';
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
function twitter_link($account, $attributes=array()){
	href('http://twitter.com/'.$account, '@'.$account, $attributes);
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