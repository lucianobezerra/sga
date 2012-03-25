ALTER TABLE operadores DROP CONSTRAINT tb_operadores_pkey cascade;
update operadores set id=op_id;
ALTER TABLE operadores ADD CONSTRAINT pk_operadores PRIMARY KEY (id) USING INDEX TABLESPACE pg_default;
