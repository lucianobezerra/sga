<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    <script type="text/javascript">
      $(function($){
        $('form#competencia').submit(function(){
          $(this).ajaxSubmit(function(retorno){
            if(!retorno){
              alert('Competência Cadastrada.');
              $('div#right').load("views/competencias/");
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
    <p style="font-size: 12pt; margin-top: 14pt;"> Cadastro de Competências</p><br/>
    <form name="competencia" id="competencia" method="POST" action="model/competencia.php?acao=inserir">
      <table width="100%">
        <tr>
          <td width="20%">Mês: </td>
          <td width="80%">
            <select size="1" name="mes" class="campo">
              <option selected value="">Selecione</option>
              <option value="01">Janeiro</option>
              <option value="02">Fevereiro</option>
              <option value="03">Março</option>
              <option value="04">Abril</option>
              <option value="05">Maio</option>
              <option value="06">Junho</option>
              <option value="07">Julho</option>
              <option value="08">Agosto</option>
              <option value="09">Setembro</option>
              <option value="10">Outubro</option>
              <option value="11">Novembro</option>
              <option value="12">Dezembro</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>Ano</td>
          <td>
            <select name="ano" class="campo">
              <option value="">Selecione</option>
              <option value="2011">2011</option>
              <option value="2012">2012</option>
              <option value="2013">2013</option>
              <option value="2014">2014</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>Ativo?</td>
          <td>
            Sim <input type="radio" name="ativo" id="ativo" value="true" class="campo"  checked/>
            Não <input type="radio" name="ativo" id="ativo" value="false" class="campo"/>
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