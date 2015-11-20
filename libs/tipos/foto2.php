<?php
namespace libs\tipos;

class foto2 extends foto
{
	function campo ($icone, $id = '')
	{	
		$html = '';		
		
		if($this->valor != null && $this->valor != '')
			$html = $this->mostraImagem($this->valor);

		$this->campoNome = $id;
		$html .= "<div class='ui corner labeled left icon input'>";
		$html .= "<input type='file' name='$id' id='input_$id' value='" . $this->trata_valor_para_input() . "' class='imagem camposInput' />";	
		$html .= "<i class='photo icon'></i>";	
		if($this->obrigatorio)
			$html .= "<div class='ui corner label'><i class='icon asterisk'></i></div>";
		$html .= '</div>';

		return $html;
	}	

	function mostraImagem($valor)
	{
		return "<div class='ui left corner rounded image' style='float:left; margin-right:10px;'><img style='max-height:115px;' src='" . URL . "public/imagens/$valor'></div><br><div class='ui checkbox' onclick=\"moduloClick();\"> <input name='patrimonio' class='modulos' type='checkbox'> <label><i class='suitcase icon'></i><strong>Patrimônio</strong></label> </div>";
	}
}
?>