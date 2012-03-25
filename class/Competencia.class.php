<?php

require_once("Base.class.php");

class Competencia extends Base {

  public function __construct($campos = array()) {
    parent::__construct();
    $this->tabela = 'competencias';
    if (sizeof($campos) <= 0) {
      $this->campos_valores = array("ano" => null, "mes" => null, "ativo" => null );
    } else {
      $this->campos_valores = $campos;
    }
    $this->campopk = 'id';
  }

  public function inserir($objeto){
    $sql = "insert into {$objeto->tabela} (ano, mes, ativo) values ({$objeto->campos_valores['ano']}, '{$objeto->campos_valores['mes']}', '{$objeto->campos_valores['ativo']}')";
    return $this->executaSql($sql);
  }

  public function atualizar($objeto){
    $sql = "update {$objeto->tabela} SET ano = {$objeto->campos_valores['ano']},
                                         mes = '{$objeto->campos_valores['mes']}',
                                       ativo = '{$objeto->campos_valores['ativo']}'
            where {$objeto->campopk}=$objeto->valorpk";
    return $this->executaSql($sql);
  }

}

?>
