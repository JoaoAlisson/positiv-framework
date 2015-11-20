<?php 
  
  $segmentos = '';
  foreach ($dados['segmentos'] as $id => $segmento)
    $segmentos .= "<option value='" . $segmento['id'] ."'>" . $segmento['segmento'] . "</option>";  


  function select($id, $array, $campo) 
  { 
    $options = '';
    foreach ($array as $key => $valor)
      $options .= ($valor['id'] == $id) 
        ? "<option selected value='". $valor['id'] ."'>". $valor[$campo] ."</option>" 
        : "<option value='". $valor['id'] ."'>". $valor[$campo] ."</option>";
    
    echo $options;
  }

  $cargos = '';
  foreach ($dados['cargos'] as $id => $cargo)
    $cargos .= "<option value='" . $cargo['id'] ."'>" . $cargo['cargo'] . "</option>";  
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Editar</title>

<link href="<?php echo URL; ?>public/css/estiloNovo.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Alegreya+Sans' rel='stylesheet' type='text/css'>

<link href="<?php echo URL; ?>public/css/estiloPaginaNovo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="<?php echo URL; ?>favicon.ico" type="image/x-icon" />

<script src="<?php echo URL; ?>public/js/valid.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.js"></script>


<script type="text/javascript">

function confirmar(id) {

  $('.telaConfirma').fadeIn(500);

}



function carregar(acao) {
  if(acao == "abrir"){
    $('.confirmaFundo').fadeIn(500);
  }else{
    $('.telaConfirma').fadeOut(500);
    $('.confirmaFundo').fadeOut(500);
  }
}



$(document).keydown(function(event) { // caso seja precionado ESC chama mostrarLogin('0')
        if (event.keyCode == 27) 
      mostrarLogin('0');
    });



function mostrarLogin(acao){
  if(acao == "1")
    $('.mascara').fadeIn(400);
  else
    $('.mascara').fadeOut(400);
}

</script>

<script type="text/javascript">

function verificarLogin() {
  var x = document.getElementById('email2');
  $.post('verificarLogin.php', { login: x.value },
    function(output) {
      $('#retorno').html(output).fadeIn(1000);
    });

}



function mostrarSubmit() {

  $('#submit').fadeIn(200);

  $('#verlogin').fadeOut(200);

}

function esconderSubmit() {

  /*
  $('#submit').fadeOut(200);

  $('#retorno').fadeOut(200);

  $('#verlogin').fadeIn(200);
  */
}



</script>



</head>

<body>

<!--bloco para confirmação de cadastro de curriculo ou empresa-->


<div class="confirmaFundo" style="display:none"><div id="loading">

</div></div>

<!--bloco para confirmação de cadastro de curriculo ou empresa-->



<div class="topo">
<div class="topoinner">


<div class="menu">
<div class="menuinner">
<a href="<?php echo URL; ?>"><img src="<?php echo URL; ?>public/images/titulo.png" width="344" height="65" border="0" /></a><br />
<div>
<a target="_blank" href="<?php echo URL; ?>curriculos/visualizar">Currículo &nbsp;|&nbsp;</a><a href="<?php echo URL; ?>curriculos/editar"> Atualizar Currículo &nbsp;|</a>
<a href="<?php echo URL; ?>vagas">&nbsp; Vagas</a>
</div>
</div>
<!--LOGIN-->

<!--FINAL DO LOGIN-->


</div>

</div>
<div class="transparente"></div>
</div>

<div class="sombra"></div>
<div class="conteudo">

  






<script src="<?php echo URL; ?>public/js/SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<!-- <script src="<?php echo URL; ?>public/js/jquery.js" type="text/javascript"></script> -->
<script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.maskedinput.min.js"></script>
<!-- <script src="<?php echo URL; ?>public/js/jquery-mask.min.1.6.1.js" type="text/javascript"></script> -->


<script src="<?php echo URL; ?>public/js/novosTratamentosEditar.js" type="text/javascript"></script>


<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />



<script src="../SpryAssets/SpryValidationRadio.js" type="text/javascript"></script>

<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>

<link href="../SpryAssets/SpryValidationRadio.css" rel="stylesheet" type="text/css" />



<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />



<script type="text/javascript">



  function verSenha(){



    if (document.formCadCurriculo.senha.value != document.formCadCurriculo.senha2.value) {



      alert('As senhas não conferem');  



    }



  }



</script>














<div class="barra">

  <h3 id="cadCurriculo">Editando seu Currículo</h3>



</div>

<?php 
  if($dados['curriculo']['foto'] != '') {
      \Positiv\Sessao::inserir('foto', $dados['curriculo']['foto']);
?>
  <img style="max-height: 150px; border-radius: 6px; >" src="<?php echo URL . 'curriculos/imagens/'; ?>" /><br>
<?php } ?>

* Campos de preenchimento obrigatório






<form id="formCadCurriculo" name="formCadCurriculo" method="post" action="" class="formulario" enctype="multipart/form-data">



  



  <h2>Dados Pessoais<strong><a name="trocaEmail" id="trocaEmail"></a></strong></h2>



  



  <table width="100%" border="0" cellpadding="2" cellspacing="1" class="bloco">



    <tr>



      <td width="27%" align="right" bgcolor="#F3F3F3"><strong>*Nome completo</strong></td>



      <td width="73%" bgcolor="#FFFFFF"><label for="nome"></label>



        <span id="nomecampleto">



        <input type="text" name="nome" id="nome" value="<?php echo $dados['curriculo']['nome']; ?>" style="width:400px"/>



      <span class="textfieldRequiredMsg">digite seu nome.</span></span></td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3"><strong>*E-mail</strong></td>



      <td bgcolor="#FFFFFF"><span id="sprytextfield2">



      <input type="text" name="email" id="email" value="<?php echo $dados['curriculo']['email']; ?>" style="width:400px" onchange="pegaEmail()" onfocus="esconderSubmit()" />



      <span class="textfieldRequiredMsg">Digite seu e-mail.</span><span class="textfieldInvalidFormatMsg">Formato Inválido.</span></span></td>



    </tr>

 <tr>



      <td align="right" bgcolor="#F3F3F3">Facebook</td>



      <td bgcolor="#FFFFFF"><span id="facebook">



      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;https://www.facebook.com/<input type="text" name="facebook" id="faceCampo" value="<?php echo $dados['curriculo']['facebook']; ?>" style="width:200px"/>



     <span class="textfieldInvalidFormatMsg">Esta conta não existe.</span></span></td>


   </tr>
   <tr>
      <td align="right" bgcolor="#F3F3F3">Selecione uma foto sua</td>
      <td bgcolor="#FFFFFF">
        <input type='file' name='foto' id='foto' />
        <span class="textfieldInvalidFormatMsg" id="mensagemFoto" style="color: #CC3333;"></span>
      </td>
   </tr>


    <tr>

      <td align="right" bgcolor="#F3F3F3"><strong>*CPF</strong></td>



      <td bgcolor="#FFFFFF"><span id="sprytextfield3">



      <input name="cpf" value="<?php echo $dados['curriculo']['cpf']; ?>" type="text" id="cpf" onblur="" maxlength="11"/>

<span class="textfieldInvalidFormatMsg" id="mensagemCpf">Cpf Inválido.</span><span class="textfieldRequiredMsg">Digite seu CPF.</span></span></td>



    </tr>


    <tr>
      <td align="right" bgcolor="#F3F3F3"><strong>*RG</strong></td>
      <td bgcolor="#FFFFFF"><span id="rgSpan">
      <input name="rg" type="text" id="rgCampo" onblur="" maxlength="20" value="<?php echo $dados['curriculo']['rg']; ?>" />
      <span class="textfieldInvalidFormatMsg" id="mensagemRg">RG Inválido.</span><span class="textfieldRequiredMsg">Digite seu RG.</span></span></td>
    </tr>

    <tr>
      <td width="27%" align="right" bgcolor="#F3F3F3"><strong>*Nome da Mãe</strong></td>
      <td width="73%" bgcolor="#FFFFFF"><label for="nome"></label>
        <span id="nomeMae">
        <input type="text" value="<?php echo $dados['curriculo']['nomeMae']; ?>" name="nomeMae" id="nomeMaeCampo" style="width:400px"/>
      <span class="textfieldRequiredMsg">Digite o nome da sua mãe.</span></span></td>
    </tr>    

    <tr>



      <td align="right" bgcolor="#F3F3F3"><strong>*Data de Nascimento</strong></td>



      <td bgcolor="#FFFFFF"><span id="sprytextfield4">



      <input type="text" name="dataNascimento" value="<?php echo $dados['curriculo']['dataNascimento']; ?>" id="dataNascimento" onkeyup="DigitaData(this)" onblur="DigitaData(this)" />



      <span class="textfieldRequiredMsg">Digite sua data de nascimento.</span><span class="textfieldInvalidFormatMsg">Data Inválida.</span></span></td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3"><strong>*Sexo</strong></td>



      <td bgcolor="#FFFFFF"><label for="sexo"><span id="spryradio1">



          <input type="radio" <?php if($dados['curriculo']['sexo'] == 'masculino') echo 'checked'; ?> name="sexo" value="masculino" id="sexoValida_0" /> 



          Masculino







