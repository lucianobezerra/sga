<?php

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

?>