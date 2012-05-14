<?php
define('DS', DIRECTORY_SEPARATOR);
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Tipo.class.php');

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;

$tipo = new Tipo();
$tipo->valorpk = $id;
$tipo->seleciona($tipo);
$linha = $tipo->retornaDados("array");
?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    <script type="text/javascript">
      $(function($){
        $('form#tipo').submit(function(){
          $(this).ajaxSubmit(function(retorno){
            if(!retorno){
              alert('Tipo de Autorização Atualizado.');
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
    <p style="font-size: 12pt; margin-top: 12pt;">Atualização de Tipos de Autorização</p><br/>
    <form name="tipo" id="tipo" method="POST" action="model/tipo.php?acao=alterar">
      <input type="hidden" name="id" value="<?php echo $linha['id']; ?>" />
      <table width="100%">
        <tr>
          <td width="20%">Código: </td>
          <td width="80%"><input type="text" size="7" name="codigo" class="campo" value="<? echo $linha['codigo']; ?>"/></td>
        </tr>
        <tr>
          <td>Descrição</td>
          <td><input type="text" size="40" name="descricao" class="campo" value="<? echo $linha['descricao']; ?>"/></td>
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