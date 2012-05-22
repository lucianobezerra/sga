<?php

if (defined('ROOT_APP') == false) {
  define('ROOT_APP', $_SERVER['DOCUMENT_ROOT'] . "/sga");
}

require_once(ROOT_APP . '/class/Conexao.class.php');

$unidade = isset($_REQUEST['unidade'])         ? $_REQUEST['unidade']     : null;
$competencia = isset($_REQUEST['competencia']) ? $_REQUEST['competencia'] : null;

$valor_saldo = null;
$result = null;

$conexao = new Conexao("sga2");
$conexao->open();
$sql = "select (tetos_por_estabelecimento.valor_teto - sum(procedimentos.valor_sa + procedimentos.valor_sh + procedimentos.valor_sp)) as valor_saldo ";
$sql .= "from autorizacoes ";
$sql .= "inner join tetos_por_estabelecimento on autorizacoes.id_estabelecimento = tetos_por_estabelecimento.id_estabelecimento and autorizacoes.id_competencia = tetos_por_estabelecimento.id_competencia ";
$sql .= "inner join procedimentos on autorizacoes.id_procedimento = procedimentos.id and autorizacoes.id_competencia = procedimentos.id_competencia ";
$sql .= "where autorizacoes.id_competencia={$competencia} and autorizacoes.id_estabelecimento={$unidade} ";
$sql .= "group by tetos_por_estabelecimento.valor_teto";
$result = pg_query($sql) or die(pg_last_error());
if(pg_num_rows($result) != 0):
  $valor_saldo = pg_fetch_result($result, 0, 0);
else:
  $sql = "select valor_teto from tetos_por_estabelecimento ";
  $sql .= "where id_competencia={$competencia} and id_estabelecimento={$unidade}";
  $result = pg_query($sql);
  $valor_saldo = pg_fetch_result($result, 0, 0);
endif;
$conexao->close();


$conexao = new Conexao("sga2");
$conexao->open();
$sql = "update tetos_por_estabelecimento set valor_saldo={$valor_saldo} where id_competencia={$competencia} and id_estabelecimento={$unidade}";
$result = pg_query($sql);
if($result):
  pg_query('commit');
  echo 'Saldo Atualizado!';
endif;
$conexao->close();

?>
