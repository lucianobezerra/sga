<?php
define( 'DS', DIRECTORY_SEPARATOR );
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Competencia.class.php');
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Login.class.php');
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'util' . DS . 'funcoes.php');
$login = new Login();
$nivel = $login->getNivel();

$competencia = new Competencia();
$competencia->extras_select = "where ativo=true order by ano,mes";
$competencia->selecionaTudo($competencia);

echo "<p style='text-align: right'>OPERADOR: ".$_SESSION['nome']."</p>";
?>
<html>
  <head>
    <script type="text/javascript">
      function excluir(id){
        $.post('model/competencia.php?acao=excluir',
        {id: +id, ajax: true},
        function(resposta){
          if(!resposta){
            $('#row_'+id).fadeOut('slow');
            $('#retorno').html('Registro Excluido');
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
        $.post('model/competencia.php?acao=desativar',
        {id: +id, ajax: true},
        function(resposta){
          if(!resposta){
            $('#row_'+id).fadeOut('slow');
            $('#retorno').html('Competência Desativada');
            $('#retorno').fadeIn('slow');
            $('#retorno').delay(2000).fadeOut(1000);
          } else {
            $('#retorno').html(resposta);
            $('#retorno').fadeIn('slow');
            $('#retorno').delay(2000).fadeOut(1000);
          }
        });
      }
      
      $(function($){
        $('tbody tr:odd').addClass('odd');
        $('.nova_competencia').click(function(){
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
    <table width="100%" border="1" align="center" style="margin-top: 2px;font-size: 10pt; line-height: 130%">
      <thead>
        <tr>
          <th colspan="5" style='text-align: center; font-size: 12pt'>Competências Cadastradas</th>
        </tr>
        <tr>
          <th>Competência</th>
          <th style='text-align: center'>Ativo</th>
          <th colspan="3" style='text-align: center'>Ação</th>
        </tr>
      </thead>
      <?php
      while ($linha = $competencia->retornaDados()) {
        $ativo = $linha->ativo == true ? "Sim" : "Não";
        $cmpt = formata_competencia(trim($linha->ano) . '-' . trim($linha->mes) . '-01');
        ?>
        <tr id='row_<?= $linha->id; ?>'>
          <td><?= $cmpt ?></td>
          <td style='text-align: center'><?= $ativo ?></td>
          <td style='text-align: center'><? echo ($nivel < 2) ? "<a class='alterar' href='views/competencias/alterar.php?id=$linha->id' title='Alterar'><img src='imagens/alterar.gif' border='0' alt='Alterar' /></a>" : "<img src='imagens/alterar.gif' border='0' alt='Alterar' />"; ?></td>
          <td style='text-align: center'><? echo ($nivel < 2) ? "<a href='#' onClick='excluir($linha->id)' title='Excluir'><img src='imagens/excluir.png' border='0' alt='Excluir' /></a>" : "<img src='imagens/excluir.png' border='0' alt='Excluir' />"; ?></td>
          <td style='text-align: center'><? echo ($nivel < 2) ? "<a href='#' onClick='desativar($linha->id)' title='Desativar'><img src='imagens/desativar.gif' border='0' alt='Desativar' /></a>" : "<img src='imagens/desativar.gif' border='0' alt='Desativar' />"; ?></td>
        </tr>
      <? } ?>
    </table>
    <br/>
    <br/>
    <?php echo ($nivel < 2) ? "<a class='nova_competencia' href='views/competencias/cadastro.php'>Nova Competência</a>" : ""; ?>
  </body>
</html>