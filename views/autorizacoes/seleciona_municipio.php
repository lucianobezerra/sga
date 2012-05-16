<?php
require_once('../../class/Conexao.class.php');
require_once('../../class/Cidade.class.php');
?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="/sga/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="/sga/css/main.css"/>
    <script type="text/javascript">
      function retorna(id, codigo, nome, uf_id){
        window.opener.document.autorizacao.hidden_municipio.value = id;
        window.opener.document.autorizacao.id_municipio.value     = codigo;
        window.opener.document.autorizacao.nome_municipio.value   = nome;
        window.opener.document.autorizacao.hidden_estado.value    = uf_id
        window.close();
      }
    </script>
  </head>
  <body>
    <form name="seleciona_municipio" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
      <fieldset style='padding: 4px; margin: 4px; border: solid 1px; font-size: 9pt; width: 570px;'>
        <legend style="font-size: 11pt;">&nbsp;&nbsp;Pesquisar Municipios&nbsp;&nbsp;</legend>
        <label style="width: 560px;"><input type="text" name="descricao" size="50" class="campo" style="height: 22px; font-size: 11pt;"/>&nbsp;<input type="submit" name="submit" value="Pesquisar" style="width: 100px; height: 22px" class="botao" /></label>
      </fieldset>
    </form>

    <?php
    if (isset($_POST['submit'])) {
      $sql  = "select cidades.id, cidades.codigo, cidades.descricao, estados.sigla ";
      $sql .= "from cidades ";
      $sql .= "inner join estados on cidades.estado_id = estados.id ";
      $sql .= "where upper(cidades.descricao) like '%".strtoupper($_POST['descricao'])."%' ";
      $sql .= "order by cidades.codigo, cidades.descricao";

      $conexao = new Conexao('sga2');
      $conexao->open();
      $res = pg_query($sql);
      if ($res) {
        echo "<div style='width: 580px; margin: 0px; padding: 5px; border: none;'>";
        echo "<table border='1' width='100%'>";
        echo "  <tr>";
        echo "    <td width='12%'>Código</td>";
        echo "    <td>Descrição</td>";
        echo "    <td width='6%' align='center'>UF</td>";
        echo "  </tr>";
        while ($linha = pg_fetch_object($res)) {
          $codigo    = substr($linha->codigo, 0, 6)."-".substr($linha->codigo, 6, 1);
         ?>
          <tr>
            <td style='font-size: 9pt;'><a href='#' style="text-decoration: none" onclick="javascript:retorna('<?=$linha->id; ?>', '<?=$linha->codigo; ?>','<?=$linha->descricao; ?>', '<?=$linha->sigla; ?>');"><?=$codigo; ?></a></td>
          <td style='font-size: 9pt;'><?=$linha->descricao; ?></td>
          <td style='font-size: 9pt; text-align: center'><?=$linha->sigla; ?></td>
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
