alter table tipo_autorizacao rename to tipos;
alter table tipos rename cod_tipo to codigo;
alter table tipos rename dsc_tipo to descricao;

ALTER TABLE tipos ALTER codigo TYPE character varying(3);
ALTER TABLE tipos DROP CONSTRAINT pk_tipo_aut;
ALTER TABLE tipos ADD CONSTRAINT pk_tipo PRIMARY KEY (id);


CREATE OR REPLACE FUNCTION atualiza_tipo() RETURNS integer AS
$$
  DECLARE result RECORD;  DECLARE wret int;  DECLARE wid int;
begin
  FOR result IN EXECUTE('SELECT id FROM tipos order by id')
  LOOP
      wret = wret + 1; wid = result.id;
      EXECUTE ('update aihs   set id_tipo='||wid||' where tipo_aih='''||wid||'''');
      EXECUTE ('update faixas set id_tipo='||wid||' where faixa_tipo='''||wid||'''');
      raise notice 'Tipo: %', wid;
  END LOOP;
  RETURN wret;
end;
$$
  LANGUAGE plpgsql VOLATILE COST 100;
ALTER FUNCTION atualiza_tipo() OWNER TO postgres;
COMMENT ON FUNCTION atualiza_tipo() IS 'Percorre a Tabela de Tipos, Atualizando cada AIH e cada Faixa';

select atualiza_tipo();
ALTER TABLE aihs ADD CONSTRAINT fk_tipo FOREIGN KEY (id_tipo) REFERENCES tipos (id) ON UPDATE NO ACTION ON DELETE NO ACTION;
ALTER TABLE faixas ADD CONSTRAINT fk_tipo FOREIGN KEY (id_tipo) REFERENCES tipos (id) ON UPDATE NO ACTION ON DELETE NO ACTION;