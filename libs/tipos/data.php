<?php
namespace libs\tipos;

class data extends Tipos
{

	function campo ($icone = '', $id = '', $complemento = '', $classe = '')
	{		
		return parent::campo('calendar', $id, "onfocus=\"datapick()\"");
	}

	function trata_valor_para_salvar ()
	{
		$data = $this->valor;

		if ($data == '')
			return '';		

		$data = explode('/', $data);
		$dia = $data[0];
		$mes = $data[1];
		$ano = $data[2];

		return "$ano-$mes-$dia";
	}

	function trata_valor_para_input ()
	{
		return $this->trata_valor_para_mostrar();
	}

	function trata_valor_para_mostrar ()
	{
		$data = $this->valor;

		if ($data == '0000-00-00' || $data == '')
			return '';

		$data = explode('-', $data);
		$ano = $data[0];
		$mes = $data[1];
		$dia = $data[2];

		return "$dia/$mes/$ano";
	}	
}
?>