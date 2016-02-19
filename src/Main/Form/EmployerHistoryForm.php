<?php
namespace Main\Form;

use RedBeanPHP\R;

class EmployerHistoryForm extends Form
{
  public $attr = [
    'term_at'=> '',
    'contract_no'=> '',
    'contract_description'=> '',
    'repair_1'=> '',
    'repair_2'=> '',
    'repair_3'=> ''
  ];
  public function validate()
  {
    if($this->emptyAttr('contract_no')) {
      $this->pushError('Contract no is empty');
    }

    return !$this->error;
  }

  public function save($employerId)
  {
    if(!$this->emptyAttr('id')){
      $item = R::findOne('employer_history', 'id=?', [$this->getAttr('id')]);
    }
    else {
      $item = R::dispense('employer_history');
      $item->employer_id = $employerId;
    }

    $item->term_at = $this->getAttr('term_at', '');
    $item->contract_no = $this->getAttr('contract_no', '');
    $item->contract_description = $this->getAttr('contract_description', '');
    $item->repair_1 = $this->getAttr('repair_1', '');
    $item->repair_2 = $this->getAttr('repair_2', '');
    $item->repair_3 = $this->getAttr('repair_3', '');
    return R::store($item);
  }
}
