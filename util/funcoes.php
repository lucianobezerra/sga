<?php

require_once(dirname(dirname(__FILE__)) . '/class/Sessao.class.php');
require_once(dirname(dirname(__FILE__)) . '/class/Operador.class.php');

function retornaNivel() {
  $session = new Session();
  $session->start();
  $usuario = $session->getNode("id_operador");

  $operador = new Operador();
  $operador->extras_select = "where id={$usuario}";
  $operador->pegaNivel($operador);
  $nivel = $operador->retornaDados("array");
  return $nivel['nivel'];
}

function formata_competencia($strDate) {
  $arrMonthsOfYear = array(1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');

  $intMonthOfYear = date('n', strtotime($strDate));

  $intYear = date('Y', strtotime($strDate));
  return $arrMonthsOfYear[$intMonthOfYear] . ' de ' . $intYear;
}

function ConverteDataParaBR($data) {
  if ((isset($data)) and ($data <> '')) {
    // captura as partes da data
    $ano = substr($data, 0, 4);
    $mes = substr($data, 5, 2);
    $dia = substr($data, 8, 4);
    // retorna a data resultante
    return "{$dia}/{$mes}/{$ano}";
  } else {
    return NULL;
  }
}

function ConverteDataParaEUA($data) {
  if ((isset($data)) and ($data <> '')) {
    $dia = substr($data, 0, 2);
    $mes = substr($data, 3, 2);
    $ano = substr($data, 6, 4);
    return "{$ano}-{$mes}-{$dia}";
  } else {
    return NULL;
  }
}

function encode5t($str) {
  for ($i = 0; $i < 5; $i++) {
    $str = strrev(base64_encode($str));
  }
  return $str;
}

function decode5t($str) {
  for ($i = 0; $i < 5; $i++) {
    $str = base64_decode(strrev($str)); //apply base64 first and then reverse the string}
  }
  return $str;
}

function abreArquivo($nomeDoCampo) {
  $nometmp = $_FILES[$nomeDoCampo][tmp_name];
  if ($nometmp != "") {
    $handle = fopen($nometmp, "r");
    return $nometmp;
  } else {
    return false;
  }
}

function removerAcentos($str, $enc = "UTF-8") {
  $acentos = array(
      'A' => '/&Agrave;|&Aacute;|&Acirc;|&Atilde;|&Auml;|&Aring;/',
      'a' => '/&agrave;|&aacute;|&acirc;|&atilde;|&auml;|&aring;/',
      'C' => '/&Ccedil;/',
      'c' => '/&ccedil;/',
      'E' => '/&Egrave;|&Eacute;|&Ecirc;|&Euml;/',
      'e' => '/&egrave;|&eacute;|&ecirc;|&euml;/',
      'I' => '/&Igrave;|&Iacute;|&Icirc;|&Iuml;/',
      'i' => '/&igrave;|&iacute;|&icirc;|&iuml;/',
      'N' => '/&Ntilde;/',
      'n' => '/&ntilde;/',
      'O' => '/&Ograve;|&Oacute;|&Ocirc;|&Otilde;|&Ouml;/',
      'o' => '/&ograve;|&oacute;|&ocirc;|&otilde;|&ouml;/',
      'U' => '/&Ugrave;|&Uacute;|&Ucirc;|&Uuml;/',
      'u' => '/&ugrave;|&uacute;|&ucirc;|&uuml;/',
      'Y' => '/&Yacute;/',
      'y' => '/&yacute;|&yuml;/');

  return preg_replace($acentos, array_keys($acentos), htmlentities($str, ENT_NOQUOTES, $enc));
}
?>
