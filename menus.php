<?php
//$nivel = $_SESSION['nivel'];
?>
<dl>
  <dt id="inicio"><a href="home.php">Início</a></dt>
  <dt><a href="#">Tabelas Básicas</a></dt>
  <dd>
    <ul>
      <li><a href="views/estabelecimentos/index.php">Estabelecimentos</a></li>
      <li><a href="views/competencias/index.php">Competências</a></li>
      <li><a href="views/tipos/index.php">Tipos de Autorização</a></li>
      <li><a href="views/faixas/index.php">Faixas de Autorização</a></li>
      <li><a href="views/operadores/index.php">Operadores</a></li>
    </ul>
  </dd>
  <dt><a href="#">Autorização</a></dt>
  <dd>
    <ul>
      <li><a href="views/autorizacoes/cadastro.php">Emissão</a></li>
      <li><a href="views/autorizacoes/pesquisar.php">Pesquisa</a></li>
      <li><a href="views/autorizacoes/listagem.php">Relatório</a></li>
      <li><a href="views/autorizacoes/resumo.php">Resumo</a></li>
    </ul>
  </dd>
    <dt><a href="#">Manutenção</a></dt>
    <dd>
      <ul>
        <li><?php //echo ($nivel <= 1) ? "<a href='views/faixas/ajustar.php'>Ajustar Faixa</a>" : "<span style='color:#03C; padding:5px; font-size: 14px; font-family: arial, helvetica, serif;'>Ajustar Faixa</span>" ?></li>
      </ul>
    </dd>
  <dt><a class="sair" href="sair.php">Sair do Sistema</a></dt>
</dl>
