<?php
class Library_Controller extends sController {
	private $user;
	private $data;
	function  __construct($model, $controller) {
		$this->user = new sUser();
		$this->data = array();
		$this->data['loggedIn'] = false;
		if($this->user->loggedIn()) {
			$this->data['loggedIn'] = true;
		}
		parent::__construct($model, $controller);
		$this->loadModel('Doc');
	}
	function index() {
		$this->data['files'] = $this->Doc->getFiles();
		//$this->template->render('index', $this->data);
	}
}