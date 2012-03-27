<?php

require_once("Base.class.php");

class Autorizacao extends Base {

  public function __construct($campos = array()) {
    parent::__construct();
    $this->tabela = 'aihs';
    if (sizeof($campos) <= 0) {
      $this->campos_valores = array(
          "id_operador" => null,
          "id_estabelecimento" => null,
          "id_tipo" => null,
          "id_faixa" => null,
          "id_competencia" => null,
          "numero" => null,
          "digito" => null,
          "nome_pac" => null,
          "nascimento" => null,
          "internacao" => null);
      $this->campos_valores = $campos;
    }
    $this->campopk = 'id';
  }

  public function contaAutorizacoes($inicial, $final) {
    $sql = "select count(numero) as quantidade from aihs ";
    $sql .= "where numero between {$inicial} and {$final}";
    $res = pg_query($sql);
    $ret = pg_fetch_array($res);
    return $ret['quantidade'];
  }
  
  public function ultima($id_faixa){
    $sql_aih = "select coalesce(max(numero), 0) as ultima from aihs where id_faixa={$id_faixa}";
    $res_aih = pg_query($sql_aih);
    $linha_aih = pg_fetch_array($res_aih);
    
    if($linha_aih['ultima'] == 0){
      $sql_faixa = "select (inicial -1) as primeira from faixas where id={$id_faixa}";
      $res_faixa = pg_query($sql_faixa);
      $linha_faixa = pg_fetch_array($res_faixa);
      return $linha_faixa['primeira'];
    } else {
      return $linha_aih['ultima'];
    }
  }
  
  public function proxima($id_faixa){
    $ultima  = $this->ultima($id_faixa);
    echo "Ultima: {$ultima}<br/>";
    $proxima = $ultima +1;
    echo "Proxima: {$proxima}<br/>";
    return $proxima;
  }
  
  public function buscaDetalhada($id){
  $sql = "select aihs.numero||'-'||aihs.digito as numero, estabelecimentos.cnes, estabelecimentos.nome_fantasia, tipos.descricao as tipo, faixas.inicial||' a '||faixas.final as faixa, ";
  $sql .= "competencias.ano||competencias.mes as competencia, operadores.nome nome_operador, aihs.nome_pac, ";
  $sql .= "aihs.nascimento, aihs.internacao from aihs ";
  $sql .= "inner join operadores on aihs.id_operador=operadores.id ";
  $sql .= "inner join estabelecimentos on aihs.id_estabelecimento = estabelecimentos.id ";
  $sql .= "inner join tipos on aihs.id_tipo = tipos.id ";
  $sql .= "inner join faixas on aihs.id_faixa = faixas.id ";
  $sql .= "inner join competencias on aihs.id_competencia = competencias.id ";
  $sql .= "where aihs.id={$id} ";
  $result = pg_query($sql);
    $retorno = pg_fetch_array($result);
    return $retorno;
  }
  
}



?>
