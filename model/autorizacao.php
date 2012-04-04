<?php
require('../class/Autorizacao.class.php');
require('../class/Sessao.class.php');
require('../class/Permissao.class.php');
require('../util/funcoes.php');

$acao  = isset($_REQUEST['acao']) ? $_REQUEST['acao'] : null;
$id    = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
$valor = isset($_POST['searchField']) ? $_POST['searchField'] : null;

switch ($acao) {
  case "inserir": inserir();          break;
  case "alterar": alterar($id);       break;
  case "listagem": listagem();        break;
  case "localiza": localiza($valor);  break;
  case "exibir": exibir($id);         break;
}

function exibir($id) {
  $autorizacao = new Autorizacao();
  $linha = $autorizacao->buscaDetalhada($id);
  ?>
  <table width='100%' border='1' style='margin-top: 6px; font-size: 10pt; line-height: 130%'>
    <tr>
      <td>Número</td>
      <td style="color: blue; font-weight: bold;"><?= $linha['numero'] ?> </td>
    </tr>
    <tr>
      <td>Estabelecimento</td>
      <td><?= $linha['cnes'] . ' - ' . $linha['nome_fantasia'] ?> </td>
    </tr>
    <tr>
      <td>Tipo Autorização</td>
      <td><?= $linha['tipo'] ?> </td>
    </tr>
    <tr>
      <td>Faixa</td>
      <td><?= $linha['faixa'] ?> </td>
    </tr>
    <tr>
      <td>Competência</td>
      <td><?= formata_competencia($linha['competencia']) ?> </td>
    </tr>
    <tr>
      <td>Operador</td>
      <td><?= $linha['nome_operador'] ?> </td>
    </tr>
    <tr>
      <td>Nome do Paciente</td>
      <td><?= $linha['nome_pac'] ?> </td>
    </tr>
    <tr>
      <td>Data Nascimento</td>
      <td><?= ConverteDataParaBR($linha['nascimento']); ?> </td>
    </tr>
    <tr>
      <td>Data Internação</td>
      <td><?= ConverteDataParaBR($linha['internacao']); ?> </td>
    </tr>
  </table>
<?
}

function inserir() {
  $autorizacao = new Autorizacao();
  $autorizacao->delCampo("digito");
  $numero = $autorizacao->proxima($_POST['id_faixa']);
  $digito = (fmod($numero, 11) == 10) ? 0 : fmod($numero, 11);
  $autorizacao->setValor("id_competencia", $_POST['id_competencia']);
  $autorizacao->setValor("id_estabelecimento", $_POST['id_estabelecimento']);
  $autorizacao->setValor("id_faixa", $_POST['id_faixa']);
  $autorizacao->setValor("id_operador", $_POST['id_operador']);
  $autorizacao->setValor("id_tipo", $_POST['id_tipo']);
  $autorizacao->setValor("numero", $numero);
  $autorizacao->setValor("internacao", ConverteDataParaEUA($_POST['internacao']));
  $autorizacao->setValor("nascimento", ConverteDataParaEUA($_POST['nascimento']));
  $autorizacao->setValor("nome_pac", strtoupper($_POST['nome_paciente']));
  if ($autorizacao->inserir($autorizacao) == 1) {
    $retorno = substr($numero, 0, 2) . '.' . substr($numero, 2, 2) . '.' . substr($numero, 4, 1) . '.' . substr($numero, 5, 7);
    echo "AUTORIZAÇÃO: {$retorno}-{$digito}";
  }
}

