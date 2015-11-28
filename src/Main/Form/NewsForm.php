<?php
namespace Main\Form;

use RedBeanPHP\R;

class NewsForm extends Form {
	public $attr = [
		'name'=> '',
		// 'created_at'=> '',
		// 'updated_at'=> '',
		'picture'=> '',
		'thumb'=> '',
		'content'=> '',
		'link'=> ''
	];

	public function validate(){
		$this->errors = [];
		$this->error = false;
		$this->isValid = true;

		if(empty($this->attr['name'])){
			$this->pushError("name empty");
		}
		return !$this->error;
	}

	public function save(){
		if(!$this->emptyAttr('id')){
			$news = R::findOne('user', 'id=?', [$this->getAttr('id')]);
			$news->created_at = date('Y-m-d H:i:s');
			$news->updated_at = $news->created_at;
		}
		else {
			$news = R::dispense('user');
			$news->updated_at = date('Y-m-d H:i:s');
		}
		$news->name = $this->getAttr('name');
		$news->picture = $this->getAttr('picture');
		$news->thumb = $this->getAttr('thumb');
		$news->content = $this->getAttr('content', '');
		$news->link = $this->getAttr('link', '');
		return R::store($news);
	}
}
