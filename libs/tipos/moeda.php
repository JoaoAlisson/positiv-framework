<?php
namespace libs\tipos;

class moeda extends Tipos
{

	function trata_valor_para_salvar ()
	{	
		return str_replace(array('.', ','), array('', '.'), $this->valor);
	}
	

	function trata_valor_para_mostrar ()
	{	
		return ($this->valor != 0) ? str_pad($this->valor, 9, "0", STR_PAD_LEFT) : ''; 
	}
}
?>