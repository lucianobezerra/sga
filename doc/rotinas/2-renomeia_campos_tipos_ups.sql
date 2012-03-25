ALTER TABLE ups_tipo RENAME TO tipos_por_estabelecimento;
ALTER TABLE tipos_por_estabelecimento ADD COLUMN id_estabelecimento integer NOT NULL DEFAULT 0;
update tipos_por_estabelecimento set id_estabelecimento = 1 where cod_ups='2795329';
update tipos_por_estabelecimento set id_estabelecimento = 2 where cod_ups='2426056';
update tipos_por_estabelecimento set id_estabelecimento = 3 where cod_ups='2426080';
update tipos_por_estabelecimento set id_estabelecimento = 4 where cod_ups='2426099';
update tipos_por_estabelecimento set id_estabelecimento = 5 where cod_ups='2562499';
update tipos_por_estabelecimento set id_estabelecimento = 6 where cod_ups='6011578';
update tipos_por_estabelecimento set id_estabelecimento = 7 where cod_ups='2426072';
update tipos_por_estabelecimento set id_estabelecimento = 8 where cod_ups='3616711';

ALTER TABLE tipos_por_estabelecimento DROP CONSTRAINT "pk_ups.tipo";

ALTER TABLE tipos_por_estabelecimento RENAME cod_tipo  TO id_tipo;
ALTER TABLE tipos_por_estabelecimento ALTER id_tipo TYPE "char";

ALTER TABLE tipos_por_estabelecimento ALTER COLUMN id_tipo TYPE integer USING convertecharparainteiro(id_tipo);

ALTER TABLE tipos_por_estabelecimento ADD COLUMN id serial NOT NULL;
ALTER TABLE tipos_por_estabelecimento ADD CONSTRAINT pk_tipos_por_estabelecimento PRIMARY KEY (id) USING INDEX TABLESPACE pg_default;
ALTER TABLE tipos_por_estabelecimento ADD CONSTRAINT fk_tipos_estabelecimento FOREIGN KEY (id_estabelecimento) REFERENCES estabelecimentos (id) ON UPDATE NO ACTION ON DELETE NO ACTION;
ALTER TABLE tipos_por_estabelecimento ADD CONSTRAINT fk_tipo_tipo FOREIGN KEY (id_tipo) REFERENCES tipos (id) ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE tipos_por_estabelecimento DROP COLUMN cod_ups;