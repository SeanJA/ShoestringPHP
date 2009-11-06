<?php
class Users_Controller extends sController {
    /**
     * The default page, if you are logged in it will let you see it, otherwise it will
     * throw you out to the login page
     */
	function index() {
		if($this->data['loggedIn']) {
			$this->template->render('index', $this->data);
		} else {
			redirect('users/login');
		}
	}
	/**
     * An example login page, it includes an example of how the validation is used
     */
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
    /**
     * An example of a logout page
     */
	function logout() {
		$this->user->logout();
		$this->data['loggedIn'] = false;
		$this->data['message'] = 'You are now logged out';
		$this->template->render('login', $this->data);
	}
    /**
     * An example callback password check function
     * @param string $password
     * @return array
     */
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
