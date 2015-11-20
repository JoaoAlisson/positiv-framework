<?php
namespace Positiv;

class estadosModelo extends Modelo
{	
	public $tipos = array('estado');

	public function estados ()
	{	
		return $this->todos(array('id', 'estado'));
	}

}
?>