<?php
namespace Positiv;

class Bootstrap
{	
	function __construct ()
	{	
		$this->trataUrl();

		if (!$this->verificaLogado() && !$this->paginasPublicas())
			$this->carregaLogin();
		
		$this->validaControle();
		$this->montaApp();
	}

	private function verificaLogado ()
	{	
		Sessao::iniciar();
		
		return Sessao::pegar('logado');
	}

	private function paginasPublicas ()
	{
		if($this->controle == 'comofunciona')
			return true;

		if($this->controle == 'curriculos' && $this->visao == 'cadastrar')
			return true;

		if($this->controle == 'cidades' && $this->visao == 'pegarCidades')
			return true;		

		if($this->controle == 'curriculos' && $this->visao == 'verificaCpf')
			return true;

		if($this->controle == 'curriculos' && $this->visao == 'verificaEmail')
			return true;

		if($this->controle == 'login' && ($this->visao == 'esqueciasenha' || $this->visao == 'mudarsenha'))
			return true;		

		return false;
	}

	private function carregaLogin ()
	{	
		$login  = RAIZ . SEPARADOR . 'controles' . SEPARADOR . 'loginControle.php';

		require $login;

		$login = new \Positiv\login;

		$this->controle = 'login';
		$login->modelo = $this->pegaModelo();
		
		$login->index();

		$HTML = $this->setaHTML($login);

		require RAIZ . SEPARADOR . 'visoes' . SEPARADOR . 'login' . SEPARADOR . 'index.phtml';

		exit();
	}

	private function trataUrl ()
	{	
		$url = isset($_GET['url']) ? $_GET['url'] : null;
		$url = rtrim($url, '/');
		$url = explode('/', $url);	
		
		$this->controle = ($url[0] != '') ? $url[0] : 'index';
		$this->visao    = isset($url[1])  ? $url[1] : 'index';

		define('CONTROLE', $this->controle);
		define('VISAO',    $this->visao);

		if (isset($url[2]))
			$this->geraGets($url);
	}

	private function geraGets ($url)
	{
		unset($url[0], $url[1]);

		$_GET = array();

		foreach ($url as $campo) {
			$campo = explode(':', $campo);
			$_GET[$campo[0]] = $campo[1];
		}
	}

	private function validaControle ()
	{
		$controle = $this->controle;
		$file = RAIZ . SEPARADOR . 'controles' . SEPARADOR . $controle .'Controle.php';
		if(file_exists($file))
			require $file;
		else {
			$this->controle = 'erro';
			$this->visao    = 'index';
			require RAIZ . SEPARADOR . 'controles' . SEPARADOR .'erroControle.php';
		}
	}

	private function montaApp ()
	{	
		$controle   = 'Positiv\\' . $this->controle;
		$controle   = new $controle();
		$visaoClass = new Visao();

		$visao = $this->visao;
		if (method_exists($controle, $visao)) {
			$controle->visao = $visao;
			$controle->modelo = $this->pegaModelo();
			$controle->$visao();
			$HTML = $this->setaHTML($controle);
			$renderizar = isset($controle->renderizar) ? $controle->renderizar : true;
			$visaoClass->renderizar($this->controle, $controle->visao, $HTML, $controle->dados, $renderizar);
		}
		else
			$visaoClass->renderizar('erro', 'index', array());

	}

	private function pegaModelo ()
	{	
		$modeloClass = null;
		$modelo = RAIZ . SEPARADOR . 'modelos' . SEPARADOR . $this->controle .'Modelo.php';
		if (file_exists($modelo)) {
			require $modelo;
			$modeloClass = 'Positiv\\' . $this->controle . 'Modelo';
			$modeloClass = new $modeloClass();
		}
		
		return $modeloClass;		
	}

	private function setaHTML(&$controle) 
	{
		$nomesCampos      = $controle->campos;
		$tiposCampos      = ($controle->modelo != null) ? $controle->modelo->tipos            : array();
		$obrigatorios     = ($controle->modelo != null) ? $controle->modelo->obrigatorios     : array();
		$errosDeValidacao = ($controle->modelo != null) ? $controle->modelo->errosDeValidacao : array();

		return new HTML($nomesCampos, $tiposCampos, $obrigatorios, $errosDeValidacao);
	}
}
?>