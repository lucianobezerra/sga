<?php
if(defined('ROOT_APP') == false){
  define('ROOT_APP', $_SERVER['DOCUMENT_ROOT'] . "/sga");
}

if (defined('ROOT_IMP') == false) {
  define('ROOT_IMP', ROOT_APP . "/importar");
}
require_once(ROOT_APP.'/class/Autorizador.class.php');

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;

$autorizador = new Autorizador();
$autorizador->valorpk = $id;
$autorizador->seleciona($autorizador);

$linha = $autorizador->retornaDados("array");
?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    <script type="text/javascript">
      $(function($){
        $('form#autorizador').submit(function(){
          $(this).ajaxSubmit(function(retorno){
            if(!retorno){
              alert('Autorizador Atualizado.');
              $('#right').load("views/autorizadores/index.php");
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
    <p style="font-size: 12pt; margin-top: 12px;">Alterando Cadastro de Autorizadores</p><br/>
    <form name="autorizador" id="autorizador" method="POST" action="model/autorizador.php?acao=alterar&id=<?= $linha['id'] ?>">
      <input type="hidden" name="hidden_id" value="<?= $linha['id']; ?>" />
      <table width="100%">
        <tr>
          <td width="20%">Login: </td>
          <td width="80%"><input type="text" name="cns" id="cns" autofocus="true" size="15" maxlength="15" class="campo" required="true" value="<?= $linha['cns']; ?>" disabled /></td>
        </tr>
        <tr>
          <td>Nome Completo:</td>
          <td><input type="text" name="nome" id="nome" size="40" maxlength="60" class="campo" required="true" value="<?= $linha['nome']; ?>"/></td>
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