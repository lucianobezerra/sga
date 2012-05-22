<?php

if (defined('ROOT_APP') == false) {
  define('ROOT_APP', $_SERVER['DOCUMENT_ROOT'] . "/sga");
}

require_once(ROOT_APP.'/class/EstabelecimentoTeto.class.php');
require_once(ROOT_APP.'/class/Estabelecimento.class.php');
require_once(ROOT_APP.'/class/Competencia.class.php');
require_once(ROOT_APP.'/class/Procedimento.class.php');

$acao = isset($_REQUEST['acao']) ? $_REQUEST['acao'] : null;
$id   = isset($_REQUEST['id'])   ? $_REQUEST['id']   : null;

switch ($acao){
  case 'inserir': inserir();    break;
  case 'alterar': alterar($id); break;
  case 'excluir': excluir($id); break;
}

function inserir(){
  $teto = new EstabelecimentoTeto();
  $teto->setValor("id_estabelecimento", $_POST['id_unidade']);
  $teto->setValor("id_competencia",     $_POST['id_competencia']);
  $teto->setValor("valor_teto",         $_POST['valor_teto']);
  $teto->setValor("valor_medio",        $_POST['valor_medio']);
  $teto->delCampo("valor_saldo");
  $teto->inserir($teto);
}

function alterar($id){
  $teto = new EstabelecimentoTeto();
  $teto->setValor("valor_teto",         $_POST['valor_teto']);
  $teto->setValor("valor_medio",        $_POST['valor_medio']);
  $teto->valorpk = $id;
  $teto->delCampo("valor_saldo");
  $teto->delCampo("id_competencia");
  $teto->delCampo("id_estabelecimento");
  $teto->atualizar($teto);
}

?>
