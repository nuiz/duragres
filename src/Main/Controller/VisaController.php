<?php

namespace Main\Controller;

use RedBeanPHP\R;
use Main\Form\VisaSearchForm;

class VisaController extends BaseController {

	public function index()
	{
		$perPage = 10;

		$searchForm = new VisaSearchForm($_GET);
		$searchForm->search();

		$items = $searchForm->getItems();
		$page = $searchForm->getPage();
		$maxPage = $searchForm->getMaxPage();

		$this->slim->render("visa/list.php", ['items'=> $items, 'searchForm'=> $searchForm, 'page'=> $page, 'maxPage'=> $maxPage]);
	}
}
