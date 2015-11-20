<?php
namespace libs\tipos;

abstract class Tipos
{
	protected $valor       = null;
	protected $campoNome   = '';
	protected $obrigatorio = false;
	protected $nome        = '';
	public    $errosValidacao = array();

	function setaCampo ($nome, $valor = null, $obrigatorio = false, $campo = '')
	{
		$this->setaNome($nome);
		$this->setaValor($valor);
		$this->setaObrigatorio($obrigatorio);
		$this->setaCampoNome($campo);
	}

	function setaCampoNome($campo)
	{
		$this->campoNome = $campo;
	}

	function setaNome ($nome)
	{
		$this->nome = $nome;
	}

	function setaValor ($valor)
	{
		$this->valor = $this->trata($valor);
	}

	function setaObrigatorio ($obrigatorio = true)
	{
		$this->obrigatorio = $obrigatorio;
	}


	function pegaValor ()
	{
		return $this->trata_valor_para_mostrar();
	}

	function campoCompleto ($icone = 'pencil', $id = null, $filtro)
	{	
		$erro = empty($this->errosValidacao) ? '' : 'error'; 
		$html =  "<div class='field $erro' id='campo_$id'>
			      	<label>" . $this->nome . '</label>';
		if ($filtro)
			$html .= '<br>';
		$html .=  $this->campo($icone, $id);
		$html .=  $this->addErros();
		$html .= '</div>';		

		return $html;
	}

	protected function addErros ()
	{
		if (empty($this->errosValidacao))
			return '';

		$erros = '';
		foreach ($this->errosValidacao as $erro)
			$erros .= ($erros == '') ? "<i class='attention icon'></i>$erro" : "<br><i class='attention icon'></i>$erro"; 
		
		return "<div class='ui red pointing prompt label transition mensagemErro' style='display: inline-block;'>
				$erros</div>";
	}


	function campo ($icone = 'pencil', $id = '', $complemento = '', $classe = '')
	{	
		$html  = "<div class='ui corner labeled left icon input'>";
		$html .= "<input type='text' $complemento class='camposInput $classe' onkeypress='enterSubmit(event);' value='" . $this->trata_valor_para_input() . "' id='input_$id' name='$id' />";
		$html .= "<i class='$icone icon'></i>";
		if($this->obrigatorio)
			$html .= "<div class='ui corner label'><i class='icon asterisk'></i></div>";
		$html .= "</div>";	

		return $html;
	}

	protected function trata_valor_para_input ()
	{
		return $this->valor;
	}

	protected function trata ($valor)
	{
		return $valor;
	}

	function trata_valor_para_salvar ()
	{
		return $this->valor;
	}

	function trata_valor_para_mostrar ()
	{
		return $this->valor;
	}

	function valido ()
	{	
		if (!$this->validaObrigatorio())
			return false;

		return $this->validacao();
	}

	function pegaErrosValidacoes ()
	{
		$this->valido();
		return $this->errosValidacao;
	}

	protected function validaObrigatorio ()
	{
		if ($this->obrigatorio)
			if ($this->valor == null) {
				array_push($this->errosValidacao, 'Campo Obrigatório');
				return false;
			}

		return true;	
	}

	protected function validacao ()
	{
		return true;
	}
}
?>