<?php
if (defined('ROOT_APP') == false) {
  define('ROOT_APP', $_SERVER['DOCUMENT_ROOT'] . '/sga');
}

require_once(ROOT_APP.'/class/Sessao.class.php');
$session = new Session();
$session->start();
$competencia = $session->getNode("id_competencia");
if(!isset($competencia)){
 echo "<p style='font-size: 12pt; margin-top: 12px; color: red'><a class='ambiente' href='ambiente.php'>Ambiente não configurado, clique para configurar</a></p>";
 exit();
}
?>
<html>
  <head>
    <script type="text/javascript">
      $(function(){
        $('.upload').live('click', function(){
          $('#right').load($(this).attr('href'));
          return false;
        })
        $('.processar').live('click', function(e){
          e.preventDefault();
          $('#right').load($(this).attr('href'));
          return false;
        });
      });
    </script>
  </head>
  <body>
    <fieldset style="border: solid 1px; padding: 15px">
      <legend>Manutenção de Arquivos da Tabela Unificada</legend>
      <label style="width: 300px;"><a class="upload" href="views/manutencao/baixar_tabelas.php">Baixar Tabelas SigTap</a></label>
      <label style="width: 300px;"><a class="processar" href="views/manutencao/processa_arquivos.php">Importar TXT SIGTAP</a></label>
    </fieldset>
  </body>
</html>