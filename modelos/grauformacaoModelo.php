<?php
namespace Positiv;

class grauformacaoModelo extends Modelo
{	
	public $tipos = array('grau' => 'nome');

	public function grauformacao ()
	{	
		return $this->todos(array('id', 'grau'));
	}

}
?>