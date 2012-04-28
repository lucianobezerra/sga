<?php

$host = "ftp://ftp2.datasus.gov.br/public/sistemas/tup/downloads/";
$file = $_POST['arquivo'];
$url  = $host.$file;

if(defined('ROOT_APP') == false){
  define('ROOT_APP', $_SERVER['DOCUMENT_ROOT'] . "/sga");
}

if (defined('ROOT_IMP') == false) {
  define('ROOT_IMP', ROOT_APP . "/importar");
}

/***************************************************************
  Bloco para Limpar a Pasta de Importação
****************************************************************/
if (!$dirhandle = @opendir(ROOT_IMP))
  
    return;
  while (false !== ($filename = readdir($dirhandle))) {
    if ($filename != "." && $filename != "..") {
      $filename = ROOT_IMP . "/" . $filename;
      echo @unlink($filename);
    }
  }

/***************************************************************
  Bloco para Baixar o Arquivo do Site Datasus
****************************************************************/
  echo "<br/>Efetuando Download do Arquivo, aguarde .....<br/>";
  $out = fopen(ROOT_IMP."/".$file, "wb");
  if ($out === false) {
    echo "Arquivo nao Localizado, verifique ....";
    exit;
  }

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_FILE, $out);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_exec($ch);
  curl_close($ch);
  echo "<br/>Arquivo recebido com Sucesso.<br/>";

/***************************************************************
  Bloco para Descompactar o Arquivo Baixado
****************************************************************/
  echo "<br/>Iniciando a Descompactação dos Arquivos ...<br/>";
  $zip = new ZipArchive();
  $zip->open(ROOT_IMP."/".$file);
  $zip->extractTo(ROOT_IMP);
  $zip->close();

echo "<br/>Processo Concluído ...<br/>";

/***************************************************************
  Fim da Rotina de download dos Arquivos
****************************************************************/


?>