<input type="radio" name="sexo" <?php if($dados['curriculo']['sexo'] != 'masculino') echo 'checked'; ?> value="feminino" id="sexoValida_1" /> 



Feminino



<br />



<span class="radioRequiredMsg">Marque seu sexo.</span></span></label></td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3"><strong>*Estado Civil</strong></td>



      <td bgcolor="#FFFFFF"><label for="estado"></label>

        <span id="spryselect1">

        <select name="estadoCivil" id="estadoCivil">

          <option>Selecione</option>

          <option <?php if($dados['curriculo']['estadoCivil'] == 1) echo 'selected'; ?> value="1">Casado</option>

          <option <?php if($dados['curriculo']['estadoCivil'] == 2) echo 'selected'; ?> value="2">Solteiro</option>

          <option <?php if($dados['curriculo']['estadoCivil'] == 3) echo 'selected'; ?> value="3">Divorciado</option>

          <option <?php if($dados['curriculo']['estadoCivil'] == 4) echo 'selected'; ?> value="4">Viúvo</option>

        </select>

      <span class="selectRequiredMsg">Escolha seu estado civil.</span></span></td>



    </tr>


    <tr>
      <td align="right" bgcolor="#F3F3F3"><strong>*Quantidade de Filhos</strong></td>
          <td bgcolor="#FFFFFF">
            <span id="quantidadeFilhos">
              <select name="qtdFilhos"/>
                <option value=""></option>
                <option <?php if($dados['curriculo']['qtdFilhos'] == 0) echo 'selected'; ?> value="0">0</option>
                <option <?php if($dados['curriculo']['qtdFilhos'] == 1) echo 'selected'; ?> value="1">1</option>
                <option <?php if($dados['curriculo']['qtdFilhos'] == 2) echo 'selected'; ?> value="2">2</option>
                <option <?php if($dados['curriculo']['qtdFilhos'] == 3) echo 'selected'; ?> value="3">3</option>
                <option <?php if($dados['curriculo']['qtdFilhos'] == 4) echo 'selected'; ?> value="4">4</option>
                <option <?php if($dados['curriculo']['qtdFilhos'] == 5) echo 'selected'; ?> value="5">5</option>
                <option <?php if($dados['curriculo']['qtdFilhos'] == 6) echo 'selected'; ?> value="6">6</option>
                <option <?php if($dados['curriculo']['qtdFilhos'] == 7) echo 'selected'; ?> value="7">7</option>
                <option <?php if($dados['curriculo']['qtdFilhos'] == 8) echo 'selected'; ?> value="8">8</option>
                <option <?php if($dados['curriculo']['qtdFilhos'] == 9) echo 'selected'; ?> value="9">9</option>
                <option <?php if($dados['curriculo']['qtdFilhos'] == 10) echo 'selected'; ?> value="10">10</option>
                <option <?php if($dados['curriculo']['qtdFilhos'] == 11) echo 'selected'; ?> value="11">Mais</option>
              </select>
            <span class="selectRequiredMsg">Informe a quantidade de filhos</span></span>
        </td>
    </tr>  

    <tr>



      <td width="200" align="right" bgcolor="#F3F3F3"><strong>*CEP</strong></td>



      <td bgcolor="#FFFFFF"><span id="sprytextfield5">



      <input type="text" value="<?php echo $dados['curriculo']['cep']; ?>"  name="cep" id="cep" />



      <span class="textfieldRequiredMsg">Digite seu cep.</span></span> 



      <a href="http://www.buscacep.correios.com.br/servicos/dnec/menuAction.do?Metodo=menuEndereco" target="_blank">Esqueci meu cep</a></td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3"><strong>*Endereço</strong></td>



      <td bgcolor="#FFFFFF"><span id="sprytextfield6">



        <input type="text" value="<?php echo $dados['curriculo']['endereco']; ?>" name="endereco" id="endereco" style="width:400px"/>



      <span class="textfieldRequiredMsg">Digite seu endereço.</span></span></td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3"><strong>*Número</strong></td>



      <td bgcolor="#FFFFFF"><span id="sprytextfield7">



        <input type="text" value="<?php echo $dados['curriculo']['numero']; ?>" name="numero" id="numero" />



      <span class="textfieldRequiredMsg">Digite o número de sua residência ou S/N.</span></span></td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3"><strong>Complemento</strong></td>



      <td bgcolor="#FFFFFF"><input type="text" value="<?php echo $dados['curriculo']['complemento']; ?>" name="complemento" id="complemento" style="width:400px"/></td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3"><strong>*Bairro</strong></td>



      <td bgcolor="#FFFFFF"><span id="sprytextfield8">



        <input type="text" name="bairro" value="<?php echo $dados['curriculo']['bairro']; ?>" id="bairro" />



      <span class="textfieldRequiredMsg">Digite seu bairro.</span></span></td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3"><strong>*Estado</strong></td>



      <td bgcolor="#FFFFFF"><span id="spryselect2">

      <select name="estado" id='estado_cur' onchange="pegarCidades();" help="Selecione o estado em que você reside." class="input">
        <option label="Selecione" value="">Selecione</option>
        <?php select($dados['curriculo']['estado'], $dados['estados'], 'estado'); ?>
      </select>

<span class="selectRequiredMsg">Escolha seu estado.</span></span></td>



    </tr>

    <tr>



      <td align="right" bgcolor="#F3F3F3"><strong>* Cidade</strong></td>



      <td bgcolor="#FFFFFF"><span id="sprytextfield9">


           <select name="cidade" id='cidade' help="Selecione a cidade em que você reside." class="input">
           <option label="" value=""></option>
            <?php select($dados['curriculo']['cidade'], $dados['cidades'], 'cidade'); ?>           
          </select>
<img hidden id="carregandoCidades" width="30px" style="margin-bottom:-10px;" src="<?php echo URL; ?>public/images/carregando.gif">
          
      <span class="selectRequiredMsg">Escolha sua cidade.</span></span>
  
      </td>



    </tr>


    <tr>



      <td align="right" bgcolor="#F3F3F3"><p><strong>*Telefones para contato: </strong></p>



      <p>(Informe ao menos 1 telefone)</p></td>



      <td bgcolor="#FFFFFF"><table width="100%" border="0">



        <tr>



          <td>Fone 1: </td>



          <td><span id="sprytextfield23">

            <input type="text" name="foneCell" value="<?php echo $dados['curriculo']['foneCell']; ?>" id="foneCell" />

            <span class="textfieldRequiredMsg">Digite pelo menos um telefone de contato.</span></span></td>



          </tr>



        <tr>



          <td>Fone 2: </td>



          <td><input type="text" value="<?php echo $dados['curriculo']['foneFixo']; ?>" name="foneFixo" id="foneFixo" /></td>



          </tr>



        <tr>



          <td>Fone 3: </td>



          <td><input type="text" value="<?php echo $dados['curriculo']['foneComercial']; ?>" name="foneComercial" id="foneComercial" /></td>



          </tr>



      </table></td>



    </tr>



    <tr>



      <td align="right">&nbsp;</td>



      <td bgcolor="#FFFFFF">&nbsp;</td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3"><strong>*Está empregado atualmente?</strong></td>



      <td bgcolor="#FFFFFF"><label for="empregado"><span id="spryradio2">



          <input type="radio" <?php if($dados['curriculo']['empregado'] == 1 ) echo 'checked'; ?> name="empregado" value="1" id="empregado_0" />



Sim



<input type="radio" name="empregado" <?php if($dados['curriculo']['empregado'] != 1 ) echo 'checked'; ?> value="0" id="empregado_1" />



