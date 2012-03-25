<?php
define('DS', DIRECTORY_SEPARATOR);
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Tipo.class.php');
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Competencia.class.php');
$tipos = new Tipo();
$tipos->extras_select = "order by id";
$tipos->selecionaTudo($tipos);

$competencias = new Competencia();
$competencias->extras_select = "where ativo order by id";
$competencias->selecionaTudo($competencias);

?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    <script type="text/javascript">
      $(function($){
        $('form#faixa').submit(function(){
          $(this).ajaxSubmit(function(retorno){
            if(!retorno){
              alert('Faixa de Autorização Cadastrada.');
              $('div#right').load("views/faixas/");
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
    <p style="font-size: 12pt; margin-top: 14pt;">Cadastro de Faixas de Autorização</p><br/>
    <form name="faixa" id="faixa" method="POST" action="model/faixa.php?acao=inserir">
      <table width="100%">
        <tr>
          <td>Autorização Inicial</td>
          <td><input type="text" size="15" maxlength="12" name="inicial" class="campo"/></td>
        </tr>
        <tr>
          <td>Autorização Final</td>
          <td><input type="text" size="15" maxlength="12" name="final" class="campo"/></td>
        </tr>
        <tr>
          <td>Tipo de Autorização</td>
          <td>
            <select name="tipo" class="campo">
              <option value="" selected>Selecione</option>
              <?
              while ($linha = $tipos->retornaDados("array")) {
                echo "<option value='{$linha['id']}'>{$linha['descricao']}</option>";
              }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>Competência Inicial</td>
          <td>
            <select name="competencia" class="campo">
              <option value="" selected>Selecione</option>
              <?
              while ($linha = $competencias->retornaDados("array")) {
                echo "<option value='{$linha['id']}'>{$linha['ano']}{$linha['mes']}</option>";
              }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>Ativo</td>
          <td>
            Sim <input type="radio" name="ativo" id="ativo" value="true" class="campo" checked />
            Não <input type="radio" name="ativo" id="ativo" value="false" class="campo" />
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