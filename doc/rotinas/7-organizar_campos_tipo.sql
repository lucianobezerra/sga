alter table estabelecimentos add ativo2 boolean;
update estabelecimentos set ativo2=true where ativo='S';
update estabelecimentos set ativo2=false where ativo='N';
alter table estabelecimentos drop ativo;
alter table estabelecimentos rename ativo2 to ativo;