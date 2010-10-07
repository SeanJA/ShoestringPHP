<?php
/**
 * A basic form class that handles creating forms
 */
class sForm{
	private $method;
	private $name;
	private $echo = 'echo';
	/**
	 * 
	 * @param boolean $echo if this is true, it will echo out each part of the form as it is created
	 * if it is false, it will return the values to you instead and you can print them out later
	 * Default: true
	 */
	function __construct($echo = true){
		if(!is_bool($echo)){
			throw new Exception('$echo must be a boolean value');
		}
		$this->echo = $echo;
	}
	/**
	 * Open up the form
	 * @param string $action Where are we submitting the form to?
	 * @param string $method How are we submitting the form?
	 * @param array $attributes
	 */
	function open($action, $method = 'post', array $attributes=array()){
		$this->setMethod($method);
		$action = baseUrl($action);
		$form = '<form action="'.sEscape::html($action).'" method="'.sEscape::html($method).'" ';
		$form .= $this->getAttributes($attributes);
		$form.= ' >';
		return $this->returnValue($form);
	}

	/**
	 * Open a multi part form (for fileuploads)
	 * @param string $action Where are we submitting the form to?
	 * @param string $method How are we submitting the form?
	 * @param array $attributes
	 */
	function openMultipart($action, $method='post', array $attributes=array()){
		$attributes['enctype'] = 'multipart/form-data';
		$this->open($action, $method, $attributes);
	}

	/**
	 * Create a label
	 * @param string $for
	 * @param array $attributes
	 */
	function label($for, $text, array $attributes=array()){
		if(empty($attributes['id'])){
			$attributes['id'] = $for.'_label';
		}
		$form = '<label for="'.sEscape::html($for).'" ';
		$form .= $this->getAttributes($attributes);
		$form.= '>'.sEscape::html($text).' </label>';
		return $this->returnValue($form);
	}

	/**
	 * Create a text field
	 * @param string $name
	 * @param array $attributes
	 */
	function textField($name, array $attributes=array()){
		$this->name = sEscape::html($name);
		if(empty($attributes['value'])){
			$attributes['value'] = '';
		}
		$form = '<input type="text" name="'.$this->name.'" ';
		$form .= $this->getAttributes($attributes);
		$form.= ' />';
		return $this->returnValue($form);
	}

	/**
	 * Create a password field
	 * @param string $name
	 * @param array $attributes
	 */
	function password($name, array $attributes=array()){
		$this->name = sEscape::html($name);
		$form = '<input type="password" name="'.$this->name.'" ';
		$form .= $this->getAttributes($attributes);
		$form.= ' />';
		return $this->returnValue($form);
	}

	/**
	 * Create a text area
	 * @param string $name
	 * @param str $size ROWSxCOLS
	 * @param array $attributes
	 */
	function textArea($name, $size, $content='', array $attributes=array()){
		$this->name = sEscape::html($name);
		$size = strtolower($size);
		$size = explode('x', $size);
		if(count($size) != 2){
			throw new Exception('Size must be ROWSxCOLS which is [int]x[int]');
		}
		$form = '<textarea name="'.$this->name.'" rows="'.sEscape::html($size[0]).'" cols="'.sEscape::html($size[1]).'" ';
		$form .= $this->getAttributes($attributes);
		$form.= ' >'.sEscape::html($content).'</textarea>';
		return $this->returnValue($form);
	}

	/**
	 * Create a hidden form element
	 * @param string $name
	 * @param array $attributes
	 */
	function hidden($name, array $attributes=array()){
		$this->name = sEscape::html($name);
		if(!$attributes['value']){
			$attributes['value'] = '';
		}
		$form = '<input type="hidden" name="'.$this->name.'" ';
		$form .= $this->getAttributes($attributes);
		$form.= ' />';
		return $this->returnValue($form);
	}

	/**
	 * Create a select box
	 * @param string $name
	 * @param array $valuesArray
	 * @param string $selected
	 * @param array $attributes
	 */
	function selectBox($name, array $valuesArray, $selected=null, array $attributes=array()){
		$this->name = sEscape::html($name);
		$id = $this->nameToId();
		$form = '<select name="'.$this->name.'" ';
		$form .= $this->getAttributes($attributes) . ' >';
		
		if(!array_is_associative($valuesArray) && !is_int($selected)){
			$values = array_flip($valuesArray);
			$selected = isset($values[$selected])? $values[$selected]:$selected;
		}
		
		foreach($valuesArray as $value=>$content){
			$form .= '<option value="'.sEscape::html($value).'"';
			if($selected == $value){
				$form .= ' selected = "selected" ';
			}
			$form .= '>'.sEscape::html($content).'</option>';
		}
		$form .= '</select>';
		return $this->returnValue($form);
	}

