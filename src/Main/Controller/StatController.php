<?php
namespace Main\Controller;

use RedBeanPHP\R;
use Main\Form\ProductForm;

class StatController extends BaseController {
	public function index()
	{
		$perPage = 10;

		$page = @$_GET['page']? $_GET['page']: 1;
		$start = ($page-1) * $perPage;

		$where = [];
		$where[] = 1;
		$queryParam = [];

		$where = implode(" AND ", $where);
		$queryParam[] = $start;
		$queryParam[] = $perPage;

		$form = [];
		$sub = 'SELECT SUM(product_view.view_count) FROM product_view WHERE product_view.product_id = product.id';
		$sub2 = 'SELECT SUM(product_add.add_count) FROM product_add WHERE product_add.product_id = product.id';
		if(!empty($_GET["month"]) && !empty($_GET["year"])) {
			$sub .= " AND MONTH(product_view.view_date) = ?";
			$sub .= " AND YEAR(product_view.view_date) = ?";
			array_unshift($queryParam, (int)$_GET["month"], (int)$_GET["year"]);

			$sub2 .= " AND MONTH(product_add.add_date) = ?";
			$sub2 .= " AND YEAR(product_add.add_date) = ?";
			array_unshift($queryParam, (int)$_GET["month"], (int)$_GET["year"]);

			$form["month"] = $_GET["month"];
			$form["year"] = $_GET["year"];
		}
		else {
			$form["month"] = '';
			$form["year"] = '';
		}
		$sql = 'SELECT *, ('.$sub.') as total_view, ('.$sub2.') as total_add
			FROM product WHERE '.$where.' ORDER BY total_view DESC LIMIT ?,?';

		$items = R::getAll($sql, $queryParam);
		$count = R::count('product', $where, array_slice($queryParam, 0, -2));
		$maxPage = floor($count/$perPage) + ($count%$perPage == 0 ? 0: 1);
		$items = array_map(function($item){
			if(is_null($item["total_view"])) {
				$item["total_view"] = 0;
			}
			if(is_null($item["total_add"])) {
				$item["total_add"] = 0;
			}
			return $item;
		}, $items);
		$this->slim->render("stat/list.php", ['items'=> $items, 'page'=> $page, 'maxPage'=> $maxPage, 'form'=> $form]);
	}

	public function goBack()
	{
		return <<<HTML
<script type="text/javascript">history.go(-1);</script>
HTML;
	}
}
