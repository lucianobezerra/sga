<?php
define('DS', DIRECTORY_SEPARATOR);
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Faixa.class.php');
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Tipo.class.php');
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Competencia.class.php');

$tipos = new Tipo();
$tipos->extras_select = "where ativo order by id";
$tipos->selecionaTudo($tipos);

$competencias = new Competencia();
$competencias->extras_select = "where ativo order by id";
$competencias->selecionaTudo($competencias);

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
$faixa = new Faixa();
$faixa->valorpk = $id;
$faixa->seleciona($faixa);
$linha = $faixa->retornaDados("array");
?>

<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    <script type="text/javascript">
      $(function($){
        $('form#faixa').submit(function(){
          $(this).ajaxSubmit(function(retorno){
            if(!retorno){
              alert('Faixa de Autorização Atualizada.');
              $('div#right').load("views/faixas/");
            } else{
              $('div#mensagem-erro').html(retorno);
              $('div#mensagem-erro').fadeIn('slow');
              $('div#mensagem-erro').delay(6000).fadeOut(1000);
            }
          });
          return false;
        });
      });
    </script>
  </head>
  <body>
    <p style="font-size: 12pt; margin-top: 14pt;">Atualização de Faixas de Autorização</p><br/>
    <form name="faixa" id="faixa" method="POST" action="model/faixa.php?acao=alterar&id=<?= $linha['id']; ?>">
      <input type="hidden" name="hidden_id" value="<?= $linha['id']; ?>" />
      <input type="hidden" name="hidden_inicial" value="<?= $linha['inicial']; ?>" />
      <table width="100%">
        <tr>
          <td>Autorização Inicial</td>
          <td><input type="text" size="15" maxlength="12" name="inicial" class="campo" value="<?= $linha['inicial']; ?>" disabled/></td>
        </tr>
        <tr>
          <td>Autorização Final</td>
          <td><input type="text" size="15" maxlength="12" name="final" class="campo" value="<?= $linha['final']; ?>"/></td>
        </tr>
        <tr>
          <td>Tipo de Autorização</td>
          <td>
            <select name="tipo" class="campo">
              <?php
              while ($linhas = $tipos->retornaDados()) {
                $selecionado = $linha['id_tipo'] == $linhas->id ? "selected='selected'" : "";
                echo "<option value='{$linhas->id}' {$selecionado}>{$linhas->descricao}</option>";
              }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>Competência Inicial</td>
          <td>
            <select name="competencia" class="campo">
              <?php
              while ($linhas = $competencias->retornaDados()) {
                $selecionado = $linha['id_competencia'] == $linhas->id ? "selected='selected'" : "";
                echo "<option value='{$linhas->id}' {$selecionado}>{$linhas->ano}{$linhas->mes}</option>";
              }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>Ativo?</td>
          <td>
            Sim <input type="radio" name="ativo" id="ativo" value="t" class="campo" <?php echo $linha['ativo'] == 't' ? 'checked=checked' : ''; ?>/>
            Não <input type="radio" name="ativo" id="ativo" value="f" class="campo" <?php echo $linha['ativo'] == 'f' ? 'checked=checked' : ''; ?>/>
          </td>
        </tr>
        <tr>
          <td></td>
          <td><button name="salvar" type="submit" style="width: 85px; height: 25px" class="campo">Salvar</button></td>
        </tr>
      </table>
    </form>
    <br/>
    <div id="mensagem-erro" class="mensagem-erro"></div>
  </body>
</html>