<?php
require_once('../../class/Conexao.class.php');
require_once('../../class/Competencia.class.php');
require_once('../../class/Sessao.class.php');

$procedimento = $_GET['procedimento'];
$session = new Session();
$session->start();
$cmpt = $session->getNode("id_competencia");
?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="/sga/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="/sga/css/main.css"/>
    <script type="text/javascript">
      function retorna(id, codigo, nome){
        window.opener.document.autorizacao.hidden_diagnostico.value = id;
        window.opener.document.autorizacao.id_diagnostico.value     = codigo;
        window.opener.document.autorizacao.nome_diagnostico.value   = nome;
        window.close();
      }
    </script>
  </head>
  <body onload="document.seleciona_diagnostico.descricao.focus();">
    <?php
    $sql = "select procedimentos_cids.id, cids.codigo, cids.descricao ";
    $sql .= "from procedimentos_cids ";
    $sql .= "inner join cids on procedimentos_cids.codigo_cid = cids.codigo ";
    $sql .= "where procedimentos_cids.codigo_procedimento='{$procedimento}' and procedimentos_cids.id_competencia={$cmpt} order by cids.descricao";
    $conexao = new Conexao('sga2');
    $conexao->open();
    $res = pg_query($sql);
    if ($res) {
      echo "<div style='width: 780px; margin: 0px; padding: 5px; border: none;'>";
      echo "<table border='1' width='100%'>";
      echo "  <tr>";
      echo "    <td width='6%'>Código</td>";
      echo "    <td>Descrição</td>";
      echo "  </tr>";
      while ($linha = pg_fetch_object($res)) {
        ?>
      <tr>
        <td style='font-size: 9pt;text-align: center'><a href='#' onclick="javascript:retorna('<?= $linha->id; ?>', '<?= $linha->codigo; ?>','<?= $linha->descricao; ?>');"><?= $linha->codigo; ?></a></td>
        <td style='font-size: 9pt;'><?= $linha->descricao ?></td>
      </tr>
      <?
    }
    echo "</table>";
    echo "</div>";
  }
  $conexao->close();
  ?>
</body>
</html>
