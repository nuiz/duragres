<?php

namespace Main\Form;

abstract class Form {
	public $isValid = false, $fields = [], $attr = [], $errors = [], $error = false;
	public function __construct($attr = []){
		$this->attr = array_merge($this->attr, $attr);
	}
	public function validate(){
		$this->isValid = true;
	}
	public function getIsValid(){
		return $this->isValid;
	}
	public function getAttr($name = null, $default = null){
		return is_null($name)? $this->attr:
			(isset($this->attr[$name])? $this->attr[$name]: $default);
	}
	public function hasAttr($name){
		return isset($this->attr[$name]);
	}
	public function emptyAttr($name){
		return empty($this->attr[$name]);
	}

	protected function pushError($error){
		$this->isValid = false;
		$this->error = $error;
		$this->errors[] = $error;
	}

	protected function _isDateFormat($input){
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$input))
	    {
	    	return true;
	    }else{
	        return false;
	    }
	}
}
