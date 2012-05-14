<?php

require_once("Base.class.php");

class Config extends Base {

  public function __construct($campos = array()) {
    parent::__construct();
    $this->tabela = 'config';
    if (sizeof($campos) <= 0) {
      $this->campos_valores = array("expira" => null);
    } else {
      $this->campos_valores = $campos;
    }
    $this->campopk = 'id';
  }

}

?>
