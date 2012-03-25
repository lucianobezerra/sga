<?php
require_once('config/conn.php');

$objLogin = new Login();

if (!$objLogin->verificar('index.html'))
  exit;

$query = pg_query("SELECT * FROM operadores WHERE id = {$objLogin->getID()}");
$usuario = pg_fetch_object($query);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Painel do usuário logado</title>
  </head>
  <body>
    <h1>Painel</h1>

    <p>Bem vindo <strong><?php echo $usuario->nome; ?></strong></p>

    Informações da sessão:

    <ul>
      <li><strong>ID:</strong> <?php echo $objLogin->getID() ?></li>
      <li><strong>Login:</strong> <?php echo $objLogin->getLogin() ?></li>
    </ul>

    <a href="sair.php">Sair</a>
  </body>
</html>
