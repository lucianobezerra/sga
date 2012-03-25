<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Entrar</title>
  </head>
  <body>
    <?php
    require('class/Estabelecimento.class.php');

    $ups = new Estabelecimento();
    $ups->extras_select = "order by cnes";
    $ups->selecionaTudo($ups);

    while($linha = $ups->retornaDados()){
      echo "{$linha->cnes} - {$linha->nome_fantasia}<br/>";
    }
    echo "<pre>";
    print_r($ups);
    echo "</pre>";
    ?>
  </body>
</html>
