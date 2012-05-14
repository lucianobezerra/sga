<?php
if (defined('ROOT_APP') == false) {
  define('ROOT_APP', $_SERVER['DOCUMENT_ROOT'] . "/sga");
}

require_once(ROOT_APP .'/class/Estabelecimento.class.php');
require_once(ROOT_APP .'/class/Sessao.class.php');
require_once(ROOT_APP . '/util/funcoes.php');

$sessao = new Session();
$sessao->start();
$cmpt = $sessao->getNode("id_competencia");

$nivel = retornaNivel();

$ups = new Estabelecimento();
$ups->extras_select = "where ativo order by cnes";
$ups->selecionaTudo($ups);
?>
<HTML>
  <head>
    <script type="text/javascript">
      function desativar(id){
        $.post('model/estabelecimento.php',
        {acao: 'desativar', id: +id, ajax: true},
        function(resposta){
          if(!resposta){
            $('#row_'+id).fadeOut('slow');
            $('#retorno').html('Estabelecimento Desativado!');
            $('#retorno').fadeIn('slow');
            $('#retorno').delay(4000).fadeOut(1000);
          } else {
            $('#retorno').html(resposta);
            $('#retorno').fadeIn('slow');
            $('#retorno').delay(4000).fadeOut(1000);
          }
        });
      }

      function excluir(id){
        $.post('model/estabelecimento.php',
        {acao: 'excluir', id: +id, ajax: true},
        function(resposta){
          if(!resposta){
            $('#row_'+id).fadeOut('slow');
            $('#retorno').html('Registro Excluido');
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
        $('.novo_estabelecimento').click(function(){
          $('div#right').load($(this).attr('href'));
          return false;
        });

        $('.alterar').click(function(){
          $('div#right').load($(this).attr('href'));
          return false;
        });

        $('.tipo_doc').click(function(){
          $('div#right').load($(this).attr('href'));
          return false;
        });
        
        $('.teto').click(function(){
          $('div#right').load($(this).attr('href'));
          return false;
        });
      });

    </script>
  </head>
  <body>
    <div id="retorno" style="color: red; font-weight: bold;"></div>
    <table width="100%" border="1" align="center">
      <thead>
        <tr>
          <th colspan="7" style="text-align: center; font-size: 11pt;">ESTABELECIMENTOS CADASTRADOS</th>
        </tr>
        <tr>
          <th style="text-align: center; font-size: 10pt; width: 11%;">CNES</th>
          <th style="font-size: 10pt; width: 65%;">NOME DO ESTABELECIMENTO</th>
          <th colspan="5" style='text-align: center; font-size: 10pt'>AÇÃO</th>
        </tr>
      </thead>
      <?php
      while ($linha = $ups->retornaDados()) {
      ?>
        <tr id="row_<? echo $linha->id; ?>">
          <td style='text-align: center; font-size: 9pt'><? echo $linha->cnes ?></td>
          <td style='text-align: left;   font-size: 9pt'><? echo $linha->nome_fantasia ?></td>
          <td style='text-align: center'><? echo ($nivel < 2) ? "<a class='alterar' href='views/estabelecimentos/alterar.php?id={$linha->id}' title='Alterar'><img src='imagens/alterar.gif' border='0' alt='alterar'/></a>" : "<img src='imagens/alterar.gif' border='0' alt='Alterar' title='Sem permissão para Alterar'/>" ?></td>
          <td style='text-align: center'><? echo ($nivel < 2) ? "<a href='#' onClick='excluir({$linha->id})' title='Excluir'><img src='imagens/excluir.png' border='0' alt='Excluir Estabelecimento'/></a>" : "<img src='imagens/excluir.png' border='0' alt='Excluir Estabelecimento' title='Sem permissão para Excluir'/>" ?> </td>
          <td style='text-align: center'><? echo ($nivel < 2) ? "<a href='#' onClick='desativar({$linha->id})' title='Desativar'><img src='imagens/desativar.gif' border='0' alt=Desativar Estabelecimento/></a>" : "<img src='imagens/desativar.gif' border='0' alt=Desativar Estabelecimento title='Sem permissão para Desativar'/>" ?> </td>
          <td style='text-align: center'><? echo ($nivel < 2) ? "<a class='tipo_doc' href='views/estabelecimento_tipos/index.php?id_estabelecimento={$linha->id}' title='Inserir Tipos'><img src='imagens/tipo_doc.gif' border='0' alt='Inserir Tipos'/></a>" : "<img src='imagens/tipo_doc.gif' border='0' alt='Inserir Tipos' title='Sem permissão para Inserir Tipos'/>" ?></td>
          <td style='text-align: center'><? echo ($nivel < 2) ? "<a class='teto' href='views/tetos_por_estabelecimento/index.php?id_estabelecimento={$linha->id}&id_competencia=$cmpt' title='Tetos Financeiros'><img src='imagens/tetos.gif' border='0' alt='Tetos Financeiros'/></a>" : "<img src='imagens/tetos.gif' border='0' alt='Inserir Tipos' title='Sem permissão para Visualizar Tetos'/>" ?></td>
        </tr>
      <?php } ?>
    </table>
    <br/><br/>
    <?php echo ($nivel < 2) ? "<a class='novo_estabelecimento' href='views/estabelecimentos/cadastro.php'>Novo Estabelecimento</a>" : ""; ?>
  </body>
</HTML>