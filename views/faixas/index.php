<?php
define('DS', DIRECTORY_SEPARATOR);
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Faixa.class.php');
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'util' . DS . 'funcoes.php');

$nivel = retornaNivel();

$faixas = new Faixa();
$listagem = $faixas->lista();
?>
<html>
  <head>
    <script type="text/javascript">
      function desativar(id){
        $.post('model/faixa.php?acao=desativar',
        {id: +id, ajax: true},
        function(resposta){
          if(!resposta){
            $('#row_'+id).fadeOut('slow');
            $('#retorno').html('Faixa de Autorização Desativada!');
            $('#retorno').fadeIn('slow');
            $('#retorno').delay(4000).fadeOut(1000);
          } else{
            $('#retorno').html(resposta);
            $('#retorno').fadeIn('slow');
            $('#retorno').delay(4000).fadeOut(1000);
          }
        });
      }
      function excluir(id){
        $.post('model/faixa.php?acao=excluir',
        {id: +id, ajax: true},
        function(resposta){
          if(!resposta){
            $('#row_'+id).fadeOut('slow');
            $('#retorno').html('Faixa de Autorização Excluida!');
            $('#retorno').fadeIn('slow');
            $('#retorno').delay(4000).fadeOut(1000);
          } else {
            $('#retorno').html(resposta);
            $('#retorno').fadeIn('slow');
            $('#retorno').delay(4000).fadeOut(1000);
          }
        });
      }

      $(function($){
        $('tbody tr:odd').addClass('odd');
        $('.nova_faixa').click(function(){
          $('div#right').load($(this).attr('href'));
          return false;
        });

        $('.alterar').click(function(){
          $('div#right').load($(this).attr('href'));
          return false;
        });
      });
    </script>
  </head>
  <body>
    <div id="retorno" style="color: red; font-weight: bold; margin-top: 12px;"></div>
    <table width="100%" border="1" align="center" style="margin-top: 12px;font-size: 10pt; line-height: 140%">
      <thead>
        <tr>
          <th colspan="7" style='text-align: center; font-size: 12pt'>Faixas Cadastradas</th>
        </tr>
        <tr>
          <th width="35%">Tipo</th>
          <th style='text-align: center;' width="20%">Inicial</th>
          <th style='text-align: center;' width="20%">Final</th>
          <th style='text-align: center;' width="10%">Saldo</th>
          <th colspan="3" style='text-align: center;' width="15%">Ação</th>
        </tr>
      </thead>
      <?php foreach ($listagem as $faixa) { ?>
        <tr id="row_<? echo $faixa['id']; ?>">
          <td><?= $faixa['tipo']; ?></td>
          <td style='text-align: center;'><?= $faixa['inicial']; ?></td>
          <td style='text-align: center;'><?= $faixa['final']; ?></td>
          <td style='text-align: center;'><?= $faixa['saldo']; ?></td>
          <td style='text-align: center;'><? echo ($nivel < 2) ? "<a class='alterar' href='views/faixas/alterar.php?id={$faixa['id']}' title='Alterar'><img src='imagens/alterar.gif' border='0' alt='Alterar Faixa'/></a>" : "<img src='imagens/alterar.gif' border='0' alt='Alterar Faixa' title='Sem permissão para Alterar'/>" ?></td>
          <td style='text-align: center;'><? echo ($nivel < 2) ? "<a class='excluir' href='#' onClick='excluir({$faixa['id']})' title='Excluir'><img src='imagens/excluir.png' border='0' alt='Excluir Faixa'/></a>" : "<img src='imagens/excluir.png' border='0' alt='Excluir Faixa' title='Sem permissão para Excluir'/>" ?></td>
          <td style='text-align: center;'><? echo ($nivel < 2) ? "<a class='desativar' href='#' onClick='desativar({$faixa['id']})' title='Desativar'><img src='imagens/desativar.gif' border='0' alt='Desativar Faixa'/></a>" : "<img src='imagens/desativar.gif' border='0' alt='Desativar Faixa' title='Sem permissão para Deativar'/>" ?></td>
        </tr>
      <? } ?>
    </table>
    <br/><br/><? echo ($nivel < 2) ? "<a class='nova_faixa' href='views/faixas/cadastro.php'>Nova Faixa</a>" : "" ?>
  </body>
</html>