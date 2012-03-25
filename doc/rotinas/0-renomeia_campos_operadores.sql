ALTER TABLE operadores DROP CONSTRAINT uk_login_operador;

ALTER TABLE operadores RENAME op_login  TO "login";
ALTER TABLE operadores RENAME op_nome  TO nome;
ALTER TABLE operadores RENAME op_senha  TO senha;
ALTER TABLE operadores RENAME op_ativo  TO ativo;

delete from aihs where id_operador in (1, 14, 16);

ALTER TABLE operadores ADD CONSTRAINT uk_operadores UNIQUE ("login") USING INDEX TABLESPACE pg_default;