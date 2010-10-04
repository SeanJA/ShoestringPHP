<?php
/**
 * @property bool $development_environment
 * @property string $base_url
 * @property string $index_file
 * @property string $allowed_uri_characters
 * @property string $char_encoding
 * @property string $default_location
 * @property string $helper_prefix
 * @property array $auto_load
 * @property string $auto_load['helpers']
 * @property array $db
 * @property string $db['name']
 * @property string $db['user']
 * @property string $db['password']
 * @property string $db['host']
 * @property string $db['type']
 * @property array $users
 * @property string $users['table']
 * @property string $users['encryption']
 * @property array $users['fields']
 * @property string $users['session_name']
 * @property string $users['salt_length']
 */
class sConfig {
	/**
	 *
	 * @var sConfig
	 */
	private static $instance;
	/**
	 *
	 */
	private $data = array();
	/**
	 *
	 * @param array $config
	 */
	protected function __construct(array $config = array()) {
		if($config) {
			$this->load($config);
		}
	}
	/**
	 *
	 * @param array $config
	 */
	function load(array $config) {
		$this->data = $config;
	}
	/**
	 * Get a var from the config values
	 * @param string $var
	 */
	function __get($var) {
		if(isset($this->data[$var])) {
			return $this->data[$var];
		}
	}
	/**
	 *
	 * @param string $var
	 * @param multiple $value
	 * @return  multiple
	 */
	function __set($var, $value) {
		return $this->data[$var] = $value;
	}

	/**
	 * Get the only instance of this class that should exist
	 * @return sConfig
	 */
	public static function getInstance() {
		if (!isset(self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c;
		}

		return self::$instance;
	}
	/**
	 * prevent cloning this object
	 */
	public function __clone() {
		trigger_error('Clone is not allowed.', E_USER_ERROR);
	}
}