<?php

require_once("../class/Acesso.class.php");

$acesso = new Acesso();

$login = strtoupper($_POST['login']);
$senha = $_POST['senha'];

if ($acesso->autentica($login, $senha)) {
  echo false;
} else {
  echo 'Login ou senha inválidos';
}

?>
