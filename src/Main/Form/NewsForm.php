<?php
namespace Main\Form;

use RedBeanPHP\R;

class NewsForm extends Form
{
	public $attr = [
		// 'created_at'=> '',
		// 'updated_at'=> '',
		'name'=> '',
		'picture'=> '',
		'thumb'=> '',
		'content'=> '',
		'link'=> ''
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
			if(!$this->attr['thumb']->uploaded) {
				$this->pushError("thumb empty");
			}
		}
		return !$this->error;
	}

	public function save()
	{
		if(!$this->emptyAttr('id')) {
			$news = R::findOne('news', 'id=?', [$this->getAttr('id')]);
			$news->updated_at = date('Y-m-d H:i:s');
		}
		else {
			$news = R::dispense('news');
			$news->created_at = date('Y-m-d H:i:s');
			$news->updated_at = date('Y-m-d H:i:s');
			$news->sort_order = (int)R::getCell("SELECT MAX(sort_order) FROM news") + 1;
		}
		$news->name = $this->getAttr('name');

		$oldPicture = null;
		$thumb = null;
		if(!$this->emptyAttr('picture') && $this->attr['picture']->uploaded) {
			$picture = $this->getAttr('picture');
			$picture->file_new_name_body = $this->generateName("news_picture_");
			$picture->image_resize = true;
	    $picture->image_convert = 'jpeg';
	    // $picture->image_x = 964;
	    // $picture->image_y = 1024;

			$picture->image_y = 1024;
			$xDes = round(($picture->image_src_x * $picture->image_y) / $picture->image_src_y);
			if($xDes > 964) {
				$picture->image_ratio = true;
				$picture->image_x = 964;
				$picture->image_ratio_crop = true;
			}
			else {
				$picture->image_ratio_x = true;
			}

	    // $picture->image_ratio_y = true;
			$picture->process('upload/');

			$oldPicture = $news->picture;
			$news->picture = $picture->file_dst_name;
		}

		$oldThumb = null;
		$thumb = null;
		if(!$this->emptyAttr('thumb') && $this->attr['thumb']->uploaded) {
			$thumb = $this->getAttr('thumb');
			$thumb->file_new_name_body = $this->generateName("news_thumb_");
			$thumb->image_resize = true;
	    $thumb->image_convert = 'jpeg';
	    // $thumb->image_x = 460;
	    // $thumb->image_y = 520;
	    //$thumb->image_ratio_y = true;

			$thumb->image_y = 520;
			$xDes = round(($thumb->image_src_x * $thumb->image_y) / $thumb->image_src_y);
			if($xDes > 460) {
				$thumb->image_ratio = true;
				$thumb->image_x = 460;
				$thumb->image_ratio_crop = true;
			}
			else {
				$thumb->image_ratio_x = true;
			}

			$thumb->process('upload/');


			$oldThumb = $news->thumb;
			$news->thumb = $thumb->file_dst_name;
		}
		$news->content = $this->getAttr('content', '');
		$news->link = $this->getAttr('link', '');
		$success = R::store($news);

		if($success) {
			if(!is_null($oldPicture)) {
				@unlink('upload/'.$oldPicture);
			}
			if(!is_null($oldThumb)) {
				@unlink('upload/'.$oldThumb);
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
