<?php
namespace libs\tipos;

class raca extends chaveEstrangeira
{
	function __construct ()
	{	
		$this->tabela = 'raca';
	}	

	protected function buscaValores()
	{
		if ($this->valor != null && $this->valor != '')
			parent::buscaValores();
	}
}
?>