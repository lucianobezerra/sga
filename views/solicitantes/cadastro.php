<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    <script type="text/javascript">
      $(function($){
        $('form#solicitante').submit(function(){
          $(this).ajaxSubmit(function(retorno){
            if(!retorno){
              alert('Solicitante Cadastrado.');
              $('#right').load("views/solicitantes/index.php");
            } else{
              $('div#mensagem-erro').html(retorno);
            }
          });
          return false;
        });
      });
    </script>
  </head>
  <body>
    <p style="font-size: 12pt; margin-top: 12px;">Cadastro de Solicitantes</p><br/>
    <form name="solicitante" id="solicitante" method="POST" action="model/solicitante.php?acao=inserir">
      <table width="100%">
        <tr>
          <td width="20%">Cartão SUS: </td>
          <td width="80%"><input type="text" name="cns" id="cns" autofocus="true" size="15" maxlength="15" class="campo" required="true" /></td>
        </tr>
        <tr>
          <td>Nome Completo:</td>
          <td><input type="text" name="nome" id="nome" size="40" maxlength="60" class="campo" required="true"/></td>
        </tr>
        <tr>
          <td>Ativo?</td>
          <td>
            Sim <input type="radio" name="ativo" id="ativo" value="true" class="campo" checked/>
            Não <input type="radio" name="ativo" id="ativo" value="false" class="campo"/>
          </td>
        </tr>
        <tr>
          <td></td>
          <td><button name="salvar" type="submit" style="width: 85px; height: 25px" class="campo">Salvar</button></td>
        </tr>
      </table>
    </form>
    <br/>
    <div id="mensagem-erro" class="mensagem-erro"></div>
  </body>
</html>