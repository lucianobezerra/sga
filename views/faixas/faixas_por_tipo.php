<?php

define('DS', DIRECTORY_SEPARATOR);
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Faixa.class.php');
$id_tipo = $_REQUEST['id_tipo'];

$faixas = new Faixa();
$faixas->extras_select = "where id_tipo = $id_tipo and saldo >0 and ativo";
$faixas->selecionaPorTipo($faixas);
echo "<option value=''>Selecione</option>";
while ($faixa = $faixas->retornaDados()) {
  echo "<option value=" . $faixa->id . ">" . $faixa->inicial . " a " . $faixa->final . "</option>";
}
?>
