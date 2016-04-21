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
		'icon_1'=> '',
		'icon_2'=> '',
		'icon_3'=> '',
		'icon_4'=> '',
		'thumb'=> '',
		'size'=> '',
		'size_unit'=> '',
		'style'=> '',
		'type'=> '',
		'porcelain_type'=> '',
		'company'=> '',
		'price'=> '',
		'is_hot'=> 0,
		'is_new'=> 0,
		'is_group'=> 0,
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
				$this->pushError("picture empty");
			}
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
			$product->icon_1 = "";
			$product->icon_2 = "";
			$product->icon_3 = "";
			$product->icon_4 = "";
		}
		$product->code = $this->getAttr('code');
		$product->name = $this->getAttr('name');
		$product->name_eng = $this->getAttr('name_eng');
		$product->size = $this->getAttr('size');
		$product->size_unit = $this->getAttr('size_unit');
		$product->style = $this->getAttr('style');
		$product->type = $this->getAttr('type');
		$product->porcelain_type = $this->getAttr('porcelain_type');
		$product->company = $this->getAttr('company');
		$product->price = $this->getAttr('price');
		$product->is_hot = $this->getAttr('is_hot');
		$product->is_new = $this->getAttr('is_new');
		$product->is_group = $this->getAttr('is_group');
		$product->color = $this->getAttr('color');
		$product->surface = $this->getAttr('surface');
		$product->pcs_ctn = $this->getAttr('pcs_ctn');
		$product->sqm_ctn = $this->getAttr('sqm_ctn');

		$product->icon_1 = $this->getAttr('icon_1');
		$product->icon_2 = $this->getAttr('icon_2');
		$product->icon_3 = $this->getAttr('icon_3');
		$product->icon_4 = $this->getAttr('icon_4');

		$oldPicture = null;
		$picture = null;
		$oldThumb = null;
		$thumb = null;

		if(!$this->emptyAttr('picture') && $this->attr['picture']->uploaded) {
			$picture = $this->getAttr('picture');
			$thumb = clone $picture;

			$picture->file_new_name_body = $this->generateName("product_picture_");
			$thumb->file_new_name_body = $this->generateName("product_thumb_");

	    $thumb->image_convert = $picture->image_convert = 'jpeg';

	    // $picture->image_ratio_y = true;
			if($picture->image_src_x > 512 || $picture->image_src_y > 512) {
				$picture->image_resize = true;
				if($picture->image_src_x > $picture->image_src_y) {
					$picture->image_ratio_y = true;
			    $picture->image_x = 512;
				}
				else {
					$picture->image_ratio_x = true;
			    $picture->image_y = 512;
				}
			}
			if($thumb->image_src_x > 150 || $thumb->image_src_y > 150) {
				$thumb->image_resize = true;
				if($thumb->image_src_x > $thumb->image_src_y) {
					$thumb->image_ratio_y = true;
			    $thumb->image_x = 150;
				}
				else {
					$thumb->image_ratio_x = true;
			    $thumb->image_y = 150;
				}
			}

			// var_dump($picture); exit();
			$picture->process('upload/');
			$thumb->process('upload/');

			$oldPicture = $product->picture;
			$product->picture = $picture->file_dst_name;

			$oldThumb = $product->thumb;
			$product->thumb = $thumb->file_dst_name;
		}

		// $oldIcon1 = null;
		// $icon1 = null;
		// if(!$this->emptyAttr('icon_1') && $this->attr['icon_1']->uploaded) {
		// 	$icon1 = $this->getAttr('icon_1');
		// 	$icon1->file_new_name_body = $this->generateName("product_icon_");
	  //   // $icon1->image_convert = 'jpeg';
		//
	  //   // $picture->image_ratio_y = true;
		// 	if($icon1->image_src_x > 150 || $icon1->image_src_y > 150) {
		// 		$icon1->image_resize = true;
		// 		if($icon1->image_src_x > $icon1->image_src_y) {
		// 			$icon1->image_ratio_y = true;
		// 	    $icon1->image_x = 150;
		// 		}
		// 		else {
		// 			$icon1->image_ratio_x = true;
		// 	    $icon1->image_y = 150;
		// 		}
		// 	}
		//
		// 	$icon1->process('upload/');
		//
		// 	$oldIcon1 = $product->icon_1;
		// 	$product->icon_1 = $icon1->file_dst_name;
		// }
		//
		// $oldIcon2 = null;
		// $icon2 = null;
		// if(!$this->emptyAttr('icon_2') && $this->attr['icon_2']->uploaded) {
		// 	$icon2 = $this->getAttr('icon_2');
		// 	$icon2->file_new_name_body = $this->generateName("product_icon_");
	  //   // $icon2->image_convert = 'jpeg';
		//
	  //   // $picture->image_ratio_y = true;
		// 	if($icon2->image_src_x > 150 || $icon2->image_src_y > 150) {
		// 		$icon2->image_resize = true;
		// 		if($icon2->image_src_x > $icon2->image_src_y) {
		// 			$icon2->image_ratio_y = true;
		// 	    $icon2->image_x = 150;
		// 		}
		// 		else {
		// 			$icon2->image_ratio_x = true;
		// 	    $icon2->image_y = 150;
		// 		}
		// 	}
		//
		// 	$icon2->process('upload/');
		//
		// 	$oldIcon2 = $product->icon_2;
		// 	$product->icon_2 = $icon2->file_dst_name;
		// }
		//
		// $oldIcon3 = null;
		// $icon3 = null;
		// if(!$this->emptyAttr('icon_3') && $this->attr['icon_3']->uploaded) {
		// 	$icon3 = $this->getAttr('icon_3');
		// 	$icon3->file_new_name_body = $this->generateName("product_icon_");
	  //   // $icon3->image_convert = 'jpeg';
		//
	  //   // $picture->image_ratio_y = true;
		// 	if($icon3->image_src_x > 150 || $icon3->image_src_y > 150) {
		// 		$icon3->image_resize = true;
		// 		if($icon3->image_src_x > $icon3->image_src_y) {
		// 			$icon3->image_ratio_y = true;
		// 	    $icon3->image_x = 150;
		// 		}
		// 		else {
		// 			$icon3->image_ratio_x = true;
		// 	    $icon3->image_y = 150;
		// 		}
		// 	}
		//
		// 	$icon3->process('upload/');
		//
		// 	$oldIcon3 = $product->icon_3;
		// 	$product->icon_3 = $icon3->file_dst_name;
		// }
		//
		// $oldIcon4 = null;
		// $icon4 = null;
		// if(!$this->emptyAttr('icon_4') && $this->attr['icon_4']->uploaded) {
		// 	$icon4 = $this->getAttr('icon_4');
		// 	$icon4->file_new_name_body = $this->generateName("product_icon_");
	  //   // $icon4->image_convert = 'jpeg';
		//
	  //   // $picture->image_ratio_y = true;
		// 	if($icon4->image_src_x > 150 || $icon4->image_src_y > 150) {
		// 		$icon4->image_resize = true;
		// 		if($icon4->image_src_x > $icon4->image_src_y) {
		// 			$icon4->image_ratio_y = true;
		// 	    $icon4->image_x = 150;
		// 		}
		// 		else {
		// 			$icon4->image_ratio_x = true;
		// 	    $icon4->image_y = 150;
		// 		}
		// 	}
		//
		// 	$icon4->process('upload/');
		//
		// 	$oldIcon4 = $product->icon_4;
		// 	$product->icon_4 = $icon4->file_dst_name;
		// }

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
			if(!is_null($oldThumb)) {
				@unlink('upload/'.$oldThumb);
			}
			// if(!is_null($oldIcon1)) {
			// 	@unlink('upload/'.$oldIcon1);
			// }
			// if(!is_null($oldIcon2)) {
			// 	@unlink('upload/'.$oldIcon2);
			// }
			// if(!is_null($oldIcon3)) {
			// 	@unlink('upload/'.$oldIcon3);
			// }
			// if(!is_null($oldIcon4)) {
			// 	@unlink('upload/'.$oldIcon4);
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
