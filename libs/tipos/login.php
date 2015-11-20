<?php
namespace libs\tipos;

class login extends Tipos
{

	function campo ($icone = 'user', $id = '', $complemento = '', $classe = '')
	{	
		return parent::campo('user', $id, $complemento, $classe);
	}
	
}
?>