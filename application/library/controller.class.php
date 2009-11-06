<?php
/**
 * A new controller class that extends the default controller to reduce code duplication
 */
class controller extends sController{
	protected $user;
	protected $data;
	function  __construct($controller) {
		$this->user = new sUser();
		$this->data = array();
		$this->data['loggedIn'] = false;
		if($this->user->loggedIn()) {
			$this->data['loggedIn'] = true;
		}
		parent::__construct($controller);
	}
}

?>
