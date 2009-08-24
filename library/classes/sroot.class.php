<?php

class sRoot{
	/**
	 * The configuration settings, it will be available to all of the classes
	 * @var <type>
	 */
	protected $config;
	/**
	 * Display errors? Set this to true if you are going to seek for help, or have troubles with the script
	 * @var bool
	 */
	protected $displayErrors;
	public function __construct(){
		//sigh...
		global $config;
		$this->config = $config;
		$this->displayErrors = $this->config->development_environment;
	}
	/**
	 * Throws an exception
	 * @access protected
	 * @param string $error
	 * @param int $line
	 * @param string $file
	 * @return bool
	 */
	protected function error($error, $line = '', $file='') {
		if ( $this->displayErrors ) {
			if(!$line || !$file){
				$debug = debug_backtrace();
				if(!$line){
					$line = $debug[1]['line'];
				}
				if(!$file){
					$file = str_replace(ROOT, '', $debug[1]['file']);
				}
			}
			$error = $error.' on line '.$line.' of file '.$file;
		}
		throw new Exception($error);
	}
}