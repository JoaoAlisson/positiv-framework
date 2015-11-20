<?php
namespace libs\tipos;

class telefone extends Tipos
{

	function campo ($icone, $id = '')
	{	
		return parent::campo('call', $id, "onkeyup=\"telefoneMask();\"");
	}
}
?>