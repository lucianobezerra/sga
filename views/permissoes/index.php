<?php
define('DS', DIRECTORY_SEPARATOR);
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Operador.class.php');
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Permissao.class.php');
$id_operador = isset($_REQUEST['id_operador']) ? $_REQUEST['id_operador'] : null;

$operadores = new Operador();
$operadores->extras_select = "where id=$id_operador";
$operadores->selecionaNome($operadores);

$permissoes = new Permissao();
$permissoes->extras_select = "where permissoes.id_operador=$id_operador and estabelecimentos.ativo";
$permissoes->selecionaTudo($permissoes);
?>
<html>
  <head>
    <script type="text/javascript">
      function excluir(id){
        $.post('model/permissao?acao=excluir',
        {id: +id, ajax: true},
        function(resposta){
          if(!resposta){
            $('#row_'+id).fadeOut('slow');
            $('#retorno').html('Permissão Excluida.');
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
        $('.nova_permissao').click(function(){
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
          <th colspan="7" style='text-align: center; font-size: 10pt'>OPERADOR:
            <?php
            $operador = $operadores->retornaDados("array");
            echo $operador['nome'];
            ?>
          </th>
        </tr>
        <tr>
          <th >Permissões</th>
          <th style='text-align: center;'>Ação</th>
        </tr>
      </thead>
      <?php while ($linha = $permissoes->retornaDados()) { ?>
        <tr id="row_<?= $linha->id; ?>">
          <td><?= $linha->nome_fantasia; ?> </td>
          <td style="text-align: center;"><a class="excluir" href="#" onclick="excluir(<?= $linha->id; ?>)" title="Excluir"><img src="imagens/excluir.png" border="0"/></a></td>
        </tr>
      <?php } ?>
    </table>
    <br/><a class="nova_permissao" href="views/permissoes/cadastro.php?id_operador=<?= $id_operador; ?>">Cadastrar Permissão</a>
  </body>
</html>