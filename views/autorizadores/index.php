<?php
if(defined('ROOT_APP') == false){
  define('ROOT_APP', $_SERVER['DOCUMENT_ROOT'] . "/sga");
}

if (defined('ROOT_IMP') == false) {
  define('ROOT_IMP', ROOT_APP . "/importar");
}

require_once(ROOT_APP.'/class/Autorizador.class.php');
require_once(ROOT_APP.'/util/funcoes.php');

$nivel = retornaNivel();

$autorizador = new Autorizador();
$autorizador->extras_select = "where ativo order by nome";
$autorizador->selecionaTudo($autorizador);
?>
<html>
  <head>
    <script type="text/javascript">
      function desativar(id){
        $.post('model/autorizador.php?acao=desativar',
        {id: +id, ajax: true},
        function(resposta){
          if(!resposta){
            $('#row_'+id).fadeOut('slow');
            $('#retorno').html('Autorizador Desativado!');
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
        $.post('model/autorizador.php?acao=excluir',
        {id: +id, ajax: true},
        function(resposta){
          if(!resposta){
            $('#row_'+id).fadeOut('slow');
            $('#retorno').html('Autorizador Excluido');
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
        $('.novo_autorizador').click(function(){
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
    <div id="retorno" style="color: red; font-weight: bold; margin-top: 8px;"></div>
    <table width="100%" border="1" align="center" style="margin-top: 8px;font-size: 10pt; line-height: 130%">
      <thead>
        <tr>
          <th colspan="7" style='text-align: center; font-size: 12pt'>Autorizadores Ativos</th>
        </tr>
        <tr>
          <th style="width: 20%">CNS</th>
          <th style="width: 60%">Nome do Autorizador</th>
          <th colspan="4" style='text-align: center; width: 20%'>Ação</th>
        </tr>
      </thead>
      <?php while ($linha = $autorizador->retornaDados()) { ?>
        <tr id="row_<?= $linha->id; ?>">
          <td style='text-align: center;'><?= $linha->cns ?></td>
          <td><?= $linha->nome ?></td>
          <td style='text-align: center;'><?php echo ($nivel <2) ? "<a class='alterar' href='views/autorizadores/alterar.php?id={$linha->id}' title='Alterar'><img src='imagens/alterar.gif' border='0' alt=''/></a>" : "<img src='imagens/alterar.gif' border='0' alt='' title='Sem permissão para alterar'/>" ?></td>
          <td style='text-align: center;'><?php echo ($nivel <2) ? "<a class='desativar' href='#' onClick='desativar({$linha->id})' title='Desativar'><img src='imagens/desativar.gif' border='0' alt=''/></a>"    : "<img src='imagens/desativar.gif' border='0' alt='' title='Sem permissão para Desativar'/>" ?></td>
          <td style='text-align: center;'><?php echo ($nivel <2) ? "<a class='excluir' href='#' onClick='excluir({$linha->id})' title='Excluir'><img src='imagens/excluir.png' border='0' alt=''/></a>" : "<img src='imagens/excluir.png' border='0' alt='' title='Sem permissão para Excluir'/>" ?></td>
        </tr>
      <?php } ?>
    </table>
    <br/><? echo ($nivel < 2) ? "<a class='novo_autorizador' href='views/autorizadores/cadastro.php'>Novo autorizador</a>" : ""; ?>
  </body>
</html>