Não<br />



<span class="radioRequiredMsg">Diga se você está ou não empregado atualmente</span></span></label></td>



    </tr>

<tr>
<td align="right" bgcolor="#F3F3F3">Possui carteira de motorista?</td>  
<td bgcolor="#FFFFFF"><label for="empregado"><span id="spryradio2">

   <input type="radio" <?php if($dados['curriculo']['habilitacao'] == 2 ) echo 'checked'; ?> name="habilitacao" value="2" id="habilitacaoSim" />
   Sim
    <input type="radio" <?php if($dados['curriculo']['habilitacao'] != 2 ) echo 'checked'; ?> name="abilitacao" value="1" id="habilitacaoNao"/>
   Não 
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   Categoria:
    <select name="categoria" id="categoria" <?php if($dados['curriculo']['habilitacao'] != 2) echo 'disabled'; ?>>
      <option value="" id="categoriaValor"></option>
      <option <?php if($dados['curriculo']['categoria'] == 'A' ) echo 'selected'; ?> value="A">A</option>
      <option <?php if($dados['curriculo']['categoria'] == 'B' ) echo 'selected'; ?> value="B">B</option>
      <option <?php if($dados['curriculo']['categoria'] == 'C' ) echo 'selected'; ?> value="C">C</option>
      <option <?php if($dados['curriculo']['categoria'] == 'D' ) echo 'selected'; ?> value="D">D</option>
      <option <?php if($dados['curriculo']['categoria'] == 'E' ) echo 'selected'; ?> value="E">E</option>
    </select>
   
</tr>

<tr>
<td align="right" bgcolor="#F3F3F3">Possui alguma deficiência?</td>  
<td bgcolor="#FFFFFF"><label for="empregado"><span id="spryradio2">
  <input type="radio" <?php if($dados['curriculo']['deficiencia'] == 1 ) echo 'checked'; ?> name="deficiencia" value="1" id="deficienciaSim" />
   Sim
  <input type="radio" <?php if($dados['curriculo']['deficiencia'] != 1 ) echo 'checked'; ?> name="deficiencia" value="0" id="deficienciaNao" checked="checked"/>
   Não 

   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  Descreva a deficiência
  <input type="text" value="<?php echo $dados['curriculo']['descricaoDeficiencia']; ?>" name="descricaoDeficiencia" id="descricaoDeficiencia" style="width:300px" disabled/>
</tr>  

  </table>



  



  <h2>Interesse Profissional</h2>



  



  <table width="100%" border="0" cellpadding="2" cellspacing="1" class="bloco">



    <tr>



      <td align="right" bgcolor="#F3F3F3"><strong>*Cargo de Interesse</strong></td>



      <td bgcolor="#FFFFFF"><span id="sprytextfield11">



        <!-- <input type="text" name="cargoInteresse" id="cargoInteresse" /> -->
 <select name="cargoInteresse" id="cargoInteresse">

          <option></option>

         <?php select($dados['curriculo']['cargoInteresse'], $dados['cargos'], 'cargo'); ?>

        </select>


      <span class="selectRequiredMsg">Selecione o cargo de interesse.</span></span></td>



    </tr>



    <tr>



      <td align="right">&nbsp;</td>



      <td><label for="nome"></label></td>



    </tr>



    <tr>



      <td colspan="2" bgcolor="#d9e3e8"><strong>*Área profissional desejada (selecione todas as aréas nas quais deseja atuar)</strong></td>
    </tr>
    <tr>
      <td align="right" width="35%">Nível 
        <select name="interNivel1" id="interNivel1" onchange="nivel()">
          <option value="">Selecione uma opção</option>
          <?php 
            $niveis = $dados['niveis'];
            array_unshift($niveis, array('id' => 'Primeiro Emprego', 'nivel' => 'Primeiro Emprego'));
            select($dados['curriculo']['interNivel1'], $niveis, 'nivel'); 
          ?>
        </select>
      </td>
      <td>
        &nbsp;&nbsp;&nbsp;&nbsp;Segmento
        <select name="interSegmento1">
          <option value="">Selecione uma opção</option>
           <?php select($dados['curriculo']['interSegmento1'], $dados['segmentos'], 'segmento'); ?>
          </select>  
      </td>
    </tr>

    <tr>
      <td align="right" width="35%">Nível 
        <select name="interNivel2">
          <option value="">Selecione uma opção</option>
          <?php select($dados['curriculo']['interNivel2'], $dados['niveis'], 'nivel'); ?>
        </select>
      </td>
      <td>
        &nbsp;&nbsp;&nbsp;&nbsp;Segmento
        <select name="interSegmento2">
          <option value="">Selecione uma opção</option>
          <?php select($dados['curriculo']['interSegmento2'], $dados['segmentos'], 'segmento'); ?>
          </select>  
      </td>
    </tr>  

    <tr>
      <td align="right" width="35%">Nível 
        <select name="interNivel3">
          <option value="">Selecione uma opção</option>
            <?php select($dados['curriculo']['interNivel3'], $dados['niveis'], 'nivel'); ?>
        </select>
      </td>
      <td>
        &nbsp;&nbsp;&nbsp;&nbsp;Segmento
        <select name="interSegmento3">
          <option value="">Selecione uma opção</option>
            <?php select($dados['curriculo']['interSegmento3'], $dados['segmentos'], 'segmento'); ?>
          </select>  
      </td>
    </tr>      


    <tr>



      <td align="right">&nbsp;</td>



      <td>&nbsp;</td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3"><strong>*Pretensão Salarial:</strong></td>



      <td bgcolor="#FFFFFF"><span id="sprytextfield12">



        <input type="text" value="<?php echo $dados['curriculo']['pretensaoSalarial']; ?>"  name="pretensaoSalarial" class="moeda" id="pretensaoSalarial" />



      <span class="textfieldRequiredMsg">Digite uma pretensão salarial</span></span> (estimativa)</td>



    </tr>



  </table>



  



  



  <h2>Experiência profissonal</h2>



  



  <table width="100%" border="0" cellpadding="2" cellspacing="1" class="bloco">



    <tr>



      <td colspan="2" bgcolor="#d9e3e8"><strong>Última experiência/Experiência Atual</strong></td>



    </tr>

    <tr>
      <td align="right" width="35%">Nível 
        <select name="expNivel1" id="expNivel1">
          <option value="">Selecione uma opção</option>
            <?php select($dados['curriculo']['expNivel1'], $dados['niveis'], 'nivel'); ?>
        </select>
      </td>
      <td>
        &nbsp;&nbsp;&nbsp;&nbsp;Segmento
        <select name="expSegmento1" id="expSegmento1">
          <option value="">Selecione uma opção</option>
          <?php select($dados['curriculo']['expSegmento1'], $dados['segmentos'], 'segmento'); ?>
          </select>  
      </td>
    </tr> 

    <tr>
      <td align="right" bgcolor="#F3F3F3"> Empresa:</td>
      <td bgcolor="#FFFFFF">
        <span id="sprytextfield50">
          <input type="text" value="<?php echo $dados['curriculo']['expNomeDaEmpresa']; ?>" name="expNomeDaEmpresa" id="expNomeDaEmpresa" style="width:405px" onchange="setObrigatorioDatas1();" />
          <span class="textfieldRequiredMsg"><br>Adicione alguma experiência profissional.</span>
          <span class="textfieldInvalidFormatMsg"><br>Adicione alguma experiência profissional.</span>
        </span>          
     </td>



    </tr>

    <tr>



      <td align="right" bgcolor="#F3F3F3">Último cargo:</td>



      <td bgcolor="#FFFFFF"><input value="<?php echo $dados['curriculo']['expCargo']; ?>" type="text" name="expCargo" id="expCargo" /></td>



    </tr>

    <tr>
      <td align="right" bgcolor="#F3F3F3">Período:</td>
      <td bgcolor="#FFFFFF">
    <span id="sprytextfield30">
        &nbsp;&nbsp;Início <input type="text" value="<?php echo $dados['curriculo']['expInicio1']; ?>" name="expInicio1" id="expInicio1" onkeyup="DigitaData(this)" onblur="DigitaData(this)" /> 
    <span class="textfieldInvalidFormatMsg">Data Inválida.</span><span class="textfieldRequiredMsg">Obrigatório</span></span>
    <span id="sprytextfield31">
        Fim <input type="text" name="expFim1" value="<?php echo $dados['curriculo']['expFim1']; ?>" id="expFim1" onkeyup="DigitaData(this)" onblur="DigitaData(this)" />
    <span class="textfieldInvalidFormatMsg">Data Inválida.</span><span class="textfieldRequiredMsg">Obrigatório</span></span>   
      </td>    
    </tr>

    <tr>



      <td align="right" bgcolor="#F3F3F3">Último salário:</td>



      <td bgcolor="#FFFFFF"><strong>R$:</strong>



        <input value="<?php echo $dados['curriculo']['expUltimoSalarioInt']; ?>" name="expUltimoSalarioInt" class="moeda" type="text" id="expUltimoSalarioInt"/>


