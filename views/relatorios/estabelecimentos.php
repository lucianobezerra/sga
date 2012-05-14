<?php
if (defined('ROOT_APP') == false) {
  define('ROOT_APP', $_SERVER['DOCUMENT_ROOT'] . "/sga");
}

require_once(ROOT_APP . '/class/Conexao.class.php');

$conexao = new Conexao('sga2');
$conexao->open();

$sql = "select estabelecimentos.cnes, estabelecimentos.razao_social, tetos_por_estabelecimento.valor_teto, ";
$sql .= "tetos_por_estabelecimento.valor_medio, tetos_por_estabelecimento.valor_saldo ";
$sql .= "from estabelecimentos ";
$sql .= "inner join tetos_por_estabelecimento on estabelecimentos.id = tetos_por_estabelecimento.id_estabelecimento ";
$sql .= "order by cnes";

$result = pg_query($sql);
if ($result) {
  ?>
  <table width="100%" border="1" align="center" style="margin-top: 6px;">
    <thead>
      <tr>
        <th colspan="7" style="text-align: center; font-size: 10pt;">LISTAGEM DE ESTABELECIMENTOS</th>
      </tr>
      <tr>
        <th style="text-align: center; font-size: 9pt; width: 10%;">CNES</th>
        <th style="text-align: left;   font-size: 9pt; width: 54%;">NOME DO ESTABELECIMENTO</th>
        <th style="text-align: right;  font-size: 9pt; width: 13%;">TETO</th>
        <th style="text-align: right;  font-size: 9pt; width: 10%;">MÉDIA</th>
        <th style="text-align: right;  font-size: 9pt; width: 13%;">SALDO</th>
      </tr>
    </thead>
    <?
    while ($linha = pg_fetch_object($result)) {
      ?>
      <tr>
        <td style="text-align: center; font-size: 9pt;"><?= $linha->cnes; ?></td>
        <td style="text-align: left;   font-size: 9pt;"><?= $linha->razao_social; ?></td>
        <td style="text-align: right;  font-size: 9pt;"><?= number_format($linha->valor_teto, 2, ',', '.'); ?></td>
        <td style="text-align: right;  font-size: 9pt;"><?= number_format($linha->valor_medio, 2, ',', '.'); ?></td>
        <td style="text-align: right;  font-size: 9pt;"><?= number_format($linha->valor_saldo, 2, ',', '.'); ?></td>
      </tr>
      <?
    }
    $sql = "select sum(tetos_por_estabelecimento.valor_teto) as soma_teto, avg(tetos_por_estabelecimento.valor_medio) valor_medio, sum(tetos_por_estabelecimento.valor_saldo) as soma_saldo
        from estabelecimentos
        inner join tetos_por_estabelecimento on estabelecimentos.id = tetos_por_estabelecimento.id_estabelecimento";
    $result = pg_query($sql);
    $soma = pg_fetch_array($result);
    ?>
    <tr>
      <td colspan="2"  style="text-align: right;  font-size: 9pt;">TOTALIZAÇÃO</td>
      <td style="text-align: right;  font-size: 9pt;"><?= number_format($soma['soma_teto'], 2, ',', '.'); ?></td>
      <td style="text-align: right;  font-size: 9pt;"><?= number_format($soma['valor_medio'], 2, ',', '.'); ?></td>
      <td style="text-align: right;  font-size: 9pt;"><?= number_format($soma['soma_saldo'], 2, ',', '.'); ?></td>
    </tr>

    <? $conexao->close();
  }
  ?>
</table>