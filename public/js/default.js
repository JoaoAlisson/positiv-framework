function listarEmails()
{	
	var filtros = '';
	$.each($('.formulario').serializeArray(), function(i, campo) {
		if(campo.value != '')
			if(campo.name != 'expInicio1')
				filtros = filtros + campo.name + ':' + campo.value + '/';
	});	
	window.open($('#URL').val() + CONTROLE + '/listaEmails/' + filtros);
}

function paginacao(controle, pagina){
	$('#pg').val(pagina);
	filtrar('');
}

function enterSubmit(e){
	
	if(e.which == 13 || e.keyCode == 13){
		$('#submeter').click();
	}
}

function trocaImgSexo(id){
	if($("#input_"+id).val() == 1){
		$("#masculino_"+id).show();
		$("#feminino_"+id).hide();
	}else{
		if($("#input_"+id).val() == 2){
			$("#feminino_"+id).show();
			$("#masculino_"+id).hide();
		}else{
			$("#feminino_"+id).show();
			$("#masculino_"+id).show();
		}
	}
}

function link (caminho)
{
	caminho = URL + caminho;
	window.location.href = caminho;
}

function link2 (caminho)
{
	caminho = URL + caminho;
	window.location.href = caminho;
}

function ordem (campo)
{
	if($('#ordem').val() == '') {
		$('#ordem').val(campo); 
		$('#ordenacao').val('ASC'); 
	} else {
		$('#ordem').val(campo); 
			if($('#ordenacao').val() == 'ASC')
				$('#ordenacao').val('DESC');
			else
				$('#ordenacao').val('ASC'); 			
		
	}

	filtrar('');
}

/*
function paginacao (pagina)
{
	caminho = URL + 'animal/index/pag:' + pagina + '/campo:' + ORDEM_CAMPO + '/ordem:' + ORDEM_VAR + filtros();
	window.location.href = caminho;
}


function ordenacao (ordem)
{
	if(ordem === ORDEM_CAMPO) {
		if(ORDEM_VAR === 'ASC') {
			ORDEM_VAR = 'DESC';
		} else {
			ORDEM_VAR = 'ASC';
		}
	}

	ORDEM_CAMPO = ordem;

	caminho = URL + 'animal/index/campo:' + ORDEM_CAMPO + '/ordem:' + ORDEM_VAR + filtros();
	window.location.href = caminho;
}
*/

function filtrar (val)
{
	var filtros = '';
	$.each($('.formulario').serializeArray(), function(i, campo) {
		if(campo.value != '')
			if(campo.name != 'expInicio1' && campo.name != 'cadastro')
				filtros = filtros + campo.name + ':' + campo.value + '/';
	});

	//link('curriculos/index/' + filtros);
	window.history.pushState("Currículos", "Currículos", URL + CONTROLE + '/index/' + filtros);
	garrePgTabela(URL + CONTROLE + '/index/' + filtros);
}

function garrePgTabela(caminho) 
{	
	$('#carregandoIco').show();
	$.ajax({
		url: caminho,
		type: 'POST',
		data: { filtraAjax : true },
		dataType: "html",
		success: function (result) {
			$('#tabela').html(result);
			$('#totalBusc').html('Total: ' + $('#quantidadeResultados').val());
		}
	}); 
}


function datapick(){

  $('#input_nascimento').mask('00/00/0000');
  $('#input_nascimento').pickadate({
    selectYears: true,
      selectMonths: true,
      editable: true,
      format: 'dd/mm/yyyy',
      formatSubmit: 'dd/mm/yyyy',
      labelMonthNext: 'Próximo Mês',
    labelMonthPrev: 'Mês Anterior',
      monthsFull: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
      weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
      today: 'Hoje',
      clear: 'Limpar',
      close: 'Cancelar'
  });
}


function telefoneMask(){
	
	telefoneM = $("#input_telefone").val();

	if(telefoneM.length < 15)
		$("#input_telefone").mask('(00) 0000-00000');
	else
		$("#input_telefone").unmask().mask('(00) 00000-0000');
}