<?php

require('../class/Faixa.class.php');

$acao = isset($_REQUEST['acao']) ? $_REQUEST['acao'] : null;
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;

switch ($acao) {
  case "inserir": inserir();    break;
  case "alterar": alterar($id);    break;
  case "excluir": excluir($id);    break;
  case "desativar": desativar($id);    break;
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
    $faixa->delCampo("faixa_tipo");
    $faixa->delCampo("faixa_cmpt");
    $faixa->atualizar($faixa);
    
//    $faixa->atualizaSaldo($id, $_POST['hidden_inicial'], $_POST['final']);
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
