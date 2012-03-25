<?php

require_once("Base.class.php");

class Tipo extends Base {

  public function __construct($campos = array()) {
    parent::__construct();
    $this->tabela = 'tipos';
    if (sizeof($campos) <= 0) {
      $this->campos_valores = array("codigo" => null, "descricao" => null, "ativo" => null);
    } else {
      $this->campos_valores = $campos;
    }
    $this->campopk = 'id';
  }

}

?>
