<?php

if (defined('ROOT_APP') == false) {
  define('ROOT_APP', $_SERVER['DOCUMENT_ROOT'] . '/sga');
}

if (defined('ROOT_IMP') == false) {
  define('ROOT_IMP', ROOT_APP . '/importar');
}

require_once(ROOT_APP . '/util/funcoes.php');
require_once(ROOT_APP . '/class/Conexao.class.php');


/* * *************************************************************************************
  Bloco para importar Tabela de Procedimentos
 * ************************************************************************************* *
echo "";
echo "";
echo "";
echo "Preparando ambiente para Importação das Tabelas Nacionais...<br/><br/>";
echo "Iniciando a importação de Procedimentos (tb_procedimento.txt)<br/>";
if (($arquivo = fopen(ROOT_IMP . '/tb_procedimento.txt', 'r'))) {
  $lines = array();
  while (( $linha = fgets($arquivo, 1024))) {
    $lines[] = sprintf('("%s")', implode('","', array(
                trim(substr($linha, 0, 10)),
                utf8_encode(trim(substr($linha, 10, 250))),
                trim(substr($linha, 261, 1)),
                trim(substr($linha, 274, 4)),
                trim(substr($linha, 278, 4)),
                trim(substr($linha, 282, 10)) / 100,
                trim(substr($linha, 292, 10)) / 100,
                trim(substr($linha, 302, 10)) / 100,
                trim(substr($linha, 320, 6)),
                0)));
  }
  fclose($arquivo);

  $sql = sprintf('INSERT INTO procedimentos (codigo, descricao, sexo, idade_minima, idade_maxima, valor_sh, valor_sa, valor_sp, cmpt, competencia_id) VALUES %s', implode(',', array_slice($lines, 0)));
  $sql = str_replace('"', "'", $sql);
  $conexao = new Conexao('sga2');
  $conexao->open();
  pg_query($sql);
  $conexao->close();
}

/* * *************************************************************************************
  Bloco para importar Tabela de Diagnósticos
 * ************************************************************************************* *
echo "Iniciando a importação de Diagnósticos (tb_cid.txt)<br/>";
if (($arquivo = fopen(ROOT_IMP . '/tb_cid.txt', 'r'))) {
  $lines = array();
  while (( $linha = fgets($arquivo, 1024))) {
    $lines[] = sprintf('("%s")', implode('","', array(
                trim(substr($linha, 0, 4)),
                utf8_encode(trim(substr($linha, 4, 100))),
                trim(substr($linha, 105, 1)))));
  }
  fclose($arquivo);

  $sql = sprintf('INSERT INTO cids (codigo, descricao, sexo) VALUES %s', implode(',', array_slice($lines, 0)));
  $sql = str_replace('"', "'", $sql);
  $conexao = new Conexao('sga2');
  $conexao->open();
  pg_query($sql);
  $conexao->close();
}

/* * *************************************************************************************
  Bloco para importar Tabela de Detalhes
 * ************************************************************************************* *
echo "Iniciando a importação de Detalhes (tb_detalhe.txt)<br/>";
if (($arquivo = fopen(ROOT_IMP . '/tb_detalhe.txt', 'r'))) {
  $lines = array();
  while (( $linha = fgets($arquivo, 1024))) {
    $lines[] = sprintf('("%s")', implode('","', array(
                trim(substr($linha, 0, 3)),
                utf8_encode(trim(substr($linha, 3, 100))),
                trim(substr($linha, 103, 6)))));
  }
  fclose($arquivo);

  $sql = sprintf('INSERT INTO detalhes (codigo, descricao, cmpt) VALUES %s', implode(',', array_slice($lines, 0)));
  $sql = str_replace('"', "'", $sql);
  $conexao = new Conexao('sga2');
  $conexao->open();
  pg_query($sql);
  $conexao->close();
}

/* * *************************************************************************************
  Bloco para importar Tabela de Tipos de Registro de Atendimento
 * ************************************************************************************* */
