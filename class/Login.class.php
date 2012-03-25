<?php

class Login {

  private $tabela, $campoID, $campoLogin, $campoNome, $campoNivel, $campoSenha;

  function __construct($tabela = 'operadores', $campoID = 'id', $campoLogin = 'login', $campoSenha = 'senha', $campoNome = 'nome', $campoNivel = 'nivel') {
    session_start();

    $this->tabela = $tabela;
    $this->campoID = $campoID;
    $this->campoLogin = $campoLogin;
    $this->campoSenha = $campoSenha;
    $this->campoNome = $campoNome;
    $this->campoNivel = $campoNivel;
  }

  function getLogin() {
    return $_SESSION[$this->campoLogin];
  }

  function getID() {
    return $_SESSION[$this->campoID];
  }
  
  function getNome(){
    return $_SESSION[$this->campoNome];
  }

  function getNivel(){
    return $_SESSION[$this->campoNivel];
  }

  function logar($login, $senha, $redireciona = null) {
    $login = $login;
    $senha = $senha;
    $query = pg_query("SELECT {$this->campoID}, {$this->campoLogin}, {$this->campoSenha}, {$this->campoNome}, {$this->campoNivel}
                             FROM {$this->tabela}
                             WHERE {$this->campoLogin} = '{$login}' AND {$this->campoSenha} = '{$senha}'");
    if (pg_num_rows($query) > 0) {
      $usuario = pg_fetch_object($query);

      $_SESSION[$this->campoID]    = $usuario->{$this->campoID};
      $_SESSION[$this->campoLogin] = $usuario->{$this->campoLogin};
      $_SESSION[$this->campoSenha] = $usuario->{$this->campoSenha};
      $_SESSION[$this->campoNome]  = $usuario->{$this->campoNome};
      $_SESSION[$this->campoNivel] = $usuario->{$this->campoNivel};

      if ($redireciona !== null)
        header("Location: {$redireciona}");
      else
        return true;
    }
    else
      return false;
  }

  function verificar($redireciona = null) {
    if (isset($_SESSION[$this->campoID]) and isset($_SESSION[$this->campoLogin]))
      return true;
    else {
      if ($redireciona !== null)
        header("Location: {$redireciona}");
      return false;
    }
  }

  function logout($redireciona = null) {
    $_SESSION = array();
    session_destroy();
    session_regenerate_id();
    if ($redireciona !== null)
      header("Location: {$redireciona}");
  }

}

?>