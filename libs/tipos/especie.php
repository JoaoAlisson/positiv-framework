<?php
namespace libs\tipos;

class especie extends chaveEstrangeira
{
	function __construct ()
	{	
		$this->tabela = 'especie';
	}	

	function campo ($icone = 'pencil', $id = '', $onChange = "pegaRacas()")
	{	
		$onChange = ($onChange != '') ? "onChange=\"$onChange\"" : '';
		return parent::campo('pencil', $id, $onChange);
	}

}
?>