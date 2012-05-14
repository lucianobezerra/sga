<?php
  if (defined('ROOT_APP') == false) {
    define('ROOT_APP', $_SERVER['DOCUMENT_ROOT'] . "/sga");
  }

  require(ROOT_APP . "/class/Cidade.class.php");

  $codigo = $_REQUEST['codigo'];
  
  $cidade = new Cidade();
  $cidade->extras_select = "where cidades.codigo='{$codigo}'";
  $cidade->selecionaCidade($cidade);
  while($linha = $cidade->retornaDados()){
    echo $linha->id.",".$linha->sigla.",".$linha->descricao;
  }
?>
