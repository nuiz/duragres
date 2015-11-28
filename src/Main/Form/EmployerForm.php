<?php
namespace Main\Form;

use RedBeanPHP\R;

class EmployerForm extends Form
{
  public $attr = [
    'first_name'=> '',
    'last_name'=> '',
    'tel_number'=> '',
    'id_card'=> '',
    'customer_id'=> '',
    'address'=> '',
    'job_request_date'=> '',
    'job_description'=> '',
    'status'=> '1'
  ];

  public function __construct($attr = [])
  {
    $this->attr['job_request_date'] = date('Y-m-d');
    parent::__construct($attr);
  }

  public function getOptionStatus()
  {
    $items = R::find('employer_status');
    return $items;
  }

  public function validate()
  {
    $this->errors = [];
    $this->error = false;
    $this->isValid = true;
    $emptyFirstname = empty($this->attr['first_name']);
    if ($emptyFirstname) {
      $this->pushError("First Name is empty");
    }

    if (empty($this->attr['last_name'])) {
      $this->pushError("Last Name is empty");
    }

    if(empty($this->attr['job_request_date'])) {
      $this->pushError("Job request date is empty");
    }

    if(!$this->_isDateFormat($this->attr['job_request_date'])) {
      $this->pushError("Job request date is not date format");
    }

    return !$this->error;
  }

  public function save($userId)
  {
    if(!$this->emptyAttr('id')){
      $item = R::findOne('employer', 'id=?', [$this->getAttr('id')]);
    }
    else {
      $item = R::dispense('employer');
      $item->blacklist = 0;
      $item->user_id = $userId;
    }
    $item->first_name = $this->getAttr('first_name', '');
		$item->last_name = $this->getAttr('last_name', '');
		$item->tel_number = $this->getAttr('tel_number', '');
		$item->id_card = $this->getAttr('id_card', '');
		$item->customer_id = $this->getAttr('customer_id', '');
		$item->address = $this->getAttr('address', '');
		$item->job_request_date = $this->getAttr('job_request_date', '');
		$item->job_description = $this->getAttr('job_description', '');
		$item->status = $this->getAttr('status', '');
    $item->update_time = date("Y-m-d H:i:s");
    return R::store($item);
  }
}
