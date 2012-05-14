<?php

require_once("Base.class.php");

class Diagnostico extends Base {

  public function __construct($campos = array()) {
    parent::__construct();
    $this->tabela = 'cids';
    if (sizeof($campos) <= 0) {
      $this->campos_valores = array("codigo" => null, "descricao" => null, "sexo" => null);
    } else {
      $this->campos_valores = $campos;
    }
    $this->campopk = 'id';
  }

  public function selecionaDiagnostico($objeto) {
    $sql = "select id, descricao from {$objeto->tabela} ";
    if ($objeto->extras_select != null) {
      $sql .= " " . $objeto->extras_select . " ";
    }
    return $this->executaSql($sql);
  }

}

?>
