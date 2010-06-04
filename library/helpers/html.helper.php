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
		$attributeString .= sEscape::html($attribute).'="'.sEscape::html($value).'"';
	}
	if(strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
		$url = $config->base_url.$config->index_file.$url;
	}
	echo '<a '.$attributeString.' href="'.sEscape::html($url).'">'.sEscape::html($title).'</a>';
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
		$attributeList .= sEscape::html($attribute) .'="'.sEscape::html($value).'" ';
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
		$str = '<link rel="stylesheet" type="text/css" href="'.sEscape::html($file).'"';
	} else {
		$str = '<link rel="stylesheet" type="text/css" href="'.sEscape::html($config->base_url.'public/css/'.$file).'"';
	}
	$str .= ' media = "'.sEscape::html(implode(',', $media)).'" />';
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
		echo '<script type="text/javascript" src="'.sEscape::html($file).'" ></script>';
	} else {
		echo '<script type="text/javascript" src="'.sEscape::html($config->base_url."public/js/$file").'" ></script>';
	}
}