	/**
	 * Create a file upload element
	 * @param str $name
	 * @param array $attributes
	 */
	function file($name, array $attributes=array()){
		$this->name = sEscape::html($name);
		$form = '<input type="file" name="'.$this->name.'" ';
		$form .= $this->getAttributes($attributes);
		$form.= ' />';
		return $this->returnValue($form);
	}

	/**
	 * Create a checkbox element
	 * @param str $name
	 * @param bool checked
	 * @param array $attributes
	 */
	function checkbox($name, $checked=false, array $attributes=array()){
		$this->name = sEscape::html($name);
		$form = '<input type="checkbox" name="'.$this->name.'" ';
		if($checked){
			$form .= ' checked="checked" ';
		}
		$form .= $this->getAttributes($attributes);
		$form.= ' />';
		return $this->returnValue($form);
	}

	/**
	 * Create a radio button element
	 * @param string $name
	 * @param bool $checked
	 * @param array $attributes
	 */
	function radio($name, $checked=false, array $attributes=array()){
		$this->name = sEscape::html($name);
		$form = '<input type="radio" name="'.$this->name.'" ';
		if($checked){
			$form .= ' checked="checked" ';
		}
		$form .= $this->getAttributes($attributes);
		$form.= ' />';
		return $this->returnValue($form);
	}
	
	/**
	 * Create an image input
	 * @param string $name
	 * @param string $src
	 */
	function image($name, $src, array $attributes=array()){
		$this->name = sEscape::html($name);
		$form = '<input type="image" ';
		$form .= $this->getAttributes($attributes);
		$form.= ' />';
		return $this->returnValue($form);
	}

	/**
	 * Create a button
	 * @param string $content
	 */
	function button($content, array $attributes=array()){
		$form = '<button ';
		$form .= $this->getAttributes($attributes);
		$form.= '>'.sEscape::html($content).'</button>';
		return $this->returnValue($form);
	}
	
	/**
	 * Create a submit button
	 * @param string $value
	 * @param array $attributes
	 */
	function submit($name, $value, array $attributes=array()){
		$this->name = sEscape::html($name);
		$form = '<input type="submit" name="'.$this->name.'" value="'.sEscape::html($value).'" ';
		$form .= $this->getAttributes($attributes);
		$form.= ' />';
		return $this->returnValue($form);
	}

	/**
	 * Create a reset button
	 * @param string $value
	 * @param array $attributes
	 */
	function reset($name, $value, array $attributes=array()){
		$this->name = sEscape::html($name);
		$form = '<input type="reset" name="'.$this->name.'" value="'.sEscape::html($value).'" ';
		$form .= $this->getAttributes($attributes);
		$form.= ' />';
		return $this->returnValue($form);
	}

	
	/**
	 * Start a fieldset
	 * @param string $legend
	 * @param array $attributes
	 */
	function openFieldSet($legend, array $attributes=array()){
		$form = '<fieldset ';
		$form .= $this->getAttributes($attributes) . ' >';
		$form .= '<legend>'.sEscape::html($legend).'</legend>';
		return $this->returnValue($form);
	}

	/**
	 * End a fieldset
	 */
	function closeFieldSet(){
		$form = '</fieldset>';
		return $this->returnValue($form);
	}

	

	/**
	 * Close the form
	 */
	function  close(){
		$form = '</form>';
		return $this->returnValue($form);
	}

	/**
	 * Extracts the options from the options array
	 * @param array $attributes
	 * @return string
	 */
	private function getAttributes(array $attributes){
		if(!array_key_exists('id', $attributes)){
			if($id = $this->nameToId()){
				$attributes['id'] = $id;
			}
			
		}
		$attributesString = ' ';
		foreach($attributes as $attribute=>$value){
			$attributesString .= sEscape::html($attribute) . '="'.sEscape::html($value).'" ';
		}
		return $attributesString.' ';
	}
	/**
	 * Return the value in the method specified
	 * @param string $string
	 * @return string or boolean
	 */
	private function returnValue($string){
		if($this->echo == 'echo'){
			echo $string;
		} else {
			return $string;
		}
		return true;
	}
	/**
	 * Set the form method
	 * @param string $method the method that the form will use to submit itself (either get or post)
	 */
	private function setMethod($method='post'){
		$method = strtoupper($method);
		if($method !== 'GET'){
			$method = 'POST';
		}
		$this->method = $method;
	}
	/**
	 * Make the id for the field valid
	 * @return string
	 */
	private function nameToId(){
		$id = $this->name;
		$id = str_replace('][', '_', $id);
		$id = str_replace('[', '', $id);
		$id = str_replace(']', '', $id);
		$this->name = null;
		return sEscape::html($id);
	}
}