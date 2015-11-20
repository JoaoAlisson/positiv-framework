<?php
namespace Positiv;

class Controle 
{	
	public $visao; 
	public $modelo; 
	public $dados;
	public $campos; 
	
	function index()
	{
		//echo 'Index';
	}

	protected function salvar ()
	{
		$dados;
		
		foreach ($this->campos as $campo => $value)
			$dados[$campo] = isset($_POST[$campo]) ? $_POST[$campo] : '';

		return $this->modelo->inserir($dados);		
	}

	protected function atualizar ($id)
	{
		$dados;
		
		foreach ($this->campos as $campo => $value)
			$dados[$campo] = isset($_POST[$campo]) ? $_POST[$campo] : '';

		$this->modelo->atualizar($id, $dados);		
	}	
}
?>