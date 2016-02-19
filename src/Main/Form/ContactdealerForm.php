<?php
namespace Main\Form;

use RedBeanPHP\R;

class ContactdealerForm extends Form
{
	public $attr = [
		// 'created_at'=> '',
		// 'updated_at'=> '',
		'name'=> '',
		'address'=> '',
		'phone'=> '',
		'province_id'=> '1',
		'geo_id'=> '',
		'lat'=> '',
		'lng'=> ''
	];

	public function validate()
	{
		$this->errors = [];
		$this->error = false;
		$this->isValid = true;

		if(empty($this->attr['name'])) {
			$this->pushError("name empty");
		}
		return !$this->error;
	}

	public function save()
	{
		if(!$this->emptyAttr('id')) {
			$contactDealer = R::findOne('contactdealer', 'id=?', [$this->getAttr('id')]);
			$contactDealer->updated_at = date('Y-m-d H:i:s');
		}
		else {
			$contactDealer = R::dispense('contactdealer');
			$contactDealer->created_at = date('Y-m-d H:i:s');
			$contactDealer->updated_at = date('Y-m-d H:i:s');
		}
		$contactDealer->name = $this->getAttr('name');
		$contactDealer->address = $this->getAttr('address', '');
		$contactDealer->phone = $this->getAttr('phone', '');
		$contactDealer->province_id = $this->getAttr('province_id', '');
		$contactDealer->geo_id = $this->getAttr('geo_id', '');
		$contactDealer->lat = $this->getAttr('lat', '');
		$contactDealer->lng = $this->getAttr('lng', '');

		$province = R::getRow('SELECT * FROM provinces WHERE province_id = ?', [$contactDealer->province_id]);
		if($province) {
			$contactDealer->geo_id = $province['geo_id'];
		}

		$success = R::store($contactDealer);

		return $success;
	}

	public function isNew()
	{
		return empty($this->attr['id']);
	}
}
