<?php
namespace libs\tipos;

class senhaNova2 extends senha
{
	
	function validacao ()
	{
		if ($_POST['nova1'] != $_POST['nova2']) {
			array_push($this->errosValidacao, 'As senhas não conferem.');
			return false;
		}

		return true;
	}
}
?>