<?php
require_once('class/Faixa.class.php');
require_once('class/Login.class.php');
require_once('class/Sessao.class.php');

$faixas = new Faixa();
$listagem = $faixas->lista();

$session = new Session();
$session->start();
$nome_operador = $session->getNode("nome_operador");
$cp = $session->getNode("id_competencia");
if(!$session->check()):
  $link_ambiente = "<a class='ambiente' href='ambiente.php'>CONFIGURAR AMBIENTE PARA {$nome_operador}</a>";
else:
  $link_ambiente = "<a class='ambiente' href='ambiente.php'>AMBIENTE DE {$nome_operador}. CLIQUE PARA RECONFIGURAR</a>";
endif;
?>
<div id="ambiente"><?php echo $link_ambiente; ?></div>
<p>Informações Iniciais:</p>
<table width="100%" border="1" align="center">
  <thead>
    <tr>
      <th width="30%" style="text-align: left">Tipo</th>
      <th width="20%"style="text-align: center">Inicial</th>
      <th width="20%"style="text-align: center">Final</th>
      <th width="20%"style="text-align: center">Última</th>
      <th width="8%" style='text-align:center;'>Saldo</th>
    </tr>
  </thead>
  <?php
  foreach ($listagem as $faixa) {
    $ultima = str_pad($faixa['ultima'], 12, '0', STR_PAD_LEFT);
    $ultima = substr($ultima, 0, 2) . '.' . substr($ultima, 2, 2) . '.' . substr($ultima, 4, 1) . '.' . substr($ultima, 5, 7);
    echo "<tr>";
    echo "<td style='text-align:left;'>" . $faixa['tipo'] . "</td>";
    echo "<td style='text-align:center;'>" . $faixa['inicial'] . "</td>";
    echo "<td style='text-align:center;'>" . $faixa['final'] . "</td>";
    echo "<td style='text-align:center;'>" . $ultima . "</td>";
    echo "<td style='text-align:center;'>" . $faixa['saldo'] . "</td>";
    echo "</tr>";
  }
  ?>
</table>
<div class="aviso">
  Atenção: <br/>
  Essa aplicação só funcionará satisfatoriamente se atendidos os requisitos abaixo:<br/>
  a) Navegador Mozilla Firefox 4.0 ou superior;<br/>
  b) Resolução <span class="requisito">Mínima</span> de 1024x768px<br/>
  c) Velocidade <span class="requisito">Mínima</span> de Conexão a Internet de 1mb;<br/><br/><br/>
</div>
<div style="height: 100px; margin-top: 60px; border: none;">
  <a href="http://affiliates.mozilla.org/link/banner/16211"><img src="imagens/firefox.png" alt="Atualização" /></a>
  <div id="cmpt" style="text-align: right">Competência: <?=$cp; ?></div>
</div>