</td>



    </tr>



    <tr>



      <td width="322" align="right" bgcolor="#F3F3F3">Atribuições e realizações na empresa:</td>



      <td bgcolor="#FFFFFF"><label for="expAtribuicoes2"></label>



      <textarea name="expAtribuicoes" id="expAtribuicoes" cols="70" rows="7"><?php echo $dados['curriculo']['expAtribuicoes']; ?></textarea></td>



    </tr>



    <tr>



      <td align="right">&nbsp;</td>



      <td>&nbsp;</td>



    </tr>

 
   <tr>



      <td colspan="2" bgcolor="#d9e3e8"><strong>Outra Experiência</strong></td>



    </tr>

    <tr>
      <td align="right" width="35%">Nível 
        <select name="expNivel2" id="expNivel2">
            <option value="">Selecione uma opção</option>
            <?php select($dados['curriculo']['expNivel2'], $dados['niveis'], 'nivel'); ?>
        </select>
      </td>
      <td>
        &nbsp;&nbsp;&nbsp;&nbsp;Segmento
        <select name="expSegmento2" id="expSegmento2">
          <option value="">Selecione uma opção</option>
            <?php select($dados['curriculo']['expSegmento2'], $dados['segmentos'], 'segmento'); ?>
          </select>  
      </td>
    </tr>

    <tr>



      <td align="right" bgcolor="#F3F3F3">Empresa:</td>



      <td bgcolor="#FFFFFF"><input value="<?php echo $dados['curriculo']['expNomeDaEmpresa2']; ?>" type="text" name="expNomeDaEmpresa2" id="expNomeDaEmpresa2" onchange="setObrigatorioDatas2()" style="width:405px" /></td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3">Último cargo:</td>



      <td bgcolor="#FFFFFF"><input value="<?php echo $dados['curriculo']['expCargo2']; ?>" type="text" name="expCargo2" id="expCargo2" /></td>



    </tr>
    <tr>
      <td align="right" bgcolor="#F3F3F3">Período:</td>
      <td bgcolor="#FFFFFF">
      <span id="sprytextfield40">
        &nbsp;&nbsp;Início <input value="<?php echo $dados['curriculo']['expInicio2']; ?>" type="text" name="expInicio2" id="expInicio2" onkeyup="DigitaData(this)" onblur="DigitaData(this)" />
      <span class="textfieldInvalidFormatMsg">Data Inválida.</span><span class="textfieldRequiredMsg">Obrigatório</span></span>
      <span id="sprytextfield32">
         Fim <input type="text" value="<?php echo $dados['curriculo']['expFim2']; ?>" name="expFim2" id="expFim2" onkeyup="DigitaData(this)" onblur="DigitaData(this)" />
      <span class="textfieldInvalidFormatMsg">Data Inválida.</span><span class="textfieldRequiredMsg">Obrigatório</span></span>
       </td>
    </tr>


    <tr>



      <td align="right" bgcolor="#F3F3F3">Último salário:</td>



      <td bgcolor="#FFFFFF"><strong>R$:</strong>



        <input value="<?php echo $dados['curriculo']['expUltimoSalarioInt2']; ?>" name="expUltimoSalarioInt2" class="moeda" type="text" id="expUltimoSalarioInt2" size="8" />


</td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3">Atribuições e realizações na empresa:</td>



      <td bgcolor="#FFFFFF"><label for="expAtribuicoes2"></label>



      <textarea name="expAtribuicoes2" id="expAtribuicoes2" cols="70" rows="7"><?php echo $dados['curriculo']['expAtribuicoes2']; ?></textarea></td>



    </tr>



    <tr>



      <td align="right">&nbsp;</td>



      <td>&nbsp;</td>



    </tr>


    <tr>
      <td colspan="2" bgcolor="#d9e3e8"><strong>Outra Experiência</strong></td>
    </tr>
    <tr>
      <td align="right" width="35%">Nível 
        <select name="expNivel3" id="expNivel3">
          <option value="">Selecione uma opção</option>
            <?php select($dados['curriculo']['expNivel3'], $dados['niveis'], 'nivel'); ?>
        </select>
      </td>
      <td>
        &nbsp;&nbsp;&nbsp;&nbsp;Segmento
        <select name="expSegmento3" id="expSegmento3">
          <option value="">Selecione uma opção</option>
            <?php select($dados['curriculo']['expSegmento3'], $dados['segmentos'], 'segmento'); ?>
          </select>  
      </td>
    </tr>
    <tr>
      <td align="right" bgcolor="#F3F3F3">Empresa:</td>
      <td bgcolor="#FFFFFF"><input value="<?php echo $dados['curriculo']['expNomeEmpresa3']; ?>" type="text" name="expNomeEmpresa3" id="expNomeEmpresa3" onchange="setObrigatorioDatas3()" style="width:405px" /></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#F3F3F3">Último cargo:</td>
      <td bgcolor="#FFFFFF"><input value="<?php echo $dados['curriculo']['expCargo3']; ?>" type="text" name="expCargo3" id="expCargo3" /></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#F3F3F3">Período:</td>
   
      <td bgcolor="#FFFFFF">
      <span id="sprytextfield33">
        &nbsp;&nbsp;Início <input value="<?php echo $dados['curriculo']['expInicio3']; ?>" type="text" name="expInicio3" id="expInicio3" onkeyup="DigitaData(this)" onblur="DigitaData(this)" />
      <span class="textfieldInvalidFormatMsg">Data Inválida.</span><span class="textfieldRequiredMsg">Obrigatório</span></span>
      <span id="sprytextfield34">
         Fim <input value="<?php echo $dados['curriculo']['expFim3']; ?>" type="text" name="expFim3" id="expFim3" onkeyup="DigitaData(this)" onblur="DigitaData(this)" />
       <span class="textfieldInvalidFormatMsg">Data Inválida.</span><span class="textfieldRequiredMsg">Obrigatório</span></span>
       </td>
    </tr>
    <tr>
      <td align="right" bgcolor="#F3F3F3">Último salário:</td>
      <td bgcolor="#FFFFFF"><strong>R$:</strong>
        <input value="<?php echo $dados['curriculo']['expUltimoSalarioInt3']; ?>" name="expUltimoSalarioInt3" class="moeda" type="text" id="expUltimoSalarioInt3" size="8" /></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#F3F3F3">Atribuições e realizações na empresa:</td>
      <td bgcolor="#FFFFFF"><label for="expAtribuicoes2"></label>
      <textarea name="expAtribuicoes3" id="expAtribuicoes3" cols="70" rows="7"><?php echo $dados['curriculo']['expAtribuicoes3']; ?></textarea></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>

