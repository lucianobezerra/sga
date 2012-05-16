<?php
define('DS', DIRECTORY_SEPARATOR);
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Operador.class.php');

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;

$operador = new Operador();
$operador->valorpk = $id;
$operador->seleciona($operador);

$linha = $operador->retornaDados("array");
?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    <script type="text/javascript">
      $(function($){
        $('form#operador').submit(function(){
          $(this).ajaxSubmit(function(retorno){
            if(!retorno){
              alert('Operador Atualizado.');
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
    <p style="font-size: 12pt; margin-top: 12px;">Alterando Cadastro de Operadores</p><br/>
    <form name="operador" id="operador" method="POST" action="model/operador.php?acao=alterar&id=<?= $linha['id'] ?>">
      <input type="hidden" name="hidden_id" value="<?= $linha['id']; ?>" />
      <table width="100%">
        <tr>
          <td width="20%">Login: </td>
          <td width="80%"><input type="text" name="login" id="login" autofocus="true" size="15" maxlength="10" class="campo" required="true" value="<?= $linha['login']; ?>" disabled /></td>
        </tr>
        <tr>
          <td>Nome Completo:</td>
          <td><input type="text" name="nome" id="nome" size="40" maxlength="60" class="campo" required="true" value="<?= $linha['nome']; ?>"/></td>
        </tr>
        <tr>
          <td>Nível</td>
          <td>
            <select name="nivel" size="1" class="campo">
              <option value="" selected>Selecione</option>
              <option value="0" <? if ($linha['nivel'] == '0') { echo "selected='selected'";} ?>>Operador Master</option>
              <option value="1" <? if ($linha['nivel'] == '1') { echo "selected='selected'";} ?>>Operador Sênior</option>
              <option value="2" <? if ($linha['nivel'] == '2') { echo "selected='selected'";} ?>>Operador Pleno</option>
              <option value="3" <? if ($linha['nivel'] == '3') { echo "selected='selected'";} ?>>Operador Júnior</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>Ativo?</td>
          <td>
            Sim <input type="radio" name="ativo" id="ativo" value="t" class="campo" <?php echo $linha['ativo'] == 't' ? 'checked=checked' : ''; ?>/>
            Não <input type="radio" name="ativo" id="ativo" value="f" class="campo" <?php echo $linha['ativo'] == 'f' ? 'checked=checked' : ''; ?>/>
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