<?php
/**
 * Display an error, it requires a severity
 * @param string $errorText
 * @param string $severity
 */
function error404($errorText){
	$config = sConfig::getInstance();
	die(header('Location: '.$config->base_url.$config->index_file.'errors/four-oh-four/'.$errorText));
}

/**
 *
 * @param <type> $errno
 * @param <type> $errstr
 * @param <type> $errfile
 * @param <type> $errline
 * @return <type>
 */
function sErrorHandler($errno, $errstr, $errfile, $errline){
//	$config = sConfig::getInstance();
	//	$backtrace = debug_backtrace();
	//    $backtrace = $backtrace[0];
	//    echo '<div class="'.$severity.'">';
	//    echo $errorText . '<br />';
	//    if($config->development_environment){
	//        echo $backtrace['file'] . '<br />';
	//        echo $backtrace['line'] . '<br />';
	//    }
	//    echo '</div>';
	//    if($severity == FATAL_ERROR){
	//        die();
	//    }
	$debug = debug_backtrace();

	if($errno === E_USER_ERROR){
		echo "<b>FATAL ERROR</b> [$errno] $errstr<br />\n";
		echo "  Fatal error on line $errline in file $errfile";
		echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
		exit(1);
	}
	elseif($errno === E_USER_WARNING){
		echo "<b>WARNING</b> [$errno] $errstr<br />\n";
	}
	elseif($errno === E_USER_NOTICE){
		echo "<b>NOTICE</b> [$errno] $errstr<br />\n";
	}
	else {
		echo "Unknown error type: [$errno] $errstr<br />\n";
	}
	/* Don't execute PHP internal error handler */
	return true;
}

function sExceptionHandler($exception) {
	$config = sConfig::getInstance();
	$debug = debug_backtrace();
	$debug = $debug[0]['args'][0];
	echo 'Uncaught exception: ' , $exception->getMessage(), "\n";
	if($config->development_environment){
		echo 'On line ', $debug->getLine(), "<br />";
		echo 'In File: ', $debug->getFile();
//		echo 'Trace: ';
//		pre_print_r($debug->getTrace());
	}
}

//$old_error_handler = set_error_handler('sErrorHandler');
//set_exception_handler('sExceptionHandler');