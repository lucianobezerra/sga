alter table aih_autorizada rename to aihs;

ALTER TABLE aihs RENAME data_registro  TO registro;
ALTER TABLE aihs DROP CONSTRAINT fk_operador;

select atualiza_aih_por_faixa();

ALTER TABLE aihs ADD CONSTRAINT fk_faixa FOREIGN KEY (id_faixa) REFERENCES faixas (id) ON UPDATE NO ACTION ON DELETE NO ACTION;

CREATE OR REPLACE FUNCTION "retornaDigito"()
  RETURNS trigger AS
$BODY$begin
  select case
    when (mod(new.numero, 11) = 10) then 0
     else
    mod(new.numero, 11) end into new.digito;
  return NEW;
end;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION "retornaDigito"() OWNER TO postgres;

CREATE TRIGGER "geraDigito"
  BEFORE INSERT
  ON aihs
  FOR EACH ROW
  EXECUTE PROCEDURE "retornaDigito"();
  

CREATE OR REPLACE FUNCTION "verificaSaldo"()
  RETURNS trigger AS
$BODY$declare
  saldo integer;
begin
   select faixas.saldo from faixas where faixas.id = new.id_faixa into saldo;
   if(saldo <= 0) then
     raise exception 'Faixa não possui Saldo!';
   end if;
end$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION "verificaSaldo"() OWNER TO postgres;


CREATE OR REPLACE FUNCTION "atualizaSaldo"()
  RETURNS trigger AS
$BODY$begin
  update faixas set saldo = (saldo -1) where id = new.id_faixa;
  return null;
end$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION "atualizaSaldo"() OWNER TO postgres;

CREATE TRIGGER "atualizaFaixa"
  AFTER INSERT
  ON aihs
  FOR EACH ROW
  EXECUTE PROCEDURE "atualizaSaldo"();
