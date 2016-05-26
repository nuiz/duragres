<?php
namespace Main\Controller;

use RedBeanPHP\R;
use Main\Form\RoomForm;
use Main\Helper\FlashSession;
use PHPExcel;
use PHPExcel_IOFactory;

class UserController extends BaseController
{
	public function index()
	{
		$perPage = 10;

		$page = @$_GET['page']? $_GET['page']: 1;
		$start = ($page-1) * $perPage;
		$items = R::find('account', 'email IS NOT NULL LIMIT ?,?', [$start, $perPage]);
		$count = R::count('account', 'email IS NOT NULL');
		$maxPage = floor($count/$perPage) + ($count%$perPage == 0 ? 0: 1);

		$itemsExport = R::exportAll($items);
		$this->builds($itemsExport);



		$this->slim->render("user/list.php", ['items'=> $itemsExport, 'page'=> $page, 'maxPage'=> $maxPage]);
	}

	public function sheet()
	{
		$items = R::find("account", "email IS NOT NULL");

		$itemsExport = R::exportAll($items);
		$this->builds($itemsExport);

		// var_dump($itemsExport);

		$excel = new PHPExcel();
    $excel->getProperties()->setCreator("duragres - users");
    $excel->getProperties()->setLastModifiedBy("duragres - users");
    $excel->getProperties()->setTitle("duragres - users");
    $excel->getProperties()->setSubject("duragres - users");
    $excel->getProperties()->setDescription("duragres - users, report.");
    $excel->setActiveSheetIndex(0);

		$sheet = $excel->getActiveSheet();
    $sheet->setTitle("Report");

		foreach($itemsExport as $key => $item) {
			if($key == 0) {
				$sheet->SetCellValue('A'.'1', "ID");
				$sheet->SetCellValue('B'.'1', "Created At");
				$sheet->SetCellValue('C'.'1', "Email");
				$sheet->SetCellValue('F'.'1', "Product Count");
			}

			$i = $key+2;
	    $bTime = @strtotime($item["created_at"]);
	    $bYear = @date('Y', $bTime); // + 543;
	    $bStr = @date('d/m/', $bTime).$bYear;
	    $bStr = !empty($item["created_at"])? $bStr: "";

	    $sheet->SetCellValue('A'.$i, $item["id"]);
	    $sheet->SetCellValue('B'.$i, $bStr);
	    $sheet->SetCellValue('C'.$i, $item["email"]);
			$sheet->SetCellValue('F'.$i, $item["product_count"]);
		}

		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		// We'll be outputting an excel file
    header('Content-type: application/vnd.ms-excel');

    // It will be called file.xls
    header('Content-Disposition: attachment; filename="users.xls"');

    // Write file to the browser
    $objWriter->save('php://output');

		exit();
	}

	public function sheetUser($id)
	{


		$excel = new PHPExcel();
    $excel->getProperties()->setCreator("duragres - user");
    $excel->getProperties()->setLastModifiedBy("duragres - user");
    $excel->getProperties()->setTitle("duragres - user");
    $excel->getProperties()->setSubject("duragres - user");
    $excel->getProperties()->setDescription("duragres - user, report.");
    $excel->setActiveSheetIndex(0);

		$sheet = $excel->getActiveSheet();



		$account = R::findOne('account','id = ?',[$id]);
		$account_products = R::find('account_product','account_id = ?',[$id]);

	$sheet->setTitle("User Data");

		$sheet->SetCellValue('A'.'1', "#");
		$sheet->SetCellValue('B'.'1', "Name EN");
		$sheet->SetCellValue('C'.'1', "Name TH");
		$sheet->SetCellValue('D'.'1', "Type");
		$sheet->SetCellValue('E'.'1', "Style");
		$sheet->SetCellValue('F'.'1', "Size");
		$sheet->SetCellValue('G'.'1', "Unit");

	$i = 1;
		foreach ($account_products as $key => $account_product) {

			$porduct = R::findOne('product','id=?',[$account_product->product_id]);

			$i = $i+1;
				$sheet->SetCellValue('A'.$i, $i-1);
				$sheet->SetCellValue('B'.$i, $porduct->name_eng);
				$sheet->SetCellValue('C'.$i, $porduct->name);
				$sheet->SetCellValue('D'.$i, $porduct->type);
				$sheet->SetCellValue('E'.$i, $porduct->style);
				$sheet->SetCellValue('F'.$i, $porduct->size);
				$sheet->SetCellValue('G'.$i, $porduct->size_unit);

		}





		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		// We'll be outputting an excel file
		header('Content-type: application/vnd.ms-excel');

		// It will be called file.xls
		header('Content-Disposition: attachment; filename="'.$account->email.'.xls"');

		// Write file to the browser
		$objWriter->save('php://output');


			exit();
	}

	public function build(&$item)
	{
		// $item["created_at"] = strtotime($item["created_at"]);

		$account_product = R::find('account_product','account_id = ?',[$item['id']]);

		$item["product_count"] = sizeof($account_product);

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
