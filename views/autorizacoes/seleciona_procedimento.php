<?php
require_once('../../class/Conexao.class.php');
require_once('../../class/Competencia.class.php');
require_once('../../class/Sessao.class.php');

$session = new Session();
$session->start();

$tipo = $session->getNode("id_tipo");
$cmpt = $session->getNode("id_competencia");

?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="/sga/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="/sga/css/main.css"/>
    <script type="text/javascript">
      function retorna(id, codigo, nome){
        window.opener.document.autorizacao.hidden_procedimento.value = id;
        window.opener.document.autorizacao.id_procedimento.value     = codigo;
        window.opener.document.autorizacao.nome_procedimento.value   = nome;
        window.close();
      }
    </script>
  </head>
  <body>
    <form name="seleciona_procedimento" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
      <fieldset style='padding: 4px; margin: 4px; border: solid 1px; font-size: 9pt; width: 770px;'>
        <legend style="font-size: 11pt;">&nbsp;&nbsp;Pesquisar Procedimento&nbsp;&nbsp;</legend>
        <label style="width: 770px;"><input type="text" name="descricao" size="55" class="campo" style="height: 22px; font-size: 11pt;"/>&nbsp;<input type="submit" name="submit" value="Pesquisar" style="width: 100px; height: 22px" class="botao" /></label>
      </fieldset>
    </form>

    <?php
    if (isset($_POST['submit'])) {
      $tipos = ($tipo == 1) ? '03' : '';
      $sql  = "select procedimentos.id, procedimentos.codigo, procedimentos.descricao from procedimentos ";
      $sql .= "inner join procedimentos_registros on procedimentos.codigo=procedimentos_registros.codigo_procedimento ";
      $sql .= "where procedimentos_registros.codigo_registro = '{$tipos}' and procedimentos_registros.id_competencia={$cmpt} ";
      $sql .= "and procedimentos.id_competencia={$cmpt} AND upper(procedimentos.descricao) like '%".strtoupper($_POST['descricao'])."%' ";
      $sql .= "order by procedimentos.descricao";
      $conexao = new Conexao('sga2');
      $conexao->open();
      $res = pg_query($sql);
      if ($res) {
        echo "<div style='width: 780px; margin: 0px; padding: 5px; border: none;'>";
        echo "<table border='1' width='100%'>";
        echo "  <tr>";
        echo "    <td width='12%'>Código</td>";
        echo "    <td>Descrição</td>";
        echo "  </tr>";
        while ($linha = pg_fetch_object($res)) {
          $codigo    = substr($linha->codigo, 0, 2).".".substr($linha->codigo, 2, 2).".".substr($linha->codigo, 4, 2).".".substr($linha->codigo, 6, 3)."-".substr($linha->codigo, 9, 1);
          $descricao = substr($linha->descricao, 0, 90); ?>
          <tr>
          <td style='font-size: 9pt;'><a href='#' onclick="javascript:retorna('<?=$linha->id; ?>', '<?=$linha->codigo; ?>','<?=$linha->descricao; ?>');"><?=$codigo; ?></a></td>
          <td style='font-size: 9pt;'><?=$descricao ?></td>
          </tr>
        <? }
        echo "</table>";
        echo "</div>";
      }
      $conexao->close();
    }
    ?>
  </body>
</html>
