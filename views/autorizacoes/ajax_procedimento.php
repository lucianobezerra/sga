<?php

if (defined('ROOT_APP') == false) {
  define('ROOT_APP', $_SERVER['DOCUMENT_ROOT'] . "/sga");
}

require(ROOT_APP . "/class/Procedimento.class.php");
require(ROOT_APP . "/class/Competencia.class.php");

function formataCompetencia($cmpt) {
  $cp = new Competencia();
  $cp->valorpk = $cmpt;
  $cp->strCompetencia($cp);
  $strCmpt = '';
  while ($s = $cp->retornaDados("array")) {
    $strCmpt = $s[0];
  }
  return $strCmpt;
}

$codigo = $_REQUEST['codigo'];
$cmpt = formataCompetencia($_REQUEST['cmpt']);

$procedimento = new Procedimento();
$procedimento->extras_select = "where codigo='{$codigo}' and cmpt='{$cmpt}'";
$procedimento->selecionaProcedimento($procedimento);
while ($linha = $procedimento->retornaDados("array")) {
  echo $linha[0] . "," . $linha[1];
}
?>
