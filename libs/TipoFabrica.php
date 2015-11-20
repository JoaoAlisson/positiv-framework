<?php
namespace Positiv;

class TipoFabrica
{
	function pegaTipo ($tipo)
	{	
		$tipoClass = 'libs\\tipos\\' . $tipo;
		return new $tipoClass();
	}
}
?>