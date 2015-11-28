<?php
namespace Main\Controller;

use Main\Auth\Auth;

class IndexController extends BaseController
{
    public function index()
    {
      $auth = new Auth();
      $user = $auth->getUserSession();
      $this->slim->redirect($this->slim->request()->getRootUri().'/news');
    }
}
