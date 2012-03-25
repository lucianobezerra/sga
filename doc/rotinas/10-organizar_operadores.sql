alter table operadores add ativo2 boolean;
update OPERADORES set ativo2 = true where ativo='S';
update OPERADORES set ativo2 = false where ativo='N';
alter table OPERADORES drop ativo;
alter table OPERADORES rename ativo2 to ativo;
