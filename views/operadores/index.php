<?php
define('DS', DIRECTORY_SEPARATOR);
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Login.class.php');
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Operador.class.php');
$login = new Login();
$nivel = $login->getNivel();

$operador = new Operador();
$operador->extras_select = "where ativo order by id";
$operador->selecionaTudo($operador);
?>
<html>
  <head>
    <script type="text/javascript">
      function desativar(id){
        $.post('model/operador.php?acao=desativar',
        {id: +id, ajax: true},
        function(resposta){
          if(!resposta){
            $('#row_'+id).fadeOut('slow');
            $('#retorno').html('Operador Desativado!');
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
        $.post('model/operador.php?acao=excluir',
        {id: +id, ajax: true},
        function(resposta){
          if(!resposta){
            $('#row_'+id).fadeOut('slow');
            $('#retorno').html('Operador Excluido');
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
        $('.novo_operador').click(function(){
          $('div#right').load($(this).attr('href'));
          return false;
        });
        
        $('.alterar').click(function(){
          $('div#right').load($(this).attr('href'));
          return false;
        });
        $('.permissao').click(function(){
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
          <th colspan="7" style='text-align: center; font-size: 12pt'>Operadores Ativos</th>
        </tr>
        <tr>
          <th >Login</th>
          <th >Nome Completo</th>
          <th >Nível</th>
          <th colspan="4" style='text-align: center;'>Ação</th>
        </tr>
      </thead>
      <?php while ($linha = $operador->retornaDados()) { ?>
        <tr id="row_<?= $linha->id; ?>">
          <td><?= $linha->login ?></td>
          <td><?= $linha->nome ?></td>
          <td>
            <?php
            switch ($linha->nivel) {
              case 0: echo 'Master';  break;
              case 1: echo 'Sênior';  break;
              case 2: echo 'Pleno';   break;
              case 3: echo 'Júnior';  break;
            }
            ?>
          </td>
          <td style='text-align: center;'><a class='alterar' href='views/operadores/alterar.php?id=<?= $linha->id; ?>' title="Alterar"><img src="imagens/alterar.gif" border="0" alt=""/></a></td>
          <td style='text-align: center;'><a class='desativar' href='#' onClick='desativar(<?= $linha->id; ?>)' title="Desativar"><img src="imagens/desativar.gif" border="0" alt=""/></a></td>
          <td style='text-align: center;'><a class='excluir' href='#' onClick="excluir(<?= $linha->id ?>)" title="Excluir"><img src="imagens/excluir.png" border="0" alt=""/></a></td>
          <td style='text-align: center;'><a class='permissao' href='views/permissoes/index.php?id_operador=<?=$linha->id ?>' title="Permissões"><img src="imagens/permissoes.gif" border="0" alt=""/></a></td>
        </tr>
      <?php } ?>
    </table>
    <br/><? echo ($nivel < 2) ? "<a class='novo_operador' href='views/operadores/cadastro.php'>Novo Operador</a>" : ""; ?>
  </body>
</html>