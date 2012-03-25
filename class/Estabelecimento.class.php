<?php

require_once("Base.class.php");

class Estabelecimento extends Base {

  public function __construct($campos = array()) {
    parent::__construct();
    $this->tabela = 'estabelecimentos';
    if (sizeof($campos) <= 0) {
      $this->campos_valores = array(
          "cnes" => null,
          "razao_social" => null,
          "nome_fantasia" => null,
          "valor_teto" => null,
          "valor_medio" => null,
          "emite_aih" => null,
          "emite_apac" => null,
          "ativo" => null);
    } else {
      $this->campos_valores = $campos;
    }
    $this->campopk = 'id';
  }

}

?>