<?php

require_once("Base.class.php");
require_once("Autorizacao.class.php");

class Faixa extends Base {

  public function __construct($campos = array()) {
    parent::__construct();
    $this->tabela = 'faixas';
    if (sizeof($campos) <= 0) {
      $this->campos_valores = array(
          "inicial" => null,
          "final" => null,
          "ultima" => null,
          "saldo" => null,
          "data_cadastro" => null,
          "faixa_tipo" => null,
          "faixa_cmpt" => null,
          "id_tipo" => null,
          "id_competencia" => null,
          "ativo" => null);
    } else {
      $this->campos_valores = $campos;
    }
    $this->campopk = 'id';
  }

  public function inserir($objeto) {
    $sql = "insert into {$objeto->tabela} (inicial, final, id_tipo, id_competencia, ativo) 
              values
            ({$objeto->campos_valores['inicial']}, 
             {$objeto->campos_valores['final']}, 
             {$objeto->campos_valores['id_tipo']},
             {$objeto->campos_valores['id_competencia']},
             {$objeto->campos_valores['ativo']})";
             
    return $this->executaSql($sql);
  }

  public function quantidadeAutorizacoes($id) {
    $sql = "select id, (final - inicial) +1 as quantidade from faixas where id={$id}";
    $res = pg_query($sql);
    $ret = pg_fetch_array($res);
    return $ret['quantidade'];
  }

  function lista() {
    $sql = "select faixa.id, tipo.descricao as tipo, ";
    $sql .= "substring(cast(faixa.inicial as varchar) from 1 for 2)||'.'||substring(cast(faixa.inicial as varchar) from 3 for 2)||'.'||substring(cast(faixa.inicial as varchar) from 5 for 1)||'.'||substring(cast(faixa.inicial as varchar) from 6 for 7) as inicial, ";
    $sql .= "substring(cast(faixa.final as varchar) from 1 for 2)||'.'||substring(cast(faixa.final as varchar) from 3 for 2)||'.'||substring(cast(faixa.final as varchar) from 5 for 1)||'.'||substring(cast(faixa.final as varchar) from 6 for 7) as final, ";
    $sql .= "faixa.ultima, faixa.saldo, cmpt.ano||cmpt.mes as cmpt ";
    $sql .= "from faixas faixa ";
    $sql .= "inner join tipos tipo on faixa.id_tipo=tipo.id ";
    $sql .= "inner join competencias cmpt on faixa.id_competencia=cmpt.id ";
    $sql .= "where faixa.ativo=true and faixa.saldo > 0 ";
    $sql .= "order by tipo.codigo, faixa.inicial";
    $result = pg_query($sql);
    $retorno = array();
    while ($row = pg_fetch_array($result)) {
      $retorno[] = $row;
    }
    return $retorno;
  }

  public function selecionaPorTipo($objeto) {
    $sql = "select id, inicial, final from {$objeto->tabela}";
    if ($objeto->extras_select != null) {
      $sql .= " " . $objeto->extras_select . " ";
    }
    return $this->executaSql($sql);
  }
}

?>