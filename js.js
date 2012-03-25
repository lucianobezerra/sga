$(function(){
  $('#formlogin').submit(function(){
    var url   = 'ajax/logar.php';
    var login = $('#login').val();
    var senha = $('#senha').val();
    $.post(url, {login: login, senha: senha }, function(resposta){
      if(!resposta){
        alert('logado');
      } else {
        $('div.mensagem-erro').html(resposta);
      }
    });
    return false;
  });
});