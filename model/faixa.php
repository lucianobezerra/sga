<?php

require('../class/Faixa.class.php');

$acao = isset($_REQUEST['acao']) ? $_REQUEST['acao'] : null;
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;

switch ($acao) {
  case "inserir":   inserir();      break;
  case "alterar":   alterar($id);   break;
  case "excluir":   excluir($id);   break;
  case "desativar": desativar($id); break;
  case "ajustar":   ajustar($id);   break;
}

function ajustar($id){
  $faixa = new Faixa();
  $faixa->valorpk = $id;
  $geradas = $faixa->quantidadeAutorizacoes($id);
  $usadas  = $faixa->contaAutorizacoes($id);
  $novo_saldo = $geradas - $usadas;
  $faixa->setValor("saldo", $novo_saldo);
  $faixa->delCampo("inicial");
  $faixa->delCampo("final");
  $faixa->delCampo("ultima");
  $faixa->delCampo("data_cadastro");
  $faixa->delCampo("id_tipo");
  $faixa->delCampo("id_competencia");
  $faixa->delCampo("ativo");
  $faixa->atualizar($faixa);
}

function inserir() {
  $faixa = new Faixa();
  $faixa->setValor('inicial', $_POST['inicial']);
  $faixa->setValor('final', $_POST['final']);
  $faixa->setValor('id_tipo', $_POST['tipo']);
  $faixa->setValor('id_competencia', $_POST['competencia']);
  $faixa->setValor('ativo', $_POST['ativo']);
  $faixa->inserir($faixa);
}

function alterar($id) {
  $faixa = new Faixa();
  $final = $_POST['final'];
  $ultima = $faixa->ultimaDaFaixa($_POST['hidden_inicial'], $_POST['final']);
  if ($final > $ultima) {
    $faixa->setValor('final', $_POST['final']);
    $faixa->setValor('id_tipo', $_POST['tipo']);
    $faixa->setValor('id_competencia', $_POST['competencia']);
    $faixa->setValor('ativo', $_POST['ativo']);
    $faixa->valorpk = $id;
    $faixa->delCampo("inicial");
    $faixa->delCampo("ultima");
    $faixa->delCampo("saldo");
    $faixa->delCampo("data_cadastro");
    $faixa->atualizar($faixa);
  } else {
    echo "Autorização FINAL {$_POST['final']} já utilizada!";
  }
}

function excluir($id){
  $faixa = new Faixa();
  $faixa->valorpk = $id;
  $faixa->excluir($faixa);
}

function desativar($id) {
  $faixa = new Faixa();
  $faixa->valorpk=$id;
  $faixa->desativar($faixa);
}

?>
