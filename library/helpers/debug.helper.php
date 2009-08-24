<?php
/**
 * wraps print_r with <pre> </pre> to make it easier to read
 * Only works in development mode
 * @param any $var
 */
function pre_print_r($var){
	global $config;
	if($config->development_environment){
	    echo "<pre>";
	    print_r($var);
	    echo "</pre>";
	} else {
	    throw new Exception('pre_print_r is in use in a production environment');
	}
}

/**
 * wraps var_dump with <pre> </pre> to make it easier to read
 * Only works in development mode
 * @param any $var
 */
function pre_var_dump($var){
	global $config;
	if($config->development_environment){
	    echo "<pre>";
	    var_dump($var);
	    echo "</pre>";
	}
}

/**
 * Wraps debug_backtrace with pre_print_r making it easier to read and a lot less to write
 * Only works in development mode
 */
function pre_debug_backtrace(){
	global $config;
	if($config->development_environment){
		pre_print_r(debug_backtrace());
	}
}

/**
 * Pulls out the file, line, class and function for each level in the debug_backtrace
 * Only works in development mode
 */
function pre_trace(){
	global $config;
	if($config->development_environment){
		$debug = debug_backtrace();
		$trace = '<div class="trace">';
		foreach($debug as $level=>$d){
			$trace .= "Level: {$level}\n";
			if(isset($d['file'])){
				$trace .= "{$d['file']}\n";
			}
			if(isset($d['line'])){
				$trace .= "{$d['line']}\n";
			}
			if(isset($d['class'])){
				$trace .= "{$d['class']}\n";
			}
			if(isset($d['function'])){
				$trace .= "{$d['function']}\n";
			}
			$trace .= "<hr />\n";
		}
		$trace .= '</div>';
		pre_print_r($trace);
	}
}

/**
 * Handles the sAssert callback
 * @param string $file
 * @param string $line
 * @param string $code
 */
function sAssertHandler($file, $line, $code){
	echo "<hr />
	<div class=\"assert_error\">
		Assertion Failed:
		File '$file'<br />
		Line '$line'<br />
		Code '$code'<br />
	</div>
	<hr />";
}

/**
 * Sets the assert_options and then calls assert
 * Always fatal when assertion fails 
 * @param string $code The code you are testing
 */
function sAssert($code=null){
	global $config;
	if($config->deveopment_environment){
		@assert_options(ASSERT_ACTIVE, 		true);
		@assert_options(ASSERT_WARNING, 	false);
		@assert_options(ASSERT_QUIET_EVAL, 	true);
		@assert_options(ASSERT_BAIL, 		true);
		@assert_options(ASSERT_CALLBACK, 	'sAssertHandler');
		assert($code);
	}
}

