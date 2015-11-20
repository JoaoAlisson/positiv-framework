<?php
namespace Positiv;

class uploadImagens
{
	private $campos;
	private $valores;
	private $pasta;

	function __construct (&$campos, &$valores, $atualizar = false, &$modelo = null, $id = null)
	{	

		$this->campos  = $campos;
		$this->valores = &$valores;
		//$this->pasta   = RAIZ . SEPARADOR . 'public' . SEPARADOR . 'imagens' . SEPARADOR;
		$this->pasta = PASTA_IMAGENS;

		$this->separaCamposImagens();

		if($atualizar)
			$this->deletarImagensAntigas($id, $modelo);

		$this->upload();
	}	

	private function deletarImagensAntigas($id, $modelo)
	{	
		if(!empty($this->campos)) {
			$imagens = $modelo->pesquisarId($id, array_keys($this->campos));
			$this->deletarImagens(array_values($imagens));
		}
	}

	private function deletarImagens($imagens)
	{
		foreach ($imagens as $imagem)
			$this->deletarImagem($imagem);
	}

	private function separaCamposImagens ()
	{
		foreach ($this->campos as $campo => $tipo)
			$this->verificaCampo($campo);

	}

	private function verificaCampo ($campo)
	{
		if ($this->campos[$campo] != 'foto')
			unset($this->campos[$campo]);
		else
			$this->enviado($campo);
	}

	private function enviado ($campo)
	{
		if ($_FILES[$campo]['name'] == '') {
			unset($this->campos[$campo]);
			unset($this->valores[$campo]);
		}
	}

	private function upload ()
	{
		foreach ($this->campos as $campo => $tipo)
			$this->uploadImagem($campo);
	}

	private function uploadImagem ($campo)
	{	
		$nome = $this->novoNome($campo);
		$this->valores[$campo] = $nome;
		$_POST[$campo] = $nome;
		$this->salvaImagem($campo, $nome);
	}

	private function novoNome ($campo)
	{
		$nome = $_FILES[$campo]['name'];
		return $this->nomeImagem() . '.' . $this->pegaExtensao($nome);		
	}

	private function pegaExtensao($nomeImagem){
		$info = new \SplFileInfo($nomeImagem);
		return strtolower($info->getExtension());
	}

	private function nomeImagem ()
	{
		$nome = microtime();
		return str_replace(array('.', ' '), '-', $nome);
	}

	private function salvaImagem($campo, $novoNome){

        move_uploaded_file($_FILES[$campo]['tmp_name'], PASTA_IMAGENS . $novoNome);

	}

	private function deletarImagem ($imagem)
	{
		$caminho = $this->pasta . $imagem;
		unlink($caminho);
	}	
}
?>