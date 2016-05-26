<?php
namespace Main\Controller;

use RedBeanPHP\R;
use Main\Form\ECatalogForm;
use Main\Form\ECatalogMoveForm;
use Main\Helper\FlashSession;

class ECatalogController extends BaseController
{
	public function index()
	{
		$perPage = 10;

		$page = @$_GET['page']? $_GET['page']: 1;
		$start = ($page-1) * $perPage;
		$items = R::find('ecatalog', 'ORDER BY sort_order LIMIT ?,?', [$start, $perPage]);
		$itemsAll = R::find('ecatalog', 'ORDER BY sort_order');
		$count = R::count('ecatalog');
		$maxPage = floor($count/$perPage) + ($count%$perPage == 0 ? 0: 1);

		$itemsExport = R::exportAll($items);
		$this->builds($itemsExport);
		$itemsAll = R::exportAll($items);
		$this->builds($itemsAll);

		$this->slim->render("ecatalog/list.php", [
			'items'=> $itemsExport,
			'itemsAll'=> $itemsAll,
			'page'=> $page,
			'maxPage'=> $maxPage
		]);
	}

	public function add()
	{
		$form = new ECatalogForm();
		$form->error = FlashSession::getInstance()->get("add_ecatalog_form_error", false);
		$this->slim->render("ecatalog/add.php", ['form'=> $form]);
	}

	public function post_add()
	{
		$attr = $this->slim->request->post();
		$attr['pdf'] = $_FILES['pdf'];

		$form = new ECatalogForm($attr);
		if($form->validate()){
			$form->save();
			$this->slim->redirect($this->slim->request()->getRootUri().'/ecatalog');
		}
		else {
			FlashSession::getInstance()->set("add_ecatalog_form_error", $form->error);
			echo $this->goBack(); exit();
			// $this->slim->render("ecatalog/add.php", ['form'=> $form]);
		}
	}

	public function edit($id)
	{
		$item = R::findOne('ecatalog', 'id=?', [$id]);
		$this->slim->render("ecatalog/add.php", ['form'=> new ECatalogForm($item->export())]);
	}

	public function post_edit($id){
		$attr = $this->slim->request->post();
		$attr['pdf'] = $_FILES['pdf'];

		$attr['id'] = $id;
		$form = new ECatalogForm($attr);
		if($form->validate()){
			$form->save();
			$this->slim->redirect($this->slim->request()->getRootUri().'/ecatalog');
		}
		else {
			echo $this->goBack(); exit();
			// $this->slim->render("ecatalog/add.php", ['form'=> $form]);
		}
	}

	public function delete($id)
	{
		$item = R::findOne('ecatalog', 'id=?', [$id]);
		R::trash($item);
		@unlink('upload/'.$item['pdf_path']);
		@unlink('upload/'.$item['cover_path']);
		$this->slim->redirect($this->slim->request()->getRootUri().'/ecatalog');
	}

	public function sort_move($id)
	{
		$attr = $this->slim->request->get();
		$moveSort = new ECatalogMoveForm($id);
		$moveSort->moveTo($attr["id"], $attr["position"]);

		$this->slim->redirect($this->slim->request()->getReferrer());
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

	public function goBack()
	{
		return <<<HTML
<script type="text/javascript">history.go(-1);</script>
HTML;
	}
}
