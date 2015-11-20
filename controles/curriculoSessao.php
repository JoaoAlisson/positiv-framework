<?php
namespace Controles;
class curriculoSessao {

	private $campos;

	function __construct(&$campos)
	{	
		$this->campos = $campos;
	}

	function addSessaoEditar($curriculo)
	{	
		$campos = $this->campos;
		
		foreach ($campos as $campo => $texto)
			if($campo != 'foto')
				Sessao::inserir($campo, $curriculo[$campo]);
		
	}

	function salvarSessao()
	{
		$campos = $this->campos;

		foreach ($campos as $campo => $texto) {
			$valor = isset($_POST[$campo]) ? $_POST[$campo] : '';
			if($campo != 'foto')
				if(isset($_POST[$campo]))
					\Positiv\Sessao::inserir($campo, $valor);
		}

		$this->foto();
	} 

	function preparaPostEditar()
	{
		$campos = $this->campos;

		foreach ($campos as $campo => $texto)
			if(!isset($_POST[$campo]))
				if($this->campoCheckBox($campo))
					$_POST[$campo] = \Positiv\Sessao::pegar($campo);


		//print_r($_POST);
		//exit();

		if($_POST['passo'] == 2)
			if($_POST['interNivel1'] == 'Primeiro Emprego')
				$this->trataPostPrimeiroEmprego();
	}

	private function trataPostPrimeiroEmprego()
	{
		$array = array('expNivel1', 'expSegmento1', 'expNomeDaEmpresa', 'expCargo', 'expInicio1', 'expFim1', 'expUltimoSalarioInt', 'expAtribuicoes',
					   'expNivel2', 'expSegmento2', 'expNomeDaEmpresa2', 'expCargo2', 'expInicio2', 'expFim2', 'expUltimoSalarioInt2', 'expAtribuicoes2',
					   'expNivel3', 'expSegmento3', 'expNomeDaEmpresa3', 'expCargo3', 'expInicio3', 'expFim3', 'expUltimoSalarioInt3', 'expAtribuicoes3',
					   'expNivel4', 'expSegmento4', 'expNomeDaEmpresa4', 'expCargo4', 'expInicio4', 'expFim4', 'expUltimoSalarioInt4', 'expAtribuicoes4',
					   'expNivel5', 'expSegmento5', 'expNomeDaEmpresa5', 'expCargo5', 'expInicio5', 'expFim5', 'expUltimoSalarioInt5', 'expAtribuicoes5', 'expInformacoes');

		foreach ($array as $campo)
			$_POST[$campo] = '';
	}

	private function campoCheckBox($campo)
	{
		$array = array('idiomaIngles', 'idiomaEspanhol', 'idiomaFrances', 'idiomaAlemao', 'idiomaItaliano',
					   'infOffice', 'infAplGraficas', 'infDes', 'infManut');

		if(!in_array($campo, $array))
			return true;

		if($_POST['passo'] == 4)
			return false;

		if(Sessao::pegar($campo) != '' && \Positiv\Sessao::pegar($campo) != '0')
			return true;

		return false;
	}

	function preparaPost()
	{
		$campos = $this->campos;

		foreach ($campos as $campo => $texto)
			if(!isset($_POST[$campo]))
				$_POST[$campo] = \Positiv\Sessao::pegar($campo);

		$foto = Sessao::pegar('foto');
		if($foto != '')
			$this->fotoParaTemp($foto);

	}

	private function fotoParaTemp($foto)
	{	
		$foto = 'sess_' . $foto;
		$tmp = ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir();

		rename(session_save_path() . SEPARADOR . $foto, $tmp . SEPARADOR . $foto);

		$_FILES['foto']['name']     = $foto;
		$_FILES['foto']['size']	    = Sessao::pegar('foto_tamanho');
		$_FILES['foto']['tmp_name'] = $tmp . SEPARADOR . $foto;
		$_FILES['foto']['type']     = ' image/jpeg';

	}

	private function foto()
	{
		$nome = $_FILES['foto']['name'];

		if($nome != '')
			if($this->valida($nome))
				$this->salvaImagem($nome);
	}

	private function salvaImagem($nome)
	{	

		$this->deletaAnterior();

		$novoNome = $this->novoNome($nome);
		$this->upload($novoNome);

		\Positiv\Sessao::inserir('foto', $novoNome);
		\Positiv\Sessao::inserir('foto_tamanho', $_FILES['foto']['size']);

	}

	private function deletaAnterior()
	{
		$anterior = \Positiv\Sessao::pegar('foto');

		if($anterior != '')
			$this->deletarFoto();
	}

	private function deletarFoto()
	{
		$caminho = session_save_path() . SEPARADOR . 'sess_' . \Positiv\Sessao::pegar('foto');
		if(file_exists($caminho))
			unlink($caminho);
	}

	private function valida($nome)
	{
		$extensao = $this->pegaExtensao($nome);
		$extensao = strtolower($extensao);

		if($extensao == 'jpg' || $extensao == 'png' || $extensao == 'jpeg' || $extensao == 'gif')
			$extensao = true;
		else
			$extensao = false;

		$tamanho = $_FILES['foto']['size'];

		$tamanho = ($tamanho <= 2000000) ? true : false;


		if($extensao && $tamanho)
			return true;
		else
			return false;
	}

	private function novoNome ($nome)
	{
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

	private function upload($novoNome)
	{	
		$caminho = session_save_path() . SEPARADOR . 'sess_' . $novoNome;
		move_uploaded_file($_FILES['foto']['tmp_name'], $caminho);		
	}
}
?>