<?php
namespace Main\Form;

use RedBeanPHP\R;

class PatternForm extends Form
{
	public $attr = [
		// 'created_at'=> '',
		// 'updated_at'=> '',
		'room_id'=> '',
		'name'=> '',
		'width'=> '0',
		'height'=> '0',
		'tile_width'=> '0',
		'tile_height'=> '0',
		'tile_size_unit'=> 'inch',
		'picture'=> '',
		'thumb'=> '',
		'product_use'=> []
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
		if(empty($this->attr['width'])) {
			$this->pushError("width empty");
		}
		if(empty($this->attr['height'])) {
			$this->pushError("height empty");
		}
		if(empty($this->attr['tile_width'])) {
			$this->pushError("tile_width empty");
		}
		if(empty($this->attr['tile_height'])) {
			$this->pushError("tile_height empty");
		}
		if(empty($this->attr['tile_size_unit'])) {
			$this->pushError("tile_size_unit empty");
		}

		if($this->emptyAttr('id')) {
			if(!$this->attr['picture']->uploaded) {
				$this->pushError("picture empty");
			}
			if(!$this->attr['thumb']->uploaded) {
				$this->pushError("thumb empty");
			}
		}

		return !$this->error;
	}

	public function save()
	{
		if(!$this->emptyAttr('id')) {
			$item = R::findOne('room_pattern', 'id=?', [$this->getAttr('id')]);
			$item->updated_at = date('Y-m-d H:i:s');
		}
		else {
			$item = R::xdispense('room_pattern');
			$item->created_at = date('Y-m-d H:i:s');
			$item->updated_at = date('Y-m-d H:i:s');
		}
		$item->room_id = $this->getAttr('room_id');
		$item->name = $this->getAttr('name');
		$item->width = $this->getAttr('width');
		$item->height = $this->getAttr('height');
		$item->tileWidth = $this->getAttr('tile_width');
		$item->tileHeight = $this->getAttr('tile_height');
		$item->tileSizeUnit = $this->getAttr('tile_size_unit');
		$item->product_use = ','.implode(',', $this->getAttr('product_use')).',';

		if(!$this->emptyAttr('picture') && $this->attr['picture']->uploaded) {
			$picture = $this->getAttr('picture');
			$picture->file_new_name_body = $this->generateName("pattern_picture_");
	    $picture->image_convert = 'jpeg';
			$picture->process('upload/');

			$this->pushDeleteWhenSuccess('upload/'.$item->picture);
			$this->pushDeleteWhenFailed('upload/'.$picture->file_dst_name);

			$item->picture = $picture->file_dst_name;
		}

		if(!$this->emptyAttr('thumb') && $this->attr['thumb']->uploaded) {
			$thumb = $this->getAttr('thumb');
			$thumb->file_new_name_body = $this->generateName("pattern_thumb_");
	    $thumb->image_convert = 'jpeg';
			$thumb->image_resize = true;
			$thumb->image_x = 150;
			$thumb->image_y = 150;
			$thumb->process('upload/');

			$this->pushDeleteWhenSuccess('upload/'.$item->thumb);
			$this->pushDeleteWhenFailed('upload/'.$thumb->file_dst_name);

			$item->thumb = $thumb->file_dst_name;
		}

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
		foreach($this->successDeleteFiles as $file) {
			@unlink($file);
		}
	}

	public function handlerFailed()
	{
		foreach($this->failedDeleteFiles as $file) {
			@unlink($file);
		}
	}
}
