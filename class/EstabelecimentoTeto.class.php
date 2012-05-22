<?php

require_once("Base.class.php");

class EstabelecimentoTeto extends Base {

  public function __construct($campos = array()) {
    parent::__construct();
    $this->tabela = 'tetos_por_estabelecimento';
    if (sizeof($campos) <= 0) {
      $this->campos_valores = array(
          "id_competencia" => null,
          "id_estabelecimento" => null,
          "valor_teto" => null,
          "valor_saldo" => null,
          "valor_medio" => null);
    }
    $this->campopk = 'id';
  }

  public function retornaSaldo($objeto) {
    $sql = "select valor_saldo from $objeto->tabela ";
    if ($objeto->extras_select != null) {
      $sql .= " " . $objeto->extras_select . " ";
    }
    return $this->executaSql($sql);
  }
  
  public function retornaTeto($objeto) {
    $sql = "select valor_teto from $objeto->tabela ";
    if ($objeto->extras_select != null) {
      $sql .= " " . $objeto->extras_select . " ";
    }
    return $this->executaSql($sql);
  }
  
  public function retornaId($objeto) {
    $sql = "select id from $objeto->tabela ";
    if ($objeto->extras_select != null) {
      $sql .= " " . $objeto->extras_select . " ";
    }
    return $this->executaSql($sql);
  }
  
}

?>
