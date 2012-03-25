<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
    <script type='text/javascript' src='js/jquery.min.js'></script>
  </head>
  <body>
    <script type="text/javascript">
      $(function(){
        chave = $('input[name=chave]').val();
        $.post('model/licenca.php?acao=liberar', {id: 1, ajax: true, chave: chave},
        function(resposta){
          if(resposta){
            $('#retorno').html(resposta);
          } else {
            $(window.document.location).attr('href', 'index.php');
          }
        }
      );
      });
    </script>
    <div class="box_centralizado">
      <form id="frmExpirado" action="" method="post" class="expirado">
        <fieldset style="border: #f90 1px solid; margin: 5px; padding: 5px;">
          <div class="loader" style="display: none;"><img src="imagens/loader.gif" alt="Carregando" ></div>
          <div class="mensagem-erro"></div>
          <p>
            <label for="chave">Informe a Chave de Liberação</label> <br>
            <input type="text" name="chave" class="campos" size="50"/>
          </p>
          <button name="salvar" type="submit" style="width: 85px; height: 25px" class="campo">Liberar</button>
        </fieldset>
      </form>
    </div>
    <div class="retorno"></div>
  </body>
</html>
