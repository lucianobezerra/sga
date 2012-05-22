<?php
if (defined('ROOT_APP') == false) {
  define('ROOT_APP', $_SERVER['DOCUMENT_ROOT'] . "/sga");
}
require_once(ROOT_APP . '/class/Estabelecimento.class.php');
require_once(ROOT_APP . '/class/EstabelecimentoTeto.class.php');
require_once(ROOT_APP . '/class/Competencia.class.php');
require_once(ROOT_APP . '/util/funcoes.php');
$id_unidade = isset($_REQUEST['id_estabelecimento']) ? $_REQUEST['id_estabelecimento'] : null;
$id_competencia = isset($_REQUEST['id_competencia']) ? $_REQUEST['id_competencia'] : null;
$competencia_extenso = null;
$ups = new Estabelecimento();
$ups->valorpk = $id_unidade;
$ups->seleciona($ups);
$linha_unidade = $ups->retornaDados("array");

$cmpt = new Competencia();
$cmpt->valorpk = $id_competencia;
$cmpt->extensoCompetencia($cmpt);
while ($linha_cmpt = $cmpt->retornaDados()) {
  $competencia_extenso = $linha_cmpt->cmpt;
}

$teto = new EstabelecimentoTeto();
$teto->extras_select = "where id_estabelecimento={$id_unidade} and id_competencia={$id_competencia}";
$teto->selecionaTudo($teto);
?>
<html>
  <head>
    <script type="text/javascript">
      function ajustar(unidade, competencia){
        var url = 'views/tetos_por_estabelecimento/ajustar.php'
        $.post(url, {unidade: +unidade, competencia: +competencia, ajax: true}, function(resposta){
          alert('Saldo Atualizado');
          $('div#right').load('views/estabelecimentos/index.php');
        });
      }
      
      $(function(){
        $('tbody tr:odd').addClass('odd');
        $('.novo').click(function(){
          $('div#right').load($(this).attr('href'));
          return false;
        });
        
        $('.alterar').live('click', function(e){
          e.preventDefault();
          $('div#right').load($(this).attr('href'));
          return false;
        });        
      })
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
          <th style='text-align: center;'>Competência</th>
          <th style='text-align: right;'>Valor Teto</th>
          <th style='text-align: right;'>Valor Médio</th>
          <th style='text-align: right;'>Valor Saldo</th>
          <th colspan="3" style='text-align: center;'>Ação</th>
        </tr> 
      </thead>
      <?php while ($linha = $teto->retornaDados()) { ?>
        <tr id="row_<? echo $linha->id; ?>">
          <td><?= $competencia_extenso; ?></td>
          <td style='text-align: right;'><?= number_format($linha->valor_teto, 2, ',', '.'); ?></td>
          <td style='text-align: right;'><?= number_format($linha->valor_medio, 2, ',', '.'); ?></td>
          <td style='text-align: right;'><?= number_format($linha->valor_saldo, 2, ',', '.'); ?></td>
          <td style='text-align: center;'><a class='alterar' href="views/tetos_por_estabelecimento/alterar.php?id=<?= $linha->id; ?>&id_unidade=<?= $linha->id_estabelecimento; ?>&id_competencia=<?= $id_competencia; ?>" title='Alterar'><img src='imagens/alterar.gif' border='0' alt='Alterar'/></a></td>
          <td style="text-align: center;"><a class="excluir" href="#" onclick="excluir(<?= $linha->id; ?>)" title="Excluir"><img src="imagens/excluir.png" border="0"/></a></td>
          <td style="text-align: center;"><a class="ajustar" href="#" onclick="ajustar(<?= $linha->id_estabelecimento; ?>, <?=$linha->id_competencia; ?>)" title="Ajustar"><img src="imagens/ajustar.png" border="0"/></a></td>
        </tr>
      <? } ?>
    </table>
    <br/>
    <a class="novo" href="views/tetos_por_estabelecimento/cadastro.php?id_estabelecimento=<?= $linha_unidade['id']; ?>&id_competencia=<?= $id_competencia; ?>">Cadastrar Novo Teto</a>
  </body>
</html>
