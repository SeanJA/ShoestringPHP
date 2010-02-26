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
//	public function  __call($name,  $arguments) {
//		if (!preg_match('/^(find|findFirst|count)By(\w+)$/', $method, $matches)) {
//            throw new Exception("Call to undefined method {$method}");
//        }
//
//        $criteriaKeys = explode('_And_', preg_replace('/([a-z0-9])([A-Z])/', '$1_$2', $matches[2]));
//        $criteriaKeys = array_map('strtolower', $criteriaKeys);
//        $criteriaValues = array_slice($params, 0, count($criteriaKeys));
//        $criteria = array_combine($criteriaKeys, $criteriaValues);
//
//        $method = $matches[1];
//        return $this->$method($criteria);
//	}
	public function __destruct() {
	}
}
