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
