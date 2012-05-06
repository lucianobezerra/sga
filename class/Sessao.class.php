<?php

class Session {

  public function start() {
    session_cache_expire(300);
    @session_start();
  }

  public function addNode($key, $value) {
    $_SESSION['node'][$key] = $value;
    return $this;
  }

  public function getNode($key) {
    if (isset($_SESSION['node'][$key])) {
      return $_SESSION['node'][$key];
    }
  }

  public function remNode($key) {
    if (isset($_SESSION['node'][$key])) {
      unset($_SESSION['node'][$key]);
    }
    return $this;
  }

  public function destroyNodes() {
    if (isset($_SESSION['node'])) {
      unset($_SESSION['node']);
    }
    return $this;
  }

  public function check() {
    $ups  = $this->getNode("id_estabelecimento");
    $cmpt = $this->getNode("id_competencia");
    $tipo = $this->getNode("id_tipo");
    $faixa = $this->getNode("id_faixa");
    if (empty($ups) || empty($cmpt) || empty($tipo) || empty($faixa)) {
      return false;
    } else {
      return true;
    }
  }

}

?>
