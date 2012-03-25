<?php

require('../class/Estabelecimento.class.php');

$acao = isset($_REQUEST['acao']) ? $_REQUEST['acao'] : null;
$id   = isset($_REQUEST['id'])   ? $_REQUEST['id']   : null;

switch ($acao) {
  case "inserir":   inserir();      break;
  case "alterar":   alterar($id);   break;
  case "excluir":   excluir($id);   break;
  case "desativar": desativar($id); break;
}

function inserir() {
  $ups = new Estabelecimento();
  $ups->setValor('cnes',          $_POST['cnes']);
  $ups->setValor('razao_social',  strtoupper($_POST['razao']));
  $ups->setValor('nome_fantasia', strtoupper($_POST['fantasia']));
  $ups->setValor('valor_teto',    $_POST['valor_teto']);
  $ups->setValor('valor_medio',   $_POST['valor_medio']);
  $ups->setValor('emite_aih',     $_POST['aih']);
  $ups->setValor('emite_apac',    $_POST['apac']);
  $ups->setValor('ativo',         $_POST['ativo']);

  $ups->inserir($ups);
}

function alterar($id) {
  $ups = new Estabelecimento();
  $ups->setValor('razao_social',  strtoupper($_POST['razao']));
  $ups->setValor('nome_fantasia', strtoupper($_POST['fantasia']));
  $ups->setValor('valor_teto',    $_POST['valor_teto']);
  $ups->setValor('valor_medio',   $_POST['valor_medio']);
  $ups->setValor('emite_aih',     $_POST['aih']);
  $ups->setValor('emite_apac',    $_POST['apac']);
  $ups->setValor('ativo',         $_POST['ativo']);
  $ups->valorpk = $id;
  $ups->delCampo("cnes");
  $ups->atualizar($ups);
}

function excluir($id) {
  $ups = new Estabelecimento();
  $ups->valorpk=$id;
  $ups->excluir($ups);
}

function desativar($id) {
  $ups = new Estabelecimento();
  $ups->valorpk=$id;
  $ups->desativar($ups);
}

?>
