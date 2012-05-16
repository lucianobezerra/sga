
<?php
if (defined('ROOT_APP') == false) {
  define('ROOT_APP', $_SERVER['DOCUMENT_ROOT'] . "/sga");
}

require(ROOT_APP . '/util/funcoes.php');
require(ROOT_APP . '/class/Procedimento.class.php');
require(ROOT_APP . '/class/Cidade.class.php');
require(ROOT_APP . '/class/Estado.class.php');
require(ROOT_APP . '/class/ProcedimentoDetalhe.class.php');
require(ROOT_APP . '/class/ProcedimentoCid.class.php');
require(ROOT_APP . '/class/Competencia.class.php');
require(ROOT_APP . '/class/Permissao.class.php');
require(ROOT_APP . '/class/Autorizacao.class.php');
require(ROOT_APP . '/class/Estabelecimento.class.php');

$acao  = isset($_REQUEST['acao'])     ? $_REQUEST['acao']     : null;
$id    = isset($_REQUEST['id'])       ? $_REQUEST['id']       : null;
$valor = isset($_POST['searchField']) ? $_POST['searchField'] : null;

switch ($acao) {
  case "inserir": inserir();         break;
  case "alterar": alterar($id);      break;
  case "listagem": listagem();       break;
  case "localiza": localiza($valor); break;
  case "exibir": exibir($id);        break;
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

function formataCompetencia($cmpt) {
  $cp = new Competencia();
  $cp->valorpk = $cmpt;
  $cp->strCompetencia($cp);
  $strCmpt = '';
  while ($s = $cp->retornaDados("array")) {
    $strCmpt = $s[0];
  }
  return $strCmpt;
}

function exigeCartaoSUS($procedimento, $cmpt) {
  $strCmpt = formataCompetencia($cmpt);
  $pd = new ProcedimentoDetalhe();
  $pd->extras_select = "where codigo_procedimento = '{$procedimento}' and codigo_detalhe='009' and cmpt = '{$strCmpt}'";
  $pd->exigeCNS($pd);
  $retorno = '';
  while ($s = $pd->retornaDados("array")) {
    $retorno = $s[0];
  }
  return ($retorno > 0 ) ? true : false;
}

function compativel($procedimento, $cid, $cmpt) {
  $strCmpt = formataCompetencia($cmpt);
  $retorno = '';

  $pc = new ProcedimentoCid();
  $pc->extras_select = "where codigo_procedimento='{$procedimento}' and codigo_cid='{$cid}' and cmpt='{$strCmpt}'";
  $pc->compativel($pc);
  while ($s = $pc->retornaDados("array")) {
    $retorno = $s[0];
  }
  return ($retorno > 0 ) ? true : false;
}

function atualizaSaldo($id, $valor) {
  $ups = new Estabelecimento();
  $ups->setValor("valor_saldo", $valor);
  $ups->valorpk = $id;
  $ups->delCampo("cnes");
  $ups->delCampo("razao_social");
  $ups->delCampo("nome_fantasia");
  $ups->delCampo("valor_teto");
  $ups->delCampo("valor_medio");
  $ups->delCampo("emite_aih");
  $ups->delCampo("emite_apac");
  $ups->delCampo("bloqueia_teto");
  $ups->delCampo("ativo");
  $ups->atualizar($ups);
}

function pegaValor($id_procedimento, $id_competencia) {
  $strCmpt = formataCompetencia($id_competencia);
  $valor = null;
  $procedimento = new Procedimento();
  $procedimento->extras_select = "where id={$id_procedimento} and cmpt='{$strCmpt}'";
  $procedimento->retornaValor($procedimento);
  while($linha = $procedimento->retornaDados()){
    $valor = $linha->valor;
  }
  return $valor;
}

function inserir() {
  if (exigeCartaoSus($_POST['id_procedimento'], $_POST['id_competencia']) == true) {
    if ((validaCNS($_POST['cns']) == false) || (validaCNS_PROVISORIO($_POST['cns']) == false)) {
      echo "Cartão SUS inválido ou não informado!";
      exit;
    }
  }

  if (compativel($_POST['id_procedimento'], $_POST['id_diagnostico'], $_POST['id_competencia']) == false) {
    echo "Erro - Diagnóstico Incompatível com o Procedimento!";
    exit;
  }

  $autorizacao = new Autorizacao();
  $autorizacao->delCampo("digito");
  $autorizacao->delCampo("data_emissao");
  $numero = $autorizacao->proxima($_POST['id_faixa']);
  $digito = (fmod($numero, 11) == 10) ? 0 : fmod($numero, 11);
  $autorizacao->setValor("numero", $numero);
  $autorizacao->setValor("id_competencia",     $_POST['id_competencia']);
  $autorizacao->setValor("id_estabelecimento", $_POST['id_estabelecimento']);
  $autorizacao->setValor("id_faixa",           $_POST['id_faixa']);
  $autorizacao->setValor("id_operador",        $_POST['id_operador']);
  $autorizacao->setValor("id_tipo",            $_POST['id_tipo']);
  $autorizacao->setValor("id_autorizador",     $_POST['id_autorizador']);
  $autorizacao->setValor("id_solicitante",     $_POST['id_solicitante']);
  $autorizacao->setValor("id_municipio",       $_POST['hidden_municipio']);
  $autorizacao->setValor("uf",                 $_POST['hidden_estado']);
  $autorizacao->setValor("id_procedimento",    $_POST['hidden_procedimento']);
  $autorizacao->setValor("id_diagnostico",     $_POST['hidden_diagnostico']);
  $autorizacao->setValor("cartao_sus",         $_POST['cns']);
  $autorizacao->setValor("nome_paciente",      strtoupper($_POST['nome_paciente']));
  $autorizacao->setValor("nome_da_mae",        strtoupper($_POST['nome_mae']));
  $autorizacao->setValor("nome_responsavel",   strtoupper($_POST['nome_responsavel']));
  $autorizacao->setValor("sexo",               strtoupper($_POST['sexo']));
  $autorizacao->setValor("endereco",           strtoupper($_POST['endereco']));
  $autorizacao->setValor("bairro",             strtoupper($_POST['bairro']));
  $autorizacao->setValor("cep",                str_replace('-', '', $_POST['cep']));
  $autorizacao->setValor("raca_cor",           $_POST['raca_cor']);
  $autorizacao->setValor("data_autoriza",      ConverteDataParaEUA($_POST['data_autoriza']));
  $autorizacao->setValor("data_nascimento",    ConverteDataParaEUA($_POST['data_nascimento']));
  $autorizacao->setValor("str_competencia",    formataCompetencia($_POST['id_competencia']));
  if ($autorizacao->inserir($autorizacao) == 1) {
/*    $unidade = new Estabelecimento("valor_saldo");
    $unidade->valorpk = $_POST['id_estabelecimento'];
    $saldo_atual = $unidade->getValor("valor_saldo");
    atualizaSaldo($_POST['id_estabelecimento'], ($saldo_atual - pegaValor($_POST['hidden_procedimento'], $_POST['id_competencia'])));
  */  echo $numero;
  }
}

function listagem() {
  $session = new Session();
  $session->start();
  $cmpt = $session->getNode("id_competencia");

  $operador = $_POST['_operador'];
  $unidade = $_POST['_estabelecimento'];
  $tipo = $_POST['_tipo'];

  $and_operador = ($_POST['_operador'] == 999) ? "" : "and id_operador={$operador}";
  $and_unidade = ($_POST['_estabelecimento'] == 999) ? "" : "and id_estabelecimento={$unidade}";
  $and_tipo = ($_POST['_tipo'] == 999) ? "" : "and id_tipo={$tipo}";

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
      <td style="width: 14%; text-align: center">Autorização</td>
    </tr> 
  <? while ($linha = $autorizacao->retornaDados()) { ?>
      <tr>
        <td style="text-align: center"><?= $linha->numero . $linha->digito ?></td>
        <td style="text-align: left"  ><?= $linha->nome_paciente ?></td>
        <td style="text-align: center"><?= ConverteDataParaBR($linha->data_nascimento) ?></td>
        <td style="text-align: center"><?= ConverteDataParaBR($linha->data_autoriza) ?></td>
      </tr>
      <?
    }
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
      $autorizacao->setValor("nome_pac", strtoupper($_POST['nome_paciente']));
      $autorizacao->setValor("nascimento", ConverteDataParaEUA($_POST['nascimento']));
      $autorizacao->setValor("internacao", ConverteDataParaEUA($_POST['internacao']));
      $autorizacao->valorpk = $id;
      $autorizacao->delCampo("numero");
      $autorizacao->delCampo("digito");
      $autorizacao->atualizar($autorizacao);
    }
    ?>
