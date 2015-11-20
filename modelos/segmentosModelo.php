<?php
namespace Positiv;

class segmentosModelo extends Modelo
{	
	public $tipos = array('segmento' => 'nome');

	public function segmentos ()
	{	
		return $this->todos(array('id', 'segmento'));
	}

}
?>