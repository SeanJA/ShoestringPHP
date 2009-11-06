<?php

/**
 * Generic Template Class
 */
class sTemplate extends sRoot{
	protected $controller;
	protected $header = true;
	protected $footer = true;
	public function __construct($controller) {
		parent::__construct();
		$this->controller = $controller;
	}
	/**
	 * Display the template (include the header and footer as well)
	 * @param str $action
	 * @param <type> $data 
	 */
	public function render($__renderThisAction,$__useThisData=array()) {
		extract($__useThisData);
		$this->controller = strtolower($this->controller);
		if($this->header){
			if (file_exists(ROOT . DS . 'application' . DS . 'views' . DS . $this->controller . DS . 'header.php')) {
				include (ROOT . DS . 'application' . DS . 'views' . DS . $this->controller . DS . 'header.php');
			} else {
				include (ROOT . DS . 'application' . DS . 'views' . DS . 'header.php');
			}
		}
		include (ROOT . DS . 'application' . DS . 'views' . DS . $this->controller . DS . $__renderThisAction . '.php');
		if($this->footer){
			if (file_exists(ROOT . DS . 'application' . DS . 'views' . DS . $this->controller . DS . 'footer.php')) {
				include (ROOT . DS . 'application' . DS . 'views' . DS . $this->controller . DS . 'footer.php');
			} else {
				include (ROOT . DS . 'application' . DS . 'views' . DS . 'footer.php');
			}
		}
	}

	public function noWrapper(){
		$this->noHeader();
		$this->noFooter();
	}
	public function useWrapper(){
		$this->useHeader();
		$this->useFooter();
	}
	public function noHeader(){
		$this->header = false;
	}
	public function useHeader(){
		$this->header = true;
	}
	public function noFooter(){
		$this->footer = false;
	}
	public function useFooter(){
		$this->footer = true;
	}
}
