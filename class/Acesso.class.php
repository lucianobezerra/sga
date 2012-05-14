<?php

require("Base.class.php");
require("Sessao.class.php");

class Acesso extends Base {

  public function __construct($campos = array()) {
    parent::__construct();
    $this->tabela = 'operadores';

    if (sizeof($campos) <= 0) {
      $this->campos_valores = array("login" => null, "senha" => null, "nome" => null, "nivel" => null, "ativo" => null);
    } else {
      $this->campos_valores = $campos;
    }
    $this->campopk = 'id';
  }

  private function criptografaSenha($senha) {
    return md5($senha);
  }

  public function autentica($login, $senha) {
    $login = strtoupper($login);
    $senha = $this->criptografaSenha($senha);
    $sql = "select id, login, nome, nivel from $this->tabela ";
    $sql .= "where login = '{$login}' and senha = '{$senha}' and ativo";
    $query = pg_query($sql);

    if (pg_num_rows($query) > 0) {
      while ($usuario = pg_fetch_assoc($query)) {
        $session = new Session();
        $session->start();
        $session->addNode("id_operador", $usuario['id']);
        $session->addNode("login_operador", $usuario['login']);
        $session->addNode("nome_operador", $usuario['nome']);
        $session->addNode("nivel_operador", $usuario['nivel']);
      }
      return true;
    } else
      return false;
  }

  public function autenticado() {
    $session = new Session();
    $user = $session->getId();
    if ($user == '') {
      return true;
    } else
      return false;
  }

  public function getNomeOperador() {
    $session = new Session();
    return $session->getNode("nome_operador");
  }

  public function getIdOperador() {
    $session = new Session();
    return $session->getNode("id_operador");
  }

  public function getLoginOperador() {
    $session = new Session();
    return $session->getNode("login_operador");
  }

  public function getNivelOperador() {
    $session = new Session();
    return $session->getNode("nivel_operador");
  }

  public function destruirSessao($redirect = null) {
    $session = new Session();
    $session->destroyNodes("id_operador");
    $session->destroyNodes("login_operador");
    $session->destroyNodes("nome_operador");
    $session->destroyNodes("nivel_operador");
    $session->destroy();
    if ($redirect !== null) {
      header("Location: {$redirect}");
    }
  }

}

?>