<?php
namespace Main\Form;

use RedBeanPHP\R;

class ECatalogForm extends Form
{
	public $attr = [
		// 'created_at'=> '',
		// 'updated_at'=> '',
		'name'=> '',
		'cover_path'=> '',
		'pdf_path'=> '',
		'is_new'=> '0'
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

		if($this->emptyAttr('id')) {
			if(!is_uploaded_file($this->attr['pdf']['tmp_name'])) {
				$this->pushError("pdf empty");
			}
		}
		return !$this->error;
	}

	public function save()
	{
		if(!$this->emptyAttr('id')) {
			$ecatalog = R::findOne('ecatalog', 'id=?', [$this->getAttr('id')]);
			$ecatalog->updated_at = date('Y-m-d H:i:s');
		}
		else {
			$ecatalog = R::dispense('ecatalog');
			$ecatalog->created_at = date('Y-m-d H:i:s');
			$ecatalog->updated_at = date('Y-m-d H:i:s');
			$ecatalog->sort_order = (int)R::getCell("SELECT MAX(sort_order) FROM ecatalog") + 1;
		}
		$ecatalog->name = $this->getAttr('name');
		$ecatalog->is_new = $this->getAttr('is_new');

		if(!$this->emptyAttr('pdf') && is_uploaded_file($this->attr['pdf']['tmp_name'])) {
			$pdf = $this->getAttr('pdf');

			$pdf_path = $this->generateName('ecatalog_pdf_').'.pdf';
			$cover_path = $this->generateName('ecatalog_cover_').'.jpeg';

			$im = new \Imagick($pdf['tmp_name'].'[0]');
			$im->setImageBackgroundColor('white');
			// $im = $im->flattenImages();
			$im = $im->mergeImageLayers(\Imagick::LAYERMETHOD_FLATTEN);

			$im->setImageFormat('jpeg');
			if($im->getImageColorspace() == \Imagick::COLORSPACE_CMYK) {
				$im->setImageColorspace(\Imagick::COLORSPACE_SRGB);
			}
			$im->thumbnailImage(512, 0);
			$im->writeImage('upload/'.$cover_path);
			$im->clear();
			$im->destroy();

			move_uploaded_file($pdf['tmp_name'], 'upload/'.$pdf_path);

			$this->pushDeleteWhenSuccess('upload/'.$ecatalog->pdf_path);
			$this->pushDeleteWhenSuccess('upload/'.$ecatalog->cover_path);

			$this->pushDeleteWhenFailed('upload/'.$pdf_path);
			$this->pushDeleteWhenFailed('upload/'.$cover_path);

			$ecatalog->pdf_path = $pdf_path;
			$ecatalog->cover_path = $cover_path;
		}

		$success = R::store($ecatalog);

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
