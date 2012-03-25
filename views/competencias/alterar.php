<?php
define( 'DS', DIRECTORY_SEPARATOR );
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Competencia.class.php');
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Login.class.php');
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'util' . DS . 'funcoes.php');

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;

$login = new Login();
$nivel = $login->getNivel();

$competencia = new Competencia();
$competencia->valorpk = $id;
$competencia->extras_select = "where ativo=true order by ano,mes";
$competencia->seleciona($competencia);

$linha = $competencia->retornaDados("array");

?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    <script type="text/javascript">
      $(function($){
        $('form#competencia').submit(function(){
          $(this).ajaxSubmit(function(retorno){
            if(!retorno){
              alert('Competência Atualizada.');
              $('div#right').load("views/competencias/");
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
    <p style="font-size: 14pt; margin-top: 15px;">Alterar Competência</p><br/><br/>
    <form name="competencia" id="competencia" method="POST" action="model/competencia.php?acao=alterar">
      <input type="hidden" name="id" id="id" value="<?= $id; ?>" />
      <table width="100%">
        <tr>
          <td width="20%">Mês: </td>
          <td width="80%">
            <select size="1" name="mes" class="campo">
              <option value="">Selecione</option>
              <option value="01"<? echo $linha['mes'] == "01" ? " selected='selected'" : ""; ?>>Janeiro</option>
              <option value="02"<? echo $linha['mes'] == "02" ? " selected='selected'" : ""; ?>>Fevereiro</option>
              <option value="03"<? echo $linha['mes'] == "03" ? " selected='selected'" : ""; ?>>Março</option>
              <option value="04"<? echo $linha['mes'] == "04" ? " selected='selected'" : ""; ?>>Abril</option>
              <option value="05"<? echo $linha['mes'] == "05" ? " selected='selected'" : ""; ?>>Maio</option>
              <option value="06"<? echo $linha['mes'] == "06" ? " selected='selected'" : ""; ?>>Junho</option>
              <option value="07"<? echo $linha['mes'] == "07" ? " selected='selected'" : ""; ?>>Julho</option>
              <option value="08"<? echo $linha['mes'] == "08" ? " selected='selected'" : ""; ?>>Agosto</option>
              <option value="09"<? echo $linha['mes'] == "09" ? " selected='selected'" : ""; ?>>Setembro</option>
              <option value="10"<? echo $linha['mes'] == "10" ? " selected='selected'" : ""; ?>>Outubro</option>
              <option value="11"<? echo $linha['mes'] == "11" ? " selected='selected'" : ""; ?>>Novembro</option>
              <option value="12"<? echo $linha['mes'] == "12" ? " selected='selected'" : ""; ?>>Dezembro</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>Ano</td>
          <td>
            <select name="ano" class="campo">
              <option value="">Selecione</option>
              <option value="2011"<? echo $linha['ano'] == '2011' ? ' selected' : '' ?>>2011</option>
              <option value="2012"<? echo $linha['ano'] == '2012' ? ' selected' : '' ?>>2012</option>
              <option value="2013"<? echo $linha['ano'] == '2013' ? ' selected' : '' ?>>2013</option>
              <option value="2014"<? echo $linha['ano'] == '2014' ? ' selected' : '' ?>>2014</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>Ativo?</td>
          <td>
            Sim <input type="radio" name="ativo" id="ativo" value="t" class="campo"<? echo $linha['ativo'] == 't' ? ' checked' : ''; ?>/>
            Não <input type="radio" name="ativo" id="ativo" value="f" class="campo"<? echo $linha['ativo'] == 'f' ? ' checked' : ''; ?>/>
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
