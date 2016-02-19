<?php
namespace Main\Controller;

use RedBeanPHP\R;
// use Main\Form\ProductForm;

class ApiProductController extends BaseController {
	public function index()
	{
		$perPage = 10;

		$page = @$_GET['page']? $_GET['page']: 1;
		$start = ($page-1) * $perPage;

		$where = [];
		$where[] = 1;
		$queryParam = [];
		if(!empty($_GET['type'])) {
			$where[] = "type = ?";
			$queryParam[] = $_GET['type'];
		}
		if(!empty($_GET['size'])) {
			$where[] = "size = ?";
			$queryParam[] = $_GET['size'];
		}
		if(!empty($_GET['style'])) {
			$where[] = "style = ?";
			$queryParam[] = $_GET['style'];
		}
		if(!empty($_GET['company'])) {
			$where[] = "company = ?";
			$queryParam[] = $_GET['company'];
		}

		$where = implode(" AND ", $where);
		$queryParam[] = $start;
		$queryParam[] = $perPage;

		$items = R::getAll('SELECT * FROM product WHERE '.$where.' ORDER BY is_hot DESC, is_new DESC, created_at DESC LIMIT ?,?', $queryParam);
		$count = R::count('product', $where, array_slice($queryParam, 0, -2));
		$maxPage = floor($count/$perPage) + ($count%$perPage == 0 ? 0: 1);

		// $itemsExport = R::exportAll($items);
		$this->builds($items);

		header('Content-Type: application/json');
		echo json_encode(['items'=> $items, 'page'=> $page, 'maxPage'=> $maxPage, 'total'=> $count], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		exit();
	}

	public function get($id)
	{
		$item = R::findOne('product', 'id=?', [$id]);
		$itemExport = $item->getProperties();
		$this->build($itemExport);

		header('Content-Type: application/json');
		echo json_encode($itemExport, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		exit();
	}

	public function addView($productId)
	{
		$item = R::findOne('product', 'id=?', [$productId]);
		if(!$item) {
			header('Content-Type: application/json');
			echo json_encode(['error'=> 'NOT_FOUND_PRODUCT'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			exit();
		}

		$dateStr = date('Y-m-d');
		$productView = R::getRow('SELECT * FROM product_view WHERE product_id=? AND view_date=?', [$productId, $dateStr]);
		if(!$productView) {
			R::exec('INSERT INTO product_view SET product_id=?, view_date=?', [$productId, $dateStr]);
		}
		R::exec('UPDATE product_view SET view_count = view_count+1 WHERE product_id=? AND view_date=?', [$productId, $dateStr]);

		header('Content-Type: application/json');
		echo json_encode(['success'=> true], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		exit();
	}

	public function build(&$item)
	{
		$item['picture_url'] = $this->getBaseUrl().'/upload/'.$item['picture'];
		$item['thumb_url'] = $this->getBaseUrl().'/upload/'.$item['thumb'];
		$item['total_view'] = R::getCell('SELECT SUM(view_count) FROM product_view WHERE product_id=?', [$item['id']]) | '0';
		$item['total_add'] = R::getCell('SELECT SUM(add_count) FROM product_add WHERE product_id=?', [$item['id']]) | '0';
	}

	public function builds(&$items)
	{
		foreach($items as &$item) {
			$this->build($item);
		}
	}

	public function getBaseUrl()
	{
		$req = $this->slim->request;
		return $req->getUrl()."".$req->getRootUri();
	}
}
