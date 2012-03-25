CREATE OR REPLACE FUNCTION autorizacoes_na_faixa(_inicial bigint, _final bigint)
  RETURNS record AS
$BODY$
  DECLARE result RECORD;
  DECLARE wret int;
begin
  select count(numero) qtde into result from aihs where numero between _inicial and _final;
  return result;
end$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION autorizacoes_na_faixa(bigint, bigint) OWNER TO postgres;

CREATE OR REPLACE FUNCTION atualiza_saldo_por_faixa() RETURNS integer AS
$$
 DECLARE result RECORD;
 DECLARE retorno int;
 DECLARE id int;
 DECLARE saldo1 bigint;
 DECLARE saldo2 bigint;
 DECLARE usei bigint;
 DECLARE usadas record;
 DECLARE inicio bigint;
 DECLARE fim bigint;
begin
  FOR result IN EXECUTE('SELECT id, inicial, final, saldo FROM faixas order by id')
  LOOP
    retorno = retorno + 1;
    id     = result.id;
    inicio = result.inicial;
    fim    = result.final;
    saldo1 = (fim - inicio) +1;
    for usadas in EXECUTE('select qtde from autorizacoes_na_faixa('||result.inicial||','||result.final||') as (qtde bigint)')
    loop
      usei = usadas.qtde;
      saldo2 = saldo1 - usei;
      EXECUTE ('update faixas set saldo='||saldo2||' where inicial = '||inicio||' and final ='||fim||'');
      EXECUTE ('update faixas set ultima=(select coalesce(max(aihs.numero), 0) as ultima from aihs where aihs.numero between '||inicio||' and '||fim||')');
    end loop;
    raise notice 'Id: %', id;
  END LOOP;
  EXECUTE ('update faixas set ativo = ''S''');
  EXECUTE ('update faixas set ativo = ''N'' where saldo= 0 or id_competencia <= 36');
  EXECUTE ('update faixas set ativo = ''N'' where ativo= ''S'' and saldo > 0 and id not in (101,103,107,115)');
  RETURN retorno;
end;
$$
  LANGUAGE plpgsql VOLATILE COST 100;
ALTER FUNCTION atualiza_saldo_por_faixa() OWNER TO postgres;

select atualiza_saldo_por_faixa()