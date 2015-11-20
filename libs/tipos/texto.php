<?php
namespace libs\tipos;

class texto extends Tipos
{

	function campo ($icone = 'pencil', $id = '', $complemento = '', $classe = '')
	{	
		$html  = "<div class='ui corner labeled left icon input'>";
		//$html .= "<input type='text' $complemento class='camposInput $classe' value='" . $this->trata_valor_para_input() . "' id='input_$id' name='$id' />";
		$html .= "<textarea type='text' $complemento class='textoLongo camposInput $classe' id='input_$id' name='$id'>" . $this->trata_valor_para_input() . "</textarea>";
		$html .= "<i class='$icone icon'></i>";
		if($this->obrigatorio)
			$html .= "<div class='ui corner label'><i class='icon asterisk'></i></div>";
		$html .= "</div>";	

		return $html;
	}	
}
?>
