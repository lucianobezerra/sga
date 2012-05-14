<?php

require_once("Base.class.php");

class EstabelecimentoTeto extends Base {

  public function __construct($campos = array()) {
    parent::__construct();
    $this->tabela = 'tetos_por_estabelecimento';
    if (sizeof($campos) <= 0) {
      $this->campos_valores = array("id_competencia" => null, "valor_teto" => null, "valor_saldo" => null, "valor_medio" => null);
    }
    $this->campopk = 'id';
  }

}

?>
