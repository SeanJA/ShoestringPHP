<?php
class Users_Controller extends sController {
	private $user;
	private $data;
	function  __construct($model, $controller) {
		$this->user = new sUser();
		$this->data = array();
		$this->data['loggedIn'] = false;
		if($this->user->loggedIn()) {
			$this->data['loggedIn'] = true;
			$this->data['user'] = $this->user;
		}
		parent::__construct($model, $controller);
	}
	function index() {
		if($this->data['loggedIn']) {
			$this->template->render('index', $this->data);
		} else {
			redirect('users/login');
		}
	}
	
	function login() {
		if($_POST) {
			$validation['username'] = 'minLen:1';
			$validation['password'] = 'minLen:1|callback_passwordCheck';
			$fields['username'] = 'Username';
			$fields['password'] = 'Password';
			$this->setValidation($validation);
			$this->setValidationFields($fields);
			if($this->validate()) {
				echo 'validated';
				try {
					$this->user->login($this->post('username'), $this->post('password'));
					redirect('users/index');
				} catch (Exception $e ) {
					$this->data['error'] = $e->getMessage();
				}
			} else {
				$this->data['errors'] = $this->getValidationErrors();
			}
		}
		$this->template->render('login', $this->data);
	}

	function logout() {
		$this->user->logout();
		$this->data['loggedIn'] = false;
		$this->data['message'] = 'You are now logged out';
		$this->template->render('login', $this->data);
	}

	function edit($id='') {
		if(!$this->user->loggedIn()) {
			redirect('users/login');
		}
		if($_POST) {

		}
		if(!$id) {
			$this->data['editUser'] = $this->user->getUserData();
		} else {
			if($this->user->level == 'admin') {
				$tempUser = new sUser($id);
				$this->data['editUser'] = $tempUser->getUserData();
			} else {
				$this->data['editUser'] = $this->user->getUserData();
			}
		}
		if($this->user->level == 'admin') {
			$this->data['levels'] = $this->user->getUserLevels();
		}
		$this->template->render('edit', $this->data);
	}
	protected function passwordCheck($password) {
		$return['valid'] = true;
		$return['error'] = '';
		if($password === 'password') {
			$return['valid'] = false;
			$return['error'] = ' is password';
		}
		return $return;
	}
}
