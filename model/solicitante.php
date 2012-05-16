<?php

require('../class/Solicitante.class.php');

$acao = isset($_REQUEST['acao']) ? $_REQUEST['acao'] : null;
$id   = isset($_REQUEST['id'])   ? $_REQUEST['id']   : null;

switch ($acao) {
  case "inserir": inserir();        break;
  case "alterar": alterar($id);     break;
  case "excluir": excluir($id);     break;
  case "desativar": desativar($id); break;
}

function inserir() {
  $solicitante = new Solicitante();
  $solicitante->setValor('cns',  $_POST['cns']);
  $solicitante->setValor('nome', strtoupper($_POST['nome']));
  $solicitante->setValor('ativo', $_POST['ativo']);
  $solicitante->inserir($solicitante);
}

function alterar($id) {
  $solicitante = new solicitante();
  $solicitante->setValor('nome', strtoupper($_POST['nome']));
  $solicitante->setValor('ativo', $_POST['ativo']);
  $solicitante->valorpk = $id;
  $solicitante->delCampo("cns");
  $solicitante->atualizar($solicitante);
}

function excluir($id) {
  $solicitante = new solicitante();
  $solicitante->valorpk = $id;
  $solicitante->excluir($solicitante);
}

function desativar($id) {
  $solicitante = new solicitante();
  $solicitante->valorpk = $id;
  $solicitante->desativar($solicitante);
}

?>
