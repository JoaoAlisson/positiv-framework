var GLOBAL;
var resposta = "";
var camposAbilitar = [ "expNivel1", "expSegmento1", "expNomeDaEmpresa" , "expCargo", "expUltimoSalarioInt", 
					   "expUltimoSalarioDec", "expAtribuicoes", "expInicio1", "expFim1", "expNivel2", "expSegmento2",
					   "expNomeDaEmpresa2" , "expCargo2", "expAtribuicoes2", "expUltimoSalarioInt2", "expUltimoSalarioDec2",
					   "expInicio2", "expFim2", "expNivel3", "expSegmento3", "expNomeEmpresa3", "expCargo3", "expInicio3",
					   "expFim3", "expUltimoSalarioInt3", "expUltimoSalarioDec3", "expAtribuicoes3", "expNivel4", "expSegmento4",
					   "expNomeEmpresa4", "expCargo4", "expInicio4", "expFim4", "expUltimoSalarioInt4", "expAtribuicoes4",
					   "expUltimoSalarioDec4", "expNivel5", "expSegmento5", "expNomeEmpresa5", "expCargo5", "expInicio5",
					   "expFim5", "expUltimoSalarioInt5", "expUltimoSalarioDec5", "expAtribuicoes5"];
$( document ).ready(function($) {

	//facebook();
	$('.moeda').mask('999.999,99');
	//$('#pretensaoSalarial').mask('000.000.000.000.000,00', {reverse: true});

	$("#rgCampo").keyup(function() {
		var valor = $("#rgCampo").val().replace(/[^0-9]+/g,'');
		$("#rgCampo").val(valor);
	});

	$("#cpf").keyup(function() {
		var valor = $("#cpf").val().replace(/[^0-9]+/g,'');
		$("#cpf").val(valor);
	});	

	if($("#interNivel1").val() == "Primeiro Emprego"){
		desbilitaTodos();
	}

	$("#habilitacaoSim").click(function(){
		$("#habilitacaoNao").attr("checked",false);
		$("#categoria").attr("disabled",false);
	});

	$("#habilitacaoNao").click(function(){
	    $("#habilitacaoSim").attr("checked",false);
	    $("#categoria").attr("disabled",true);
	    $("#categoriaValor").attr("selected",true);
	});

	$("#deficienciaSim").click(function(){
		$("#deficienciaNao").attr("checked",false);
		$("#descricaoDeficiencia").attr("disabled",false);
	});

	$("#deficienciaNao").click(function(){
	    $("#deficienciaSim").attr("checked",false);
	    $("#descricaoDeficiencia").attr("disabled",true);
	    $("#descricaoDeficiencia").val("");
	});

	$("#foto").change(function(){
		if($("#foto").val() != null && $("#foto").val() != "") {
			nnome = ($("#foto"))[0].files[0].name;

			mensagem = "";
			if(!verificarImagem(nnome))
				mensagem = "Formato da imagem Inválido. ";
			if(!tamanhoImagemOk())
				mensagem = mensagem + "A imagem deve conter no máximo 3 megas.";

			if(mensagem != ""){
				$("#mensagemFoto").html(mensagem);
				$("#mensagemFoto").show();
			}else{
				$("#mensagemFoto").hide();
			}
		}
	});

	$("#email2").keyup(function(){
		$("#email").val($("#email2").val());
	});

	$("#email").keyup(function(){
		$("#email2").val($("#email").val());
	});	

});

function teste(varr){
	caminho = URL +  "curriculos/verificaCpfEditar/";
	cpfVariavel = $("#cpf").val();
	$("#mensagemCpf").html("Cpf Inválido.");

	if(!validarCPF(cpfVariavel)){
		return false;
	}else{

		var variavel = "";
		cpfVariavel = $("#cpf").val();
		$.ajax({
			url: caminho,
			type: 'POST',
			data: { cpf : cpfVariavel },
			dataType: "json",
			success: function (result) {
				GLOBAL = result;	
			}
	    });

		variavel = GLOBAL;
		if (typeof variavel !== "undefined") {
			if(variavel.resultado == "ok"){
				return true;
			}else{
				$("#mensagemCpf").html("Este CPF já se encontra na nossa base de dados.");
				return false;
			}
		}else{
			return true;
		}
	}
}

function cpfExiste(cpfVariave){
	$.post(url, { cpf : cpfVariavel }, function(retorno, status){
		if(retorno == "ok")
			return "naum";
		else
			return "ok";
	});
}

function verificarImagem(nnome){
	var Extensao = nnome.substring(nnome.lastIndexOf('.') + 1);
	Extensao = Extensao.toLowerCase();
	if(Extensao == "jpg" || Extensao == "jpeg" || Extensao == "png")
		return true;
	else
		return false;
}

