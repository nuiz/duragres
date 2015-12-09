<?php
namespace Main\Controller;

use RedBeanPHP\R;

class ApiAccountController extends BaseController
{
	public function delete($token)
	{
		$success = false;
		$item = R::findOne('account', 'token=?', [$token]);
		if(!empty($item)) {
			R::trash($item);
			$success = true;
		}

		header('Content-Type: application/json');
		echo json_encode(['success'=> $success], JSON_UNESCAPED_SLASHES);
		exit();
	}
}
