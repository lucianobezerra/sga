<?php

require_once("Base.class.php");

class Competencia extends Base {

  public function __construct($campos = array()) {
    parent::__construct();
    $this->tabela = 'competencias';
    if (sizeof($campos) <= 0) {
      $this->campos_valores = array("ano" => null, "mes" => null, "ativo" => null);
    } else {
      $this->campos_valores = $campos;
    }
    $this->campopk = 'id';
  }

  public function inserir($objeto) {
    $sql = "insert into {$objeto->tabela} (ano, mes, ativo) values ({$objeto->campos_valores['ano']}, '{$objeto->campos_valores['mes']}', '{$objeto->campos_valores['ativo']}')";
    return $this->executaSql($sql);
  }

  public function atualizar($objeto) {
    $sql = "update {$objeto->tabela} SET ano = {$objeto->campos_valores['ano']},
                                         mes = '{$objeto->campos_valores['mes']}',
                                       ativo = '{$objeto->campos_valores['ativo']}'
            where {$objeto->campopk}=$objeto->valorpk";
    return $this->executaSql($sql);
  }

  public function strCompetencia($objeto) {
    $sql = "select ano||mes as cmpt from {$objeto->tabela} where {$objeto->campopk} = {$objeto->valorpk}";
    return $this->executaSql($sql);
  }

  public function extensoCompetencia($objeto) {
    $sql = "select case mes
              when '01' then 'Janeiro'
              when '02' then 'Fevereiro'
              when '03' then 'Março'
              when '04' then 'Abril'
              when '05' then 'Maio'
              when '06' then 'Junho'
              when '07' then 'Julho'
              when '08' then 'Agosto'
              when '09' then 'Setembro'
              when '10' then 'Outubro'
              when '11' then 'Novembro'
              when '12' then 'Dezembro'
            end|| ' de ' ||ano as cmpt
          from {$objeto->tabela} where {$objeto->campopk} = {$objeto->valorpk}";
    return $this->executaSql($sql);
  }

}

?>
