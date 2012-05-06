<?php

require('../class/Autorizador.class.php');

$acao = isset($_REQUEST['acao']) ? $_REQUEST['acao'] : null;
$id   = isset($_REQUEST['id'])   ? $_REQUEST['id']   : null;

switch ($acao) {
  case "inserir": inserir();        break;
  case "alterar": alterar($id);     break;
  case "excluir": excluir($id);     break;
  case "desativar": desativar($id); break;
}

function inserir() {
  $autorizador = new Autorizador();
  $autorizador->setValor('cns',  $_POST['cns']);
  $autorizador->setValor('nome', strtoupper($_POST['nome']));
  $autorizador->setValor('ativo', $_POST['ativo']);
  $autorizador->inserir($autorizador);
}

function alterar($id) {
  $autorizador = new Autorizador();
  $autorizador->setValor('nome', strtoupper($_POST['nome']));
  $autorizador->setValor('ativo', $_POST['ativo']);
  $autorizador->valorpk = $id;
  $autorizador->delCampo("cns");
  $autorizador->atualizar($autorizador);
}

function excluir($id) {
  $autorizador = new autorizador();
  $autorizador->valorpk = $id;
  $autorizador->excluir($autorizador);
}

function desativar($id) {
  $autorizador = new autorizador();
  $autorizador->valorpk = $id;
  $autorizador->desativar($autorizador);
}

?>
