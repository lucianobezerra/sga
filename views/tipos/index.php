<?php
define( 'DS', DIRECTORY_SEPARATOR );
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Tipo.class.php');
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Login.class.php');
$login = new Login();
$nivel = $login->getNivel();

$tipos = new Tipo();
$tipos->extras_select = "where ativo order by id";
$tipos->selecionaTudo($tipos);
?>
<html>
  <head>
    <script type="text/javascript">
      function excluir(id){
        $.post('model/tipo.php?acao=excluir',
        {id: +id, ajax: true},
        function(resposta){
          if(!resposta){
            $('#row_'+id).fadeOut('slow');
            $('#retorno').html('Registro Excluido.');
            $('#retorno').fadeIn('slow');
            $('#retorno').delay(2000).fadeOut(1000);
          } else {
            $('#retorno').html(resposta);
            $('#retorno').fadeIn('slow');
            $('#retorno').delay(2000).fadeOut(1000);
          }
        });
      }
      
      function desativar(id){
        $.post('model/tipo.php?acao=desativar',
        {id: +id, ajax: true},
        function(resposta){
          if(!resposta){
            $('#row_'+id).fadeOut('slow');
            $('#retorno').html('Tipo Desativado!');
            $('#retorno').fadeIn('slow');
            $('#retorno').delay(4000).fadeOut(1000);
          } else {
            $('#retorno').html(resposta);
            $('#retorno').fadeIn('slow');
            $('#retorno').delay(4000).fadeOut(1000);
          }
        });      }
      
      $(function($){
        $('tbody tr:odd').addClass('odd');
        $('.novo_tipo').click(function(){
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
    <div id="retorno" style="color: red; font-weight: bold;"></div>
    <table width="100%" border="1" align="center" style="margin-top: 12px;font-size: 10pt; line-height: 140%">
      <thead>
        <tr>
          <th colspan="6" style='text-align: center; font-size: 12pt; margin-top: 14px;'>Tipos de Autorização</th>
        </tr>
        <tr>
          <th style='text-align: center' width="10%">Código</th>
          <th width="70%">Descrição</th>
          <th colspan="3" style='text-align: center' width="20%">Ação</th>
        </tr>
      </thead>
      <?php
      while($linha = $tipos->retornaDados()){
      ?>
        <tr id='row_<?= $linha->id ?>'>
          <td style='text-align: center'><?= str_pad($linha->codigo, 3, '0', STR_PAD_LEFT) ?></td>
          <td><?= $linha->descricao; ?></td>
          <td style='text-align: center'><? echo ($nivel < 2) ? "<a class='alterar' href='views/tipos/alterar.php?id={$linha->id}' title='Alterar'><img src='imagens/alterar.gif' border='0' alt='Desativar'/></a>" : "<img src='imagens/alterar.gif' border='0' alt='Desativar'/>" ?></td>
          <td style='text-align: center'><? echo ($nivel < 2) ? "<a href='#' onClick='excluir({$linha->id})' title='Excluir'><img src='imagens/excluir.png' border='0' alt='Excluir'/></a>" : "<img src='imagens/excluir.png' border='0' alt='Excluir'/>"; ?></td>
          <td style='text-align: center'><? echo ($nivel < 2) ? "<a href='#' onClick='desativar({$linha->id})' title='Desativar'><img src='imagens/desativar.gif' border='0' alt='Desativar'/></a>" : "<img src='imagens/desativar.gif' border='0' alt='Desativar'/>"; ?></td>
        <?
      }
        ?>
    </table>
    <br/><br/><? echo ($nivel < 2) ? "<a class='novo_tipo' href='views/tipos/cadastro.php'>Novo Tipo</a>" : ""; ?>
  </body>
</html>
