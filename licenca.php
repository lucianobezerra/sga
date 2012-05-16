<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
    <script type='text/javascript' src='js/jquery-1.7.2.min.js'></script>
  </head>
  <body>
    <script type="text/javascript">
      $(function(){
        $('button[name=salvar]').live('click', function(){
          var url    = 'model/licenca.php?acao=liberar';
          var params = $('form').serialize();
          $.ajax({ type: 'post', url: url, data: params,
            success: function(resposta){
              if(resposta){
                $('.mensagem-erro').html(resposta);
              } else {
                $(window.document.location).attr('href', 'index.php');  
              }
            }
          });
          return false;
        });
      });
    </script>
    <div class="box_centralizado">
      <form id="frmExpirado" action="#" method="post" class="expirado">
        <fieldset style="border: #f90 1px solid; margin: 5px; padding: 5px;">
          <div class="loader" style="display: none;"><img src="imagens/loader.gif" alt="Carregando" ></div>
          <p>
            <label for="chave">Informe a Chave de Liberação</label> <br>
            <input type="text" name="chave" class="campos" size="50"/>
          </p>
          <button name="salvar" type="submit" style="width: 85px; height: 25px" class="campo">Liberar</button>
        </fieldset>
      </form>
      <div class="mensagem-erro"></div>
    </div>
  </body>
</html>
