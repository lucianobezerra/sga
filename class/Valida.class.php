<?php

define('DS', DIRECTORY_SEPARATOR);
require_once(dirname(dirname(__FILE__)) . DS . 'util' . DS . 'funcoes.php');

require_once("Conexao.class.php");

class Valida {

  private $tabela, $campoID, $campoData;

  function __construct($tabela = 'config', $campoID = 'id', $campoData = 'expira') {
    $this->tabela = $tabela;
    $this->campoID = $campoID;
    $this->campoData = $campoData;
    }

    function validaSistema() {
    $conexao = new Conexao('sga');
    $conexao->open();

    $data_hoje = date('Y-m-d');
    $sql = "SELECT {$this->campoID}, {$this->campoData} FROM {$this->tabela}";
    $query = @pg_query($sql);
    $result = @pg_fetch_object($query);
    $data_expira = decode5t($result->{$this->campoData});
    $conexao->close();

    $_SESSION[$this->campoData] = $this->campoData;
    if ($data_expira < $data_hoje) {
      return false;
    } else {
      return true;
    }
  }

  function getDataBanco() {
    return decode5t($_SESSION[$this->campoData]);
  }

}

?>
