<?php

require_once("Base.class.php");

class EstabelecimentoTipo extends Base {

  public function __construct($campos = array()) {
    parent::__construct();
    $this->tabela = 'tipos_por_estabelecimento';
    if (sizeof($campos) <= 0) {
      $this->campos_valores = array("id_tipo" => null, "id_estabelecimento" => null);
    } else {
      $this->campos_valores = $campos;
    }
    $this->campopk = 'id';
  }

  public function selecionaTudo($objeto) {
    $sql = "select tipo_estab.id, tipo_estab.id_estabelecimento, est.nome_fantasia, tipo_estab.id_tipo, tipo.descricao ";
    $sql .= "from {$objeto->tabela} tipo_estab ";
    $sql .= "inner join estabelecimentos est on tipo_estab.id_estabelecimento = est.id ";
    $sql .= "inner join tipos tipo on tipo_estab.id_tipo = tipo.id ";
    if ($objeto->extras_select != null) {
      $sql .= " " . $objeto->extras_select . " ";
    }
    return $this->executaSql($sql);
  }

  public function selecionaPorEstabelecimento($id_estabelecimento) {
    $where = $id_estabelecimento == 999 ? "" : "where tipos_por_estabelecimento.id_estabelecimento = $id_estabelecimento";
    $sql = "select distinct tipos_por_estabelecimento.id_tipo, tipos.descricao ";
    $sql .= "from tipos_por_estabelecimento ";
    $sql .= "inner join estabelecimentos on tipos_por_estabelecimento.id_estabelecimento = estabelecimentos.id ";
    $sql .= "inner join tipos on tipos_por_estabelecimento.id_tipo = tipos.id ";
    $sql .= "$where";
    $result = pg_query($sql);
    $retorno = array();
    while ($row = pg_fetch_array($result)) {
      $retorno[] = $row;
    }
    return $retorno;
  }

}

?>
