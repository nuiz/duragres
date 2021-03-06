<?php
namespace Main\Controller;

use RedBeanPHP\R;
use Main\Form\PatternForm;
use Main\Helper\FlashSession;

class RoomPatternController extends BaseController
{
	public function index($roomId)
	{
		$perPage = 10;

		$page = @$_GET['page']? $_GET['page']: 1;
		$start = ($page-1) * $perPage;
		$room = R::findOne('room', 'id = ?', [$roomId]);
		$items = R::find('room_pattern', 'room_id = ? LIMIT ?,?', [$roomId, $start, $perPage]);
		$count = R::count('room_pattern', 'room_id = ?', [$roomId]);
		$maxPage = floor($count/$perPage) + ($count%$perPage == 0 ? 0: 1);

		$itemsExport = R::exportAll($items);
		$this->builds($itemsExport);

		$this->slim->render("room/pattern/list.php", ['room'=> $room, 'items'=> $itemsExport, 'page'=> $page, 'maxPage'=> $maxPage]);
	}

	public function add($roomId)
	{
		$room = R::findOne('room', 'id = ?', [$roomId]);
		$products = R::find('product');
		$form = new PatternForm(['room_id'=> $roomId]);
		$form->error = FlashSession::getInstance()->get("add_room_pattern_form_error", false);
		$this->slim->render("room/pattern/add.php", [
			'products'=> $products,
			'room'=> $room->getProperties(),
			'form'=> $form
		]);
	}

	public function post_add($roomId)
	{
		$attr = $this->slim->request->post();
		$attr['picture'] = new \upload($_FILES['picture']);
		$attr['thumb'] = new \upload($_FILES['thumb']);
		$attr["room_id"] = $roomId;

		$form = new PatternForm($attr);
		if($form->validate()){
			$form->save();
			$this->slim->redirect($this->slim->request()->getRootUri().'/room/'.$roomId.'/pattern');
		}
		else {
			FlashSession::getInstance()->set("add_room_pattern_form_error", $form->error);
			echo $this->goBack(); exit();
			// $this->slim->render("room/add.php", ['form'=> $form]);
		}
	}

	public function edit($roomId, $id)
	{
		$room = R::findOne('room', 'id = ?', [$roomId]);
		$item = R::findOne('room_pattern', 'id = ?', [$id]);
		$item = $item->getProperties();
		$this->build($item);
		$products = R::find('product');
		$form = new PatternForm($item);
		$form->error = FlashSession::getInstance()->get("edit_room_pattern_form_error", false);
		$this->slim->render("room/pattern/add.php", [
			'products'=> $products,
			'room'=> $room,
			'form'=> $form
		]);
	}

	public function post_edit($roomId, $id){
		$attr = $this->slim->request->post();
		$attr['picture'] = new \upload($_FILES['picture']);
		$attr['thumb'] = new \upload($_FILES['thumb']);
		$attr["room_id"] = $roomId;
		$attr['id'] = $id;
		$form = new PatternForm($attr);
		if($form->validate()){
			$form->save();
			$this->slim->redirect($this->slim->request()->getRootUri().'/room/'.$roomId.'/pattern');
		}
		else {
			FlashSession::getInstance()->set("edit_room_pattern_form_error", $form->error);
			echo $this->goBack(); exit();
			// $this->slim->render("room/add.php", ['form'=> $form]);
		}
	}

	public function delete($roomId, $id)
	{
		$item = R::findOne('room_pattern', 'id=?', [$id]);
		@unlink('upload/'.$item->picture);
		@unlink('upload/'.$item->thumb);
		R::trash($item);
		$this->slim->redirect($this->slim->request()->getRootUri().'/room/'.$roomId.'/pattern');
	}

	public function build(&$item)
	{
		$item["product_use"] = trim($item["product_use"]);
		$item["product_use"] = explode(",", $item["product_use"]);
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
