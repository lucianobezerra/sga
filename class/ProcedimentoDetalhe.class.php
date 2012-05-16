<?php

require_once("Base.class.php");

class ProcedimentoDetalhe extends Base {

  public function __construct($campos = array()) {
    parent::__construct();
    $this->tabela = 'procedimentos_detalhes';
    if (sizeof($campos) <= 0) {
      $this->campos_valores = array("codigo_procedimento", "codigo_detalhe", "cmpt");
    } else {
      $this->campos_valores = $campos;
    }
    $this->campopk = 'id';
  }

  public function exigeCNS($objeto) {
    $sql =  "select count(id) from {$objeto->tabela} as qtde ";
    if($objeto->extras_select != null){
      $sql .= " " . $objeto->extras_select . " ";
    }
    return $this->executaSql($sql);
  }
}

?>
