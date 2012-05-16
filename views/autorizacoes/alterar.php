<?php
require_once( '../../class/Autorizacao.class.php');
require_once('../../util/funcoes.php');
$id = $_REQUEST['id'];

$autorizacao = new Autorizacao();
$autorizacao->valorpk = $id;
$autorizacao->seleciona($autorizacao);
$linha = $autorizacao->retornaDados("array");
?>
<HTML>
  <head>
    <script type="text/javascript">
      $(function($){
        $('input[name=atualizar]').live('click', function(){
          var url = 'model/autorizacao.php?acao=alterar';
          var params = $('form').serialize();
          $.ajax({
            type: 'post',
            url:  url,
            data: params,
            success: function(resposta){
              if(!resposta){
                alert('Autorização Atualizada!');
                $('#right').load('views/autorizacoes/cadastro.php');
              } else {
                $('.retorno').html(resposta);
              }
           }
          });
          return false;
        });        
      });
    </script>
  </head>
  <body>
    <p style="font-size: 12pt; margin-top: 10px;">Alteração da Autorização</p>
    <form id="autorizacao" class="campo" name="autorizacao" action="#" method="post" style="padding: 5px;">
    <input type="hidden" name="id" value="<?= $linha['id']; ?>" />
    <label for="numero">Número:</label>
    <input type="text" size="12" name="numero" class="campo" value="<?= $linha['numero']; ?>" disabled="disabled"/>
    <label for="nome_paciente">Paciente:</label>
    <input type="text" size="40" maxlength="60" name="nome_paciente" class="campo" value="<?= $linha['nome_pac']; ?>"/>
    <label for="nascimento">Nascimento:</label>
    <input type="text" size="10" maxlength="10" name="nascimento" class="campo" value="<? echo ConverteDataParaBR($linha['nascimento']); ?>"/>
    <label for="internacao">Internação:</label>
    <input type="text" id="salvar" size="10" maxlength="10" name="internacao" class="campo" value="<? echo ConverteDataParaBR($linha['internacao']); ?>"/><br/>
    <input type="button" name="atualizar" style="width: 85px; height: 25px; margin-top: 1em;" class="campo" value="Atualizar"/>
    </form>
    <div class="retorno"></div>
  </body>
</html>