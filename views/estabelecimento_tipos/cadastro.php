<?php
if (defined('ROOT_APP') == false) {
  define('ROOT_APP', $_SERVER['DOCUMENT_ROOT'] . "/sga");
}
require_once(ROOT_APP. '/class/Estabelecimento.class.php');
require_once(ROOT_APP. '/class/Tipo.class.php');
require_once(ROOT_APP. '/class/EstabelecimentoTipo.class.php');

$id_estabelecimento = $_REQUEST['id_estabelecimento'];

$ups = new Estabelecimento();
$ups->valorpk = $id_estabelecimento;
$ups->seleciona($ups);
$data = $ups->retornaDados("array");


$tipos = new Tipo();
$tipos->extras_select = "where id not in (select id_tipo from tipos_por_estabelecimento where id_estabelecimento=$id_estabelecimento) order by id";
$tipos->selecionaTudo($tipos);
?>
<html>
  <head>
    <script type="text/javascript">
      $(function($){
        $('form#tipo_estabelecimento').submit(function(){
          $(this).ajaxSubmit(function(retorno){
            if(!retorno){
              alert('Tipo de Autorização Gravado.');
              $('div#right').load("views/estabelecimento_tipos/index.php?id_estabelecimento=<?= $data['id']; ?>");
            } else{
              $('div#mensagem-erro').html(retorno);
            }
          });
          return false;
        });
      });
    </script>
  </head>
  <body>
    <p style="font-size: 10pt; margin-top: 12px;">Cadastro de Tipos de Autorização: <?= $data['nome_fantasia']; ?></p><br/>
    <form name='tipo_estabelecimento' id='tipo_estabelecimento' method="POST" action="model/estabelecimento_tipo.php?acao=inserir">
      <input type="hidden" name="id_estabelecimento" value="<?= $data['id']; ?>" />
      <table>
        <tr>
          <td>Tipo de Autorização</td>
          <td>
            <select name="id_tipo" class="campo">
              <option value="" selected>Selecione</option>
              <?
              while ($linha = $tipos->retornaDados()) {
                echo "<option value='$linha->id'>$linha->descricao</option>";
              }
              ?>
            </select>
          </td>
        <tr>
          <td></td>
          <td><button name="salvar" type="submit" style="width: 85px; height: 25px" class="campo">Inserir</button></td>
        </tr>
      </table>
    </form>
    <br/><br/>
    <div id="mensagem-erro" class="mensagem-erro"></div>
  </body>
</html>