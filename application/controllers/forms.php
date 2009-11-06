<?php
class Forms_Controller extends Controller {
	function index(){
		$this->data['title'] = 'Form Examples';
		$this->data['header'] = 'Form Examples';
		$this->data['links'] = array(
			'/forms/basic'=>'Basic Form',
			'/forms/pre-filled'=>'A Prefilled Form',
		);
		$this->template->render('index', $this->data);
	}
	function basic(){
		$this->data['title'] = 'Basic Form Example';
		$this->data['header'] = 'Basic Form Example';
		$this->template->render('basic', $this->data);
	}
	function pre_filled(){
		$this->data['title'] = 'Pre Filled Form Example';
		$this->data['header'] = 'Pre Filled Form Example';
		$this->template->render('pre_filled', $this->data);
	}
}

?>
