<?PHP
if (defined('ROOT_APP') == false) {
  define('ROOT_APP', $_SERVER['DOCUMENT_ROOT'] . "/sga");
}

require_once(ROOT_APP . "/class/Autorizacao.class.php");
require_once(ROOT_APP . "/util/funcoes.php");
?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />    
    <link rel="stylesheet" type="text/css" href="/sga/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="/sga/css/main.css"/>
    <style type="text/css">
      *{
        margin: 0; padding: 0; border: 0;
      }
      body{
        background-image: none;
      }
      label{
        display: left !important;
        padding: 2px;
        width: 750px;
      }
    </style>
  </head>
  <body>
    <?php
    $numero = $_REQUEST['numero'];

    $autorizacao = new Autorizacao();
    $aut = $autorizacao->exibe($numero);
    /*     * *********************************************************************************
     *  Bloco de Impressão da Autorização
     * ********************************************************************************* */
    ?>
    <div style='border: none; width: 760px' id="autoriza">
      <fieldset style='padding: 5px; margin: 0px; border: solid 1px; font-size: 11pt; font-family: courier new'>
        <legend align='center'>&nbsp;&nbsp;AUTORIZAÇÃO&nbsp;&nbsp;</legend>
        <label style="font-weight: bold">NÚMERO: <?= $aut['numero']; ?></label>
        <label>ESTABELECIMENTO: <?= $aut['estabelecimento']; ?></label>
        <label>NOME: <?= $aut['nome_paciente']; ?></label>
        <label>SEXO: <?= $aut['sexo']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NASCIMENTO: <?= ConverteDataParaBR($aut['data_nascimento']); ?>&nbsp;&nbsp;&nbsp;&nbsp;CARTÃO SUS: <?= $aut['cartao_sus']; ?></label> 
        <label>NOME DA MÃE: <?= $aut['nome_da_mae']; ?></label>
        <label>MUNICÍPIO: <?= $aut['municipio']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CEP:&nbsp;&nbsp;<?= $aut['cep']; ?></label>
        <label>RAÇA/COR:  <?= $aut['raca_cor']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RESPONSÁVEL: <?= $aut['nome_responsavel']; ?></label>
        <label>SOLICITANTE: <?= $aut['solicitante']; ?></label>
        <label>PROCEDIMENTO: <?= $aut['procedimento']; ?></label>
        <label>DIAGNÓSTICO: <?= $aut['diagnostico']; ?></label>
        <label>DATA: <?= ConverteDataParaBR($aut['data_autoriza']); ?></label>
        <label>AUTORIZADOR: <?= $aut['autorizador']; ?></label>
      </fieldset>
    </div>
    <p style="text-align: right; margin-right: 5px; padding-right: 5px;"><a href="#" onclick="window.print();">Imprimir</a></p>
  </body>
</html>
