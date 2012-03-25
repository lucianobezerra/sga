<?php

require_once("Base.class.php");

class Permissao extends Base {

  public function __construct($campos = array()) {
    parent::__construct();
    $this->tabela = 'permissoes';
    if (sizeof($campos) <= 0) {
      $this->campos_valores = array(
          "id_operador" => null,
          "id_estabelecimento" => null);
    } else {
      $this->campos_valores = $campos;
    }
    $this->campopk = 'id';
  }

  public function selecionaTudo($objeto) {
    $sql = "select distinct on (estabelecimentos) permissoes.id, permissoes.id_estabelecimento, estabelecimentos.nome_fantasia, permissoes.id_operador, operadores.nome ";
    $sql .= "from {$objeto->tabela} ";
    $sql .= "inner join estabelecimentos on permissoes.id_estabelecimento = estabelecimentos.id ";
    $sql .= "inner join operadores on permissoes.id_operador = operadores.id ";
    if ($objeto->extras_select != null) {
      $sql .= " " . $objeto->extras_select . " ";
    }
    return $this->executaSql($sql);
  }

  public function checaPermissao($operador, $estabelecimento) {
    $sql = "select count(*) as qtde from permissoes ";
    $sql .= "inner join estabelecimentos on permissoes.id_estabelecimento = estabelecimentos.id ";
    $sql .= "inner join operadores on permissoes.id_operador = operadores.id ";
    $sql .= "where id_estabelecimento={$estabelecimento} and id_operador={$operador}";
    $result = pg_query($sql);
    $retorno = pg_fetch_array($result);
    return $retorno;
  }
  
}

?>
