CREATE OR REPLACE FUNCTION conta_autorizacoes_na_faixa(_inicial bigint, _final bigint)
  RETURNS record AS
$BODY$
  DECLARE result RECORD;
  DECLARE wret int;
begin
  select count(numero) as qtde into result from aihs where numero between _inicial and _final;
  return result;
end$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION conta_autorizacoes_na_faixa(bigint, bigint) OWNER TO postgres;
