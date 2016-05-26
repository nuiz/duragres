<?php
namespace Main\Controller;

use RedBeanPHP\R;
use Main\Form\ProductForm;
use PHPExcel;
use PHPExcel_IOFactory;

class StatController extends BaseController {
	public function index()
	{
		$perPage = 10;

		$page = @$_GET['page']? $_GET['page']: 1;
		$start = ($page-1) * $perPage;


		$form = [];
		$where = [];
		$where[] =  1;
		$queryParam = [];

		if(!empty($_GET['type'])) {
				$where[] = "type = '{$_GET['type']}'";
		//	$where[] = "type = ?";
		//	$queryParam[] = $_GET['type'];

		}
		if(!empty($_GET['size'])) {
			$where[] = "size = '{$_GET['size']}'";
			// $where[] = "size = ?";
			// $queryParam[] = $_GET['size'];
		}
		if(!empty($_GET['style'])) {
				$where[] = "style = '{$_GET['style']}'";
			// $where[] = "style = ?";
			// $queryParam[] = $_GET['style'];
		}
		if(!empty($_GET['company'])) {
						$where[] = "company = '{$_GET['company']}'";
			// $where[] = "company = ?";
			// $queryParam[] = $_GET['company'];
		}

		$where = implode(" AND ", $where);

		$queryParam[] = $start;
		$queryParam[] = $perPage;

		$ids = "";
		$form["room"]= "";
		$form["type"] = @$_GET["type"]?: "";
		$form["size"] = @$_GET["size"]?: "";
		$form["style"] = @$_GET["style"]?: "";
		$form["company"] = @$_GET["company"]?: "";
		// if(!empty($_GET["room"])){
		//
		// 		$form["room"] = $_GET["room"];
		//
		// 		$ids = R::getCol('SELECT product_id FROM product_room WHERE room_name = :room_name',
    //     [':room_name' => $_GET["room"]]);
		//
		// 		if(!empty($ids)){
		// 		$ids = 	array_unique($ids);
		//
		// 		$where = [];
		// 		$where =  ' id IN ('.R::genSlots($ids).')';
		//
		// 		$queryParam = array_merge($ids,$queryParam);
		//
		// 	}
		//
		// }



		$sub = 'SELECT SUM(product_view.view_count) FROM product_view WHERE product_view.product_id = product.id';
		$sub2 = 'SELECT SUM(product_add.add_count) FROM product_add WHERE product_add.product_id = product.id';
		$sub3 = 'SELECT SUM(product_room.view_count) FROM product_room WHERE product_room.product_id = product.id';

		$form["month"] = '';
		$form["year"] = '';
		if(!empty($_GET["year"])) {
			$sub .= " AND YEAR(product_view.view_date) = ".(int)$_GET["year"];
			$sub2 .= " AND YEAR(product_add.add_date) = ".(int)$_GET["year"];
			$sub3 .= " AND YEAR(product_room.view_date) = ".(int)$_GET["year"];
			$form["year"] = $_GET["year"];

			if(!empty($_GET["month"])) {
				$sub .= " AND MONTH(product_view.view_date) = ".(int)$_GET["month"];
				$sub2 .= " AND MONTH(product_add.add_date) = ".(int)$_GET["month"];
				$sub3 .= " AND MONTH(product_room.view_date) = ".(int)$_GET["month"];
				$form["month"] = $_GET["month"];
			}
		}

		if(empty($_GET["order"])){
				$form["order"] = 'total_view';
		}else{
				$form["order"] = $_GET["order"];
		}

		$sql = 'SELECT *, ('.$sub3.') as total_room, ('.$sub.') as total_view, ('.$sub2.') as total_add
			FROM product WHERE '.$where.'  ORDER BY '.$form["order"].' DESC LIMIT ?,?';




		$items = R::getAll($sql, $queryParam);



		$count = R::count('product', $where, array_slice($queryParam, 0, -2));
		 $maxPage = floor($count/$perPage) + ($count%$perPage == 0 ? 0: 1);
		$items = array_map(function($item){
			if(is_null($item["total_view"])) {
				$item["total_view"] = 0;
			}
			if(is_null($item["total_add"])) {
				$item["total_add"] = 0;
			}
			if(is_null($item["total_room"])) {
				$item["total_room"] = 0;
			}
			return $item;
		}, $items);

		$this->slim->render("stat/list.php", ['items'=> $items, 'page'=> $page, 'maxPage'=> $maxPage, 'form'=> $form]);
	}