echo "Iniciando a importação de Registros (tb_registro.txt)<br/>";
if (($arquivo = fopen(ROOT_IMP . '/tb_registro.txt', 'r'))) {
  $lines = array();
  while (( $linha = fgets($arquivo, 1024))) {
    $lines[] = sprintf('("%s")', implode('","', array(
                trim(substr($linha, 0, 2)),
                utf8_encode(trim(substr($linha, 2, 50))),
                trim(substr($linha, 52, 6)))));
  }
  fclose($arquivo);

  $sql = sprintf('INSERT INTO registros (codigo, descricao, cmpt) VALUES %s', implode(',', array_slice($lines, 0)));
  $sql = str_replace('"', "'", $sql);
  $conexao = new Conexao('sga2');
  $conexao->open();
  pg_query($sql);
  $conexao->close();
}

  /* * *************************************************************************************
  Bloco para importar Tabela de Relacionamento entre Procedimento e Cid10
 * ************************************************************************************* *
echo "Iniciando a importação de Relacionamento entre Procedimento e Cid10 (rl_procedimento_cid.txt)<br/>";
if (($arquivo = fopen(ROOT_IMP . '/rl_procedimento_cid.txt', 'r'))) {
  $lines = array();
  while (( $linha = fgets($arquivo, 1024))) {
    $lines[] = sprintf('("%s")', implode('","', array(
                trim(substr($linha, 0, 10)),
                trim(substr($linha, 10, 4)),
                trim(substr($linha, 15, 6)))));
  }
  fclose($arquivo);

  $sql = sprintf('INSERT INTO procedimentos_cids (codigo_procedimento, codigo_cid, cmpt) VALUES %s', implode(',', array_slice($lines, 0)));
  $sql = str_replace('"', "'", $sql);
  $conexao = new Conexao('sga2');
  $conexao->open();
  pg_query($sql);
  $conexao->close();
}

/* * *************************************************************************************
  Bloco para importar Tabela de Relacionamento entre Procedimento e Detalhes
 * ************************************************************************************* *
echo "Iniciando a importação de Relacionamento entre Procedimento e Detalhes (rl_procedimento_detalhe.txt)<br/>";
if (($arquivo = fopen(ROOT_IMP . '/rl_procedimento_detalhe.txt', 'r'))) {
  $lines = array();
  while (( $linha = fgets($arquivo, 1024))) {
    $lines[] = sprintf('("%s")', implode('","', array(
                trim(substr($linha, 0, 10)),
                trim(substr($linha, 10, 3)),
                trim(substr($linha, 13, 6)))));
  }
  fclose($arquivo);

  $sql = sprintf('INSERT INTO procedimentos_detalhes (codigo_procedimento, codigo_detalhe, cmpt) VALUES %s', implode(',', array_slice($lines, 0)));
  $sql = str_replace('"', "'", $sql);
  $conexao = new Conexao('sga2');
  $conexao->open();
  pg_query($sql);
  $conexao->close();
}
/* * *************************************************************************************
  Bloco para importar Tabela de Relacionamento entre Procedimento e Registros
 * ************************************************************************************* */
echo "Iniciando a importação de Relacionamento entre Procedimento e Registros (rl_procedimento_registro.txt)<br/>";
if (($arquivo = fopen(ROOT_IMP . '/rl_procedimento_registro.txt', 'r'))) {
  $lines = array();
  while (( $linha = fgets($arquivo, 1024))) {
    $lines[] = sprintf('("%s")', implode('","', array(
                trim(substr($linha, 0, 10)),
                trim(substr($linha, 10, 2)),
                trim(substr($linha, 12, 6)))));
  }
  fclose($arquivo);

  $sql = sprintf('INSERT INTO procedimentos_registros (codigo_procedimento, codigo_registro, cmpt) VALUES %s', implode(',', array_slice($lines, 0)));
  $sql = str_replace('"', "'", $sql);
  $conexao = new Conexao('sga2');
  $conexao->open();
  pg_query($sql);
  $conexao->close();
}
echo "Importação Finalizada...";
?>
