<?php

require_once("Base.class.php");

class Cidade extends Base {

  public function __construct($campos = array()) {
    parent::__construct();
    $this->tabela = 'cidades';
    if (sizeof($campos) <= 0) {
      $this->campos_valores = array("estado_id" => null, "codigo" => null, "descricao" => null);
    } else {
      $this->campos_valores = $campos;
    }
    $this->campopk = 'id';
  }

  public function selecionaCidade($objeto) {
    $sql = "select cidades.id, cidades.descricao, estados.sigla ";
    $sql .= "from {$objeto->tabela} ";
    $sql .= "inner join estados on cidades.estado_id=estados.id ";
    if ($objeto->extras_select != null) {
      $sql .= " " . $objeto->extras_select . " ";
    }
    return $this->executaSql($sql);
  }

}

?>