function tamanhoImagemOk(){
	tamanho = ($("#foto"))[0].files[0].size;
	if(tamanho <= 3000000)
		return true;
	else
		return false;
}

function validarCPF(cpf){
    var numeros, digitos, soma, i, resultado, digitos_iguais;
    digitos_iguais = 1;
    if (cpf.length < 11)
          return false;
    for (i = 0; i < cpf.length - 1; i++)
          if (cpf.charAt(i) != cpf.charAt(i + 1))
                {
                digitos_iguais = 0;
                break;
                }
    if (!digitos_iguais)
          {
          numeros = cpf.substring(0,9);
          digitos = cpf.substring(9);
          soma = 0;
          for (i = 10; i > 1; i--)
                soma += numeros.charAt(10 - i) * i;
          resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
          if (resultado != digitos.charAt(0))
                return false;
          numeros = cpf.substring(0,10);
          soma = 0;
          for (i = 11; i > 1; i--)
                soma += numeros.charAt(11 - i) * i;
          resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
          if (resultado != digitos.charAt(1))
                return false;
          return true;
          }
    else
        return false;		
}

function verificaCamposEmBranco(){
	retorno = true;
	if($("#expNivel1").val() != "" && $("#expNivel1").val() != null)
		retorno = false;

	if($("#expNivel2").val() != "" && $("#expNivel2").val() != null)
		retorno = false;

	if($("#expNivel3").val() != "" && $("#expNivel3").val() != null)
		retorno = false;			

	if($("#expNivel4").val() != "" && $("#expNivel4").val() != null)
		retorno = false;

	if($("#expNivel5").val() != "" && $("#expNivel5").val() != null)
		retorno = false;		


	if($("#expSegmento1").val() != "" && $("#expSegmento1").val() != null)
		retorno = false;

	if($("#expSegmento2").val() != "" && $("#expSegmento2").val() != null)
		retorno = false;

	if($("#expSegmento3").val() != "" && $("#expSegmento3").val() != null)
		retorno = false;

	if($("#expSegmento4").val() != "" && $("#expSegmento4").val() != null)
		retorno = false;

	if($("#expSegmento5").val() != "" && $("#expSegmento5").val() != null)
		retorno = false;					


	if($("#expNomeDaEmpresa").val() != "" && $("#expNomeDaEmpresa").val() != null)
		retorno = false;

	if($("#expNomeDaEmpresa2").val() != "" && $("#expNomeDaEmpresa2").val() != null)
		retorno = false;

	if($("#expNomeEmpresa3").val() != "" && $("#expNomeEmpresa3").val() != null)
		retorno = false;

	if($("#expNomeEmpresa4").val() != "" && $("#expNomeEmpresa4").val() != null)
		retorno = false;

	if($("#expNomeEmpresa5").val() != "" && $("#expNomeEmpresa5").val() != null)
		retorno = false;
								
	return retorno;
}

function experiencia(){
	if(verificaCamposEmBranco())
		return false;
	else
		return true;
}

function verificaExperiencia(){
	if(verificaCamposEmBranco() && $("#interNivel1").val() != "Primeiro Emprego")
		alert("Se você não possui nenhuma experiência profissional, marque a opção  'Primeiro Emprego' em Área profissional desejada, na opção 'Nível'.");
}

function nivel(){
	/*
	if($("#interNivel1").val() == "Primeiro Emprego"){
		if(sprytextfield50){
			sprytextfield50.reset();
			sprytextfield50.destroy();
			sprytextfield50 = null;
			desbilitaTodos();
		}		
	}else{
		if(!sprytextfield50){
			habilitaTodos();
			sprytextfield50 = new Spry.Widget.ValidationTextField("sprytextfield50", "custom", {validation: "experiencia", validateOn:["blur", "change"]});
		}
	}
	*/
}

function desbilitaTodos(){
	$.each( camposAbilitar, function(chave, campo){
		$('#'+campo).prop('disabled', true);
		$('#'+campo).val("");
	});
}

function habilitaTodos(){
	$.each( camposAbilitar, function(chave, campo){
		$('#'+campo).prop('disabled', false);
	});
}

function facebook(){
	urlFace = "https://graph.facebook.com/" + $("#faceCampo").val();
	digitado =  $("#faceCampo").val().toLowerCase();
	
	if(digitado == "facebook")
		return false;

	if(digitado.indexOf("https://www.facebook") != -1)
		return false;

	if(digitado.indexOf("http://www.facebook") != -1)
		return false;

	if(digitado.indexOf("https://facebook") != -1)
		return false;

	if(digitado.indexOf("http://facebook") != -1)
		return false;

	if(digitado.indexOf("facebook.com.br") != -1)
		return false;

	$.get(urlFace, function(retorno){
			retorno.first_name;
			resposta = "ok";
	}).error(function (){
		resposta = "erro";
	});

	if(resposta == "ok")
		return true;
	else
		return false;
		
}

