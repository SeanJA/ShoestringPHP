<?php
/**
 * This controller serves as a demo controller as well as
 * a controller to handle errors so that your errors are themed
 * the same way that your site is themed
 */
class Errors_Controller extends controller {
    /**
     * Display a 404 error
     */
	function four_oh_four(){
		header("HTTP/1.0 404 Not Found");
		$url = func_get_args();
		$url = baseUrl(implode('/', $url));
		$this->data['error404'] = 'Sorry, the page you were looking for could not be found:';
		$this->data['page'] = sEscape::html($url);
		$this->data['header'] = 'Error 404';
		$this->template->render('four-oh-four', $this->data);
	}
    /**
     * Display an invalid characters error
     */
	function invalid_characters(){
		$this->data['error404'] = 'Sorry, the url you arrived at had invalid characters';
		$this->data['header'] = 'Invalid URL Characters';
		$this->template->render('invalid-characters', $this->data);
	}
}