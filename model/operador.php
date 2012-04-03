<?php

require('../class/Operador.class.php');

$acao = isset($_REQUEST['acao']) ? $_REQUEST['acao'] : null;
$id   = isset($_REQUEST['id'])   ? $_REQUEST['id']   : null;

switch ($acao) {
  case "inserir": inserir();        break;
  case "alterar": alterar($id);     break;
  case "excluir": excluir($id);     break;
  case "desativar": desativar($id); break;
  case "novasenha": novasenha($id); break;
}

function novasenha($id) {
  $senha1 = "'" . $_POST['password'] . "'";
  $senha2 = "'" . $_POST['confirme'] . "'";
  if (strcmp($senha1, $senha2) == 0):
    $operador = new Operador();
    $operador->setValor("senha", $operador->criptografa($_POST['password']));
    $operador->valorpk = $id;
    $operador->delCampo("login");
    $operador->delCampo("nome");
    $operador->delCampo("nivel");
    $operador->delCampo("ativo");
    $operador->atualizar($operador);
  else:
    echo "Senhas não conferem!";
  endif;
}

function inserir() {
  $operador = new Operador();
  $operador->setValor('login', $_POST['login']);
  $operador->setValor('nome', $_POST['nome']);
  $operador->setValor('senha', $operador->criptografa($_POST['senha']));
  $operador->setValor('nivel', $_POST['nivel']);
  $operador->setValor('ativo', $_POST['ativo']);
  $operador->inserir($operador);
}

function alterar($id) {
  $operador = new Operador();
  $operador->setValor('nome', $_POST['nome']);
  $operador->setValor('nivel', $_POST['nivel']);
  $operador->setValor('ativo', $_POST['ativo']);
  $operador->valorpk = $id;
  $operador->delCampo("senha");
  $operador->delCampo("login");
  $operador->atualizar($operador);
}

function excluir($id) {
  $operador = new Operador();
  $operador->valorpk = $id;
  $operador->excluir($operador);
}

function desativar($id) {
  $operador = new Operador();
  $operador->valorpk = $id;
  $operador->desativar($operador);
}

?>
