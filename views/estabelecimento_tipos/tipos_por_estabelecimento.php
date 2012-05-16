<?php

define('DS', DIRECTORY_SEPARATOR);
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'EstabelecimentoTipo.class.php');
$id_estabelecimento = $_REQUEST['id_estabelecimento'];

$estabelecimentos_tipo = new EstabelecimentoTipo();
$listagem = $estabelecimentos_tipo->selecionaPorEstabelecimento($id_estabelecimento);

if (sizeof($listagem) == 0) {
  echo "<option value='0'>Estabelecimento não possui tipos cadastrados</option>";
} else {
  echo '<option value="0">Selecione</option>';
  foreach ($listagem as $tipo) {
    echo "<option value='{$tipo['id_tipo']}'>{$tipo['descricao']}</option>";
  }
}
?>
