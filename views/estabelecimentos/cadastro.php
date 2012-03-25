<?php

function __autoload($classe) {
  include_once "../../class/{$classe}.class.php";
}
?>

<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    <script type="text/javascript">
      $(function($){
        $('form#unidade').submit(function(){
          $(this).ajaxSubmit(function(retorno){
            if(!retorno){
              alert('Estabelecimento Cadastrado.');
              $('#right').load("views/estabelecimentos/");
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
    <p style="font-size: 12pt; margin-top: 12px;">Cadastro de Unidade de Saúde</p><br/>
    <form name="unidade" id="unidade" method="POST" action="model/estabelecimento.php?acao=inserir">
      <table width="100%">
        <tr>
          <td width="20%">Cnes: </td>
          <td width="80%"><input type="text" name="cnes" id="cnes" autofocus="true" size="7" maxlength="7" class="campo" required="true" /></td>
        </tr>
        <tr>
          <td>Razão Social:</td>
          <td><input type="text" name="razao" id="razao" size="60" maxlength="60" class="campo" required="true"/></td>
        </tr>
        <tr>
          <td>Nome Fantasia:</td>
          <td><input type="text" name="fantasia" id="fantasia" size="60" maxlength="60" class="campo" required="true"/></td>
        </tr>
        <tr>
          <td>Valor Teto</td>
          <td><input type="text" name="valor_teto" size="15" class="campo" value="0.00"/></td>
        </tr>
        <tr>
          <td>Valor Médio (aih)</td>
          <td><input type="text" name="valor_medio" size="15" class="campo" value="0.00"/></td>
        </tr>
        <tr>
          <td>Emite AIH?</td>
          <td>
            Sim <input type="radio" name="aih" id="aih" value="S" class="campo"/>
            Não <input type="radio" name="aih" id="aih" value="N" class="campo" checked/>
          </td>
        </tr>
        <tr>
          <td>Emite Apac?</td>
          <td>
            Sim <input type="radio" name="apac" id="apac" value="S" class="campo"/>
            Não <input type="radio" name="apac" id="apac" value="N" class="campo" checked/>
          </td>
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