	public function sheet()
	{
		$form = [];
		$where = [];
		$where[] =  1;
		$queryParam = [];

		if(!empty($_GET['type'])) {
			$where[] = "type = '{$_GET['type']}'";
		}
		if(!empty($_GET['size'])) {
			$where[] = "size = '{$_GET['size']}'";
		}
		if(!empty($_GET['style'])) {
			$where[] = "style = '{$_GET['style']}'";
		}
		if(!empty($_GET['company'])) {
			$where[] = "company = '{$_GET['company']}'";
		}

		$where = implode(" AND ", $where);

		$ids = "";
		$form["room"]= "";

		$sub = 'SELECT SUM(product_view.view_count) FROM product_view WHERE product_view.product_id = product.id';
		$sub2 = 'SELECT SUM(product_add.add_count) FROM product_add WHERE product_add.product_id = product.id';
		$sub3 = 'SELECT SUM(product_room.view_count) FROM product_room WHERE product_room.product_id = product.id';

		if(!empty($_GET["month"]) && !empty($_GET["year"])) {
			$sub .= " AND MONTH(product_view.view_date) = ?";
			$sub .= " AND YEAR(product_view.view_date) = ?";
			array_unshift($queryParam, (int)$_GET["month"], (int)$_GET["year"]);

			$sub2 .= " AND MONTH(product_add.add_date) = ?";
			$sub2 .= " AND YEAR(product_add.add_date) = ?";
			array_unshift($queryParam, (int)$_GET["month"], (int)$_GET["year"]);

			$sub3 .= " AND MONTH(product_room.view_date) = ?";
			$sub3 .= " AND YEAR(product_room.view_date) = ?";
			array_unshift($queryParam,(int)$_GET["month"], (int)$_GET["year"]);
		}

		if(empty($_GET["order"])){
			$order = 'total_view';
		}else{
			$order = $_GET["order"];
		}

		$sql = 'SELECT *, ('.$sub3.') as total_room, ('.$sub.') as total_view, ('.$sub2.') as total_add
			FROM product WHERE '.$where.'  ORDER BY '.$order." LIMIT ".(@$_GET["limit"]? $_GET["limit"]: 999999);

		$items = R::getAll($sql, $queryParam);

		$items = array_map(function($item){
			if(is_null($item["total_view"])) {
				$item["total_view"] = 0;
			}
			if(is_null($item["total_add"])) {
				$item["total_add"] = 0;
			}
			if(is_null($item["total_room"])) {
				$item["total_room"] = 0;
			}
			return $item;
		}, $items);

		$excel = new PHPExcel();
		$excel->getProperties()->setCreator("duragres - user");
		$excel->getProperties()->setLastModifiedBy("duragres - user");
		$excel->getProperties()->setTitle("duragres - user");
		$excel->getProperties()->setSubject("duragres - user");
		$excel->getProperties()->setDescription("duragres - user, report.");
		$excel->setActiveSheetIndex(0);

		$sheet = $excel->getActiveSheet();

		$sheet->setTitle("User Data");

		$sheet->SetCellValue('A'.'1', "#");
		$sheet->SetCellValue('B'.'1', "Name EN");
		$sheet->SetCellValue('C'.'1', "Name TH");
		$sheet->SetCellValue('D'.'1', "Type");
		$sheet->SetCellValue('E'.'1', "Style");
		$sheet->SetCellValue('F'.'1', "Size");
		$sheet->SetCellValue('G'.'1', "Unit");
		$sheet->SetCellValue('H'.'1', "Total Room");
		$sheet->SetCellValue('I'.'1', "Total View");
		$sheet->SetCellValue('J'.'1', "Total Add");

		$i = 1;
		foreach ($items as $item) {
			$i = $i+1;
			$sheet->SetCellValue('A'.$i, $i-1);
			$sheet->SetCellValue('B'.$i, $item["name_eng"]);
			$sheet->SetCellValue('C'.$i, $item["name"]);
			$sheet->SetCellValue('D'.$i, $item["type"]);
			$sheet->SetCellValue('E'.$i, $item["style"]);
			$sheet->SetCellValue('F'.$i, $item["size"]);
			$sheet->SetCellValue('G'.$i, $item["size_unit"]);
			$sheet->SetCellValue('H'.$i, $item["total_room"]);
			$sheet->SetCellValue('I'.$i, $item["total_view"]);
			$sheet->SetCellValue('J'.$i, $item["total_add"]);
		}

		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		// We'll be outputting an excel file
		header('Content-type: application/vnd.ms-excel');
		// It will be called file.xls
		header('Content-Disposition: attachment; filename="stat.xls"');
		// Write file to the browser
		$objWriter->save('php://output');
		exit();
	}

	public function goBack()
	{
		return <<<HTML
<script type="text/javascript">history.go(-1);</script>
HTML;
	}
}