<!-- 4 -->

    <tr>
      <td colspan="2" bgcolor="#d9e3e8"><strong>Outra Experiência</strong></td>
    </tr>
    <tr>
      <td align="right" width="35%">Nível 
        <select name="expNivel4" id="expNivel4">
          <option value="">Selecione uma opção</option>
            <?php select($dados['curriculo']['expNivel4'], $dados['niveis'], 'nivel'); ?>
        </select>
      </td>
      <td>
        &nbsp;&nbsp;&nbsp;&nbsp;Segmento
        <select name="expSegmento4" id="expSegmento4">
          <option value="">Selecione uma opção</option>
            <?php select($dados['curriculo']['expSegmento4'], $dados['segmentos'], 'segmento'); ?>
          </select>  
      </td>
    </tr>
    <tr>
      <td align="right" bgcolor="#F3F3F3">Empresa:</td>
      <td bgcolor="#FFFFFF"><input value="<?php echo $dados['curriculo']['expNomeEmpresa4']; ?>" type="text" name="expNomeEmpresa4" id="expNomeEmpresa4" onchange="setObrigatorioDatas4()" style="width:405px" /></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#F3F3F3">Último cargo:</td>
      <td bgcolor="#FFFFFF"><input value="<?php echo $dados['curriculo']['expCargo4']; ?>" type="text" name="expCargo4" id="expCargo4" /></td>
    </tr>
    <tr> 
      <td align="right" bgcolor="#F3F3F3">Período:</td>
      <td bgcolor="#FFFFFF">
      <span id="sprytextfield36">
        &nbsp;&nbsp;Início <input value="<?php echo $dados['curriculo']['expInicio4']; ?>" type="text" name="expInicio4" id="expInicio4" onkeyup="DigitaData(this)" onblur="DigitaData(this)" />
      <span class="textfieldInvalidFormatMsg">Data Inválida.</span><span class="textfieldRequiredMsg">Obrigatório</span></span>
      <span id="sprytextfield37">
         Fim <input type="text" value="<?php echo $dados['curriculo']['expFim4']; ?>" name="expFim4" id="expFim4" onkeyup="DigitaData(this)" onblur="DigitaData(this)" />
      <span class="textfieldInvalidFormatMsg">Data Inválida.</span><span class="textfieldRequiredMsg">Obrigatório</span></span>
       </td>
    </tr>
    <tr>
      <td align="right" bgcolor="#F3F3F3">Último salário:</td>
      <td bgcolor="#FFFFFF"><strong>R$:</strong>
        <input value="<?php echo $dados['curriculo']['expUltimoSalarioInt4']; ?>" name="expUltimoSalarioInt4" class="moeda" type="text" id="expUltimoSalarioInt4" size="8" />
    </tr>
    <tr>
      <td align="right" bgcolor="#F3F3F3">Atribuições e realizações na empresa:</td>
      <td bgcolor="#FFFFFF"><label for="expAtribuicoes4"></label>
      <textarea name="expAtribuicoes4" id="expAtribuicoes4" cols="70" rows="7"><?php echo $dados['curriculo']['expAtribuicoes4']; ?></textarea></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>


<!-- 5 -->

    <tr>
      <td colspan="2" bgcolor="#d9e3e8"><strong>Outra Experiência</strong></td>
    </tr>
    <tr>
      <td align="right" width="35%">Nível 
        <select name="expNivel5" id="expNivel5">
          <option value="">Selecione uma opção</option>
          <?php select($dados['curriculo']['expNivel5'], $dados['niveis'], 'nivel'); ?>
        </select>
      </td>
      <td>
        &nbsp;&nbsp;&nbsp;&nbsp;Segmento
        <select name="expSegmento5" id="expSegmento5">
          <option value="">Selecione uma opção</option>
            <?php select($dados['curriculo']['expSegmento5'], $dados['segmentos'], 'segmento'); ?>
          </select>  
      </td>
    </tr>
    <tr>
      <td align="right" bgcolor="#F3F3F3">Empresa:</td>
      <td bgcolor="#FFFFFF"><input type="text" value="<?php echo $dados['curriculo']['expNomeEmpresa5']; ?>" name="expNomeEmpresa5" id="expNomeEmpresa5" onchange="setObrigatorioDatas5()" style="width:405px" /></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#F3F3F3">Último cargo:</td>
      <td bgcolor="#FFFFFF"><input type="text" value="<?php echo $dados['curriculo']['expCargo5']; ?>" name="expCargo5" id="expCargo5" /></td>
    </tr>
    <tr>    
      <td align="right" bgcolor="#F3F3F3">Período:</td>
      <td bgcolor="#FFFFFF">
        <span id="sprytextfield38">
        &nbsp;&nbsp;Início <input type="text" value="<?php echo $dados['curriculo']['expInicio5']; ?>" name="expInicio5" id="expInicio5" onkeyup="DigitaData(this)" onblur="DigitaData(this)" />
        <span class="textfieldInvalidFormatMsg">Data Inválida.</span><span class="textfieldRequiredMsg">Obrigatório</span></span>
        <span id="sprytextfield39">
         Fim <input type="text" value="<?php echo $dados['curriculo']['expFim5']; ?>" name="expFim5" id="expFim5" onkeyup="DigitaData(this)" onblur="DigitaData(this)" />
        <span class="textfieldInvalidFormatMsg">Data Inválida.</span><span class="textfieldRequiredMsg">Obrigatório</span></span> 
       </td>
    </tr>
    <tr>
      <td align="right" bgcolor="#F3F3F3">Último salário:</td>
      <td bgcolor="#FFFFFF"><strong>R$:</strong>
        <input value="<?php echo $dados['curriculo']['expUltimoSalarioInt5']; ?>" name="expUltimoSalarioInt5" class="moeda" type="text" id="expUltimoSalarioInt5" size="8" /></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#F3F3F3">Atribuições e realizações na empresa:</td>
      <td bgcolor="#FFFFFF"><label for="expAtribuicoes5"></label>
      <textarea name="expAtribuicoes5" id="expAtribuicoes5" cols="70" rows="7"><?php echo $dados['curriculo']['expAtribuicoes5']; ?></textarea></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>


    <tr>



      <td colspan="2" bgcolor="#d9e3e8"><strong>Informações adicionais:</strong></td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3">Fale um pouco mais sobre você e sua vida profissional que  considere importante</td>



      <td bgcolor="#FFFFFF"><textarea name="expInformacoes" id="expInformacoes" cols="70" rows="7"><?php echo $dados['curriculo']['expInformacoes']; ?></textarea></td>



    </tr>



  </table>



  



  <h2>Formação Acadêmica</h2>



  



  <table width="100%" border="0" cellpadding="2" cellspacing="1" class="bloco">



    <tr>



      <td colspan="2" bgcolor="#d9e3e8"><strong>Última Formação/Formação Atual</strong></td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3">Nome do curso:</td>



      <td bgcolor="#FFFFFF"><input value="<?php echo $dados['curriculo']['escNomeCurso']; ?>" type="text" name="escNomeCurso" id="escNomeCurso" style="width:400px"/></td>



    </tr>


    <tr>



      <td width="320" align="right" bgcolor="#F3F3F3">Grau de formação:</td>



      <td width="69%" bgcolor="#FFFFFF"><label for="escGrau"></label>



        <select name="escGrau" id="escGrau" onchange="liberaareaformacao('escGrau', 'areaformacao')" help="Selecione o grau do curso que realizou ou está realizando." class="input">



          <option label="Selecione" value="">Selecione</option>

          <?php select($dados['curriculo']['escGrau'], $dados['grauformacao'], 'grau'); ?>       



          </select>



        



        



        



      </td>



    </tr>

    <tr>



      <td align="right" bgcolor="#F3F3F3">Área de formação:</td>



      <td bgcolor="#FFFFFF"><label for="escGrau"></label>


        <span id="areaformacaoCampo">
        <select name="areaformacao" id="areaformacao" help="Selecione o grau do curso que realizou ou está realizando." class="input" <?php if ($dados['curriculo']['escGrau'] != '6') echo 'disabled'; ?>>



          <option>Selecione</option>
           <?php select($dados['curriculo']['areaformacao'], $dados['areasformacao'], 'areaformacao'); ?> 

      </select>
         <span class="selectRequiredMsg">Escolha a área da sua formação.</span>
          </span>

      </td>



    </tr>       



    <tr>



      <td align="right" bgcolor="#F3F3F3">Nome da instituição de Ensino</td>



      <td bgcolor="#FFFFFF"><input value="<?php echo $dados['curriculo']['escNomeInstituicao']; ?>" type="text" name="escNomeInstituicao" id="escNomeInstituicao" style="width:400px"/></td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3">Data de início:</td>



      <td bgcolor="#FFFFFF"><span id="sprytextfield17">



        <input type="text" value="<?php echo $dados['curriculo']['escDataInicio']; ?>"  name="escDataInicio" id="escDataInicio" onkeyup="DigitaData(this)" onblur="DigitaData(this)" />



      <span class="textfieldInvalidFormatMsg">Data Inválida.</span></span></td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3">Data de conclusão:</td>



      <td bgcolor="#FFFFFF"><span id="sprytextfield18">



      <input type="text" value="<?php echo $dados['curriculo']['escDataConclusao']; ?>" name="escDataConclusao" id="escDataConclusao" onkeyup="DigitaData(this)" onblur="DigitaData(this)" />



