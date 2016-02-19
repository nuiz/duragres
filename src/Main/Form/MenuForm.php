<?php
namespace Main\Form;

use RedBeanPHP\R;

class MenuForm extends Form
{
	public $attr = [
		// 'created_at'=> '',
		// 'updated_at'=> '',
		'name'=> '',
		'picture'=> ''
	];

	public function validate()
	{
		$this->errors = [];
		$this->error = false;
		$this->isValid = true;

		if(empty($this->attr['name'])) {
			$this->pushError("name empty");
		}

		if($this->emptyAttr('id')) {
			if(!$this->attr['picture']->uploaded) {
				$this->pushError("name empty");
			}
		}
		return !$this->error;
	}

	public function save()
	{
		if(!$this->emptyAttr('id')) {
			$menu = R::findOne('menu', 'id=?', [$this->getAttr('id')]);
		}
		else {
			$menu = R::dispense('menu');
		}
		$menu->name = $this->getAttr('name');

		$oldPicture = null;
		if(!$this->emptyAttr('picture') && $this->attr['picture']->uploaded) {
			$picture = $this->getAttr('picture');
			$picture->file_new_name_body = $this->generateName("menu_picture_");
			// $picture->image_resize = true;
	    $picture->image_convert = 'jpeg';
	    // $picture->image_x = 964;
	    // $picture->image_y = 1024;

	    // $picture->image_ratio_y = true;
			$picture->process('upload/');

			$oldPicture = $menu->picture;
			$menu->picture = $picture->file_dst_name;
		}

		$success = R::store($menu);

		if($success) {
			if(!is_null($oldPicture)) {
				@unlink('upload/'.$oldPicture);
			}
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
}
