<?php
/**
 *
 */
class sForm{
	/**
	 * Open up the form
	 * @param string $action Where are we submitting the form to?
	 * @param string $method How are we submitting the form?
	 * @param array $options
	 */
	function open($action, $method, $options=array()){
		$action = baseUrl($action);
		$form = '<form action="'.sEscape::html($action).'" method="'.sEscape::html($method).'" ';
		$form .= $this->_getOptions($options);
		$form.= ' >';
		echo $form;
	}

	/**
	 * Open a multi part form (for fileuploads)
	 * @param string $action Where are we submitting the form to?
	 * @param string $method How are we submitting the form?
	 * @param array $options
	 */
	function openMultipart($action, $method, $options=array()){
		$options['enctype'] = 'multipart/form-data';
		$this->open($action, $method, $options);
	}

	/**
	 * Create a label
	 * @param string $for
	 * @param array $options
	 */
	function label($for, $text, $options=array()){
		$form = '<label for="'.sEscape::html($for).'" ';
		$form .= $this->_getOptions($options);
		$form.= '>'.sEscape::html($text).' </label>';
		echo $form;
	}

	/**
	 * Create a text field
	 * @param string $name
	 * @param array $options
	 */
	function textField($name, $options=array()){
		$form = '<input type="text" name="'.sEscape::html($name).'" id="'.sEscape::html($name).'" ';
		$form .= $this->_getOptions($options);
		$form.= ' />';
		echo $form;
	}

	/**
	 * Create a password field
	 * @param string $name
	 * @param array $options
	 */
	function password($name, $options=array()){
		$form = '<input type="password" name="'.sEscape::html($name).'" id="'.sEscape::html($name).'" ';
		$form .= $this->_getOptions($options);
		$form.= ' />';
		echo $form;
	}

	/**
	 * Create a text area
	 * @param string $name
	 * @param str $size ROWSxCOLS
	 * @param array $options
	 */
	function textArea($name, $size, $content, $options=array()){
		$size = strtolower($size);
		$size = explode('x', $size);
		if(count($size) != 2){
			throw new Exception('Size must be ROWSxCOLS which is [int]x[int]');
		}
		$form = '<textarea name="'.sEscape::html($name).'" id="'.sEscape::html($name).'" rows="'.sEscape::html($size[0]).'" cols="'.sEscape::html($size[1]).'" ';
		$form .= $this->_getOptions($options);
		$form.= ' >'.sEscape::html($content).'</textarea>';
		echo $form;
	}

	/**
	 * Create a hidden form element
	 * @param string $name
	 * @param array $options
	 */
	function hidden($name, $options=array()){
		$form = '<input type="hidden" name="'.sEscape::html($name).'" id="'.sEscape::html($name).'" ';
		$form .= $this->_getOptions($options);
		$form.= ' />';
		echo $form;
	}

	/**
	 * Create a file upload element
	 * @param str $name
	 * @param array $options
	 */
	function file($name, $options=array()){
		$form = '<input type="file" name="'.sEscape::html($name).'" id="'.sEscape::html($name).'" ';
		$form .= $this->_getOptions($options);
		$form.= ' />';
		echo $form;
	}

	/**
	 * Create a checkbox element
	 * @param str $name
	 * @param bool checked
	 * @param array $options
	 */
	function checkbox($name, $checked=false, $options=array()){
		$form = '<input type="checkbox" name="'.sEscape::html($name).'" ';
		if($checked){
			$form .= ' checked="checked" ';
		}
		$form .= $this->_getOptions($options);
		$form.= ' />';
		echo $form;
	}

	/**
	 * Create a radio button element
	 * @param string $name
	 * @param bool $checked
	 * @param array $options
	 */
	function radio($name, $checked=false, $options=array()){
		$form = '<input type="radio" name="'.sEscape::html($name).'" ';
		if($checked){
			$form .= ' checked="checked" ';
		}
		$form .= $this->_getOptions($options);
		$form.= ' />';
		echo $form;
	}
	
	/**
	 * Create a submit button
	 * @param string $value
	 * @param array $options
	 */
	function submit($value, $options=array()){
		$form = '<input type="submit" name="submit" value="'.sEscape::html($value).'" ';
		$form .= $this->_getOptions($options);
		$form.= ' />';
		echo $form;
	}

	/**
	 * Create a reset button
	 * @param string $value
	 * @param array $options
	 */
	function reset($value, $options=array()){
		$form = '<input type="reset" name="reset" value="'.sEscape::html($value).'" ';
		$form .= $this->_getOptions($options);
		$form.= ' />';
		echo $form;
	}

	/**
	 * Create an image input
	 * @param string $name
	 * @param string $src
	 */
	function image($name, $src, $options=array()){
		$form = '<input type="image" src="'.sEscape::html($src).'" ';
		$form .= $this->_getOptions($options);
		$form.= ' />';
		echo $form;
	}

	/**
	 * Create a button
	 * @param string $name
	 * @param string $content
	 */
	function button($name, $content, $options=array()){
		$form = '<button name="'.sEscape::html($name).'" id="'.sEscape::html($name).'" ';
		$form .= $this->_getOptions($options);
		$form.= '>'.sEscape::html($content).'</button>';
		echo $form;
	}
	/**
	 * Start a fieldset
	 * @param string $legend
	 * @param array $options
	 */
	function openFieldSet($legend, $options=array()){
		$form = '<fieldset ';
		$form .= $this->_getOptions($options) . ' >';
		$form .= '<legend>'.sEscape::html($legend).'</legend>';
		echo $form;
	}

	/**
	 * End a fieldset
	 */
	function closeFieldSet(){
		$form = '</fieldset>';
		echo $form;
	}

	/**
	 *
	 * @param <type> $name
	 * @param <type> $valuesArray
	 * @param <type> $selected
	 * @param <type> $options
	 */
	function selectBox($name, $valuesArray, $selected, $options=array()){
		$form = '<select name="'.sEscape::html($name).'" id="'.sEscape::html($name).'">';
		foreach($valuesArray as $value=>$content){
			$form .= '<option value="'.sEscape::html($value).'"';
			if($selected === $value){
				$form .= ' selected = "selected" ';
			}
			$form .= '>'.sEscape::html($content).'</option>';
		}
		$form .= '</select>';
		echo $form;
	}

	/**
	 * Close the form
	 */
	function  close(){
		$form = '</form>';
		echo $form;
	}

	/**
	 * Make sure we are dealing with an array of options (even an empty one is good!)
	 * @param array $options
	 */
	private function _checkOptions($options){
		if(!is_array($options)){
			throw new Exception('Options must be an array!');
		}
	}

	/**
	 * Extracts the options from the options array
	 * @param array $options
	 * @return <type>
	 */
	private function _getOptions($options){
		$this->_checkOptions($options);
		$form = ' ';
		foreach($options as $attribute=>$value){
			$form .= sEscape::html($attribute) . '="'.sEscape::html($value).'" ';
		}
		return $form.' ';
	}
	
}