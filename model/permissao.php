<?php

require('../class/Permissao.class.php');

$acao = isset($_REQUEST['acao']) ? $_REQUEST['acao'] : null;
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;

switch ($acao) {
  case "inserir": inserir();    break;
  case "excluir": excluir($id); break;
}

function excluir($id){
  $permissao = new Permissao();
  $permissao->valorpk = $id;
  $permissao->excluir($permissao);
}

function inserir(){
  $permissao = new Permissao();
  $permissao->setValor("id_operador",        $_POST['id_operador']);
  $permissao->setValor("id_estabelecimento", $_POST['id_estabelecimento']);
  $permissao->inserir($permissao);
}

?>
