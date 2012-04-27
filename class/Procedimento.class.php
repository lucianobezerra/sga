<?php

require_once("Base.class.php");

class Procedimento extends Base {

  public function __construct($campos = array()) {
    parent::__construct();
    $this->tabela = 'procedimentos';
    if (sizeof($campos) <= 0) {
      $this->campos_valores = array(
          "codigo" => null,
          "descricao" => null,
          "sexo" => null,
          "idade_minima" => null,
          "idade_maxima" => null,
          "valor_sh" => null,
          "valor_sa" => null,
          "valor_sp" => null,
          "competencia_id" => null);
    } else {
      $this->campos_valores = $campos;
    }
    $this->campopk = 'id';
  }

}

?>
