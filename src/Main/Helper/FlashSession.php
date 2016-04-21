<?php
namespace Main\Helper;

class FlashSession
{
  private static $instance = null;
  private $attr = [];

  public static function getInstance()
  {
    if(is_null(self::$instance))
      self::$instance = new self();
    return self::$instance;
  }

  private function __construct()
  {
    $this->attr = @$_SESSION["_flash"]? $_SESSION["_flash"]: [];
    if(!is_array($this->attr)) $this->attr = [];

    $_SESSION["_flash"] = [];
  }

  public function get($name, $default = null)
  {
    return isset($this->attr[$name])? $this->attr[$name]: $default;
  }

  public function set($name, $value)
  {
    $this->attr[$name] = $value;
    $_SESSION["_flash"][$name] = $value;
  }
}
