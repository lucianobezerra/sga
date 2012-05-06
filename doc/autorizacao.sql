CREATE TABLE autorizacoes(
  id serial NOT NULL primary key,
  id_operador integer NOT NULL,
  id_estabelecimento integer NOT NULL DEFAULT 0,
  id_tipo integer NOT NULL DEFAULT 0,
  id_faixa integer NOT NULL DEFAULT 0,
  id_competencia integer NOT NULL DEFAULT 0,
  id_procedimento integer NOT NULL,
  id_autorizador integer NOT NULL,
  id_solicitante integer NOT NULL,
  id_municipio integer NOT NULL,
  numero bigint NOT NULL DEFAULT 0,
  digito integer NOT NULL,
  nome_paciente character varying(60) NOT NULL,
  data_nascimento date NOT NULL,
  data_emissao date NOT NULL,
  nome_da_mae character varying(60),
  sexo character(1),
  endereco character varying(50),
  bairro character varying(30),
  cep character varying(8),
  uf character varying(2),
  nome_responsavel character varying(60),
  raca_cor character varying(2),
  created_at timestamp without time zone NOT NULL DEFAULT now(),
  CONSTRAINT fk_aih FOREIGN KEY (id_estabelecimento) REFERENCES estabelecimentos (id) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION, 
  CONSTRAINT fk_operador FOREIGN KEY (id_operador)   REFERENCES operadores (id)       MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_tipo FOREIGN KEY (id_tipo)           REFERENCES tipos (id)            MATCH SIMPLE  ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT check_sexo CHECK (sexo = ANY (ARRAY['M'::bpchar, 'F'::bpchar]))
);

CREATE TRIGGER "callUpdateFaixaDelete" AFTER DELETE ON autorizacoes FOR EACH ROW
  EXECUTE PROCEDURE "atualizaFaixaDelete"();

CREATE TRIGGER "callUpdateFaixaInsert" AFTER INSERT ON autorizacoes FOR EACH ROW
  EXECUTE PROCEDURE "atualizaFaixaInsert"();

CREATE TRIGGER "checaSaldoFaixa" BEFORE INSERT ON autorizacoes FOR EACH ROW
  EXECUTE PROCEDURE "verificaSaldo"();

CREATE TRIGGER "geraDigito"  BEFORE INSERT  ON autorizacoes  FOR EACH ROW
  EXECUTE PROCEDURE "retornaDigito"();
