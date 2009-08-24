<?php

class Docs_Controller extends sController {
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
		$this->template->render('index', $this->data);
	}
	function display($file='') {
		$this->data['methods'] = $this->Doc->getDocs($file);
		if(!$this->data['methods']){
			$this->data['methods'] = array();
			$this->data['error'] = 'There is no documentation for this file yet!';
		}
		$this->data['header'] = 'Documentation - ' . $file . '.php';
		$this->template->render('display', $this->data);
	}
	function create($file='') {
		if(!$this->user->loggedIn()) {
			redirect('users/login');
		}
		if($_POST) {
			$methodName = $this->post('method_name');
			$comments = $this->post('comments');
			$example = $this->post('example');
			$file = $this->post('file');
			$id = $this->Doc->create($methodName, $comments, $example, $file);
			redirect('/docs/update/'.$id.'/created');
		} else {
			if($file){
				$this->data['file'] = $file;
			}
			$this->template->render('create', $this->data);
		}
		
	}
	function update($id='', $created=false) {
		if(!$this->user->loggedIn()) {
			redirect('users/login');
		}
		$this->data['doc'] = array();
		if($created){
			$this->data['message'] = 'Documentation created';
		}
		if(!$id) {
			$this->data['error'] = 'No id provided';
		}
		if($_POST){
			$methodName = $this->post('method_name');
			$comments = $this->post('comments');
			$example = $this->post('example');
			$file = $this->post('file');
			$this->Doc->update($id, $methodName, $comments, $example, $file);
			$this->data['message'] = 'Documentation updated!';
		}
		if($id){
			$this->data['doc'] = $this->Doc->getDoc($id);
		}
		$this->template->render('update', $this->data);
	}
	function delete($id=''){
		if(!$this->user->loggedIn()) {
			redirect('users/login');
		}
		if(!$id) {
			$this->data['error'] = 'No id provided';
		} else {
			$this->Doc->delete($id);
			$this->data['message'] = 'Documentation deleted!';
		}
		$this->template->render('delete', $this->data);
	}
}