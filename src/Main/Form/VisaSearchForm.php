<?php
namespace Main\Form;

use RedBeanPHP\R;

class VisaSearchForm extends Form
{
    public $attr = [
      "page"=> 1,
      "perPage"=> 15,
      "passport_expiry_start"=> "",
      "passport_expiry_end"=> "",
      "visa_expiry_start"=> "",
      "visa_expiry_end"=> "",
      "report_expiry_start"=> "",
      "report_expiry_end"=> ""
    ];

    public $items = [], $count = 0, $page = 0, $maxPage = 0;
    public function search()
    {
      $page = $this->getAttr("page");
      $perPage = $this->getAttr("perPage");

  		$start = ($page-1) * $perPage;

      $query = "";
      $bindParam = [];

      if(!empty($this->attr['passport_expiry_start']) || !empty($this->attr['passport_expiry_end'])){
        $queryPassportExpire = "";
        if(!empty($this->attr['passport_expiry_start'])){
          $queryPassportExpire .= "passport_expiry >= :passport_expiry_start";
          $bindParam['passport_expiry_start'] = $this->attr['passport_expiry_start'];
        }

        if(!empty($this->attr['passport_expiry_end'])){
          if(!empty($queryPassportExpire)) $queryPassportExpire .= " AND ";
          $queryPassportExpire .= "passport_expiry <= :passport_expiry_end";
          $bindParam['passport_expiry_end'] = $this->attr['passport_expiry_end'];
        }

        if(!empty($query)) $query .= " OR ";
        $query .= "({$queryPassportExpire})";
      }

      if(!empty($this->attr['visa_expiry_start']) || !empty($this->attr['visa_expiry_end'])){
        $queryVisaExpire = "";
        if(!empty($this->attr['visa_expiry_start'])){
          $queryVisaExpire .= "visa_expiry >= :visa_expiry_start";
          $bindParam['visa_expiry_start'] = $this->attr['visa_expiry_start'];
        }

        if(!empty($this->attr['visa_expiry_end'])){
          if(!empty($queryVisaExpire)) $queryVisaExpire .= " AND ";
          $queryVisaExpire .= "visa_expiry <= :visa_expiry_end";
          $bindParam['visa_expiry_end'] = $this->attr['visa_expiry_end'];
        }

        if(!empty($query)) $query .= " OR ";
        $query .= "({$queryVisaExpire})";
      }

      if(!empty($this->attr['report_expiry_start']) || !empty($this->attr['report_expiry_end'])){
        $queryReportExpire = "";
        if(!empty($this->attr['report_expiry_start'])){
          $queryReportExpire .= "report_expiry >= :report_expiry_start";
          $bindParam['report_expiry_start'] = $this->attr['report_expiry_start'];
        }
        if(!empty($this->attr['report_expiry_end'])){
          if(!empty($queryReportExpire)) $queryReportExpire .= " AND ";
          $queryReportExpire .= "report_expiry <= :report_expiry_end";
          $bindParam['report_expiry_end'] = $this->attr['report_expiry_end'];
        }

        if(!empty($query)) $query .= " OR ";
        $query .= "({$queryReportExpire})";
      }

      $this->count = R::count('employee', $query, $bindParam);

      $page = floor($this->count/$perPage);
      $this->maxPage = $page + ($this->count%$perPage == 0 ? 0: 1);

      $query .= " LIMIT :start,:perPage";
      $bindParam["start"] = $start;
      $bindParam["perPage"] = $perPage;

  		$this->items = R::find('employee', $query, $bindParam);
      // $this->injectsUser($this->items);
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

  	// public function injectsUser(&$items){
  	// 	$cacheUsers = [];
  	// 	foreach($items as &$item){
  	// 		if(!isset($cacheUsers[(string)$item->user_id])){
  	// 			$cacheUsers[(string)$item->user_id] = R::findOne('user', 'id=?', [$item->user_id]);
  	// 		}
  	// 		$item->user = $cacheUsers[(string)$item->user_id];
  	// 	}
  	// }
}
