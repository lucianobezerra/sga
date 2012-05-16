<?php

require_once("class/Acesso.class.php");
$acesso = new Acesso();
if ($acesso->acessoLiberado("luciano", "31011998")) {
  echo "autorizado\n";
  echo $acesso->getIdOperador() . "\n";
  echo $acesso->getLoginOperador() . "\n";
  echo $acesso->getNomeOperador() . "\n";
  echo $acesso->getNivelOperador() . "\n";
} else {
  echo "nao autorizado";
}


$acesso = new Acesso();
$acesso->destruirSessao();
echo "sessao destruida\n";
echo $acesso->getIdOperador() . "\n";
echo $acesso->getLoginOperador() . "\n";
echo $acesso->getNomeOperador() . "\n";
echo $acesso->getNivelOperador() . "\n";
?>
