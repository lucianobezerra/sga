<html>
  <head>
    <script type="text/javascript">
      function popup(url, name, opcoes){
        window.open(url, name, opcoes);
      }
    </script>
  </head>
  <body>
    
  </body>
</html>
<?php
  $numero = isset($_GET['numero']) ? $_GET['numero']  : null;
  $url = "views/autorizacoes/exibir.php?numero={$numero}";
  echo "AUTORIZAÇÃO NÚMERO: {$numero}<br/>";
?>
<a href="javascript:onclick=popup('<?=$url; ?>', 'Imprimir', 'width=770, height=400')">Imprimir</a>
