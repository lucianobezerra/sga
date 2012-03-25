<?php
require("../../class/Sessao.class.php");
require("../../class/Operador.class.php");
require("../../class/Permissao.class.php");

$session = new Session();
$session->start();
$ambiente = $session->check();
if (!$ambiente) {
  echo "<p style='font-size: 14pt; margin-top: 14px; color: red'><a class='ambiente' href='ambiente.php'>Ambiente não configurado, clique para configurar</a></p>";
  exit;
} else {
  $id_operador = $session->getNode("id_operador");

  $operador = new Operador();
  $operador->extras_select = "where id={$id_operador} and ativo=true";
  $operador->pegaNivel($operador);

  $linha_operador = $operador->retornaDados("array");

  $nivel = $linha_operador['nivel'];
  unset($operador);
}
?>
<html>
  <head>
    <script type="text/javascript">
      $(function($){
        $('select[name=id_operador]').live('change', function(){
          $('#retorno').html('');
          var _url = 'views/autorizacoes/combos.php?opcao=1';
          var _opr = $(this).val();
          $.post(_url, 
            {_operador: _opr},
            function(resposta){
             $('select[name=id_estabelecimento]').html(resposta); 
            });
            return false;
        });
        
        $('select[name=id_estabelecimento]').live('change', function(){
          $('#retorno').html('');
          var _url = 'views/autorizacoes/combos.php?opcao=2';
          var _estabelecimento = $(this).val();
          $.post(_url, 
          {_estabelecimento: _estabelecimento}, function(resposta){
            $('select[name=id_tipo]').html(resposta);
          })
          return false;
        });
        
        $('button[name=relatorio]').live('click', function(){
        var _operador        = $('select[name=id_operador]').val();
        var _estabelecimento = $('select[name=id_estabelecimento]').val();
        var _tipo            = $('select[name=id_tipo]').val();
        var _url             = 'model/autorizacao.php?acao=listagem';
        $.post(_url, {_estabelecimento: _estabelecimento, _tipo: _tipo, _operador: _operador},
        function(resposta){
          $('#retorno').html(resposta);
        });
        return false;
        });
      });
    </script>
  </head>
  <body>
    <p style="font-size: 12pt; margin-top: 12px; margin-bottom: 12px; text-align: center">Listagem de Autorizações</p>    <form name="relatorio" action="#" method="post">
    <fieldset style="border: solid 1px; padding: 5px;">
      <legend>Parâmetros</legend>
      <form name="relatorio" class="campo">
        <?php
          $operadores = new Operador();
          if($nivel > 2):
            $operadores->valorpk = $id_operador;
            $operadores->seleciona($operadores);
            else:
              $operadores->extras_select = "where ativo=true order by id";
              $operadores->selecionaTudo($operadores);
          endif;
          ?>
          <label for='id_operador'>Operador</label>
          <select name='id_operador' class='campo'>
             <option value='000'>Selecione</option>
          <?php            
            if($nivel <= 2):
              echo "<option value='999'>Todos</option>";
            endif;
            while($linha = $operadores->retornaDados()){
            echo "<option value='{$linha->id}'>{$linha->nome}</option>";
          }
          echo "</select><br/>"
        ?>
        <label for='id_estabelecimento'>Estabelecimento</label>
        <select name="id_estabelecimento" class="campo">
        </select><br/>
        
        <label for='id_tipo'>Tipo</label>
        <select name="id_tipo" class="campo">
          <option value='000'>Selecione</option>
          <option value='999'>Todos</option>
        </select><br/>
        <button name="relatorio" class="campo" style="width: 85px; height: 25px">Executar</button>
      </form>
    </fieldset>
      <div id="retorno"></div>
</body>
</html>