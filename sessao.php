<?php
require("class/Sessao.class.php");

$sessao = new Session();
$sessao->start();

$sessao->addNode("id_estabelecimento", $_POST['estabelecimento']);
$sessao->addNode("id_competencia",     $_POST['competencia']);
$sessao->addNode("id_tipo",            $_POST['tipo']);
$sessao->addNode("id_faixa",           $_POST['faixa']);
$sessao->addNode("id_operador",        $_POST['operador']);
$sessao->addNode("nivel_operador",        $_POST['operador']);

//@header('Location: index.php');
?>
