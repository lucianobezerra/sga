CREATE OR REPLACE FUNCTION atualiza_ultima_por_faixa() RETURNS integer AS
$BODY$
 DECLARE result RECORD; declare ultima RECORD; DECLARE retorno int;
begin
  FOR result IN EXECUTE('SELECT id FROM faixas order by id')
  LOOP
    EXECUTE ('update faixas set ultima=(select coalesce(max(numero),0) as ultima from aihs where id_faixa='||result.id||') where id='||result.id||'');
    raise notice 'Id: %', result.id;
  END LOOP;
  EXECUTE ('update faixas set ultima=(inicial -1) where ultima=0');
  RETURN retorno;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE  COST 100;
ALTER FUNCTION atualiza_ultima_por_faixa() OWNER TO postgres;

select atualiza_ultima_por_faixa();