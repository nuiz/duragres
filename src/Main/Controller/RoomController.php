<?php
namespace Main\Controller;

use RedBeanPHP\R;
use Main\Form\RoomForm;
use Main\Helper\FlashSession;

class RoomController extends BaseController
{
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

		$this->slim->render("room/list.php", ['items'=> $itemsExport, 'page'=> $page, 'maxPage'=> $maxPage]);
	}

	public function add()
	{
		$form = new RoomForm();
		$form->error = FlashSession::getInstance()->get("add_room_form_error", false);
		$this->slim->render("room/add.php", ['form'=> $form]);
	}

	public function post_add()
	{
		$attr = $this->slim->request->post();

		$form = new RoomForm($attr);
		if($form->validate()){
			$form->save();
			$this->slim->redirect($this->slim->request()->getRootUri().'/room');
		}
		else {
			FlashSession::getInstance()->set("add_room_form_error", $form->error);
			echo $this->goBack(); exit();
			// $this->slim->render("room/add.php", ['form'=> $form]);
		}
	}

	public function edit($id)
	{
		$item = R::findOne('room', 'id=?', [$id]);
		$form = new RoomForm($item->export());
		$form->error = FlashSession::getInstance()->get("edit_room_form_error", false);
		$this->slim->render("room/add.php", ['form'=> $form]);
	}

	public function post_edit($id){
		$attr = $this->slim->request->post();

		$attr['id'] = $id;
		$form = new RoomForm($attr);
		if($form->validate()){
			$form->save();
			$this->slim->redirect($this->slim->request()->getRootUri().'/room');
		}
		else {
			FlashSession::getInstance()->set("edit_room_form_error", $form->error);
			echo $this->goBack(); exit();
			// $this->slim->render("room/add.php", ['form'=> $form]);
		}
	}

	public function delete($id)
	{
		$item = R::findOne('room', 'id=?', [$id]);
		R::trash($item);
		$this->slim->redirect($this->slim->request()->getRootUri().'/room');
	}

	public function stat(){
		$perPage = 10;

		$page = @$_GET['page']? $_GET['page']: 1;
		$start = ($page-1) * $perPage;


	$where = [];
	$where[] = 1;

	$where = implode(" AND ", $where);
	$queryParam[] = $start;
	$queryParam[] = $perPage;

		$form =[];
		$form['room'] = '';

		$sub = 'SELECT SUM(product_room.view_count) FROM product_room WHERE product_room.product_id = product.id';
		$items = [];
		$count = 0;
		$maxPage = 0;

		if(!empty($_GET["room"])){

				$form["room"] = $_GET["room"];

				$ids = R::getCol('SELECT product_id FROM product_room WHERE room_name = :room_name',
		    [':room_name' => $_GET["room"]]);

				if(!empty($ids)){
				$ids = 	array_unique($ids);
				$room = $_GET["room"];
				$sub.=" AND product_room.room_name = '{$room}' ";

				$where  =  ' id IN ('.R::genSlots($ids).')';
				$queryParam = array_merge($ids,$queryParam);

				$sql = 'SELECT *,('.$sub.') as total_room FROM product WHERE '.$where.' LIMIT ?,?';

				$items = R::getAll($sql, $queryParam);
				$count = R::count('product', $where, array_slice($queryParam, 0, -2));
				$maxPage = floor($count/$perPage) + ($count%$perPage == 0 ? 0: 1);
			}else{

			}

		}




		$items = array_map(function($item){

			if(is_null($item["total_room"])) {
				$item["total_room"] = 0;
			}
			return $item;
		}, $items);

		$this->slim->render("room/stat_view.php", ['items'=> $items, 'page'=> $page, 'maxPage'=> $maxPage, 'form'=> $form ]);
	}


	public function build(&$item)
	{
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

	public function goBack()
	{
		return <<<HTML
<script type="text/javascript">history.go(-1);</script>
HTML;
	}
}
