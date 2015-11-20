<?php
namespace libs\tipos;

class foto extends Tipos
{
	private $tamanhoImagem = 7000000;

	function campo2 ($icone, $id = '')
	{	
		$this->campoNome = $id;
		$html  = "<div class='ui corner labeled left icon input'>";
		$html .= "<input type='file' name='$id' id='input_$id' value='" . $this->trata_valor_para_input() . "' class='imagem camposInput' />";	
		$html .= "<i class='photo icon'></i>";	
		if($this->obrigatorio)
			$html .= "<div class='ui corner label'><i class='icon asterisk'></i></div>";
		$html .= '</div>';

		return $html;
	}

	function trata_valor_para_mostrar()
	{
		return $this->mostraImagem($this->valor);
	}

	function campo ($icone = '', $id = '', $complemento = '', $classe = '')
	{	
		$html = '';		
		
		if($this->valor != null && $this->valor != '')
			$html = $this->mostraImagem($this->valor, $id);

		$this->campoNome = $id;
		$html .= "<div class='ui corner labeled left icon input'>";
		$html .= "<input type='file' name='$id' id='input_$id' value='" . $this->trata_valor_para_input() . "' class='imagem camposInput' />";	
		$html .= "<i class='photo icon'></i>";	
		if($this->obrigatorio)
			$html .= "<div class='ui corner label'><i class='icon asterisk'></i></div>";
		$html .= '</div>';

		return $html;
	}	

	function mostraImagem($valor, $id = '')
	{	
		//$id = ($id != '') ? "<script type='text/javascript'>$(document).ready(function(){ $('.ui.checkbox').checkbox(); });</script><br><div class='ui checkbox' onclick=\"moduloClick();\"><input name='del_$id' class='modulos' type='checkbox'> <label><i class='trash icon'></i><strong>Excluir</strong></label> </div>" : '';
		//return "<div class='ui left corner rounded image' style='float:left; margin-right:10px;'><img style='max-height:115px;' src='" . URL . "public/imagens/$valor'></div>$id";
		return $valor;
	}

	function pegaExtensao($nomeImagem){
		$info = new \SplFileInfo($nomeImagem);
		return strtolower($info->getExtension());
	}

	private	function ehImagem(){

		$extensao = $this->pegaExtensao($_FILES[$this->campoNome]['name']);
		
		if($extensao == 'jpg' || $extensao == 'jpeg' || $extensao == 'png' || $extensao == 'gif')
			return true;
		
		return false;
	}	

	private function validaTamanho ()
	{
		if ($_FILES[$this->campoNome]['size'] >= $this->tamanhoImagem)
			return false;
	
		return true;
	}

	private function problemaEnvio ()
	{
		if ($_FILES[$this->campoNome]['error'] != 0 || 
			$_FILES[$this->campoNome]['size'] == 0  ||
			$_FILES[$this->campoNome]['size'] == '')
			return true;

		return false;
	}

	function validacao(){

		if ($_FILES[$this->campoNome]['name'] == '')
			return true;

		if (!$this->ehImagem()) {
			array_push($this->errosValidacao, 'O arquivo selecionado não é uma imagem!');
			return false;
		}
		
		if (!$this->validaTamanho()) {
			array_push($this->errosValidacao, 'A imagem deve ter no máximo 1 mega!');
			return false;
		}

		if ($this->problemaEnvio()) {
			array_push($this->errosValidacao, 'Houve um problema no envio da imagem, tende novamente.');
			return false;
		}		

		return true;
	}	
}
?>