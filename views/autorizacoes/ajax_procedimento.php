<?php

if (defined('ROOT_APP') == false) {
  define('ROOT_APP', $_SERVER['DOCUMENT_ROOT'] . "/sga");
}

require(ROOT_APP . "/class/Procedimento.class.php");
require(ROOT_APP . "/class/Competencia.class.php");

$codigo = $_REQUEST['codigo'];

$procedimento = new Procedimento();
$procedimento->extras_select = "where codigo='{$codigo}' and id_competencia={$_REQUEST['cmpt']}";
$procedimento->selecionaProcedimento($procedimento);
while ($linha = $procedimento->retornaDados("array")) {
  echo $linha[0] . "," . $linha[1];
}
?>
