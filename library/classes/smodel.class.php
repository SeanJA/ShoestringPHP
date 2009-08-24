<?php
/**
 * Generic Model Class
 */
class sModel{
	protected $_model;
	public function __construct() {
		$this->_model = get_class($this);
	}

	public function __destruct() {
	}
}
