<?php
require_once('../../class/Sessao.class.php');
$session = new Session();
$session->start();
$ambiente = $session->check();
if (empty($ambiente)) {
  echo "<p style='font-size: 12pt; margin-top: 14px; color: red'><a class='ambiente' href='ambiente.php'>Ambiente não configurado, clique para configurar</a></p>";
  exit();
}
?>
<html>
  <head>
    <script type="text/javascript">
      function exibir(id){
        $.post('model/autorizacao.php?acao=exibir',
        {id: +id, ajax: true},
        function(resposta){
          $('.retorno').html(resposta);
        });
      }
      
      $(function($){
        $('.alterar').live('click', function(){
          $('div#right').load($(this).attr('href'));
          return false;
        })
        
        $('input[name=pesquisar]').live('click', function(){
          $('div.loader').show();
          var url = 'model/autorizacao.php?acao=localiza';
          var params = $('form').serialize();
          $.ajax({
            type: 'post',
            url:  url,
            data: params,
            success: function(resposta){
              $('.retorno').html(resposta);
              $('div.loader').hide();
              $('.pesquisar').val('');
              $('#dados tbody tr:odd').addClass('odd');
            }
          });
          return false;
        });        
      });
    </script>
  </head>
  <body>
    <fieldset style="border: solid 1px; padding: 5px; line-height: 20px; margin-top: 12px">
      <legend>Localizar Autorização</legend>
      <form action="#" method="post" name="pesquisar" class="campo" style="border: none">
        <table>
          <tr>
            <td>
              <input class="pesquisar" type="text" name="searchField" size="30"/>
              <input name="pesquisar" type="button" class="campo" value="Pesquisar" style="width: 85px; height: 25px" onclick="return false"/>
              <input name="historico" type="checkbox" class="campo" value="true" checked />Pesquisa Histórico
            </td>
          </tr>
        </table>
      </form>
    </fieldset>
    <div class="loader" style="display: none; margin-top: 14px"><img src="imagens/aguarde.gif" alt="Carregando" /></div>
    <div class="retorno">
    </div>
    <br/>
    <div id="mensagem-erro" class="mensagem-erro"></div>
  </body>
</html>