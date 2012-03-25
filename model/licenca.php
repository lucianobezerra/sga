<?php

require("../class/Config.class.php");

$id = $_REQUEST['id'];
$acao = isset($_REQUEST['acao']) ? $_REQUEST['acao'] : null;
$chave = $_REQUEST['chave'];

switch ($acao) {
  case "liberar": liberar($id, $chave);
    break;
}

function liberar($id, $chave) {
  $config = new Config();
  $config->valorpk = $id;
  $config->setValor("expira", $chave);
  $config->atualizar($config);
}

?>
