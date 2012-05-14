<?php
require_once('../../class/Permissao.class.php');
require_once('../../class/EstabelecimentoTipo.class.php');
require_once('../../class/Operador.class.php');

$opcao = isset($_REQUEST['opcao'])            ? $_REQUEST['opcao']            : null;
$id_operador = $_REQUEST['_operador'];
$id_unidade  = $_REQUEST['_estabelecimento'];

switch ($opcao) {
  case 1: geraEstabelecimentos($id_operador); break;
  case 2: geraTipos($id_unidade);             break;
}

function geraEstabelecimentos($id_operador){
  $operador = new Operador();
  $operador->extras_select = "where id={$id_operador} and ativo=true";
  $operador->pegaNivel($operador);

  $linha_operador = $operador->retornaDados("array");

  $nivel = $linha_operador['nivel'];
  unset($operador);

  $and_operador = ($id_operador == 999) ? "" : "and id_operador={$id_operador}";
  $permissao = new Permissao();
  $permissao->extras_select = "where estabelecimentos.ativo=true {$and_operador}";
  $permissao->selecionaTudo($permissao);
  echo "<option value='000'>Selecione</option>";
  if($nivel <= 2):
    echo "<option value='999'>Todos</option>";
  endif;
  while($linha = $permissao->retornaDados()){
    echo "<option value='{$linha->id_estabelecimento}'>{$linha->nome_fantasia}</option>";
  }
  echo '</select>';
}

function geraTipos($id_unidade){
  $operador = new Operador();
  $operador->extras_select = "where id={$id_operador} and ativo=true";
  $operador->pegaNivel($operador);

  $linha_operador = $operador->retornaDados("array");

  $nivel = $linha_operador['nivel'];
  unset($operador);
  $tipos = new EstabelecimentoTipo();
  $linhas = $tipos->selecionaPorEstabelecimento($id_unidade);  
  echo "<option value='000'>Selecione</option>";
  if($nivel <= 2):
    echo "<option value='999'>Todos</option>";
  endif;
  foreach ($linhas as $linha){
    echo "<option value='{$linha['id_tipo']}'>{$linha['descricao']}</option>";
  }
}
?>
