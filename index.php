<?php
require_once("class/Sessao.class.php");
require_once("class/Valida.class.php");

$session = new Session();
$session->start();
$logado = $session->getNode("id_operador");
if (!$logado) {
  @header('Location: login.html');
}

$valida = new Valida();

if (!$valida->validaSistema()) {
  header("Location: licenca.php");
  exit;
}
?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>SGA::Sistema de Gestão de Autorizações</title>
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
    <link rel="stylesheet" type="text/css" href="css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="css/menus.css"/>
    <script type='text/javascript' src='js/jquery.js'></script>
    <script type='text/javascript' src='js/jquery.form.js'></script>
    <script type='text/javascript' src='js/jquery.maskedinput.js'></script>
    <script type='text/javascript' src='js/jquery.cycle.all.js'></script>
    <script type='text/javascript'>
      $(function(){
        $('#top').cycle({ fx: 'fade', height: 120, width: 777 });
        $('#right').load("home.php");

        $('dd:not(:first)').hide();
        $('dt a').click(function(){
          $("dd:visible").slideUp("slow");
          $(this).parent().next().slideDown("slow");
          return false;
        });

        $('dt#inicio a').click(function(){
          $('#right').load(this.href);
          return false;
        });

        $('dd a').click(function(){
          $('#right').load(this.href);
          return false;
        });
        $('.sair').click(function(){
          $(window.document.location).attr('href',"sair.php");
        });
      });
      $('.ambiente').live('click', function(){
        $('#right').load($(this).attr('href'));
        return false;
      })
    </script>
  </head>
  <body>
    <div id="container">
      <div id="top">
<!--        <img src="imagens/banner_topo_p_1.jpg"/>
        <img src="imagens/banner_topo_p_2.jpg"/> -->
        <img src="imagens/banner_topo_p_3.jpg"/>
<!--        <img src="imagens/banner_topo_p_4.jpg"/> -->
      </div>
      <div id="left" style="height: 420px;"><?php include 'menus.php'; ?></div>
      <div id="right" style="overflow: auto; height: 400px"></div>
      <div id="bottom">&copy;2011 - <a style="display: inline" href="http://twitter.com/#!/lucianobezerra" target="_blank">@lucianobezerra</a>
      </div>
    </div>
  </body>
</html>