<span class="textfieldInvalidFormatMsg">Data Inválida.</span></span></td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3">Ano que está cursando:</td>



      <td bgcolor="#FFFFFF">



        <select name="escAno" help="Selecione em que período do curso você está. Ex.: se estiver no 5º semestre, selecione a opção &quot;3º ano&quot;." class="input" id="escAno">



          <option>Selecione</option>



          <option <?php if($dados['curriculo']['escAno'] == '1') echo 'selected'; ?> value="1">1º Ano</option>



          <option <?php if($dados['curriculo']['escAno'] == '2') echo 'selected'; ?> value="2">2º Ano</option>



          <option <?php if($dados['curriculo']['escAno'] == '3') echo 'selected'; ?> value="3">3º Ano</option>



          <option <?php if($dados['curriculo']['escAno'] == '4') echo 'selected'; ?> value="4">4º Ano</option>



          <option <?php if($dados['curriculo']['escAno'] == '5') echo 'selected'; ?> value="5">5º Ano</option>



          <option <?php if($dados['curriculo']['escAno'] == '6') echo 'selected'; ?> value="6">6º Ano</option>


          <option <?php if($dados['curriculo']['escAno'] == '7') echo 'selected'; ?> value="7">Incompleto</option>


          <option <?php if($dados['curriculo']['escAno'] == '8') echo 'selected'; ?> value="8" >Já formado</option>



          </select>



        



        



      </td>



    </tr>



    <tr>



      <td align="right">&nbsp;</td>



      <td>&nbsp;</td>



    </tr>



    <tr>



      <td colspan="2" bgcolor="#d9e3e8"><strong>Outra Formação</strong></td>



    </tr>


    <tr>



      <td align="right" bgcolor="#F3F3F3">Nome do curso:</td>



      <td bgcolor="#FFFFFF"><input value="<?php echo $dados['curriculo']['escNomeCurso2']; ?>" type="text" name="escNomeCurso2" id="escNomeCurso2" style="width:400px"/></td>



    </tr>


    <tr>



      <td align="right" bgcolor="#F3F3F3">Grau de formação:</td>



      <td bgcolor="#FFFFFF"><label for="escGrau"></label>



        <select name="escGrau2" id="escGrau2" onchange="liberaareaformacao('escGrau2', 'areaformacao2')" help="Selecione o grau do curso que realizou ou está realizando." class="input">



          <option>Selecione</option>
           <?php select($dados['curriculo']['escGrau2'], $dados['grauformacao'], 'grau'); ?> 

      </select></td>



    </tr>

    <tr>



      <td align="right" bgcolor="#F3F3F3">Área da formação:</td>



      <td bgcolor="#FFFFFF"><label for="escGrau"></label>


        <span id="areaformacaoCampo2">
        <select name="areaformacao2" id="areaformacao2" help="Selecione o grau do curso que realizou ou está realizando." class="input" <?php if ($dados['curriculo']['escGrau2'] != '6') echo 'disabled'; ?>>



          <option>Selecione</option>
           <?php select($dados['curriculo']['areaformacao2'], $dados['areasformacao'], 'areaformacao'); ?> 

      </select>
        <span class="selectRequiredMsg">Escolha a área da sua formação.</span>
      </span>


      </td>



    </tr>    



    <tr>



      <td align="right" bgcolor="#F3F3F3">Nome da instituição de Ensino</td>



      <td bgcolor="#FFFFFF"><input value="<?php echo $dados['curriculo']['escNomeInstituicao2']; ?>" type="text" name="escNomeInstituicao2" id="escNomeInstituicao2" style="width:400px"/></td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3">Data de início:</td>



      <td bgcolor="#FFFFFF"><span id="sprytextfield19">



      <input type="text" value="<?php echo $dados['curriculo']['escDataInicio2']; ?>" name="escDataInicio2" id="escDataInicio2" onkeyup="DigitaData(this)" onblur="DigitaData(this)"/>



<span class="textfieldInvalidFormatMsg">Data Inválida.</span></span></td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3">Data de conclusão:</td>



      <td bgcolor="#FFFFFF"><span id="sprytextfield20">



      <input type="text" value="<?php echo $dados['curriculo']['escDataConclusao2']; ?>" name="escDataConclusao2" id="escDataConclusao2" onkeyup="DigitaData(this)" onblur="DigitaData(this)" />



