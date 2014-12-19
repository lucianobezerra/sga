<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>SGA::Geração de Senhas</title>
    <script type='text/javascript' src='js/jquery-2.1.3.min.js'></script>
    <script type="text/javascript">
    $(function($){
      $('form#gera_senha').submit(function(){
        var data = $('input[name=data_limite]').val();
        var  url = 'libera_senha.php';
        $.post(url, {data: data}, function(resposta){
          $('div#retorno').html(resposta);
        })
        return false;
      });
    })
  </script>
  </head>
  <body>
    <style type="text/css">
      body {
        background-image: url('imagens/fundo.jpg'); background-repeat: repeat-x;
        font-size: 10pt;
        font-family: Arial, Verdana, sans-serif;
      }

      fieldset {
        padding-top: 10px;
        padding-bottom: 10px;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
      }

      legend {
        background: #FF9;
        border: solid 1px black;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
        padding: 6px;
      }

      .box{
        position:absolute;
        top:50%;
        left:50%;
        width:600px;
        height:200px;
        margin-left:-260px;
        margin-top:-120px;
        text-align:left;
      }
    </style>
    <div class="box">
      <form id="gera_senha" method="post" action="#">
        <fieldset>
        <legend>Gerar Senha de Liberação:</legend>
          <label for="data_limite">Liberar Até:</label>
          <input type="text" name="data_limite" size="10" placeholder="Nova Data"/><br/>
          <button name="gerar_senha" type="submit" style="width: 100px; height: 25px" class="campo">Gerar</button>
        </fieldset>  
      </form>
      <div id='retorno'></div>
    </div>
  </body>
</html>