<?php

require_once("Base.class.php");

class Procedimento extends Base {

  public function __construct($campos = array()) {
    parent::__construct();
    $this->tabela = 'procedimentos';
    if (sizeof($campos) <= 0) {
      $this->campos_valores = array("codigo" => null, "descricao" => null, "sexo" => null, "idade_minima" => null, "idade_maxima" => null, "valor_sh" => null, "valor_sa" => null, "valor_sp" => null, "cmpt" => null, "competencia_id" => null);
    } else {
      $this->campos_valores = $campos;
    }
    $this->campopk = 'id';
  }

  public function selecionaProcedimento($objeto) {
    $sql = "select id, descricao from {$objeto->tabela} ";
    if ($objeto->extras_select != null) {
      $sql .= " " . $objeto->extras_select . " ";
    }
    return $this->executaSql($sql);
  }

  public function retornaValor($objeto) {
    $sql = "select (valor_sp + valor_sa + valor_sh) as valor from {$objeto->tabela} ";
    if ($objeto->extras_select != null) {
      $sql .= " " . $objeto->extras_select . " ";
    }
    return $this->executaSql($sql);
  }
  
  public function sexoCompativel($objeto){
    $sql = "select count(id) as qtde from {$objeto->tabela} ";
    if ($objeto->extras_select != null) {
      $sql .= " " . $objeto->extras_select . " ";
    }
    return $this->executaSql($sql);
  }
  
  public function idadeCompativel($objeto){
    $sql  = "select count(id) as qtde from {$objeto->tabela} ";
    if ($objeto->extras_select != null) {
      $sql .= " " . $objeto->extras_select . " ";
    }
//    echo $sql;
    return $this->executaSql($sql);
  }
}

?>