function listagem() {
  $session = new Session();
  $session->start();
  $cmpt = $session->getNode("id_competencia");

  $operador = $_POST['_operador'];
  $unidade  = $_POST['_estabelecimento'];
  $tipo     = $_POST['_tipo'];
  
  $and_operador = ($_POST['_operador'] == 999)        ? "" : "and id_operador={$operador}";
  $and_unidade  = ($_POST['_estabelecimento'] == 999) ? "" : "and id_estabelecimento={$unidade}";
  $and_tipo     = ($_POST['_tipo'] == 999)            ? "" : "and id_tipo={$tipo}";
  
  $autorizacao = new Autorizacao();
  $autorizacao->extras_select = "where id_competencia={$cmpt} {$and_unidade} {$and_operador} {$and_tipo}";
  $autorizacao->selecionaTudo($autorizacao);
  ?>
  <table  border='1' style='width: 100%; margin-top: 15px;'>
    <tr style="background: #f90;">
      <th colspan='4' style='text-align:center;'>LISTAGEM DE AUTORIZAÇÕES</th>
    </tr>
    <tr style="background: #ffb;">
      <td style="width: 18%; text-align: center">Autorização</td>
      <td style="width: 54%">Paciente</td>
      <td style="width: 14%; text-align: center">Nascimento</td>
      <td style="width: 14%; text-align: center">Internação</td>
    </tr> 
  <? while($linha = $autorizacao->retornaDados()){ ?>
      <tr>
        <td style="text-align: center"><?=$linha->numero.$linha->digito ?></td>
        <td style="text-align: left"  ><?=$linha->nome_pac ?></td>
        <td style="text-align: center"><?=ConverteDataParaBR($linha->nascimento) ?></td>
        <td style="text-align: center"><?=ConverteDataParaBR($linha->internacao) ?></td>
      </tr>
  <? }
    echo "</table>";
  }

function localiza($valor) {
  $where = '';
  $session = new Session();
  $session->start();
  $operador = $session->getNode("id_operador");

  $where .= is_numeric($valor) ? "where numero = $valor " : "where upper(nome_pac) like upper('%$valor%') ";
  $hist = isset($_POST['historico']) ? $_POST['historico'] : null;
  if (!$hist):
    $cmpt = $session->getNode("id_competencia");
    $where .= "and id_competencia={$cmpt}";
  endif;

  $autorizacao = new Autorizacao();
  $autorizacao->extras_select = $where;
  $autorizacao->selecionaTudo($autorizacao);
  ?>
  <table  id='dados' border='1' style='width: 100%; margin-top: 15px;'>
    <tr style="background: #f90;">
      <th colspan='4' style='text-align:center;'>AUTORIZAÇÕES LOCALIZADAS</th>
    </tr>
    <tr style="background: #ffb;">
      <td style="width: 18%; text-align: center">Autorização</td>
      <td style="width: 54%">Paciente</td>
      <td style="width: 14%; text-align: center">Nascimento</td>
      <td style="width: 14%; text-align: center">Internação</td>
    </tr>
        <?
            $permissao = new Permissao();
            while ($linha = $autorizacao->retornaDados()) {
         ?>
      <tr>
        <td style="text-align: center"><a class='show' href='#' onclick='exibir(<?= $linha->id ?>)' title="Detalhar"><?= "{$linha->numero}-{$linha->digito}" ?></a> </td>
        <td>
    <?php
    $possui_permissao = $permissao->checaPermissao($operador, $linha->id_estabelecimento);
    echo ($possui_permissao == true) ? "<a class='alterar' href='views/autorizacoes/alterar.php?id={$linha->id}' title='Alterar'>" . substr($linha->nome_pac, 0, 30) . "</a>" : substr($linha->nome_pac, 0, 30)
    ?>
        </td>
        <td style="text-align: center"><?= ConverteDataParaBR($linha->nascimento) ?> </td>
        <td style="text-align: center"><?= ConverteDataParaBR($linha->internacao) ?> </td>
      </tr>
  <?
  }
  echo "</table>";
}

function alterar($id) {
  $autorizacao = new Autorizacao();
  $autorizacao->setValor("nome_pac",   strtoupper($_POST['nome_paciente']));
  $autorizacao->setValor("nascimento", ConverteDataParaEUA($_POST['nascimento']));
  $autorizacao->setValor("internacao", ConverteDataParaEUA($_POST['internacao']));
  $autorizacao->valorpk = $id;
  $autorizacao->delCampo("numero");
  $autorizacao->delCampo("digito");
  $autorizacao->atualizar($autorizacao);
}
?>
