<?php

require('../class/EstabelecimentoTipo.class.php');
$acao = isset($_REQUEST['acao']) ? $_REQUEST['acao'] : null;
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;

switch ($acao) {
  case "inserir": inserir(); break;
  case "excluir": excluir($id); break;
}

function inserir() {
  $estabelecimento_tipo = new EstabelecimentoTipo();
  $estabelecimento_tipo->setValor("id_estabelecimento", $_POST['id_estabelecimento']);
  $estabelecimento_tipo->setValor("id_tipo", $_POST['id_tipo']);
  $estabelecimento_tipo->inserir($estabelecimento_tipo);
}

function excluir($id){
  $estabelecimento_tipo = new EstabelecimentoTipo();
  $estabelecimento_tipo->valorpk = $id;
  $estabelecimento_tipo->excluir($estabelecimento_tipo);
}
?>
