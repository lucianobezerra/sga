<?php
require_once(dirname(dirname(dirname(__FILE__))) .'/class/Estabelecimento.class.php');

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;

$ups = new Estabelecimento();
$ups->valorpk = $id;
$ups->seleciona($ups);
$linha = $ups->retornaDados("array");
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
              alert('Estabelecimento Atualizado.');
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
  <body onLoad="document.unidade.cnes.focus();" >
    <p style="font-size: 14pt;">Atualizar Unidade</p><br/><br/>
    <form name="unidade" id="unidade" method="POST" action="model/estabelecimento.php?acao=alterar&id=<?= $linha['id']; ?>">
      <input type="hidden" name="id" id="id" value="<?= $linha['id']; ?>" />
      <table width="100%">
        <tr>
          <td width="20%">Cnes: </td>
          <td width="80%"><input type="text" name="cnes" id="cnes" size="7" maxlength="7" class="campo" disabled="disabled" value="<?= $linha['cnes']; ?>" /></td>
        </tr>
        <tr>
          <td>Razão Social:</td>
          <td><input type="text" name="razao" id="razao" size="60" maxlength="60" class="campo" required="true" value="<?= $linha['razao_social']; ?>"/></td>
        </tr>
        <tr>
          <td>Nome Fantasia:</td>
          <td><input type="text" name="fantasia" id="fantasia" size="60" maxlength="60" class="campo" required="true" value="<?= $linha['nome_fantasia']; ?>"/></td>
        </tr>
        <tr>
          <td>Emite AIH?</td>
          <td>
            Sim <input type="radio" name="aih" id="aih" value="true" class="campo" <?php echo ($linha['emite_aih']) == true ? 'checked=checked' : ''; ?>/>
            Não <input type="radio" name="aih" id="aih" value="false" class="campo" <?php echo ($linha['emite_aih']) == false ? 'checked=checked' : ''; ?>/>
          </td>
        </tr>
        <tr>
          <td>Emite Apac?</td>
          <td>
            Sim <input type="radio" name="apac" id="apac" value="true" class="campo" <?php echo ($linha['emite_apac']) == true ? 'checked=checked' : ''; ?>/>
            Não <input type="radio" name="apac" id="apac" value="false" class="campo" <?php echo ($linha['emite_apac']) == false ? 'checked=checked' : ''; ?>/>
          </td>
        </tr>
        <tr>
          <td>Bloqueia Teto?</td>
          <td>
            Sim <input type="radio" name="teto" id="apac" value="true" class="campo" <?php echo ($linha['bloqueia_teto']) == true ? 'checked=checked' : ''; ?>/>
            Não <input type="radio" name="teto" id="apac" value="false" class="campo" <?php echo ($linha['bloqueia_teto']) == false ? 'checked=checked' : ''; ?>/>
          </td>
        </tr>
        <tr>
          <td>Ativo?</td>
          <td>
            Sim <input type="radio" name="ativo" id="ativo" value="true" class="campo" <?php echo ($linha['ativo']) == true ? 'checked=checked' : ''; ?>/>
            Não <input type="radio" name="ativo" id="ativo" value="false" class="campo" <?php echo ($linha['ativo']) == false ? 'checked=checked' : ''; ?>/>
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