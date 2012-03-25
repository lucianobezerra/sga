<?php

require_once("Base.class.php");

class Operador extends Base {

  public function __construct($campos = array()) {
    parent::__construct();
    $this->tabela = 'operadores';
    if (sizeof($campos) <= 0) {
      $this->campos_valores = array(
          "login" => null,
          "nome" => null,
          "senha" => null,
          "nivel" => null,
          "ativo" => null);
    } else {
      $this->campos_valores = $campos;
    }
    $this->campopk = 'id';
  }

  public function criptografa($senha) {
    return md5($senha);
  }

  public function selecionaNome($objeto) {
    $sql = "select nome from {$objeto->tabela} ";
    if ($objeto->extras_select != null) {
      $sql .= " " . $objeto->extras_select . " ";
    }
    return $this->executaSql($sql);
  }

  public function pegaNivel($objeto){
    $sql = "select id, nivel from {$objeto->tabela} ";
    if ($objeto->extras_select != null) {
      $sql .= " " . $objeto->extras_select . " ";
    }
    return $this->executaSql($sql);
  }
}

?>
