<?php

require("../util/funcoes.php");
$arquivo = file("upload/tb_procedimento.txt");
foreach ($arquivo as $linha) {
  removerAcento(linha);
  echo $linha;
}
?>