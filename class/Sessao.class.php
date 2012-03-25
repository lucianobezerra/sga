<?php

class Session {

  public function start() {
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
    $ambiente = $this->getNode("id_estabelecimento");
    if (empty($ambiente)) {
      return false;
    } else {
      return true;
    }
  }

}

?>
