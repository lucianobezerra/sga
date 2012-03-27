<?php
require("../../class/Sessao.class.php");
require("../../class/Faixa.class.php");
$session = new Session();
$session->start();
$id_opr        = $session->getNode("id_operador");
$id_ups        = $session->getNode("id_estabelecimento");
$id_tipo       = $session->getNode("id_tipo");
$id_faixa      = $session->getNode("id_faixa");
$id_cmpt       = $session->getNode("id_competencia");
$nome_operador = $session->getNode("nome_operador");

$ambiente = $session->check();
if (!$ambiente) {
  echo "<p style='font-size: 14pt; margin-top: 14px; color: red'><a class='ambiente' href='ambiente.php'>Ambiente não configurado, clique para configurar</a></p>";
exit;
} else {
  $faixa = new Faixa();
  $faixa->valorpk=$id_faixa;
  $faixa->seleciona($faixa);
  $linha = $faixa->retornaDados("array");
  ?>
  <html>
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <title></title>
      <script type="text/javascript">
        $(function($){
          $("#nascimento").mask("99/99/9999");
          $("#internacao").mask("99/99/9999");
          
          $('input[type=submit]').click(function(e){
            e.preventDefault();
            var valores = $('#autorizacao').serialize();
            $.ajax({
             url:  'model/autorizacao?acao=inserir',
             type: 'post',
             dataType: 'html',
             data: valores,
             success: function(resposta){
                $('#retorno').html(resposta);
                $('input[type=text]').attr('disabled', true);
              }
            });
          });
            
          $('input[name=nova]').live('click',function(){
            $('input[type=text]').attr('disabled', false);
            $('form')[0].reset();
            $('input:text:eq(0)').focus();
          });
        });
      </script>
    </head>
    <body>
      <p style="font-size: 12pt; margin-top: 12px;">Emissão de Autorização na Faixa: <?= $linha['inicial']; ?> A <?= $linha['final']; ?></p>
      <form id="autorizacao" class="campo" name="autorizacao" action="#" method="post" style="padding: 5px;">
        <input type="hidden" name="id_operador" value="<?= $id_opr; ?>" />
        <input type="hidden" name="id_estabelecimento" value="<?= $id_ups; ?>" />
        <input type="hidden" name="id_tipo" value="<?= $id_tipo; ?>" />
        <input type="hidden" name="id_faixa" value="<?= $id_faixa; ?>" />
        <input type="hidden" name="id_competencia" value="<?= $id_cmpt; ?>" />
        <label for="nome_paciente">Paciente:</label><input type="text" size="60" maxlength="60" name="nome_paciente" id="nome_paciente" class="campo"/>
        <label for="nascimento">Nascimento:</label><input type="text" size="15" maxlength="10" name="nascimento" id="nascimento" class="campo" />
        <label for="internacao">Internação:</label><input type="text" size="15" maxlength="10" name="internacao" id="internacao" class="campo" /><br/><br/>
        <input name="salvar"  type="submit" style="width: 120px; height: 25px;" class="campo" value="Gerar Autorização"/>
        <input name="nova"    type="button" style="width: 120px; height: 25px;" class="campo" value="Nova Autorização"/>
      </form>
      <br/>
      <div id="retorno" style="font-size: 12pt; color: red"></div>
    </body>
  </html>
<? } ?>