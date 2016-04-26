<?php
namespace Main\Controller;

use RedBeanPHP\R;

class ApiContactdealerController extends BaseController {
	public function index()
	{
		$perPage = 999999;

		$page = @$_GET['page']? $_GET['page']: 1;
		$start = ($page-1) * $perPage;

		$where = [];
		$where[] = 1;
		$queryParam = [];
		if(!empty($_GET['geo_id'])) {
			$where[] = "geo_id = ?";
			$queryParam[] = $_GET['geo_id'];
		}

		$where = implode(" AND ", $where);
		$queryParam[] = $start;
		$queryParam[] = $perPage;

		$items = R::getAll('SELECT * FROM contactdealer WHERE '.$where.' LIMIT ?,?', $queryParam);
		//$items = R::find('contactdealer', 'LIMIT ?,?', [$start, $perPage]);
		$count = R::count('contactdealer', $where, array_slice($queryParam, 0, -2));
		$maxPage = floor($count/$perPage) + ($count%$perPage == 0 ? 0: 1);

		// $itemsExport = R::exportAll($items);
		$this->builds($items);

		header('Content-Type: application/json');
		echo json_encode(['items'=> $items, 'page'=> $page, 'maxPage'=> $maxPage, 'total'=> $count], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		exit();
	}

	public function get($id)
	{
		$item = R::findOne('contactdealer', 'id=?', [$id]);
		$itemExport = $item->getProperties();
		$this->build($itemExport);

		header('Content-Type: application/json');
		echo json_encode($itemExport, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		exit();
	}

	public function build(&$item)
	{
		$item['province'] = R::getRow('SELECT * FROM provinces WHERE province_id=?', [$item['province_id']]);
		$item['geography'] = R::getRow('SELECT * FROM geography WHERE geo_id=?', [$item['geo_id']]);
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
