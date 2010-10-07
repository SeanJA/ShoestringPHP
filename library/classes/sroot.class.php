<?php

abstract class sRoot {

	/**
	 * The configuration settings, it will be available to all of the classes
	 * @var sConfig
	 */
	protected $config;
	/**
	 * Display errors? Set this to true if you are going to seek for help, or have troubles with the script
	 * @var bool
	 *
	 */
	protected $displayErrors;
	public function __construct() {
		$this->config = sConfig::getInstance();
		$this->displayErrors = $this->config->development_environment;
	}

	/**
	 * Throws an exception, if in development mode it will try to add in the location of the error as well
	 * @param string $error
	 * @param int $line
	 * @param string $file
	 * @return bool
	 */
	protected function error($error, $line = '', $file='') {
		if ($this->displayErrors) {
			if (!$line || !$file) {
				$debug = debug_backtrace();
				if (!$line) {
					$line = $debug[1]['line'];
				}
				if (!$file) {
					$file = str_replace(ROOT, '', $debug[1]['file']);
				}
			}
			$error = $error . ' on line ' . $line . ' of file ' . $file;
		}
		throw new Exception($error);
	}

	/**
	 * Retrieve a post variable if it is set, otherwise it will return null
	 * @param string $var
	 * @param int $filter The way that you want to filter the input ( default is FILTER_UNSAFE_RAW )
	 * @return multiple
	 */
	protected function post($var, $filter=FILTER_UNSAFE_RAW) {
		if (isset($_POST[$var])) {
			return filter_input(INPUT_POST, $var, $filter);
		}
		return null;
	}

	/**
	 * Retrieve a get variable if it is set, otherwise it will return null
	 * @param string $var
	 * @param int $filter The way that you want to filter the input ( default is FILTER_UNSAFE_RAW )
	 * @return multiple
	 */
	protected function get($var, $filter=FILTER_UNSAFE_RAW) {
		if (isset($_POST[$var])) {
			return filter_input(INPUT_GET, $var, $filter);
		}
		return null;
	}

	/**
	 * Retrieve a request variable if it is set, otherwise it will return null
	 * @param string $var
	 * @param int $filter The way that you want to filter the input ( default is FILTER_UNSAFE_RAW )
	 * @return multiple
	 */
	protected function request($var, $filter=FILTER_UNSAFE_RAW) {
		if (isset($_REQUEST[$var])) {
			return filter_input(INPUT_REQUEST, $var, $filter);
		}
		return null;
	}

	/**
	 * Retrieve a session variable if it is set, otherwise it will return null
	 * @param string $var
	 * @param int $filter The way that you want to filter the input ( default is FILTER_UNSAFE_RAW )
	 * @return multiple
	 */
	protected function session($var, $filter=FILTER_UNSAFE_RAW) {
		if (isset($_SESSION[$var])) {
			return filter_input(INPUT_SESSION, $var, $filter);
		}
		return null;
	}

	/**
	 * Retrieve a cookie variable if it is set, otherwise it will return null
	 * @param string $var
	 * @param int $filter The way that you want to filter the input ( default is FILTER_UNSAFE_RAW )
	 * @return multiple
	 */
	protected function cookie($var, $filter=FILTER_UNSAFE_RAW) {
		if (isset($_COOKIE[$var])) {
			return filter_input(INPUT_COOKIE, $var, $filter);
		}
		return null;
	}

}