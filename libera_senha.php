<?php
	include 'util/funcoes.php';
	list($dia, $mes, $ano) = split("/", $_REQUEST['data']);
	$data = $ano."-".$mes."-".$dia;
	echo encode5t($data);
?>
