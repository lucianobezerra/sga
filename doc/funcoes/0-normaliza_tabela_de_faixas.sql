alter table faixa_aih rename to faixas;
ALTER TABLE faixas RENAME id_faixa  TO id;
ALTER TABLE faixas RENAME faixa_inicial  TO inicial;
ALTER TABLE faixas RENAME faixa_final  TO final;
ALTER TABLE faixas RENAME faixa_ultima  TO ultima;
ALTER TABLE faixas RENAME faixa_saldo  TO saldo;
ALTER TABLE faixas RENAME faixa_cadastro  TO data_cadastro;
ALTER TABLE faixas RENAME faixa_ativo  TO ativo;
ALTER TABLE faixas DROP CONSTRAINT "pkey.faixa";
ALTER TABLE faixas ADD CONSTRAINT pk_faixa PRIMARY KEY (id) USING INDEX TABLESPACE pg_default;

CREATE OR REPLACE FUNCTION faixa_b_ins() RETURNS trigger AS
$BODY$begin
 select current_date into new.data_cadastro;
 select (new.inicial -1) into new.ultima ;
 select (new.final - new.inicial) +1 into new.saldo;
 return NEW;
end;$BODY$
LANGUAGE plpgsql VOLATILE
COST 100;
ALTER FUNCTION faixa_b_ins() OWNER TO postgres;

insert into faixas (inicial, final, ultima, ativo, id_tipo, id_competencia) values (230810382761,230810383960,230810382760,'N',1,7);
insert into faixas (inicial, final, ultima, ativo, id_tipo, id_competencia) values (230810420453,230810421652,230810382760,'N',1,8);
insert into faixas (inicial, final, ultima, ativo, id_tipo, id_competencia) values (230810475946,230810477145,230810475945,'N',1,10);
insert into faixas (inicial, final, ultima, ativo, id_tipo, id_competencia) values (230810547229,230810547628,230810547228,'N',1,12);
insert into faixas (inicial, final, ultima, ativo, id_tipo, id_competencia) values (230817005001,230817005600,230817005000,'N',2,4);
insert into faixas (inicial, final, ultima, ativo, id_tipo, id_competencia) values (230817010821,230817011020,230817010820,'N',2,9);
insert into faixas (inicial, final, ultima, ativo, id_tipo, id_competencia) values (230817012006,230817012305,230817012005,'N',2,10);
insert into faixas (inicial, final, ultima, ativo, id_tipo, id_competencia) values (230820347251,230820347329,230820347250,'N',4,9);
insert into faixas (inicial, final, ultima, ativo, id_tipo, id_competencia) values (230820347330,230820347531,230820347329,'N',4,10);
insert into faixas (inicial, final, ultima, ativo, id_tipo, id_competencia) values (230820435675,230820435770,230820435674,'N',4,10);
insert into faixas (inicial, final, ultima, ativo, id_tipo, id_competencia) values (230820435771,230820435774,230820435770,'N',4,11);
insert into faixas (inicial, final, ultima, ativo, id_tipo, id_competencia) values (230820449341,230820449457,230820449340,'N',4,11);
insert into faixas (inicial, final, ultima, ativo, id_tipo, id_competencia) values (230820449458,230820449717,230820449457,'N',4,12);
insert into faixas (inicial, final, ultima, ativo, id_tipo, id_competencia) values (230910050925,230910052124,230910050924,'N',1,13);
insert into faixas (inicial, final, ultima, ativo, id_tipo, id_competencia) values (230920023907,230920024005,230920023906,'N',2,14);
insert into faixas (inicial, final, ultima, ativo, id_tipo, id_competencia) values (230920104840,230920104863,230920104839,'N',2,15);
insert into faixas (inicial, final, ultima, ativo, id_tipo, id_competencia) values (230920023605,230920023906,230920023634,'N',2,12);
insert into faixas (inicial, final, ultima, ativo, id_tipo, id_competencia) values (230810447699,230810448898,230810447698,'N',1,9);
insert into faixas (inicial, final, ultima, ativo, id_tipo, id_competencia) values (230810498401,230810499600,230810498400,'N',1,11);

CREATE OR REPLACE FUNCTION atualiza_aih_por_faixa() RETURNS integer AS
$$  DECLARE result RECORD; DECLARE wret int; DECLARE ini bigint; DECLARE fim bigint; DECLARE wid int;
begin
  FOR result IN EXECUTE('SELECT id, inicial, final FROM faixas order by id')
  LOOP
    wret := wret + 1; ini  := result.inicial; fim  := result.final; wid  := result.id;
    EXECUTE ('update aihs set id_faixa='||wid||' where cast(num_aih as bigint) >= '||ini||' and cast(num_aih as bigint) <= '||fim||' and id_faixa=0');
    raise notice 'Id: %', wid;
  END LOOP;
  RETURN wret;
end;
$$
LANGUAGE plpgsql VOLATILE COST 100;
ALTER FUNCTION atualiza_aih_por_faixa() OWNER TO postgres;
COMMENT ON FUNCTION atualiza_aih_por_faixa() IS 'Percorre a Tabela de Faixas, Atualizando Saldo de cada Faixa';

