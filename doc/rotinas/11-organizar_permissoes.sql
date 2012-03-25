DROP TABLE permissoes;

CREATE TABLE permissoes(
  id serial NOT NULL,
  id_operador integer,
  id_estabelecimento integer,
  CONSTRAINT pk_permissao PRIMARY KEY (id),
  CONSTRAINT fk_permisao_operador FOREIGN KEY (id_operador) REFERENCES operadores (id) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_permissao_estabelecimento FOREIGN KEY (id_estabelecimento) REFERENCES estabelecimentos (id) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION);
  
insert into permissoes (id_operador, id_estabelecimento) values (1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6), (1, 7), (1, 8);
insert into permissoes (id_operador, id_estabelecimento) values (2, 2), (2, 3), (2, 4), (2, 5), (2, 7);
insert into permissoes (id_operador, id_estabelecimento) values (3, 2), (3, 3), (3, 4), (3, 5), (3, 7);
insert into permissoes (id_operador, id_estabelecimento) values (5, 3);
insert into permissoes (id_operador, id_estabelecimento) values (8, 7);
insert into permissoes (id_operador, id_estabelecimento) values (12, 1);
insert into permissoes (id_operador, id_estabelecimento) values (13, 6);
insert into permissoes (id_operador, id_estabelecimento) values (19, 8);

