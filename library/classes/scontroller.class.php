<?php

class sController extends sRoot{
    /**
     * 
     * @var string
     */
	protected $controller;
	/**
	 *
	 * @var sTemplate
	 */
	protected $template;
	/**
	 *
	 * @var array
	 */
	private $validationErrors = array();
	/**
	 *
	 * @var array
	 */
	private $validation = array();
	/**
	 *
	 * @var array
	 */
	private $validationFields = array();
	/**
	 *
	 * @param string $controller
	 */
	public function __construct($controller) {
		parent::__construct();
		$this->template = new sTemplate($controller);
	}
	/**
	 * Load a helper
	 * @param string $helper
	 */
	public function loadHelper($helper){
		if(file_exists(ROOT . DS . 'application' . DS . 'helpers' . DS . strtolower($helper) .$this->config->helper_prefix. '.php')){
			include_once(ROOT . DS . 'application' . DS . 'helpers' . DS . strtolower($helper) .$this->config->helper_prefix. '.php');
		} elseif(file_exists(ROOT . DS . 'library' . DS . 'helpers' . DS . strtolower($helper).'.helper.php')){
			include_once(ROOT . DS . 'library' . DS . 'helpers' . DS . strtolower($helper).'.helper.php');
		} else {
			$this->error('Helper does not exist: '.$helper);
		}
	}
    /**
     * Set how things will be validated
     * @param array $array['variable']=>'validation';
     */
	protected function setValidation($array){
		$this->validation = $array;
	}
    /**
     * Set the human readable variables (to be displayed in the view)
     * @param array $array['variable']=>'Human Readable Variable'
     */
	protected function setValidationFields($array){
		$this->validationFields = $array;
	}
	/**
	 * Validate against multiple options
	 * @param string $var the variable you are validating
	 * @param string $validation a string of validation options ('option1|option2:test2')
	 * @return array
	 */
	public function validate($method='post'){
		$valid = true;
		$errors = array();
		$array = $this->validation;
		foreach($array as $input=>$validation){
			if(in_array($method, array('post', 'get', 'request', 'cookie', 'session'))){
				$var = $this->$method($input);
			}
			$validation = explode('|', $validation);
			foreach($validation as $validate){
				$function = '';
				$validate = explode(':', $validate);
				if(isset($validate[1])){
					$function = array_shift($validate);
					if(strpos($function, 'callback_') === 0){
						$function = str_replace('callback_', '', $function);
						$return = $this->$function($var, $validate);
					}else{
						$return = sValidate::$function($var, $validate);
					}
				} else {
					$function = $validate[0];
					unset($validate);
					if(strpos($function, 'callback_') === 0){
						$function = str_replace('callback_', '', $function);
						$return = $this->$function($var);
					}else{
						$return = sValidate::$function($var);
					}
				}
				$errors[$input][$function] = $return;
			}
		}
		foreach($errors as $field=>$error){
			foreach($error as $e){
				if($e['valid'] === false){
					$this->validationErrors[$field] = $this->validationFields[$field] . $e['error'];
					$valid = false;
				}
			}
		}
		return $valid;
	}
	public function getValidationErrors(){
		return $this->validationErrors;
	}
}