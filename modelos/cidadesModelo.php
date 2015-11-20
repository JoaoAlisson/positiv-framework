<?php
namespace Positiv;

class cidadesModelo extends Modelo
{	
	public $tipos = array('cidade' => 'nome', 'estado' => 'nome');

	public function cidades ($idEstado)
	{	
		$idEstado = (int)$idEstado;
		return $this->pesquisar(array('estado' => $idEstado), array('id', 'cidade'));
	}

}
?>