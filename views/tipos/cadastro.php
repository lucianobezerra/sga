<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    <script type="text/javascript">
      $(function($){
        $('form#tipo').submit(function(){
          $(this).ajaxSubmit(function(retorno){
            if(!retorno){
              alert('Tipo de Autorização Cadastrado.');
              $('div#right').load("views/tipos/");
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
    <p style="font-size: 12pt; margin-top: 12pt;">Cadastro de Tipos de Autorização</p><br/>
    <form name="tipo" id="tipo" method="POST" action="model/tipo.php?acao=inserir">
      <table width="100%">
        <tr>
          <td width="20%">Código: </td>
          <td width="80%"><input type="text" size="7" name="codigo" class="campo"/></td>
        </tr>
        <tr>
          <td>Descrição</td>
          <td><input type="text" size="40" name="descricao" class="campo"/></td>
        </tr>
        <tr>
          <td>Ativo?</td>
          <td>
            Sim <input type="radio" name="ativo" id="ativo" value="true" class="campo"/>
            Não <input type="radio" name="ativo" id="ativo" value="false" class="campo" checked/>
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