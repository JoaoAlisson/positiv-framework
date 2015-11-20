function deletarComentario(id) {

	nome = $('#nome' + id).html();
	mensagem = 'Deseja realmente deletar o comentário de <strong>' + nome + '</strong>?';
	$('#msgConfirmacao').html(mensagem);

	$('#modalConfimar').modal('setting', {
			closable  : false,
			onApprove : function() {
			 	deletarComent(id);
			}
		}).modal('show'); 
}

function deletarComent(id) {
	$('#id').val(id);
	$('#acao').val('deletar');
	$('#listagem2').val($('#listagem').val());

	$('#formulario').submit();
}

function despublicarComentario(id) {
	$('#id').val(id);
	$('#acao').val('despublicar');
	$('#listagem2').val($('#listagem').val());

	$('#formulario').submit();
}


function publicarComentario(id) {
	$('#id').val(id);
	$('#acao').val('publicar');
	$('#listagem2').val($('#listagem').val());

	$('#formulario').submit();
}

function filtrar() {
	if($("#listagem").val() != '')
		$('#formularioListagem').submit();
}
