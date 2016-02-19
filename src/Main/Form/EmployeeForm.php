<?php
namespace Main\Form;

use RedBeanPHP\R;

class EmployeeForm extends Form
{
  public $attr = [
    'first_name'=> '',
    'last_name'=> '',
    'tel_number'=> '',
    'passport_id'=> '',
    'passport_expiry'=> '',
    'visa_expiry'=> '',
    'report_expiry'=> ''
  ];

  public function __construct($attr = [])
  {
    $now = date('Y-m-d');
    $this->attr['passport_expiry'] = $now;
    $this->attr['visa_expiry'] = $now;
    $this->attr['report_expiry'] = $now;
    parent::__construct($attr);
  }

  public function validate()
  {
    $this->errors = [];
    $this->error = false;
    $this->isValid = true;
    if (empty($this->attr['first_name'])) {
      $this->pushError("First Name is empty");
    }

    if (empty($this->attr['last_name'])) {
      $this->pushError("Last Name is empty");
    }

    if (empty($this->attr['tel_number'])) {
      $this->pushError("Tel number is empty");
    }

    if (empty($this->attr['passport_expiry'])) {
      $this->pushError("passport Expiry is empty");
    }

    if (empty($this->attr['visa_expiry'])) {
      $this->pushError("visa Expiry is empty");
    }

    if (empty($this->attr['report_expiry'])) {
      $this->pushError("Report Expiry is empty");
    }

    if($this->_isDateFormat($this->attr['passport_expiry'])) {
      $this->pushError("visa Report Expiry is not date format");
    }

    if($this->_isDateFormat($this->attr['visa_expiry'])) {
      $this->pushError("passport Expiry Expiry is not date format");
    }

    if($this->_isDateFormat($this->attr['report_expiry'])) {
      $this->pushError("Report Expiry is not date format");
    }

    return !$this->error;
  }

  public function save($userId)
  {
    if(!$this->emptyAttr('id')){
      $item = R::findOne('employee', 'id=?', [$this->getAttr('id')]);
    }
    else {
      $item = R::dispense('employee');
      $item->user_id = $userId;
    }
    $item->first_name = $this->getAttr('first_name', '');
		$item->last_name = $this->getAttr('last_name', '');
		$item->tel_number = $this->getAttr('tel_number', '');
    $item->passport_id = $this->getAttr('passport_id');
    $item->passport_expiry = $this->getAttr('passport_expiry');
		$item->visa_expiry = $this->getAttr('visa_expiry');
		$item->report_expiry = $this->getAttr('report_expiry');
    $item->update_time = date("Y-m-d H:i:s");

    return R::store($item);
  }
}
