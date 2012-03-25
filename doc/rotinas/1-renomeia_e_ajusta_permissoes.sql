ALTER TABLE opr_ups RENAME TO permissoes;
ALTER TABLE permissoes DROP CONSTRAINT pk_op_ups;

update permissoes set id_operador = 16 where id_operador=10;
update permissoes set id_operador = 19 where id_operador=11;
ALTER TABLE permissoes ADD CONSTRAINT pk_permissao PRIMARY KEY (id) USING INDEX TABLESPACE pg_default;
ALTER TABLE opr_ups_id_seq RENAME TO permissoes_id_seq;
ALTER TABLE permissoes ADD CONSTRAINT fk_permisao_operador FOREIGN KEY (id_operador) REFERENCES operadores (id) ON UPDATE NO ACTION ON DELETE NO ACTION;
ALTER TABLE permissoes ADD CONSTRAINT fk_permissao_estabelecimento FOREIGN KEY (id_estabelecimento) REFERENCES estabelecimentos (id) ON UPDATE NO ACTION ON DELETE NO ACTION;
ALTER TABLE permissoes drop cod_opr;
ALTER TABLE permissoes drop cod_ups;
COMMENT ON TABLE permissoes IS 'Cadastro de Competencias';
COMMENT ON TABLE permissoes IS 'Cadastro de Permissoes por Usuario';

SELECT setval('public.permissoes_id_seq', 42, true);

update operadores set nivel = 0 where id = 1;
update operadores set nivel = 1 where id in (16,22);
update operadores set nivel = 2 where id in (2, 3, 4, 14, 17, 18, 20, 21);
update operadores set nivel = 3 where id in (5, 6, 7, 8, 9, 12, 13, 19);
update operadores set ativo = 'N' where id in (7, 9, 14, 18);