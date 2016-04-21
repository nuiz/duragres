<?php
namespace Main\Form;

use RedBeanPHP\R;

class RoomForm extends Form
{
	public $attr = [
		// 'created_at'=> '',
		// 'updated_at'=> '',
		'name'=> ''
	];

	public $successDeleteFiles = [], $failedDeleteFiles = [];

	public function validate()
	{
		$this->errors = [];
		$this->error = false;
		$this->isValid = true;

		if(empty($this->attr['name'])) {
			$this->pushError("name empty");
		}
		$id = @$this->attr["id"]? $this->attr["id"]: 0;
		if(R::count("room", "name = ? AND id != ?", [$this->attr["name"], $id]) > 0) {
			$this->pushError("Duplicate name ".$this->attr["name"]);
		}

		return !$this->error;
	}

	public function save()
	{
		if(!$this->emptyAttr('id')) {
			$item = R::findOne('room', 'id=?', [$this->getAttr('id')]);
			$item->updated_at = date('Y-m-d H:i:s');
		}
		else {
			$item = R::dispense('room');
			$item->created_at = date('Y-m-d H:i:s');
			$item->updated_at = date('Y-m-d H:i:s');
		}
		$item->name = $this->getAttr('name');
		$success = R::store($item);

		if($success) {
			$this->handlerSuccess();
		}
		else {
			$this->handlerFailed();
		}

		return $success;
	}

	public function generateName($prefix = "")
	{
		$name = uniqid($prefix, true);
		return str_replace(".", "-", $name);
	}

	public function isNew()
	{
		return empty($this->attr['id']);
	}

	// handler delete files

	public function pushDeleteWhenSuccess($path)
	{
		$this->successDeleteFiles[] = $path;
	}

	public function pushDeleteWhenFailed($path)
	{
		$this->failedDeleteFiles[] = $path;
	}

	public function handlerSuccess()
	{
	}

	public function handlerFailed()
	{
	}
}
