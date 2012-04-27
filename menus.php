<?php
require_once(dirname(__FILE__) . DS . 'class' . DS . 'Operador.class.php');
require_once(dirname(__FILE__) . DS . 'util' . DS . 'funcoes.php');

$nivel = retornaNivel();

?>
<dl>
  <dt id="inicio"><a href="home.php">Início</a></dt>
  <dt><a href="#">Tabelas Básicas</a></dt>
  <dd>
    <ul>
      <li><a href="views/procedimentos/index.php">Procedimentos</a></li>
      <li><a href="views/diagnosticos/index.php">Diagnósticos</a></li>
    </ul>
  </dd>
  <dt><a href="#">Cadastros</a></dt>
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
      <li><a href="views/manutencao/alterar_senha.php">Alterar Senha</a></li>
    </ul>
  </dd>
  <dt><a class="sair" href="sair.php">Sair do Sistema</a></dt>
</dl>
