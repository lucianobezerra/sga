<?php
 $expirar = '2020-10-11';
 $hoje    = Date('Y-m-d');
include 'util/funcoes.php';
echo "Expirar em: ".ConverteDataparaBR($expirar).": ". encode5t($expirar);
echo "<br/>";
echo "Data Atual: ".ConverteDataparaBR($hoje).": ". encode5t($hoje);
?>
