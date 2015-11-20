<?php
namespace Positiv;

class niveisModelo extends Modelo
{	
	public $tipos = array('nivel' => 'nome');

	public function niveis ()
	{	
		return $this->todos(array('id', 'nivel'));
	}

}
?>