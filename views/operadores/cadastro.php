<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    <script type="text/javascript">
      $(function($){
        $('form#operador').submit(function(){
          $(this).ajaxSubmit(function(retorno){
            if(!retorno){
              alert('Operador Cadastrado.');
              $('#right').load("views/operadores/index.php");
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
    <p style="font-size: 12pt; margin-top: 12px;">Cadastro de Operadores</p><br/>
    <form name="operador" id="operador" method="POST" action="model/operador.php?acao=inserir">
      <table width="100%">
        <tr>
          <td width="20%">Login: </td>
          <td width="80%"><input type="text" name="login" id="login" autofocus="true" size="15" maxlength="10" class="campo" required="true" /></td>
        </tr>
        <tr>
          <td>Nome Completo:</td>
          <td><input type="text" name="nome" id="nome" size="40" maxlength="60" class="campo" required="true"/></td>
        </tr>
        <tr>
          <td>Senha:</td>
          <td><input type="password" name="senha" id="senha" size="15" maxlength="10" class="campo" required="true"/></td>
        </tr>
        <tr>
          <td>Nível</td>
          <td>
            <select name="nivel" size="1" class="campo">
              <option value="" selected>Selecione</option>
              <option value="0">Operador Master</option>
              <option value="1">Operador Sênior</option>
              <option value="2">Operador Pleno</option>
              <option value="3">Operador Júnior</option>
            </select>
          </td>
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