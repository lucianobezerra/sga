<?php

require_once("Base.class.php");

class Estado extends Base {

  public function __construct($campos = array()) {
    parent::__construct();
    $this->tabela = 'estados';
    if (sizeof($campos) <= 0) {
      $this->campos_valores = array("codigo" => null, "sigla" => null, "descricao" => null);
    } else {
      $this->campos_valores = $campos;
    }
    $this->campopk = 'id';
  }

  public function selecionaEstado($objeto) {
    $sql = "select id, codigo, sigla, descricao from {$objeto->tabela} ";
    if ($objeto->extras_select != null) {
      $sql .= " " . $objeto->extras_select . " ";
    }
    return $this->executaSql($sql);
  }

}

?>