<span class="textfieldInvalidFormatMsg">Data Inválida.</span></span></td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3">Ano que está cursando:</td>



      <td bgcolor="#FFFFFF"><select name="escAno2" help="Selecione em que período do curso você está. Ex.: se estiver no 5º semestre, selecione a opção &quot;3º ano&quot;." class="input" id="escAno2">



        <option>Selecione</option>



          <option <?php if($dados['curriculo']['escAno2'] == '1') echo 'selected'; ?> value="1">1º Ano</option>



          <option <?php if($dados['curriculo']['escAno2'] == '2') echo 'selected'; ?> value="2">2º Ano</option>



          <option <?php if($dados['curriculo']['escAno2'] == '3') echo 'selected'; ?> value="3">3º Ano</option>



          <option <?php if($dados['curriculo']['escAno2'] == '4') echo 'selected'; ?> value="4">4º Ano</option>



          <option <?php if($dados['curriculo']['escAno2'] == '5') echo 'selected'; ?> value="5">5º Ano</option>



          <option <?php if($dados['curriculo']['escAno2'] == '6') echo 'selected'; ?> value="6">6º Ano</option>

          
          <option <?php if($dados['curriculo']['escAno2'] == '7') echo 'selected'; ?> value="7">Incompleto</option>


          <option <?php if($dados['curriculo']['escAno2'] == '8') echo 'selected'; ?> value="8" >Já formado</option>



      </select></td>



    </tr>



  </table>



  



  <h2>Idiomas</h2>



  



  <table width="100%" border="0" cellpadding="2" cellspacing="1" class="bloco">



    <tr>



      <td bgcolor="#F3F3F3"><input <?php if($dados['curriculo']['idiomaIngles'] == 1) echo 'checked'; ?> type="checkbox" name="idiomaIngles" id="idiomaIngles" />



        <label for="idiomaIngles"></label>



      Inglês</td>



      <td bgcolor="#FFFFFF">



        <input type="radio" <?php if($dados['curriculo']['nivelIdiomaIngles'] == 3) echo 'checked'; ?> name="nivelIdiomaIngles" value="3" />



        Básico 



        <input type="radio" <?php if($dados['curriculo']['nivelIdiomaIngles'] == 2) echo 'checked'; ?> name="nivelIdiomaIngles" value="2" />



        Intermediário 



        <input type="radio" <?php if($dados['curriculo']['nivelIdiomaIngles'] == 1) echo 'checked'; ?> name="nivelIdiomaIngles" value="1" />



      Fluente</td>



    </tr>



    <tr>



      <td bgcolor="#F3F3F3"><input <?php if($dados['curriculo']['idiomaEspanhol'] == 1) echo 'checked'; ?> type="checkbox" name="idiomaEspanhol" id="idiomaIngles6" />



        <label for="idiomaIngles6"></label>



      Espanhol</td>



      <td bgcolor="#FFFFFF"><input <?php if($dados['curriculo']['nivelIdiomaEspanhol'] == 3) echo 'checked'; ?> type="radio" name="nivelIdiomaEspanhol" value="3" />



        Básico



        <input type="radio" <?php if($dados['curriculo']['nivelIdiomaEspanhol'] == 2) echo 'checked'; ?> name="nivelIdiomaEspanhol" value="2" />



        Intermediário



        <input type="radio" <?php if($dados['curriculo']['nivelIdiomaEspanhol'] == 1) echo 'checked'; ?> name="nivelIdiomaEspanhol" value="1" />



      Fluente</td>



    </tr>



    <tr>



      <td bgcolor="#F3F3F3"><input type="checkbox" <?php if($dados['curriculo']['idiomaFrances'] == 1) echo 'checked'; ?> name="idiomaFrances" id="idiomaIngles7" />



        <label for="idiomaIngles7"></label>



      Francês</td>



      <td bgcolor="#FFFFFF"><input type="radio" <?php if($dados['curriculo']['nivelIdiomaFrances'] == 3) echo 'checked'; ?> name="nivelIdiomaFrances" value="3" />



        Básico



        <input type="radio" <?php if($dados['curriculo']['nivelIdiomaFrances'] == 2) echo 'checked'; ?> name="nivelIdiomaFrances" value="2" />



        Intermediário



        <input type="radio" <?php if($dados['curriculo']['nivelIdiomaFrances'] == 1) echo 'checked'; ?> name="nivelIdiomaFrances" value="1" />



      Fluente</td>



    </tr>



    <tr>



      <td bgcolor="#F3F3F3"><input type="checkbox" <?php if($dados['curriculo']['idiomaAlemao'] == 1) echo 'checked'; ?> name="idiomaAlemao" id="idiomaIngles8" />



        <label for="idiomaIngles8"></label>



      Alemão</td>



      <td bgcolor="#FFFFFF"><input type="radio" <?php if($dados['curriculo']['nivelIdiomaAlemao'] == 3) echo 'checked'; ?> name="nivelIdiomaAlemao" value="3" />



        Básico



        <input type="radio" <?php if($dados['curriculo']['nivelIdiomaAlemao'] == 2) echo 'checked'; ?> name="nivelIdiomaAlemao" value="2" />



        Intermediário



        <input type="radio" <?php if($dados['curriculo']['nivelIdiomaAlemao'] == 1) echo 'checked'; ?> name="nivelIdiomaAlemao" value="1" />



      Fluente</td>



    </tr>



    <tr>



      <td bgcolor="#F3F3F3"><input type="checkbox" <?php if($dados['curriculo']['idiomaItaliano'] == 1) echo 'checked'; ?> name="idiomaItaliano" id="idiomaItaliano" onclick="x()"/>



        <label for="idiomaIngles9"></label>



      Italiano</td>



      <td bgcolor="#FFFFFF">



        <div id="nivel">    



          <input type="radio" <?php if($dados['curriculo']['nivelIdiomaItaliano'] == 3) echo 'checked'; ?> name="nivelIdiomaItaliano" value="3"  id="nivelIdiomaItaliano"/>



          Básico



          <input type="radio" <?php if($dados['curriculo']['nivelIdiomaItaliano'] == 2) echo 'checked'; ?> name="nivelIdiomaItaliano" value="2" />



          Intermediário



          <input type="radio" <?php if($dados['curriculo']['nivelIdiomaItaliano'] == 1) echo 'checked'; ?> name="nivelIdiomaItaliano" value="1" />



          Fluente



        </div>



      </td>



    </tr>



  </table>  



  



  <h2>Informática</h2>



  <table width="100%" border="0" cellpadding="2" cellspacing="1" class="bloco">



    <tr>



      <td width="57%" bgcolor="#F3F3F3"><input type="checkbox" <?php if($dados['curriculo']['infOffice'] == 1) echo 'checked'; ?> name="infOffice" id="infOffice" />



        <strong>Pacote Office</strong> (Windows, Word, Excel, Powerpoint)</td>



      <td width="43%" bgcolor="#FFFFFF"><input type="radio" <?php if($dados['curriculo']['nivelInfOffice'] == 3) echo 'checked'; ?> name="nivelInfOffice" value="3" />



        Básico



        <input type="radio" <?php if($dados['curriculo']['nivelInfOffice'] == 2) echo 'checked'; ?> name="nivelInfOffice" value="2" />



        Intermediário



        <input type="radio" <?php if($dados['curriculo']['nivelInfOffice'] == 1) echo 'checked'; ?> name="nivelInfOffice" value="1" />



        Avançado</td>



    </tr>



    <tr>



      <td bgcolor="#F3F3F3"><input type="checkbox" <?php if($dados['curriculo']['infAplGraficas'] == 1) echo 'checked'; ?> name="infAplGraficas" id="infAplGraficas"  />



        <strong>Aplicativos Gráficos</strong> (Corel, Photoshop, Illustrator)</td>



      <td bgcolor="#FFFFFF"><input <?php if($dados['curriculo']['nivelInfAplGraficas'] == 3) echo 'checked'; ?> type="radio" name="nivelInfAplGraficas" value="3"/>



        Básico



        <input type="radio" <?php if($dados['curriculo']['nivelInfAplGraficas'] == 2) echo 'checked'; ?> name="nivelInfAplGraficas" value="2"/>



        Intermediário



        <input type="radio" <?php if($dados['curriculo']['nivelInfAplGraficas'] == 1) echo 'checked'; ?> name="nivelInfAplGraficas" value="1"/>



        Avançado</td>



    </tr>



    <tr>



      <td bgcolor="#F3F3F3"><input type="checkbox" <?php if($dados['curriculo']['infDes'] == 1) echo 'checked'; ?> name="infDes" id="idiomaFraces2" />



        <strong>Desenvolvimento de software</strong> (Programação e Design)</td>



      <td bgcolor="#FFFFFF"><input type="radio" <?php if($dados['curriculo']['nivelInfDes'] == 3) echo 'checked'; ?> name="nivelInfDes" value="3"/>



        Básico



        <input type="radio" <?php if($dados['curriculo']['nivelInfDes'] == 2) echo 'checked'; ?> name="nivelInfDes" value="2"/>



        Intermediário



        <input type="radio" <?php if($dados['curriculo']['nivelInfDes'] == 1) echo 'checked'; ?> name="nivelInfDes" value="1"/>



        Avançado</td>



    </tr>



    <tr>



      <td bgcolor="#F3F3F3"><input type="checkbox" <?php if($dados['curriculo']['infManut'] == 1) echo 'checked'; ?> name="infManut" id="infManut"/>



        <strong>Manutenção de computadores e redes</strong></td>



      <td bgcolor="#FFFFFF"><input type="radio" <?php if($dados['curriculo']['nivelInfManut'] == 3) echo 'checked'; ?> name="nivelInfManut" value="3" />



        Básico



        <input type="radio" <?php if($dados['curriculo']['nivelInfManut'] == 2) echo 'checked'; ?> name="nivelInfManut" value="2" />



        Intermediário



        <input type="radio" <?php if($dados['curriculo']['nivelInfManut'] == 1) echo 'checked'; ?> name="nivelInfManut" value="1" />



        Avançado</td>



    </tr>



  </table>



  <h2>Configuração de Login</h2>



  



  <table width="100%" border="0" cellpadding="2" cellspacing="1" class="bloco">



    <tr>



      <td colspan="2" bgcolor="#d9e3e8"><strong>Dados para utilização do Sistema</strong></td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3"><strong>Login/Email:</strong></td>



      <td bgcolor="#FFFFFF"><span id="loginemail">

      <input name="email2" value="<?php echo \Positiv\Sessao::pegar('email'); ?>" type="text" id="email2" style="width:300px;"/>

      <span class="textfieldRequiredMsg">Digite um email como seu login.</span><span id="mensagemEmail2" class="textfieldInvalidFormatMsg">Formato de email incorreto.</span></span>



      Seu Login é o E-mail acima inserido.</td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3">Nova Senha:</td>



      <td bgcolor="#FFFFFF"><span id="sprytextfield21">



      <input type="password" name="senha" id="senha" />



      <span class="textfieldRequiredMsg">Digite sua senha.</span><span class="textfieldMinCharsMsg">Sua senha deve conter no mínimo 4 caracteres.</span><span id="confirmacao1" class="textfieldInvalidFormatMsg">Formato de email incorreto.</span></span></td>



    </tr>



    <tr>



      <td align="right" bgcolor="#F3F3F3">*Confirme sua nova senha:</td>



      <td bgcolor="#FFFFFF"><span id="sprytextfield22">



      <input type="password" name="senha2" id="senha2" />



      <span class="textfieldRequiredMsg">Digite sua senha novamente.</span><span id="confirmacao2" class="textfieldInvalidFormatMsg">As senhas não conferem.</span><span class="textfieldMinCharsMsg">Sua senha deve conter no mínimo 4 caracteres.</span><span class="textfieldMaxCharsMsg" id="confirmacao2">Sua senha deve conter no máximo 20 caracteres.</span></span></td>



    </tr>



    <tr>



      <td colspan="2" align="center" bgcolor="#F3F3F3" height="45px;"><div id="retorno"></div></td>



    </tr>



  </table>  



  



  



  <div class="barra" align="center">

  

    <div id="verlogin" style="display:none"><a onclick="verificarLogin()"><spam>Clique aqui para verificar disponibilidade de Login</spam></a></div>

  <div id="submit" >

    <input type="submit" name="cadastrar" id="button" value="Salvar" onclick="verificaExperiencia()" onMouseOver="verSenha()" />

    <!-- <input type="reset" name="apagar" id="button" value="Apagar" /> -->

  </div>

  </div>  



