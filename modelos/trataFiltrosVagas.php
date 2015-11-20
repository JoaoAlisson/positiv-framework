<?php
namespace Positiv;

class trataFiltrosVagas 
{	
	public $sql = '';

	function __construct() {

		$textos = array('titulo', 'empresa');

		$this->textos($textos);


		if(isset($_GET['ativa']))
			$_GET['ativa'] = ($_GET['ativa'] == 2) ? '0' : $_GET['ativa'];


		$numeros = array('ativa');

		$this->numeros($numeros);		

		if($this->sql != '')
			$this->sql = 'WHERE ' . $this->sql;

		//echo $this->sql;
	}

	private function textos($campos)
	{
		foreach ($campos as $campo)
			if(isset($_GET[$campo]))
				if($_GET[$campo] != '')
					$this->sql .= ($this->sql == '') ? $this->texto($campo) : ' AND ' . $this->texto($campo);

	}

	private function numeros($campos)
	{
		foreach ($campos as $campo)
			if(isset($_GET[$campo]))
				if($_GET[$campo] != '')
					$this->sql .= ($this->sql == '') ? $this->numero($campo) : ' AND ' . $this->numero($campo);

	}

	private function numero($campo, $tabela = 'vagas')
	{
		return $this->campo($campo, $tabela) . " = '" . $_GET[$campo] . "'";
	}

	private function texto($campo, $tabela = 'vagas')
	{
		return $this->campo($campo, $tabela) . " REGEXP '" .  $this->textoER($_GET[$campo]) . "'";
		//return $this->campo($campo, $tabela) . " REGEXP 'o+[aã]+o'";
	}

	private function campo($campo, $tabela = 'vagas')
	{
		return "`$tabela`.`$campo`";
	}

	private function textoER($texto)
	{	
		$texto = $this->removeAcentos($texto);
		$texto = $this->addMais($texto);
		return str_replace(array('a', 'e', 'i', 'o', 'u', 'c'), 
						   array('[aãâáàäAÃÂÁÀÄ]', '[eéêèëEÉÊẼÈË]', '[iĩîíìïIÎÎÍÌÏ]', '[oõôóòöOÕÔÓÒÖ]', '[uũûúùüUŨÛÚÙÜ]', '[cçCÇ]'),
						   $texto);
	}

	private function addMais($texto)
	{	
		$retorna = '';

		for($i = 0; $i < strlen($texto); $i++)
			$retorna .= ($i + 1 < strlen($texto)) ? $texto[$i] . '+' : $texto[$i];

		return $retorna; 

	}

	private function removeAcentos($string)
	{
	    $string = preg_replace("/[áàâãä]/", "a", $string);
	    $string = preg_replace("/[ÁÀÂÃÄ]/", "A", $string);
	    $string = preg_replace("/[éèê]/", "e", $string);
	    $string = preg_replace("/[ÉÈÊ]/", "E", $string);
	    $string = preg_replace("/[íì]/", "i", $string);
	    $string = preg_replace("/[ÍÌ]/", "I", $string);
	    $string = preg_replace("/[óòôõö]/", "o", $string);
	    $string = preg_replace("/[ÓÒÔÕÖ]/", "O", $string);
	    $string = preg_replace("/[úùü]/", "u", $string);
	    $string = preg_replace("/[ÚÙÜ]/", "U", $string);
	    $string = preg_replace("/ç/", "c", $string);
	    $string = preg_replace("/Ç/", "C", $string);	
	    
	    return $string;	
	}

}
?>