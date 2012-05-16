<?php

require_once("Base.class.php");

class Autorizacao extends Base {

  public function __construct($campos = array()) {
    parent::__construct();
    $this->tabela = 'autorizacoes';
    if (sizeof($campos) <= 0) {
      $this->campos_valores = array(
          "id_operador" => null, 
          "id_estabelecimento" => null, 
          "id_tipo" => null, 
          "id_faixa" => null, 
          "id_competencia" => null, 
          "id_procedimento" => null, 
          "id_autorizador" => null, 
          "id_solicitante" => null, 
          "id_municipio" => null, 
          "numero" => null, 
          "digito" => null, 
          "nome_paciente" => null, 
          "data_nascimento" => null, 
          "data_emissao" => null, 
          "nome_da_mae" => null, 
          "sexo" => null, 
          "endereco" => null, 
          "bairro" => null, 
          "cep" => null, 
          "uf" => null, 
          "nome_responsavel" => null, 
          "raca_cor" => null, 
          "str_competencia" => null);
    } else {
      $this->campos_valores = $campos;
    }
    $this->campopk = 'id';
  }

  public function contaAutorizacoes($inicial, $final) {
    $sql = "select count(numero) as quantidade from autorizacoes ";
    $sql .= "where numero between {$inicial} and {$final}";
    $res = pg_query($sql);
    $ret = pg_fetch_array($res);
    return $ret['quantidade'];
  }

  public function ultima($id_faixa) {
    $sql_aih = "select coalesce(max(numero), 0) as ultima from autorizacoes where id_faixa={$id_faixa}";
    $res_aih = pg_query($sql_aih);
    $linha_aih = pg_fetch_array($res_aih);

    if ($linha_aih['ultima'] == 0) {
      $sql_faixa = "select (inicial -1) as primeira from faixas where id={$id_faixa}";
      $res_faixa = pg_query($sql_faixa);
      $linha_faixa = pg_fetch_array($res_faixa);
      return $linha_faixa['primeira'];
    } else {
      return $linha_aih['ultima'];
    }
  }

  public function proxima($id_faixa) {
    $ultima = $this->ultima($id_faixa);
    $proxima = $ultima + 1;
    return $proxima;
  }

  public function buscaDetalhada($id) {
    $sql = "select autorizacoes.numero||'-'||autorizacoes.digito as numero, estabelecimentos.cnes, estabelecimentos.nome_fantasia, tipos.descricao as tipo, faixas.inicial||' a '||faixas.final as faixa, ";
    $sql .= "competencias.ano||competencias.mes as competencia, operadores.nome nome_operador, autorizacoes.nome_pac, ";
    $sql .= "autorizacoes.nascimento, autorizacoes.internacao from autorizacoes ";
    $sql .= "inner join operadores on autorizacoes.id_operador=operadores.id ";
    $sql .= "inner join estabelecimentos on autorizacoes.id_estabelecimento = estabelecimentos.id ";
    $sql .= "inner join tipos on autorizacoes.id_tipo = tipos.id ";
    $sql .= "inner join faixas on autorizacoes.id_faixa = faixas.id ";
    $sql .= "inner join competencias on autorizacoes.id_competencia = competencias.id ";
    $sql .= "where autorizacoes.id={$id} ";
    $result = pg_query($sql);
    $retorno = pg_fetch_array($result);
    return $retorno;
  }

  public function selecionaUma($objeto) {
    $sql = "select * from {$objeto->tabela}";
    if ($objeto->extras_select != null) {
      $sql .= " " . $objeto->extras_select . " ";
    }
    return $this->executaSql($sql);
  }
  
  public function exibe($numero){
    $sql  = "select autorizacoes.numero||'-'||autorizacoes.digito as numero, estabelecimentos.cnes||' - '||estabelecimentos.nome_fantasia estabelecimento, tipos.descricao as tipo, ";
    $sql .= "       competencias.ano||competencias.mes as competencia, operadores.nome nome_operador, autorizacoes.nome_paciente, autorizacoes.data_nascimento, ";
    $sql .= "       autorizacoes.cartao_sus, autorizacoes.nome_da_mae, cidades.codigo ||' - '||cidades.descricao municipio, autorizacoes.cep, autorizacoes.nome_responsavel, autorizacoes.raca_cor, ";
    $sql .= "       solicitantes.cns||' - '||solicitantes.nome solicitante, procedimentos.codigo||' - '||substring(procedimentos.descricao from 1 for 55) procedimento, ";
    $sql .= "       cids.codigo||' - '||cids.descricao diagnostico, autorizacoes.data_emissao, autorizacoes.data_autoriza, autorizadores.cns||' - '||autorizadores.nome autorizador, ";
    $sql .= "       case autorizacoes.sexo ";
    $sql .= "                when 'M' then 'MASCULINO' ";
    $sql .= "                when 'F' then 'FEMININO' ";
    $sql .= "              end AS sexo, ";
    $sql .= "       case autorizacoes.raca_cor ";
    $sql .= "         when '1' then '01 - BRANCA' ";
    $sql .= "         when '2' then '02 - PRETA' ";
    $sql .= "         when '3' then '03 - PARDA' ";
    $sql .= "         When '4' then '04 - AMARELA' ";
    $sql .= "         when '5' then '05 - INDIGENA' ";
    $sql .= "         when '99' then '99 - SEM INFORMAÇÃO' ";
    $sql .= "       end AS raca_cor ";
    $sql .= "from autorizacoes ";
    $sql .= "inner join operadores on autorizacoes.id_operador=operadores.id ";
    $sql .= "inner join estabelecimentos on autorizacoes.id_estabelecimento = estabelecimentos.id ";
    $sql .= "inner join tipos on autorizacoes.id_tipo = tipos.id ";
    $sql .= "inner join faixas on autorizacoes.id_faixa = faixas.id ";
    $sql .= "inner join competencias on autorizacoes.id_competencia = competencias.id ";
    $sql .= "inner join cidades on autorizacoes.id_municipio = cidades.id ";
    $sql .= "inner join solicitantes on autorizacoes.id_solicitante = solicitantes.id ";
    $sql .= "inner join autorizadores on autorizacoes.id_autorizador = autorizadores.id ";
    $sql .= "inner join procedimentos on autorizacoes.id_procedimento = procedimentos.id and procedimentos.cmpt = competencias.ano||competencias.mes ";
    $sql .= "inner join cids on autorizacoes.id_diagnostico = cids.id ";
    $sql .= "where autorizacoes.numero={$numero}";
    $result = pg_query($sql);
    $retorno = pg_fetch_array($result);
    return $retorno;
  }

}

?>
