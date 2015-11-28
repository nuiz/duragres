<?php
namespace Main\Form;

use RedBeanPHP\R;

class EmployeeSearchForm extends Form
{
    public $attr = [
      "keyword"=> "",
      "page"=> 1,
      "perPage"=> 15
    ];

    public $items = [], $count = 0, $page = 0, $maxPage = 0;
    public function search()
    {
      $page = $this->getAttr("page");
      $perPage = $this->getAttr("perPage");

  		$start = ($page-1) * $perPage;

      $query = "";
      $bindParam = [];

      $keyword = $this->getAttr("keyword");
      $keyword = trim($keyword);
      if(!empty($keyword)) {
        $query .= "first_name LIKE :keyword OR last_name LIKE :keyword";
        $bindParam["keyword"] = '%'.$keyword.'%';
      }

      $this->count = R::count('employee', $query, $bindParam);

      $page = floor($this->count/$perPage);
      $this->maxPage = $page + ($this->count%$perPage == 0 ? 0: 1);

      $query .= " LIMIT :start,:perPage";
      $bindParam["start"] = $start;
      $bindParam["perPage"] = $perPage;

  		$this->items = R::find('employee', $query, $bindParam);
      $this->injectsUser($this->items);
    }

    public function getItems()
    {
      return $this->items;
    }

    public function getCount()
    {
      return $this->count;
    }

    public function getPage()
    {
      return $this->page;
    }

    public function getMaxPage()
    {
      return $this->maxPage;
    }

  	public function injectsUser(&$items){
  		$cacheUsers = [];
  		foreach($items as &$item){
  			if(!isset($cacheUsers[(string)$item->user_id])){
  				$cacheUsers[(string)$item->user_id] = R::findOne('user', 'id=?', [$item->user_id]);
  			}
  			$item->user = $cacheUsers[(string)$item->user_id];
  		}
  	}
}
