<?php
define( 'DS', DIRECTORY_SEPARATOR );
require_once(dirname(dirname(__FILE__)) . DS . 'class' . DS . 'Tipo.class.php');

$acao = isset($_REQUEST['acao']) ? $_REQUEST['acao'] : null;
$id   = isset($_REQUEST['id'])   ? $_REQUEST['id']   : null;

switch ($acao) {
  case "inserir"   : inserir();        break;
  case "alterar"   : alterar($id);     break;
  case "desativar" : desativar($id);   break;
  case "excluir"   : excluir($id);     break;
}

function inserir(){
  $tipo = new Tipo();

  $tipo->setValor("codigo",    $_POST['codigo']);
  $tipo->setValor("descricao", $_POST['descricao']);
  $tipo->setValor("ativo",     $_POST['ativo']);

  $tipo->inserir($tipo);
}

function alterar($id) {
  $id = $_POST['id'];
  $tipo = new Tipo();

  $tipo->setValor("codigo",    $_POST['codigo']);
  $tipo->setValor("descricao", $_POST['descricao']);
  $tipo->setValor("ativo",     $_POST['ativo']);

  $tipo->valorpk = $id;
  $tipo->atualizar($tipo);
}

function excluir($id) {
  $tipo = new Tipo();
  $tipo->valorpk=$id;
  $tipo->excluir($tipo);
}

function desativar($id) {
  $tipo = new Tipo();
  $tipo->valorpk=$id;
  $tipo->desativar($tipo);
}
?>
