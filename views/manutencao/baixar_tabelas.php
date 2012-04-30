<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <script type="text/javascript">
      $(function($){
        $('input[name=download]').live('click', function(){
          $('#retorno').html("Requisitando o Arquivo ao Servidor, Aguarde ....");
          var url  = 'views/manutencao/processar_tabelas.php';
          var data = $('#upload').serialize();
          $.post(url, data, function(resposta){
            $('#retorno').html(resposta);
          });
          return false;
        });
      });
    </script>
  </head>
  <body>
    <form id="upload" action="#" method="post">
      <fieldset style="border: solid 1px; padding: 10px; margin: 10px">
        <legend>&nbsp;&nbsp;Importação dos Arquivos da Tabela Unificada&nbsp;&nbsp;</legend>
        Origem: ftp://ftp2.datasus.gov.br/public/sistemas/tup/downloads/<br>
        Nome do Arquivo:<input type="text" name="arquivo" id="arquivo" size="65" /><br/>
        <input type="submit" name="download" value="Download" />
      </fieldset>
    </form>
    <div id='retorno'></div>
  </body>
</html>
