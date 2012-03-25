ALTER TABLE aihs RENAME dv_aih  TO digito;
ALTER TABLE aihs ALTER digito TYPE "char";
ALTER TABLE aihs ALTER COLUMN digito TYPE integer USING converteCharParaInteiro(digito);
ALTER TABLE aihs ADD COLUMN numero bigint NOT NULL DEFAULT 0;
ALTER TABLE aihs RENAME dt_nasc  TO nascimento;
ALTER TABLE aihs ALTER COLUMN nascimento SET NOT NULL;
ALTER TABLE aihs RENAME dt_int  TO internacao;
ALTER TABLE aihs ALTER COLUMN internacao SET NOT NULL;
ALTER TABLE aihs ADD COLUMN created_at timestamp without time zone NOT NULL DEFAULT current_timestamp;

update aihs set numero=cast(num_aih as bigint);
