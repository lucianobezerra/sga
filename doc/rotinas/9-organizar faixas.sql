alter table faixas add ativo2 boolean;
update faixas set ativo2 = true where ativo='S';
update faixas set ativo2 = false where ativo='N';
alter table faixas drop ativo;
alter table faixas rename ativo2 to ativo;
