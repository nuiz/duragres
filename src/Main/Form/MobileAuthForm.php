<?php
namespace Main\Form;

use RedBeanPHP\R;

class MobileAuthForm extends Form
{
	private $user;
	public function validate()
	{
		$attr = $this->attr;

		$user = R::findOne('account', 'token=?', [$this->getAttr('token')]);

		if(!$user){
			$this->pushError('Not found account');
			return false;
		}
		$this->user = $user;
		return true;
	}

	public function getUser(){
		return $this->user;
	}
}
