<?php
namespace Main\Form;

use RedBeanPHP\R;

class ECatalogMoveForm extends Form
{
  public $id, $table = "ecatalog", $sortField = "sort_order";

  public function __construct($id)
  {
    $this->id = $id;
  }

  public function moveTo($id, $position)
  {
    $item = R::findOne($this->table, 'id=?', [$this->id]);
    $desItem = R::findOne($this->table, 'id=?', [$id]);

    $itemOrder = $item->sort_order;
    $destOrder = $desItem->sort_order;

    $item->sort_order = $destOrder;
    $op = $itemOrder < $destOrder? "-": "+";
    if($itemOrder < $destOrder) {
      $op = "-";
      $execParam = [$itemOrder, $destOrder];
    }
    else {
      $op = "+";
      $execParam = [$destOrder, $itemOrder];
    }
    // if($op == "-" && $position == "before") $destOrder--;
    // if($op == "+" && $position == "after") $destOrder++;

    $query = "UPDATE {$this->table} SET sort_order = sort_order {$op} 1";
    $query .= " WHERE (sort_order BETWEEN ? AND ?) AND id != ?";
    $execParam[] = $this->id;
    if(($op == "-" && $position == "before")
      || ($op == "+" && $position == "after")) {
        $query .= " AND id != ?";
        $execParam[] = $id;
        $destOrder2 = ($op == "-" && $position == "before")? $destOrder-1: $destOrder+1;
    }
    else {
      $destOrder2 = $destOrder;
    }

    R::exec($query, $execParam);
    $item->sort_order = $destOrder2;
    R::store($item);

    $this->makeUnique();
    return true;
  }

  public function makeUnique()
  {
    $items = R::find($this->table, 'ORDER BY sort_order');
    // $items = R::exportAll($items);
    $i = 0;
    foreach($items as $key=> $item) {
      $i++;
      $item->sort_order = $i;
      R::store($item);
    }
  }
}
