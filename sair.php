<?php
// Incluindo arquivo de conexão/configuração
require_once('config/conn.php');

// Instanciando novo objeto da classe Login
$objLogin = new Login();

// Finaliza a sessão e redireciona o usuário para a página de login
$objLogin->logout('login.html');
?>
