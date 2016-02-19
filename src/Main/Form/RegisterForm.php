<?php
namespace Main\Form;

use RedBeanPHP\R;

class RegisterForm extends Form
{
	public function validate()
	{
		if(!empty($this->attr['email'])) {
			$account = R::findOne('account', 'email=?', [$this->getAttr('email')]);
			if(!empty($account)) {
				$this->pushError('DUPLICATE_EMAIL');
				return false;
			}
		}
		return true;
	}

	public function save()
	{
		$account = R::dispense('account');
		$account->created_at = date('Y-m-d H:i:s');
		$account->email = empty($this->attr['email'])? null: $this->attr['email'];
		$account->token = bin2hex(openssl_random_pseudo_bytes(16));

		if(R::store($account)) {
			return $account;
		}
		else {
			return false;
		}
	}
}
