alter table competencias add mes2 varchar(2);
update competencias set mes2=substring(mes from 1 for 2);
alter table competencias drop mes;
alter table competencias rename mes2 to mes;
ALTER TABLE competencias ADD CONSTRAINT uk_ano_mes UNIQUE (ano, mes);
