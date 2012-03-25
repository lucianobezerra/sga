<?php
define('DS', DIRECTORY_SEPARATOR);
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Permissao.class.php');
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Operador.class.php');
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Estabelecimento.class.php');
$id_operador = isset($_REQUEST['id_operador']) ? $_REQUEST['id_operador'] : null;

$estabelecimento = new Estabelecimento();
$estabelecimento->extras_select = "where id not in (select id_estabelecimento from permissoes where id_operador=$id_operador) and ativo";
$estabelecimento->selecionaTudo($estabelecimento);

$operador = new Operador();
$operador->valorpk = $id_operador;
$operador->seleciona($operador);

$linha_operador = $operador->retornaDados("array");
?>
<html>
  <head>
    <script type="text/javascript">
      $(function($){
        $('form#permissao').submit(function(){
          $(this).ajaxSubmit(function(retorno){
            if(!retorno){
              alert('Permissão Inserida.');
              $('div#right').load("views/permissoes/index.php?id_operador=<?= $linha_operador['id']; ?>");
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
    <p style="font-size: 12pt; margin-top: 12px;">Cadastro de Permissões do Operador: <?= $linha_operador['nome']; ?></p><br/>
    <form name='permissao' id='permissao' method="POST" action="model/permissao.php?acao=inserir">
      <input type="hidden" name="id_operador" value="<?= $linha_operador['id']; ?>" />
      <table>
        <tr>
          <td>Estabelecimento</td>
          <td>
            <select name="id_estabelecimento" class="campo">
              <option value="" selected>Selecione</option>
              <?
              while ($linha = $estabelecimento->retornaDados()) {
                echo "<option value='{$linha->id}'>{$linha->nome_fantasia}</option>";
              }
              ?>
            </select>
          </td>
        <tr>
          <td></td>
          <td><button name="salvar" type="submit" style="width: 85px; height: 25px" class="campo">Inserir</button></td>
        </tr>
        </tr>
      </table>
    </form>
  </body>
</html>