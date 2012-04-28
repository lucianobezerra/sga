<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <style type="text/css">
      #upload{
        margin:30px 200px; padding:10px;
        font-weight:bold; font-size:0.8em;
        font-family:Arial, Helvetica, sans-serif;
        text-align:center;
        background:#f2f2f2;
        color:#3366cc;
        border:1px solid #ccc;
        width:80px;
        cursor:pointer !important;
        -moz-border-radius:5px; -webkit-border-radius:5px;
      }
      .darkbg{
        background:#ddd !important;
      }
      #status{
        font-family:Arial; padding:5px;
      }
      ul#files{ list-style:none; padding:0; margin:0; }
      ul#files li{ padding:10px; margin-bottom:2px; width:200px; float:left; margin-right:10px;}
      ul#files li img{ max-width:180px; max-height:150px; }
      .success{ background:#99f099; border:1px solid #339933; }
      .error{ background:#f0c6c3; border:1px solid #cc6622; color: red }

    </style>
    <script type="text/javascript">
      $(function(){
        var btnUpload=$('#upload');
        var status=$('#status');
        new AjaxUpload(btnUpload, {
          action: 'views/manutencao/processa.php',
          name: 'uploadfile',
          onSubmit: function(file, ext){
            if (! (ext && /^(txt)$/.test(ext))){
              status.text('Somente envio de TXT é permitido');
              return false;
            }
            status.text('Enviando...');
          },
          onComplete: function(file, response){
            status.text('');
            if(response==="success"){
              $('#result').html('Arquivo '+file+ ' Enviado com Sucesso...').addClass('success');
            } else{
              $('#result').html('Erro no envio do arquivo: '+file).addClass('error');
            }
          }
        });
      });
    </script>
  </head>
  <body>
    <div style="border: none;">
      <p>Use essa tela para enviar os seguintes arquivos:</p>
      <p> -> Tabela de Procedimentos: tb_procedimento.txt</p>
      <p> -> Tabela de Diagnósticos: tb_cid.txt</p>
      <div id="upload" >Enviar Arquivo</div><span id="status" ></span>
      <ul id="files" ></ul>
    </div>
    <div id="result"></div>
  </body>
</html>
