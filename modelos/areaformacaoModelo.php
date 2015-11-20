<?php
namespace Positiv;

class areaformacaoModelo extends Modelo
{	
	public $tipos = array('areaformacao' => 'nome');

	public function areasformacao ()
	{	
		return $this->todos(array('id', 'areaformacao'));
	}
}
?>