<?php
namespace Main\Controller;

use RedBeanPHP\R;

class ApiAccountController extends BaseController
{
	public function delete()
	{
		$success = false;
		$token = $this->slim->request->params('token');
		$item = R::findOne('account', 'token=?', [$token]);
		if(!empty($item)) {
			R::trash($item);
			$success = true;
		}

		header('Content-Type: application/json');
		echo json_encode(['success'=> $success], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		exit();
	}

	public function product()
	{
		$perPage = 10;

		$token = $this->slim->request->params('token');
		if(empty($token)) {
			header('Content-Type: application/json');
			echo json_encode(['error'=> 'REQUIRE_AUTHORIZE'], JSON_UNESCAPED_SLASHES);
			exit();
		}

		$account = R::findOne("account", "token = ?", [$token]);
		if(!$account) {
			header('Content-Type: application/json');
			echo json_encode(['error'=> 'AUTHORIZE_FAILED'], JSON_UNESCAPED_SLASHES);
			exit();
		}

		$page = @$_GET['page']? $_GET['page']: 1;
		$start = ($page-1) * $perPage;

		$where = [];
		$queryParam = [];

		$where[] = "account_product.account_id = ?";
		$queryParam[] = $account['id'];

		if(!empty($_GET['type'])) {
			$where[] = "product.type = ?";
			$queryParam[] = $_GET['type'];
		}
		if(!empty($_GET['size'])) {
			$where[] = "product.size = ?";
			$queryParam[] = $_GET['size'];
		}
		if(!empty($_GET['style'])) {
			$where[] = "product.style = ?";
			$queryParam[] = $_GET['style'];
		}
		if(!empty($_GET['company'])) {
			$where[] = "product.company = ?";
			$queryParam[] = $_GET['company'];
		}

		$where = implode(" AND ", $where);
		// $queryParam[] = $start;
		// $queryParam[] = $perPage;

		$items = R::getAll("SELECT product.* FROM account_product RIGHT JOIN product ON account_product.product_id = product.id WHERE ".$where." LIMIT ?,?", array_merge($queryParam, [$start, $perPage]));
		$count = R::getCell("SELECT COUNT(product.id) FROM account_product RIGHT JOIN product ON account_product.product_id = product.id WHERE ".$where, $queryParam);
		$maxPage = floor($count/$perPage) + ($count%$perPage == 0 ? 0: 1);

		//$itemsExport = R::exportAll($items);
		$itemsExport = $items;
		$this->buildProducts($itemsExport);

		header('Content-Type: application/json');
		echo json_encode(['items'=> $itemsExport, 'page'=> $page, 'maxPage'=> $maxPage, 'total'=> $count], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		exit();
	}

	public function addProduct()
	{
		$productId = $this->slim->request->params('product_id');
		$token = $this->slim->request->params('token');
		if(empty($token)) {
			header('Content-Type: application/json');
			echo json_encode(['error'=> 'REQUIRE_AUTHORIZE'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			exit();
		}

		$account = R::findOne("account", "token = ?", [$token]);
		if(!$account) {
			header('Content-Type: application/json');
			echo json_encode(['error'=> 'AUTHORIZE_FAILED'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			exit();
		}

		$product = R::findOne("product", "id = ?", [$productId]);
		if(!$product) {
			header('Content-Type: application/json');
			echo json_encode(['error'=> 'PRODUCT_NOT_FOUND'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			exit();
		}

		$old = R::findOne("account_product", "account_id = ? AND product_id = ?", [$account['id'], $productId]);
		if($old) {
			header('Content-Type: application/json');
			echo json_encode(['error'=> 'DUPLICATE_ITEM'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			exit();
		}

		$item = R::xdispense('account_product');
		$item->created_at = date('Y-m-d H:i:s');
		$item->account_id = $account['id'];
		$item->product_id = $product['id'];

		R::store($item);
		$this->productAddStat($product['id']);

		header('Content-Type: application/json');
		echo json_encode(['success'=> true], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		exit();
	}

	public function deleteProduct($productId)
	{
		$token = $this->slim->request->params('token');
		if(empty($token)) {
			header('Content-Type: application/json');
			echo json_encode(['error'=> 'REQUIRE_AUTHORIZE'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			exit();
		}

		$account = R::findOne("account", "token = ?", [$token]);
		if(!$account) {
			header('Content-Type: application/json');
			echo json_encode(['error'=> 'AUTHORIZE_FAILED'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			exit();
		}

		$item = R::findOne("account_product", "account_id=? AND product_id = ?", [$account['id'], $productId]);
		if(!$item) {
			header('Content-Type: application/json');
			echo json_encode(['error'=> 'ACCOUNT_PRODUCT_NOT_FOUND'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			exit();
		}

		R::trash($item);

		header('Content-Type: application/json');
		echo json_encode(['success'=> true], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		exit();
	}

	// internal function
	public function productAddStat($productId)
	{
		$dateStr = date('Y-m-d');
		$productView = R::getRow('SELECT * FROM product_add WHERE product_id=? AND add_date=?', [$productId, $dateStr]);
		if(!$productView) {
			R::exec('INSERT INTO product_add SET product_id=?, add_date=?', [$productId, $dateStr]);
		}
		R::exec('UPDATE product_add SET add_count = add_count+1 WHERE product_id=? AND add_date=?', [$productId, $dateStr]);

		header('Content-Type: application/json');
		echo json_encode(['success'=> true], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		exit();
	}

	public function buildProduct(&$item)
	{
		$item['picture_url'] = $this->getBaseUrl().'/upload/'.$item['picture'];
		$item['thumb_url'] = $this->getBaseUrl().'/upload/'.$item['thumb'];
	}

	public function buildProducts(&$items)
	{
		foreach($items as &$item) {
			$this->buildProduct($item);
		}
	}

	public function getBaseUrl()
	{
		$req = $this->slim->request;
		return $req->getUrl()."".$req->getRootUri();
	}
}
