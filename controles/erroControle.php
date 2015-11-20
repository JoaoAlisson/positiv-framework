<?php
namespace Positiv;

class erro extends Controle
{	
	function index()
	{
		$tipo = Sessao::pegar('tipo');
		if($tipo == 0)
			$this->renderizar = false;
	}
}
?>