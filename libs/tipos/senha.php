<?php
namespace libs\tipos;

class senha extends Tipos
{

	function campo ($icone = 'lock', $id = '', $complemento = '', $classe = '')
	{	
		$html  = "<div class='ui corner labeled left icon input'>";
		$html .= "<input type='password' $complemento class='camposInput $classe' value='" . $this->trata_valor_para_input() . "' id='input_$id' name='$id' />";
		$html .= "<i class='lock icon'></i>";
		if($this->obrigatorio)
			$html .= "<div class='ui corner label'><i class='icon asterisk'></i></div>";
		$html .= "</div>";	

		return $html;
	}
		
	private function criptografa ($senha)
	{
		return \Positiv\Hash::criar($senha, CHAVE);
	}

	function trata_valor_para_salvar ()
	{
		return $this->criptografa($this->valor);
	}			
}
?>