<?php
if (defined('ROOT_APP') == false) {
  define('ROOT_APP', $_SERVER['DOCUMENT_ROOT'] . "/sga");
}

if (defined('ROOT_IMP') == false) {
  define('ROOT_IMP', ROOT_APP . "/importar");
}

require(ROOT_APP . "/class/Sessao.class.php");
require(ROOT_APP . "/class/Faixa.class.php");
require(ROOT_APP . "/class/Autorizador.class.php");
require(ROOT_APP . "/class/Solicitante.class.php");
$session = new Session();
$session->start();
$id_opr = $session->getNode("id_operador");
$id_ups = $session->getNode("id_estabelecimento");
$id_tipo = $session->getNode("id_tipo");
$id_faixa = $session->getNode("id_faixa");
$id_cmpt = $session->getNode("id_competencia");

$ambiente = $session->check();
if (!$ambiente) {
  echo "<p style='font-size: 14pt; margin-top: 14px; color: red'><a class='ambiente' href='ambiente.php'>Ambiente não configurado, clique para configurar</a></p>";
  exit;
} else {
  $faixa = new Faixa();
  $faixa->valorpk = $id_faixa;
  $faixa->seleciona($faixa);
  $linha = $faixa->retornaDados("array");

  $autorizador = new Autorizador();
  $autorizador->extras_select = 'where ativo order by nome';
  $autorizador->selecionaTudo($autorizador);

  $solicitante = new Solicitante();
  $solicitante->extras_select = 'where ativo order by nome';
  $solicitante->selecionaTudo($solicitante);
  ?>
  <html>
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <title></title>
      <style>
        *{ margin: 0; padding: 0;        }
        form{ width: 500px; margin: 0; padding: 1px;}
        form fieldset{ border: none;}
        form fieldset legend{font-weight: bold; font: 14px Verdana, arial, tahoma; margin: 0; }
        form fieldset label{ font: 12px; display: block; border: none; width: 240px; float: left; }
        form fieldset label input{ width: 220px; border: 1px solid; padding:0px; text-transform: uppercase; }
        form fieldset select{  border: 1px solid; padding: 1px; }
        form fieldset input.botao{float: right; cursor: pointer; border: none }
      </style>
      <script type="text/javascript">
        $(function($){
          $("input[name=cns]").mask("999999999999999");
          $("input[name=data_nascimento]").mask("99/99/9999");
          $("input[name=data_autoriza]").mask("99/99/9999");
          $("input[name=cep]").mask("99999-999");
                                                  
          $('input[type=submit]').live('click', function(e){
            e.preventDefault();
            var valores = $('#autorizacao').serialize();
            $.ajax({
              url:  'model/autorizacao?acao=inserir',
              type: 'post',
              dataType: 'html',
              data: valores,
              success: function(resposta){
                var numero = resposta.split('-');
                var n1 = new Number(numero[0]);
                if(n1 instanceof Number){
                  var dialogOpts = { modal: true, 
                    bgiframe: true, 
                    autoOpen: false, 
                    height: 200, 
                    width: 300, 
                    draggable: true, 
                    resizable: false,
                    title: 'AUTORIZAÇÃO GERADA',
                    buttons: {
                      "Retornar": function() {
                        $(this).dialog("close");
                      }
                    }};
                  $('#exibir').dialog(dialogOpts);
                  $('#exibir').load('views/autorizacoes/retorno.php?numero='+n1);
                  $('#exibir').dialog('open');
                  $('form')[0].reset();
                } else {
                  $('#retorno').html(resposta);
                }
              }
            });
                                                
          });
        });
      </script>
    </head>
    <body>
      <form id="autorizacao" name="autorizacao" action="#" method="post">
        <input type="hidden" name="id_operador" value="<?= $id_opr; ?>" />
        <input type="hidden" name="id_estabelecimento" value="<?= $id_ups; ?>" />
        <input type="hidden" name="id_tipo" value="<?= $id_tipo; ?>" />
        <input type="hidden" name="id_faixa" value="<?= $id_faixa; ?>" />
        <input type="hidden" name="id_competencia" value="<?= $id_cmpt; ?>" />
        <fieldset>
          <legend align="center" style="padding-bottom: 3px; padding-top: 3px;">Emissão de Autorização</legend>
          <label style="width: 120px;">Cartão Sus:    <input style="width: 115px;" type="text" maxlength="15" name="cns"/></label>
          <label style="width: 340px;">Nome Paciente: <input style="width: 340px;" type="text" maxlength="60" name="nome_paciente"/></label>
          <label style="width: 230px;">Nome da Mãe:   <input style="width: 228px;" type="text" maxlength="60" name="nome_mae"/></label>
          <label style="width: 120px;" >Nascimento:   <input style="width: 110px;" type="text" maxlength="10" name="data_nascimento"/></label>
          <label style="width: 110px;">Sexo:
            <select name="sexo"  style="width: 110px;">
              <option value="M">Masculino</option>
              <option value="F">Feminino</option>
            </select>
          </label>
          <label style="width: 300px;">Rua e Número:  <input style="width: 290px;" type="text" maxlength="60" name="endereco"/></label>
          <label style="width: 165px;" >Bairro:       <input style="width: 160px;" type="text" maxlength="25" name="bairro"/></label>
          <label style="width: 120px;">Cep:           <input style="width: 110px;" type="text" maxlength="8"  name="cep"/></label>
          <label style="width: 350px;">Município:     <br/><input style="width: 60px; margin-right: 5px" type="text" maxlength="7" name="id_municipio"/><input style="width: 275px;" type="text" maxlength="60" name="nome_municipio"/></label>
          <label style="width: 320px;">Responsável:   <input style="width: 315px;" type="text" maxlength="60" name="nome_responsavel"/></label>
          <label style="width: 140px;">Raca/Cor:
            <select style="width: 140px;" name="raca_cor">
              <option value="01">01-BRANCA</option>
              <option value="02">02-PRETA</option>
              <option value="03">03-PARDA</option>
              <option value="04">04-AMARELA</option>
              <option value="05">05-INDIGENA</option>
              <option value="99">99-SEM INFORMAÇÃO</option>
            </select>
          </label>
          <label style="width: 500px;">Procedimento:<br/>
            <input style="width: 80px;" type="text" maxlength="10" name="id_procedimento"/>
            <input style="width: 375px;" type="text" maxlength="120" name="nome_procedimento"/>
          </label>
          <label style="width: 500px;">Diagnóstico:<br/>
            <input style="width: 40px;" type="text" maxlength="4" name="id_diagnostico"/>
            <input style="width: 415px;" type="text" maxlength="120" name="nome_diagnostico"/>
          </label>
          <label>Solicitante:<select name="id_solicitante" style="width: 220px;">
              <option value=""> Selecione ...</option>
              <?php
              while ($sol = $solicitante->retornaDados()) {
                echo "<option value='{$sol->id}'>{$sol->nome}</option>";
              }
              ?>
            </select>
          </label>
          <label>Autorizador:<select name="id_autorizador" style="width: 220px;">
              <option value=""> Selecione ...</option>
              <?php
              while ($aut = $autorizador->retornaDados()) {
                echo "<option value='{$aut->id}'>{$aut->nome}</option>";
              }
              ?>
            </select>
          </label>
          <label style="width: 460px; ">Data Autorização:<br/> <input style="width: 110px;" type="text" maxlength="10" name="data_autoriza"/>
            <input name="salvar"  type="submit" class="botao" style="width: 100px; height: 22px;" value="Autorizar"/>
          </label>
        </fieldset>
      </form>
      <br/>
      <div id="retorno" style="font-size: 12pt; color: blue"></div>
      <div id="exibir"></div>
    </body>
  </html>
<? } ?>
