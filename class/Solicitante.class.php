<?php
require_once("Base.class.php");
class Solicitante extends Base{
   public function __construct($campos = array()) {
    parent::__construct();
    $this->tabela = 'solicitantes';
    if(sizeof($campos) <= 0){
      $this->campos_valores = array("cns" => null, "nome" => null, "ativo" => null);
    } else {
      $this->campos_valores = $campos;
    }
    $this->campopk = 'id';
  }
}

?>
