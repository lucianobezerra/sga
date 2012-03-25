<?php
define( 'DS', DIRECTORY_SEPARATOR );
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Estabelecimento.class.php');
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'EstabelecimentoTipo.class.php');
$id = $_REQUEST['id_estabelecimento'];

$ups = new Estabelecimento();
$ups->valorpk = $id;
$ups->seleciona($ups);
$linha_unidade = $ups->retornaDados("array");

$tipo_e = new EstabelecimentoTipo();
$tipo_e->extras_select = "where est.id=$id";
$tipo_e->selecionaTudo($tipo_e);

?>
<html>
  <head>
    <script type="text/javascript">
      function excluir(id){
        $.post('model/estabelecimento_tipo.php',
        {acao: 'excluir', id: +id, ajax: true},
        function(resposta){
          if(!resposta){
            $('#row_'+id).fadeOut('slow');
            $('#retorno').html('Tipo Excluido.');
            $('#retorno').fadeIn('slow');
            $('#retorno').delay(3000).fadeOut(1000);
          } else {
            $('#retorno').html(resposta);
            $('#retorno').fadeIn('slow');
            $('#retorno').delay(3000).fadeOut(1000);
          }
        });
      }
      $(function($){
        $('tbody tr:odd').addClass('odd');
        $('.novo_tipo').click(function(){
          $('div#right').load($(this).attr('href'));
          return false;
        });
      });
    </script>
  </head>
  <body>
    <div id="retorno" style="color: red; font-weight: bold; margin-top: 8px;"></div>
    <table width="100%" border="1" align="center" style="margin-top: 8px;font-size: 10pt; line-height: 140%">
      <thead>
        <tr>
          <th colspan="7" style='text-align: center; font-size: 10pt'>ESTABELECIMENTO: <?= $linha_unidade['nome_fantasia']; ?></th>
        </tr>
        <tr>
          <th >TIPOS DE AUTORIZAÇÃO</th>
          <th style='text-align: center;'>Ação</th>
        </tr>
      </thead>
      <?php while ($linha = $tipo_e->retornaDados()) { ?>
        <tr id="row_<? echo $linha->id; ?>">
          <td><?= $linha->descricao; ?></td>
          <td style="text-align: center;"><a class="excluir" href="#" onclick="excluir(<?= $linha->id; ?>)" title="Excluir"><img src="imagens/excluir.png" border="0"/></a></td>
        </tr>
      <? } ?>
    </table>
    <br/><a class="novo_tipo" href="views/estabelecimento_tipos/cadastro.php?id_estabelecimento=<?=$linha_unidade['id']; ?>">Inserir Tipo</a>
  </body>
</html>
