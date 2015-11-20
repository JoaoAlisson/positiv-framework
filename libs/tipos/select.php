<?php
namespace libs\tipos;

class select extends Tipos
{

	protected $valores = array();

	function setaValores ($valores)
	{
		$this->valores = $valores;
	}

	function trata_valor_para_mostrar ()
	{
		return $this->valores[$this->valor];
	}	


	function campo ($icone = 'pencil', $id = '', $complemento = '')
	{	

		$selecionado = '&nbsp;'; 
		$value = '';

		$opcoes = '';
		$valor = '';
		foreach ($this->valores as $valor => $campo){
			$opcoes .= "<div class='item' data-value='$valor'>$campo</div>";
			if($valor == $this->valor){
				$value = "value='$valor'";
				$selecionado = $campo;
			}
		}

		$html  = "<div class='ui corner labeled left  icon input'>";
		$html .= " <div class='ui search dropdown selection' id='select_$id' onkeypress='enterSubmit(event)';>
				      <input type='hidden' name='$id' $value id='input_$id' $complemento style='min-width: 100px;'>
				      <i class='triangle down icon disabled'></i>
				      <div class='text' data-value='$valor'>$selecionado</div>
				      <div class='menu' id='valores_$id'>
				      <div class='item' data-value=''></div>
				      	$opcoes	
				   </div>";

		if($this->obrigatorio)
			$html .= "<div class='ui corner label'><i class='icon asterisk'></i></div>";
		
		$html .= "</div></div>";

		return $html;

	}		
}
?>