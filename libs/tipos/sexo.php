<?php
namespace libs\tipos;

class sexo extends select
{
	function __construct ()
	{
		$this->valores = array('','Macho', 'Fêmea');
	}	
}
?>