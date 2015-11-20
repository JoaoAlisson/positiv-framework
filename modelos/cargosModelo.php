<?php
namespace Positiv;

class cargosModelo extends Modelo
{	
	public $tipos = array('cargo' => 'nome');

	public function cargos ()
	{	
		return $this->todos(array('id', 'cargo'));
	}

}
?>