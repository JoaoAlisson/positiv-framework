<?php
namespace libs\tipos;

class Tipos
{
	protected $valor       = null;
	protected $obrigatorio = false;
	protected $nome        = '';

	function setaCampo ($nome, $valor = null, $obrigatorio = false)
	{
		$this->setNome($nome);
		$this->setValor($valor);
		$this->setObrigatorio($obrigatorio);
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

	function campo ()
	{
		return "<input id='" . $this->nome . "' value='" . $this->trata_valor_para_input() . "' />";
	}

	protected function trata_valor_para_input ()
	{
		return $this->valor;
	}

	protected function trata ($valor)
	{
		return $valor;
	}

	protected function trata_valor_para_mostrar ()
	{
		return $this->valor;
	}

	function valido ()
	{	
		if(!$this->validaObrigatorio())
			return false;

		return $this->validacao();
	}

	function validaObrigatorio ()
	{
		if($this->obrigatorio)
			if($valor == null)
				return false;

		return true;	
	}

	function validacao ()
	{
		return true;
	}
}
?>