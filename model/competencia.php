<?php

require('../class/Competencia.class.php');

$acao = isset($_REQUEST['acao']) ? $_REQUEST['acao'] : null;
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;

switch ($acao) {
  case "inserir": inserir();    break;
  case "alterar": alterar($id); break;
  case "excluir": excluir($id); break;
  case "desativar": desativar($id); break;
}

function inserir() {
  $competencia = new Competencia();
  $competencia->setValor("mes", (string) $_POST['mes']);
  $competencia->setValor("ano", $_POST['ano']);
  $competencia->setValor("ativo", $_POST['ativo']);
  $competencia->inserir($competencia);
}

function alterar($id) {
  $competencia = new Competencia();
  $competencia->setValor('mes', $_POST['mes']);
  $competencia->setValor('ano', $_POST['ano']);
  $competencia->setValor('ativo', $_POST['ativo']);
  $competencia->valorpk = $id;
  $competencia->atualizar($competencia);
}

function excluir($id){
  $competencia = new Competencia();
  $competencia->valorpk = $id;
  $competencia->excluir($competencia);
}

function desativar($id){
  $competencia = new Competencia();
  $competencia->valorpk = $id;
  $competencia->desativar($competencia);
}

?>
