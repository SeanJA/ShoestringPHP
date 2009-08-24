<?php

class Errors_Controller extends sController {
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
	}
	function four_oh_four(){
		header("HTTP/1.0 404 Not Found");
		$url = func_get_args();
		$url = baseUrl(implode('/', $url));
		$this->data['error404'] = 'Sorry, the page you were looking for could not be found:';
		$this->data['page'] = sEscape::html($url);
		$this->data['header'] = 'Error 404';
		$this->template->render('four-oh-four', $this->data);
	}
	function invalid_characters(){
		$this->data['error404'] = 'Sorry, the url you arrived at had invalid characters';
		$this->data['header'] = 'Invalid URL Characters';
		$this->template->render('invalid-characters', $this->data);
	}
}