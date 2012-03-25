drop table aihs_temp;
CREATE TABLE aihs_temp(
  id serial not null,
  id_operador integer NOT NULL,
  id_estabelecimento integer NOT NULL DEFAULT 0,
  id_tipo integer NOT NULL DEFAULT 0,
  id_faixa integer NOT NULL DEFAULT 0,
  id_competencia integer NOT NULL DEFAULT 0,
  numero bigint NOT NULL DEFAULT 0,
  digito integer NOT NULL,
  nome_pac character varying(60) NOT NULL,
  nascimento date NOT NULL,
  internacao date NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_aih FOREIGN KEY (id_estabelecimento) REFERENCES estabelecimentos (id) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_faixa FOREIGN KEY (id_faixa) REFERENCES faixas (id) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_operador FOREIGN KEY (id_operador) REFERENCES operadores (id) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_tipo FOREIGN KEY (id_tipo) REFERENCES tipos (id) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION);

  insert into aihs_temp (id_operador, id_estabelecimento, id_tipo, id_faixa, id_competencia, numero, digito, nome_pac, nascimento, internacao) 
                  select id_operador, id_estabelecimento, id_tipo, id_faixa, id_competencia, numero, digito, nome_pac, nascimento, internacao from aihs order by id_competencia,id_estabelecimento, id_faixa;


  drop table aihs;
  alter table aihs_temp rename to aihs;