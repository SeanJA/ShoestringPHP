<?php
class Public_Controller extends sController {
	private $user;
	private $data;
	function  __construct($controller) {
		$this->user = new sUser();
		$this->data = array();
		$this->data['loggedIn'] = false;
		if($this->user->loggedIn()) {
			$this->data['loggedIn'] = true;
		}
		parent::__construct($controller);
		$this->loadModel('Doc');
	}
	function index() {
		$this->data['files'] = $this->Doc->getFiles();
		//$this->template->render('index', $this->data);
	}
}