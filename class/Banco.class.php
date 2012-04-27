<?php

abstract class Banco {

  private $servidor = 'localhost';
  private $usuario = 'postgres';
  private $senha = 'postgres';
  private $nomebanco = 'sga2';
  private $conexao = null;
  private $dataset = null;
  private $linhasafetadas = -1;

  public function __construct() {
    $this->conecta();
  }

  public function __destruct() {
    if ($this->conexao != null) {
      pg_close($this->conexao);
    }
  }

  public function conecta() {
    $this->conexao = pg_connect("host={$this->servidor} user={$this->usuario} password={$this->senha} dbname={$this->nomebanco}") or die($this->trataErro(__FILE__, __FUNCTION__, pg_errormessage(), true));
  }

  public function trataErro($arquivo = null, $rotina = null, $linha = null, $mensagemErro = null, $geraExcept = false) {
    if ($arquivo == null) {
      $arquivo = 'Não Informado';
    }
    if ($rotina == null) {
      $rotina = 'Não Informado';
    }
    if ($linha == null) {
      $linha = 'Não Informada';
    }
    if ($mensagemErro == null) {
      $mensagemErro = pg_errormessage($this->conexao);
    }
    $resultado = "Ocorreu um erro com os seguintes detalhes<br/>
                <strong>Arquivo: </strong>{$arquivo}<br/>
                <strong>Linha: </strong>{$linha}<br/>
                <strong>Rotina: </strong>{$rotina}<br/>
                <strong>Mensagem: </strong>{$mensagemErro}.";
    if ($geraExcept == false) {
      echo $resultado;
    } else {
      die($resultado);
    }
  }

  public function inserir($objeto) {
    $sql = "insert into {$objeto->tabela} (";
    for ($i = 0; $i < count($objeto->campos_valores); $i++) {
      $sql .= key($objeto->campos_valores);
      if ($i < (count($objeto->campos_valores) - 1)) {
        $sql .= ", ";
      } else {
        $sql .= ")";
      }
      next($objeto->campos_valores);
    }
    reset($objeto->campos_valores);
    $sql .= " values (";

    for ($i = 0; $i < count($objeto->campos_valores); $i++) {
      $sql .= is_numeric($objeto->campos_valores[key($objeto->campos_valores)]) ? $objeto->campos_valores[key($objeto->campos_valores)] : "'" . $objeto->campos_valores[key($objeto->campos_valores)] . "'";
      if ($i < (count($objeto->campos_valores) - 1)) {
        $sql .= ", ";
      } else {
        $sql .= ")";
      }
      next($objeto->campos_valores);
    }
    return $this->executaSql($sql);
  }

  public function atualizar($objeto) {
    $sql = "update {$objeto->tabela} SET ";
    for ($i = 0; $i < count($objeto->campos_valores); $i++) {
      $sql .= key($objeto->campos_valores) . "=";
      $sql .= is_numeric($objeto->campos_valores[key($objeto->campos_valores)]) ? $objeto->campos_valores[key($objeto->campos_valores)] : "'" . $objeto->campos_valores[key($objeto->campos_valores)] . "'";
      if ($i < (count($objeto->campos_valores) - 1)) {
        $sql .= ", ";
      } else {
        $sql .= " ";
      }
      next($objeto->campos_valores);
    }
    $sql .= "where {$objeto->campopk}=";
    $sql .= is_numeric($objeto->valorpk) ? $objeto->valorpk : "'" . $objeto->valorpk . "'";
    return $this->executaSql($sql);
  }

  public function desativar($objeto) {
    $sql = "update {$objeto->tabela} SET ativo=false where {$objeto->campopk}={$objeto->valorpk}";
    return $this->executaSql($sql);
  }

  public function seleciona($objeto) {
    $sql = "select * from {$objeto->tabela} where {$objeto->campopk}={$objeto->valorpk}";
    return $this->executaSql($sql);
  }

  public function selecionaTudo($objeto) {
    $sql = "select * from {$objeto->tabela} ";
    if ($objeto->extras_select != null) {
      $sql .= " " . $objeto->extras_select . " ";
    }
    return $this->executaSql($sql);
  }

  public function selecionaCampos($objeto) {
    $sql = "select ";
    for ($i = 0; $i < count($objeto->campos_valores); $i++) {
      $sql .= key($objeto->campos_valores);
      if ($i < (count($objeto->campos_valores) - 1)) {
        $sql .= ", ";
      } else {
        $sql .= " ";
      }
      next($objeto->campos_valores);
    }
    $sql .= " from {$objeto->tabela}";

    if ($objeto->extras_select != null) {
      $sql .= " " . $objeto->extras_select . " ";
    }
    return $this->executaSql($sql);
  }

  public function executaSql($sql = null) {
    if ($sql != null) {
      $query = pg_query($sql) or $this->trataErro(__FILE__, __FUNCTION__, __LINE__);
      $this->linhasafetadas = pg_affected_rows($query);
      if (substr(trim(strtolower($sql)), 0, 6) == 'select') {
        $this->dataset = $query;
        return $query;
      } else {
        return $this->linhasafetadas;
      }
    } else {
      $this->trataErro(__FILE__, __FUNCTION__, 'Dados para Cadastro nao informados, verifique o formulario', FALSE);
    }
  }

  public function retornaDados($tipo = null) {
    switch (strtolower($tipo)) {
      case "array" : return pg_fetch_array($this->dataset);
        break;
      case "assoc" : return pg_fetch_assoc($this->dataset);
        break;
      case "object": return pg_fetch_object($this->dataset);
        break;
      default : return pg_fetch_object($this->dataset);
        break;
    }
  }

  public function excluir($objeto) {
    $sql = "delete from {$objeto->tabela} where {$objeto->campopk}=";
    $sql .= is_numeric($objeto->valorpk) ? $objeto->valorpk : "'" . $objeto->valorpk . "'";
    return $this->executaSql($sql);
  }

}

?>
