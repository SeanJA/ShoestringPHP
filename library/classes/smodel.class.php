<?php
/**
 * Generic Model Class
 */
class sModel extends sRoot{
	protected $_model;
	public function __construct() {
        parent::__construct();
		$this->_model = get_class($this);
	}

	public function __destruct() {
	}
}
