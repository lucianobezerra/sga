<?php

require("../class/Config.class.php");

$acao  = isset($_REQUEST['acao'])  ? $_REQUEST['acao']  : null;
$chave = isset($_REQUEST['chave']) ? $_REQUEST['chave'] : null;

switch ($acao) {
  case "liberar": liberar($chave); break;
}

function liberar($chave) {
  $config = new Config();
  $config->valorpk = 1;
  $config->setValor("expira", $chave);
  $config->atualizar($config);
}

?>
