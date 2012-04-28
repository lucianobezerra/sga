<script type="text/javascript">
  $(function(){
    $('.upload').live('click', function(){
      $('#right').load($(this).attr('href'));
      return false;
    })
  });
</script>
<fieldset style="border: solid 1px; padding: 15px">
  <legend>Manutenção de Arquivos da Tabela Unificada</legend>
  <label style="width: 300px;"><a class="upload" href="views/manutencao/upload.php">Enviar Arquivos</a></label>
  <label style="width: 300px;"><a class="processar" href="views/manutencao/processa_arquivos.php">Importar TXT SIGTAP</a></label>
</fieldset>
