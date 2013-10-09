<script type="text/javascript">
  $(function($){
    $('form#gera_senha').submit(function(){
      var data = $('input[name=data_limite]').val();
      var  url = 'libera_senha.php';
      $.post(url, {data: data}, function(resposta){
        $('div#retorno').html(resposta);
      })
      return false;
    });
  })
</script>

<p>Gerar Senha de Liberação:</p>
<br/>
<form id="gera_senha" method="post" action="#">
  <fieldset>
    Liberar Até: <input type="date" name="data_limite" size="10" placeholder="Nova Data"/><br/>
    <button name="gerar_senha" type="submit" style="width: 100px; height: 25px" class="campo">Gerar Senha</button>
  </fieldset>  
</form>

<div id='retorno'></div>