</form>







<script type="text/javascript">

var sprytextfield1 = new Spry.Widget.ValidationTextField("nomecampleto", "none", {validateOn:["blur", "change"]});



var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "email", {validateOn:["blur", "change"]});



//var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "custom", {validation: "teste", validateOn:["blur", "change"], isRequired:true});



var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "date", {format:"dd/mm/yyyy", validateOn:["blur", "change"]});



var spryradio1 = new Spry.Widget.ValidationRadio("spryradio1", {validateOn:["change"]});



var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {validateOn:["blur", "change"]});



var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {validateOn:["blur", "change"]});



var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {validateOn:["blur", "change"]});



var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "none", {validateOn:["blur", "change"]});



//var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9", "none", {validateOn:["blur", "change"]});



var spryradio2 = new Spry.Widget.ValidationRadio("spryradio2", {validateOn:["blur", "change"]});



//var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11", "none", {validateOn:["blur", "change"]});
var spryselect1 = new Spry.Widget.ValidationSelect("sprytextfield11", {validateOn:["change", "blur"]});


var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12", "none", {validateOn:["blur", "change"]});



var sprytextfield14 = new Spry.Widget.ValidationTextField("sprytextfield14", "none", {validateOn:["blur", "change"], isRequired:false});



var sprytextfield16 = new Spry.Widget.ValidationTextField("sprytextfield16", "none", {isRequired:false, validateOn:["blur", "change"]});



var sprytextfield17 = new Spry.Widget.ValidationTextField("sprytextfield17", "date", {validateOn:["blur", "change"], isRequired:false, format:"dd/mm/yyyy"});



var sprytextfield18 = new Spry.Widget.ValidationTextField("sprytextfield18", "date", {format:"dd/mm/yyyy", validateOn:["blur", "change"], isRequired:false});



var sprytextfield19 = new Spry.Widget.ValidationTextField("sprytextfield19", "date", {format:"dd/mm/yyyy", validateOn:["blur", "change"], isRequired:false});



var sprytextfield20 = new Spry.Widget.ValidationTextField("sprytextfield20", "date", {format:"dd/mm/yyyy", validateOn:["blur", "change"], isRequired:false});


//senha
//var sprytextfield21 = new Spry.Widget.ValidationTextField("sprytextfield21", "none", {minChars:4, maxChars:20, validateOn:["change"]});

var sprytextfield21 = new Spry.Widget.ValidationTextField("sprytextfield21", "custom", {validation: "senha", validateOn:["blur", "change"], isRequired: false});



//senha2
//var sprytextfield22 = new Spry.Widget.ValidationTextField("sprytextfield22", "none", {minChars:4, maxChars:20, validateOn:["change"]});

var sprytextfield22 = new Spry.Widget.ValidationTextField("sprytextfield22", "custom", {validation: "senha2", validateOn:["blur", "change"], isRequired: false});


var sprytextfield23 = new Spry.Widget.ValidationTextField("sprytextfield23", "none", {validateOn:["blur", "change"]});

var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {validateOn:["change", "blur"]});

//var sprytextfield24 = new Spry.Widget.ValidationTextField("sprytextfield24", "email", {validateOn:["blur", "change"]}); 

var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2", {validateOn:["change", "blur"]});

var spryselect2 = new Spry.Widget.ValidationSelect("sprytextfield9", {validateOn:["change", "blur"]});

var sprytextfield30 = new Spry.Widget.ValidationTextField("sprytextfield30", "date", {format:"dd/mm/yyyy", validateOn:["blur", "change"], isRequired:<?php echo ($dados['curriculo']['expNomeDaEmpresa'] != '') ? 'true' : 'false'; ?>});

var sprytextfield31 = new Spry.Widget.ValidationTextField("sprytextfield31", "date", {format:"dd/mm/yyyy", validateOn:["blur", "change"], isRequired:<?php echo ($dados['curriculo']['expNomeDaEmpresa'] != '') ? 'true' : 'false'; ?>});

var sprytextfield32 = new Spry.Widget.ValidationTextField("sprytextfield32", "date", {format:"dd/mm/yyyy", validateOn:["blur", "change"], isRequired:<?php echo ($dados['curriculo']['expNomeDaEmpresa2'] != '') ? 'true' : 'false'; ?>});

var sprytextfield33 = new Spry.Widget.ValidationTextField("sprytextfield33", "date", {format:"dd/mm/yyyy", validateOn:["blur", "change"], isRequired:<?php echo ($dados['curriculo']['expNomeEmpresa3'] != '') ? 'true' : 'false'; ?>});

var sprytextfield34 = new Spry.Widget.ValidationTextField("sprytextfield34", "date", {format:"dd/mm/yyyy", validateOn:["blur", "change"], isRequired:<?php echo ($dados['curriculo']['expNomeEmpresa3'] != '') ? 'true' : 'false'; ?>});

var sprytextfield35 = new Spry.Widget.ValidationTextField("sprytextfield35", "date", {format:"dd/mm/yyyy", validateOn:["blur", "change"], isRequired:false});

var sprytextfield36 = new Spry.Widget.ValidationTextField("sprytextfield36", "date", {format:"dd/mm/yyyy", validateOn:["blur", "change"], isRequired:<?php echo ($dados['curriculo']['expNomeEmpresa4'] != '') ? 'true' : 'false'; ?>});

var sprytextfield37 = new Spry.Widget.ValidationTextField("sprytextfield37", "date", {format:"dd/mm/yyyy", validateOn:["blur", "change"], isRequired:<?php echo ($dados['curriculo']['expNomeEmpresa4'] != '') ? 'true' : 'false'; ?>});

var sprytextfield38 = new Spry.Widget.ValidationTextField("sprytextfield38", "date", {format:"dd/mm/yyyy", validateOn:["blur", "change"], isRequired:<?php echo ($dados['curriculo']['expNomeEmpresa5'] != '') ? 'true' : 'false'; ?>});

var sprytextfield39 = new Spry.Widget.ValidationTextField("sprytextfield39", "date", {format:"dd/mm/yyyy", validateOn:["blur", "change"], isRequired:<?php echo ($dados['curriculo']['expNomeEmpresa5'] != '') ? 'true' : 'false'; ?>});

var sprytextfield40 = new Spry.Widget.ValidationTextField("sprytextfield40", "date", {format:"dd/mm/yyyy", validateOn:["blur", "change"], isRequired:<?php echo ($dados['curriculo']['expNomeDaEmpresa2'] != '') ? 'true' : 'false'; ?>});

var spryselect41 = new Spry.Widget.ValidationSelect("quantidadeFilhos", {validateOn:["change", "blur"]});

var sprytextfield43 = new Spry.Widget.ValidationTextField("sprytextfield3", "custom", {validation: "teste", validateOn:["blur", "change"]});

var sprytextfield50 = new Spry.Widget.ValidationTextField("sprytextfield50", "custom", {validation: "experiencia", validateOn:["blur", "change"]});

//var sprytextfield60 = new Spry.Widget.ValidationTextField("facebook", "custom", {validation: "facebook", validateOn:["blur", "change"], isRequired:false});

var sprytextfield61 = new Spry.Widget.ValidationTextField("loginemail", "custom", {validation: "loginemail", validateOn:["blur"], isRequired:true});

var spryRG = new Spry.Widget.ValidationTextField("rgSpan", "none", {validateOn:["blur", "change"]});

var spryMae = new Spry.Widget.ValidationTextField("nomeMae", "none", {validateOn:["blur", "change"]});

//area da formacao
var areadaformacao = new Spry.Widget.ValidationSelect("areaformacaoCampo", {validateOn:["change", "blur"], isRequired:<?php echo ($dados['curriculo']['escGrau'] == '6') ? 'true' : 'false'; ?>});

var areadaformacao2 = new Spry.Widget.ValidationSelect("areaformacaoCampo2", {validateOn:["change", "blur"], isRequired:<?php echo ($dados['curriculo']['escGrau2'] == '6') ? 'true' : 'false'; ?>});


</script> 
 
    
<div class="clear"></div>
</div>

<div class="bottom">
    ﻿<div class="creditos">Copyright Lucrativia 2015 ©, Todos os Direitos Reservados.<br />Developed by C2 Web Soluções</div>
<div class="clear"></div>  

</div>


</body>

</html>