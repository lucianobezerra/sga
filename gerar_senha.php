<?php
 $expirar = '2012-04-12';
 $hoje    = Date('Y-m-d');
include 'util/funcoes.php';
echo "Expirar em: ".ConverteDataparaBR($expirar).": ". encode5t($expirar);
echo "<br/>";
echo "Data Atual: ".ConverteDataparaBR($hoje).": ". encode5t($hoje);
?>
