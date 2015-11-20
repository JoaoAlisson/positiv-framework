<?php
namespace libs\tipos;

class senhaNova extends senha
{

	function validacao ()
	{
		if ($_POST['senha'] != $_POST['senha2']) {
			array_push($this->errosValidacao, 'As senhas não conferem.');
			return false;
		}

		return true;
	}		
}
?>