<?php
namespace Main\Controller;

use RedBeanPHP\R;

class ApiRoomController extends BaseController {
	public function index()
	{
		$perPage = 10;

		$page = @$_GET['page']? $_GET['page']: 1;
		$start = ($page-1) * $perPage;
		$items = R::find('room', 'LIMIT ?,?', [$start, $perPage]);
		$count = R::count('room');
		$maxPage = floor($count/$perPage) + ($count%$perPage == 0 ? 0: 1);

		$itemsExport = R::exportAll($items);
		$this->builds($itemsExport);

		header('Content-Type: application/json');
		echo json_encode(['items'=> $itemsExport, 'page'=> $page, 'maxPage'=> $maxPage, 'total'=> $count], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		exit();
	}

	public function get($id)
	{
		$item = R::findOne('room', 'id=?', [$id]);
		$itemExport = $item->getProperties();
		$this->build($itemExport);

		header('Content-Type: application/json');
		echo json_encode($itemExport, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		exit();
	}

	public function build(&$item)
	{
		// $item['picture_url'] = $this->getBaseUrl().'/upload/'.$item['picture'];
		// $item['thumb_url'] = $this->getBaseUrl().'/upload/'.$item['thumb'];
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
