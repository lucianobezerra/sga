<?php
define('DS', DIRECTORY_SEPARATOR);
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Operador.class.php');
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'class' . DS . 'Sessao.class.php');
require_once(dirname(dirname(dirname(__FILE__))) . DS . 'util' . DS . 'funcoes.php');
$session = new Session();
$session->start();
$id_operador   = $session->getNode("id_operador");
$nivel         = $session->getNode("nivel_operador");

$operador = new Operador();
$where = '';
switch ($nivel){
  case 0: $where = "order by nome"; break;
  case 1: $where = "where nivel >= 1 order by nome"; break;
  case 2: $where = "where nivel >= 2 order by nome"; break;
  case 3: $where = "where id={$id_operador}"; break;
}

  $operador->extras_select = $where;
  $operador->selecionaTudo($operador);
?>
<html>
  <head>
    <script type="text/javascript">
      $('input[name=salvar]').live('click', function(e){
        e.preventDefault();
        var url='model/operador?acao=novasenha';
        var params = $('form').serialize();
        $.ajax({
          type: 'post',
          url: url,
          data: params,
          success: function(valor){
            if(!valor){
              $('#retorno').html('');
              alert('Senha Alterada!')
              $('form')[0].reset();
            } else {
              $('#retorno').html(valor);
            }
          }
        });
        return false;
      });
    </script>
  </head>
  <body>
    <fieldset style="border: solid 1px; padding: 5px; line-height: 20px; margin-top: 12px">
      <legend>Alteração de Senha:</legend>
      <form action="#" method="post" name="altera_senha" class="campo" style="border: none">
        <table>
          <tr style="height: 25px">
            <td style="width: 20%;">Usuário</td>
            <td>
              <select name="id">
                <option value="000">Selecione</option>
                <?
                while ($linha = $operador->retornaDados()) {
                  echo "<option value='{$linha->id}'>{$linha->nome}</option>";
                }
                ?>
              </select>
            </td>
          </tr>
          <tr style="height: 25px">
            <td>Senha</td>
            <td><input type="password" name="password" class="campo"/></td>
          </tr>
          <tr style="height: 25px">
            <td>Confirme</td>
            <td><input type="password" name="confirme" class="campo"/></td>
          </tr>
          <tr style="height: 25px">
            <td colspan="2"><input type="submit" class="campo" value="Salvar" name="salvar" style="width: 120px; height: 25px" /></td>
          </tr>
        </table>
      </form>
    </fieldset>
    <div id="retorno" style="margin-top: 12px; color: red; font-size: 14pt;"></div>
  </body>
</html>
