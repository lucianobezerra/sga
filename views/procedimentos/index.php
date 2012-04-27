<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/class/Procedimento.class.php');

$procedimento = new Procedimento();
$procedimento->selecionaTudo($procedimento);
?>
<html>
  <head>
  </head>
  <body>
    <?
    while ($linha = $procedimento->retornaDados()) {

      echo $linha->codigo;
    }
    ?>
  </body>
</html>