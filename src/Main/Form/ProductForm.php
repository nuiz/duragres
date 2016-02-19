<?php
namespace Main\Form;

use RedBeanPHP\R;

class ProductForm extends Form
{
	public $attr = [
		// 'created_at'=> '',
		// 'updated_at'=> '',
		'code'=> '',
		'name'=> '',
		'name_eng'=> '',
		'picture'=> '',
		'thumb'=> '',
		'size'=> '',
		'style'=> '',
		'type'=> '',
		'company'=> '',
		'price'=> '',
		'is_hot'=> 0,
		'is_new'=> 0,
		'color'=> '',
		'surface'=> '',
		'pcs_ctn'=> '',
		'sqm_ctn'=> ''
	];

	public function validate()
	{
		$this->errors = [];
		$this->error = false;
		$this->isValid = true;

		if(empty($this->attr['code'])) {
			$this->pushError("code empty");
		}
		if(empty($this->attr['name'])) {
			$this->pushError("name empty");
		}

		if($this->emptyAttr('id')) {
			if(!$this->attr['picture']->uploaded) {
				$this->pushError("name empty");
			}
			// if(!$this->attr['thumb']->uploaded) {
			// 	$this->pushError("thumb empty");
			// }
		}
		return !$this->error;
	}

	public function save()
	{
		if(!$this->emptyAttr('id')) {
			$product = R::findOne('product', 'id=?', [$this->getAttr('id')]);
			$product->updated_at = date('Y-m-d H:i:s');
		}
		else {
			$product = R::dispense('product');
			$product->created_at = date('Y-m-d H:i:s');
			$product->updated_at = $product->created_at;
		}
		$product->code = $this->getAttr('code');
		$product->name = $this->getAttr('name');
		$product->name_eng = $this->getAttr('name_eng');
		$product->size = $this->getAttr('size');
		$product->style = $this->getAttr('style');
		$product->type = $this->getAttr('type');
		$product->company = $this->getAttr('company');
		$product->price = $this->getAttr('price');
		$product->is_hot = $this->getAttr('is_hot');
		$product->is_new = $this->getAttr('is_new');
		$product->color = $this->getAttr('color');
		$product->surface = $this->getAttr('surface');
		$product->pcs_ctn = $this->getAttr('pcs_ctn');
		$product->sqm_ctn = $this->getAttr('sqm_ctn');

		$oldPicture = null;
		$picture = null;
		if(!$this->emptyAttr('picture') && $this->attr['picture']->uploaded) {
			$picture = $this->getAttr('picture');
			$picture->file_new_name_body = $this->generateName("product_picture_");
			$picture->image_resize = true;
	    $picture->image_convert = 'jpeg';
	    // $picture->image_ratio_y = true;
			if($picture->image_src_x > 512 || $picture->image_src_y > 512) {
				if($picture->image_src_x > $picture->image_src_y) {
					$picture->image_ratio_y = true;
			    $picture->image_x = 512;
				}
				else {
					$picture->image_ratio_x = true;
			    $picture->image_y = 512;
				}
			}
			// var_dump($picture); exit();
			$picture->process('upload/');

			$oldPicture = $product->picture;
			$product->picture = $picture->file_dst_name;
		}

		// $oldThumb = null;
		// $thumb = null;
		// if(!$this->emptyAttr('thumb') && $this->attr['thumb']->uploaded) {
		// 	$thumb = $this->getAttr('thumb');
		// 	$thumb->file_new_name_body = $this->generateName("product_thumb_");
		// 	$thumb->image_resize = true;
		//     $thumb->image_convert = 'jpeg';
		//     $thumb->image_x = 800;
		//     $thumb->image_y = 250;
		//     //$thumb->image_ratio_y = true;
		// 	$thumb->process('upload/');
		//
		// 	$oldThumb = $product->thumb;
		// 	$product->thumb = $thumb->file_dst_name;
		// }

		$success = R::store($product);

		if($success) {
			if(!is_null($oldPicture)) {
				@unlink('upload/'.$oldPicture);
			}
			// if(!is_null($oldThumb)) {
			// 	@unlink('upload/'.$oldThumb);
			// }
		}
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
