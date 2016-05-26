<?php
namespace Main\Controller;

use RedBeanPHP\R;

class ApiECatalogController extends BaseController {
	public function index()
	{
		$perPage = 10;

		$page = @$_GET['page']? $_GET['page']: 1;
		$start = ($page-1) * $perPage;
		$items = R::find('ecatalog', ' ORDER BY sort_order LIMIT ?,?', [$start, $perPage]);
		$count = R::count('ecatalog');
		$maxPage = floor($count/$perPage) + ($count%$perPage == 0 ? 0: 1);


		$itemsExport = R::exportAll($items);
		$this->builds($itemsExport);

		header('Content-Type: application/json');
		echo json_encode(['items'=> $itemsExport, 'page'=> $page, 'maxPage'=> $maxPage, 'total'=> $count], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		exit();
	}

	public function get($id)
	{
		$item = R::findOne('ecatalog', 'id=?', [$id]);
		$itemExport = $item->getProperties();
		$this->build($itemExport);

		header('Content-Type: application/json');
		echo json_encode($itemExport, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		exit();
	}

public function add_view(){
	$id = $this->slim->request->post()['id'];

	$item = R::load('ecatalog',$id);
	$item->view_count += 1;
	 R::store($item);

echo '555';
	exit();
}



	public function build(&$item)
	{
		$item['pdf_url'] = $this->getBaseUrl().'/upload/'.$item['pdf_path'];
		$item['cover_url'] = $this->getBaseUrl().'/upload/'.$item['cover_path'];
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
