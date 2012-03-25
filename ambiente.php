<?php
require_once('class/Competencia.class.php');
require_once('class/Permissao.class.php');
require_once('class/Estabelecimento.class.php');
require_once('class/Sessao.class.php');

$session = new Session();
$session->start();
$id_operador   = $session->getNode("id_operador");
$nome_operador = $session->getNode("nome_operador");

$competencia = new Competencia();
$competencia->extras_select = "where ativo=true order by ano,mes";
$competencia->selecionaTudo($competencia);

if (empty($id_operador)) {
  echo "<p style='font-size: 14pt; margin-top: 14px; color: red'><a class='login' href='sair.php'>Sua sessão foi encerrada por inatividade. Clique para autenticar novamente</a></p>";
  exit;
} else {
  $permissoes = new Permissao();
  $permissoes->extras_select = "where permissoes.id_operador=$id_operador and estabelecimentos.ativo";
  $permissoes->selecionaTudo($permissoes);

}
?>
<html>
  <head>
    <script type="text/javascript">
      $(function($){
        var competencia     = '';
        var estabelecimento = '';
        var tipo            = '';
        var faixa           = '';
        var operador        = '';
        
        operador = $('input[name=id_operador]').val();
        
        $('select[name=id_estabelecimento]').change(function(){
          estabelecimento = $(this).val();
          $('select[name=id_tipo]').html('<option value="">Carregando</option>');
          $.post("views/estabelecimento_tipos/tipos_por_estabelecimento.php", 
          {id_estabelecimento: $(this).val()},
          function(valor){
            $('select[name=id_tipo]').html(valor);
          });
        });
        
        $('select[name=id_tipo]').change(function(){
          tipo = $(this).val();
          $('select[name=id_faixa]').html('<option value="">Carregando</option>');
          $.post("views/faixas/faixas_por_tipo.php",
          {id_tipo: tipo},
          function(valor){
            $('select[name=id_faixa]').html(valor);
          });
        });
      
        $('select[name=id_competencia]').change(function(){
          competencia = $(this).val();
        });
        
        $('select[name=id_faixa]').change(function(){
          faixa = $(this).val();
        });
        
        $('form[name=sessao]').submit(function(){
          $.post("sessao.php", 
          { competencia: competencia, estabelecimento: estabelecimento, tipo: tipo, faixa: faixa, operador: operador },
          function(resposta){
            if(!resposta){
              $('div[id=right]').load('home.php');
            } else {
              $('div[id=msg]').html(resposta)
            }
          });
          return false;
        });
      });
    </script>
  </head>
  <body>
    <div id="ambiente" style="color: red; font-weight: bold; margin-top: 10px;">
      <form name="sessao" name="sessao" action="sessao.php" method="post">
        <input type="hidden" name="id_operador" value="<?= $id_operador; ?>" />
        <table width="100%" border="0" align="center" style="margin-top: 12px;font-size: 10pt; line-height: 180%">
          <tr>
            <td>Operador:</td>
            <td><? echo $nome_operador; ?></td>
          </tr>
          <tr>
            <td>Competência:</td>
            <td>
              <select name="id_competencia" class="campo">
                <option value="" selected>Selecione</option>
                <?php
                while ($linha = $competencia->retornaDados("array")) {
                  echo "<option value='{$linha['id']}'>{$linha['ano']}{$linha['mes']}</option>";
                }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td>Estabelecimento:</td>
            <td>
              <select name="id_estabelecimento" id="id_estabelecimento" class="campo">
                <option value="">Selecione</option>
                <?php
                while($linha = $permissoes->retornaDados()){
                  echo "<option value=".$linha->id_estabelecimento.">".$linha->nome_fantasia."</option>";
                }
                ?>
              </select>
            </td>
          <tr>
            <td>Tipo:</td>
            <td>
              <select name="id_tipo" id="id_tipo" class="campo">
                <option value="0" disabled="disabled">Selecione o Tipo</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>Faixa:</td>
            <td>
              <select name="id_faixa" id="id_faixa" class="campo">
                <option value="0" disabled="disabled">Selecione uma Faixa</option>
              </select>
            </td>
          </tr>
          <tr>
            <td></td>
            <td><button name="salvar" type="submit" id="bt_salvar" style="width: 85px; height: 22px" class="campo">Salvar</button></td>
          </tr>
        </table>
      </form>
      <br/>
    </div>
    <div id="msg"></div>
  </body>
</html>