<?php

class Conexao {

  private $host = "localhost";
  private $user = "postgres";
  private $pswd = "postgres";
  private $banco = "sga";
  private $strConexao;
  private $conexao;

  function Conexao($banco) {
    $this->banco = $banco;
    $this->strConexao = "host=$this->host user=$this->user password=$this->pswd dbname=$this->banco";
  }

  function open() {
    $this->conexao = @pg_connect($this->strConexao);
  }

  function close() {
    @pg_close($this->conexao);
    $this->conexao = false;
  }

  function status() {
    if ($this->conexao) {
      echo 'Conectado<br/>';
    } else {
      echo 'Desconectado<br/>';
      exit();
    }
  }

}

?>
