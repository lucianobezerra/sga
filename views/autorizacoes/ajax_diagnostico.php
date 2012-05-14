<?php
  if (defined('ROOT_APP') == false) {
    define('ROOT_APP', $_SERVER['DOCUMENT_ROOT'] . "/sga");
  }

  require(ROOT_APP . "/class/Diagnostico.class.php");

  $codigo = $_REQUEST['codigo'];
  
  $diagnostico = new Diagnostico();
  $diagnostico->extras_select = "where codigo='{$codigo}'";
  $diagnostico->selecionaDiagnostico($diagnostico);
  while($linha = $diagnostico->retornaDados("array")){
    echo $linha[0].",".$linha[1];
  }
?>
