CREATE OR REPLACE FUNCTION atualiza_faixa_por_competencia() RETURNS integer AS
$$
  DECLARE result RECORD;  DECLARE wret int;  DECLARE wcmp varchar(6);  DECLARE wid int;
begin
  FOR result IN EXECUTE('SELECT id, ano||mes as cmpt FROM competencias order by id')
  LOOP
      wret = wret + 1;
      wcmp = result.cmpt;
      wid  = result.id;
      EXECUTE ('update faixas set id_competencia='||wid||' where faixa_cmpt='''||wcmp||'''');
      raise notice 'Competência: %', wcmp;
  END LOOP;
  RETURN wret;
end;
$$
  LANGUAGE plpgsql VOLATILE COST 100;
ALTER FUNCTION atualiza_faixa_por_competencia() OWNER TO postgres;
COMMENT ON FUNCTION atualiza_faixa_por_competencia() IS 'Percorre a Tabela de Competências, Atualizando cada Faixa';

select atualiza_faixa_por_competencia();

ALTER TABLE faixas ADD CONSTRAINT fk_competencia FOREIGN KEY (id_competencia) REFERENCES competencias (id) ON UPDATE NO ACTION ON DELETE NO ACTION;