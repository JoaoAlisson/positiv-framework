<?php 
namespace Positiv;

class cidades extends Controle 
{

	public $campos = array();

	public $renderizar = false;					   

	function pegarCidades()
	{
		echo json_encode($this->modelo->cidades($_POST['estado']));
		//exit();
	}
}
?> 