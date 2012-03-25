alter table competencia rename to competencias;

CREATE OR REPLACE FUNCTION atualiza_aih_por_competencia() RETURNS integer AS
$BODY$
  DECLARE result RECORD;  DECLARE wret int;  DECLARE wcmp varchar(6);  DECLARE wid int;
begin
  FOR result IN EXECUTE('SELECT id, ano||mes as cmpt FROM competencias order by id')
  LOOP
      wret = wret + 1;
      wcmp = result.cmpt;
      wid  = result.id;
      EXECUTE ('update aihs set id_competencia='||wid||' where cmpt_aih='''||wcmp||'''');
      raise notice 'Competência: %', wcmp;
  END LOOP;
  RETURN wret;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION atualiza_aih_por_competencia() OWNER TO postgres;
COMMENT ON FUNCTION atualiza_aih_por_competencia() IS 'Percorre a Tabela de Competências, Atualizando cada AIH';

select atualiza_aih_por_competencia();