function validarEmail(email) 
{	
	er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/;
	if(er.exec(email))
		return true;

}

function loginemail() {

	caminho = "verificaEmailEditar/";
	//alert('verificaEmailEditar');
	cpfVariavel = $("#email2").val();
	$("#mensagemEmail2").html("Email Inválido.");

	if(!validarEmail(cpfVariavel)){
		return false;
	}else{

		var variavel = "";
		cpfVariavel = $("#email2").val();
		$.ajax({
			url: caminho,
			type: 'POST',
			data: { email : cpfVariavel },
			dataType: "json",
			success: function (result) {
				GLOBAL = result;
			}
	    });

		variavel = GLOBAL;
		if (typeof variavel !== "undefined") {
			if(variavel.resultado == "ok"){
				return true;
			}else{
				$("#mensagemEmail2").html("Este Email já se encontra na nossa base de dados.");
				return false;
			}
		}else{
			return true;
		}
	}
}

function loginemail1() {

	caminho = URL + "curriculos/verificaEmailEditar/";

	cpfVariavel = $("#email").val();
	$("#email1").html("Email Inválido.");

	if(!validarEmail(cpfVariavel)){
		return false;
	}else{

		var variavel = "";
		cpfVariavel = $("#email").val();
		$.ajax({
			url: caminho,
			type: 'POST',
			data: { email : cpfVariavel },
			dataType: "json",
			success: function (result) {
				GLOBAL = result;
			}
	    });

		variavel = GLOBAL;
		if (typeof variavel !== "undefined") {
			if(variavel.resultado == "ok"){
				return true;
			}else{
				$("#email1").html("Este Email já se encontra na nossa base de dados.");
				return false;
			}
		}else{
			return true;
		}
	}
}


function pegarCidades() {
	estadoId = $('#estado_cur').val();
	caminho = URL + "cidades/pegarCidades/";

	$('#carregandoCidades').show();
	var variavel = "";
	cpfVariavel = $("#cpf").val();
	$.ajax({
		url: caminho,
		type: 'POST',
		data: { estado : estadoId },
		dataType: "json",
		success: function (result) {
			opcoes = "<option value=''></option>";
			$.each(result, function(chave, city){
				opcoes = opcoes + '<option value='+ city.id +'>' + city.cidade + '</option>';

			});
			$('#cidade').html(opcoes);
			$('#carregandoCidades').hide();
		}
    });	
}

function liberaareaformacao(grau, area) {
	if($('#' + grau).val() == 6) {
		$('#' + area).prop( "disabled", false );
		if(area == 'areaformacao')
			areadaformacao.isRequired = true;
		else
			areadaformacao2.isRequired = true;
	}else{
		if(area == 'areaformacao')
			areadaformacao.isRequired = false;
		else
			areadaformacao2.isRequired = false;

		$('#' + area).val('');
		$('#' + area).prop("disabled", true);
	}
}

function setObrigatorioDatas1()
{
	if($('#expNomeDaEmpresa').val() != '') {
		sprytextfield30.isRequired = true;
		sprytextfield31.isRequired = true;
	} else {
		sprytextfield30.isRequired = false;
		sprytextfield31.isRequired = false;		
	}
}

function setObrigatorioDatas2()
{
	if($('#expNomeDaEmpresa2').val() != '') {
		sprytextfield40.isRequired = true;
		sprytextfield32.isRequired = true;
	} else {
		sprytextfield40.isRequired = false;
		sprytextfield32.isRequired = false;		
	}
}

function setObrigatorioDatas3()
{
	if($('#expNomeEmpresa3').val() != '') {
		sprytextfield33.isRequired = true;
		sprytextfield34.isRequired = true;
	} else {
		sprytextfield33.isRequired = false;
		sprytextfield34.isRequired = false;		
	}
}

function setObrigatorioDatas4()
{
	if($('#expNomeEmpresa4').val() != '') {
		sprytextfield36.isRequired = true;
		sprytextfield37.isRequired = true;
	} else {
		sprytextfield36.isRequired = false;
		sprytextfield37.isRequired = false;		
	}
}

function setObrigatorioDatas5()
{
	if($('#expNomeEmpresa5').val() != '') {
		sprytextfield38.isRequired = true;
		sprytextfield39.isRequired = true;
	} else {
		sprytextfield38.isRequired = false;
		sprytextfield39.isRequired = false;		
	}
}