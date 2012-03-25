select 
  aihs.numero||'-'||aihs.digito as numero, estabelecimentos.nome_fantasia, tipos.descricao as tipo, faixas.inicial||' a '||faixas.final as faixa, 
  competencias.ano||competencias.mes as competencia, operadores.nome nome_operador, aihs.nome_pac, aihs.nascimento, aihs.internacao
from aihs 
inner join operadores on aihs.id_operador=operadores.id 
inner join estabelecimentos on aihs.id_estabelecimento = estabelecimentos.id 
inner join tipos on aihs.id_tipo = tipos.id 
inner join faixas on aihs.id_faixa = faixas.id 
inner join competencias on aihs.id_competencia = competencias.id 
where aihs.id=131