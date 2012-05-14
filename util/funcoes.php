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

function validaCNS($cns) {
  if ((strlen(trim($cns))) != 15) {
    return false;
  }
  $pis = substr($cns, 0, 11);
  $soma = (((substr($pis, 0, 1)) * 15) +
          ((substr($pis, 1, 1)) * 14) +
          ((substr($pis, 2, 1)) * 13) +
          ((substr($pis, 3, 1)) * 12) +
          ((substr($pis, 4, 1)) * 11) +
          ((substr($pis, 5, 1)) * 10) +
          ((substr($pis, 6, 1)) * 9) +
          ((substr($pis, 7, 1)) * 8) +
          ((substr($pis, 8, 1)) * 7) +
          ((substr($pis, 9, 1)) * 6) +
          ((substr($pis, 10, 1)) * 5));
  $resto = fmod($soma, 11);
  $dv = 11 - $resto;
  if ($dv == 11) {
    $dv = 0;
  }
  if ($dv == 10) {
    $soma = ((((substr($pis, 0, 1)) * 15) +
            ((substr($pis, 1, 1)) * 14) +
            ((substr($pis, 2, 1)) * 13) +
            ((substr($pis, 3, 1)) * 12) +
            ((substr($pis, 4, 1)) * 11) +
            ((substr($pis, 5, 1)) * 10) +
            ((substr($pis, 6, 1)) * 9) +
            ((substr($pis, 7, 1)) * 8) +
            ((substr($pis, 8, 1)) * 7) +
            ((substr($pis, 9, 1)) * 6) +
            ((substr($pis, 10, 1)) * 5)) + 2);
    $resto = fmod($soma, 11);
    $dv = 11 - $resto;
    $resultado = $pis . "001" . $dv;
  } else {
    $resultado = $pis . "000" . $dv;
  }
  if ($cns != $resultado) {
    return false;
  } else {
    return true;
  }
}

function validaCNS_PROVISORIO($cns) {
  if ((strlen(trim($cns))) != 15) {
    return false;
  }
  $soma = (((substr($cns, 0, 1)) * 15) +
          ((substr($cns, 1, 1)) * 14) +
          ((substr($cns, 2, 1)) * 13) +
          ((substr($cns, 3, 1)) * 12) +
          ((substr($cns, 4, 1)) * 11) +
          ((substr($cns, 5, 1)) * 10) +
          ((substr($cns, 6, 1)) * 9) +
          ((substr($cns, 7, 1)) * 8) +
          ((substr($cns, 8, 1)) * 7) +
          ((substr($cns, 9, 1)) * 6) +
          ((substr($cns, 10, 1)) * 5) +
          ((substr($cns, 11, 1)) * 4) +
          ((substr($cns, 12, 1)) * 3) +
          ((substr($cns, 13, 1)) * 2) +
          ((substr($cns, 14, 1)) * 1));
  $resto = fmod($soma, 11);
  if ($resto != 0) {
    return false;
  } else {
    return true;
  }
}

?>
