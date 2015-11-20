<?php
namespace Positiv;

class index extends Controle
{	
	public $renderizar = false;	
	
	function index ()
	{
		$tipo = Sessao::pegar('tipo');
		if($tipo != '0') {
			$this->renderizar = true;
			$this->visao = 'indexAdm';
			header('location: ' . URL . 'curriculos/');
		}
	}
}
?>