<?php
if (defined('ROOT_APP') == false) {
  define('ROOT_APP', $_SERVER['DOCUMENT_ROOT'] . "/sga");
}
require_once(ROOT_APP.'/class/Competencia.class.php');
require_once(ROOT_APP.'/class/Estabelecimento.class.php');


$cmpt = isset($_REQUEST['id_competencia'])     ? $_REQUEST['id_competencia']     : null;
$ups  = isset($_REQUEST['id_estabelecimento']) ? $_REQUEST['id_estabelecimento'] : null;
$nome_unidade = null;
$str_competencia = null;

$unidade = new Estabelecimento();
$unidade->valorpk = $ups;
$unidade->seleciona($unidade);
while($linha_unidade = $unidade->retornaDados()){
  $nome_unidade = $linha_unidade->nome_fantasia;
}

$competencia = new Competencia();
$competencia->valorpk = $cmpt;
$competencia->extensoCompetencia($competencia);
while($linha_competencia = $competencia->retornaDados()){
  $str_competencia = $linha_competencia->cmpt;
}
?>
<html>
  <head>
    <script type="text/javascript">
      $(function($){
        $('form#cadastrar_teto').submit(function(){
          $(this).ajaxSubmit(function(retorno){
            if(!retorno){
              alert('Teto Financeiro Gravado.');
              $('div#right').load("views/tetos_por_estabelecimento/index.php?id_estabelecimento=<?= $cmpt; ?>&id_competencia=<?=$ups ?>");
            } else{
              $('div#mensagem-erro').html(retorno);
            }
          });
          return false;
        });
      });
    </script>
  </head>
  <body>
    <form name="cadastrar_teto" id="cadastrar_teto" class="campo" action="model/estabelecimento_teto.php?acao=inserir" style="border: none" method="post">
      <fieldset style="margin-top: 6px; border: 1px solid; padding: 10px;">
        <legend>CADASTRO DE TETOS FINANCEIROS</legend>
        <input type="hidden" name="id_competencia" value="<?= $cmpt ?>" />
        <input type="hidden" name="id_unidade"     value="<?= $ups; ?>" />
        Estabelecimento: <?=$nome_unidade; ?><br/>
        Competência: <?= $str_competencia; ?>
        <label>Valor Teto: <input type="text" name="valor_teto" size="15" class="campo" value="0.00"></label>
        <label>Valor Médio: <input type="text" name="valor_medio" size="15" class="campo" value="0.00"></label>
        <label>Valor Saldo: <input type="text" name="valor_saldo" size="15" class="campo" value="0.00" disabled></label>
        <label><input type="submit" value="Gravar" style="width: 85px"></label>
      </fieldset>
    </form>
    <div id="mensagem-erro" class="mensagem-erro"></div>
  </body>
</html>
