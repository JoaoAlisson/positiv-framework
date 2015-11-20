<?php
namespace Positiv;

class Visao
{	
	private $pastaVisoes = '';

	function __construct ()
	{
		$this->pastaVisoes = RAIZ . SEPARADOR . 'visoes' . SEPARADOR;
	}

	function renderizar ($controle, $visao, $HTML, $dados, $renderizar = true)
	{
		$visaoPhtml = $this->pastaVisoes . $controle . SEPARADOR . $visao . '.phtml';

		if (file_exists($visaoPhtml)) {

			if($renderizar)
				$this->addTopo();
			
			require $visaoPhtml;
			
			if($renderizar)
				$this->addRodape();
		}

	}

	private function addTopo ()
	{
		require $this->pastaVisoes . 'topo.phtml';
	}

	private function addRodape ()
	{
		require $this->pastaVisoes . 'rodape.phtml';
	}
}
?>