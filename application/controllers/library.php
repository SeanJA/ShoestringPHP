<?php
class Library_Controller extends sController {
	function  __construct($controller) {
		parent::__construct($controller);
		$this->loadModel('Doc');
	}
	function index() {
		$this->data['files'] = $this->Doc->getFiles();
		//$this->template->render('index', $this->data);
	}
}