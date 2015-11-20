<?php 
namespace Positiv;

class login extends Controle 
{

	public $campos = array('login' => 'Login',
						   'senha' => 'Senha');

	public function index() {

		if(isset($_POST['login'])){

			$usuario = $this->pegarUsuario();

			if(!empty($usuario))
				if($_POST['login'] == $usuario['login'] && $this->criptografa($_POST['senha']) == $usuario['senha']) {
					
					Sessao::iniciar();
					Sessao::inserir('logado', true);
					Sessao::inserir('usuario', $usuario['nome']);
					Sessao::inserir('id', $usuario['id']);
					Sessao::inserir('tipo', $usuario['tipo']);
					Sessao::inserir('curriculo', $usuario['curriculo']);
					Sessao::inserir('email', $usuario['login']);

					header('location: ' . URL);

				}
		}
		
	}

	private function pegarUsuario ()
	{
		return $this->modelo->pegarUsuario($_POST['login'], $_POST['senha']);
	}

	private function criptografa ($string)
	{	
		return Hash::criar($string, CHAVE);
	}

	public function deslogar(){
		Sessao::destruir();
		header('location: ' . URL);
	}

	public function esqueciasenha()
	{
		$this->renderizar = false;

		$this->dados['resposta'] = 0;
		if(isset($_POST['entrar'])) {
			$email = isset($_POST['login']) ? $_POST['login'] : '';
			$email = ($email == 'E-mail...') ? '' : $email;
			if($email != '')
				if($this->modelo->ferificaExisteEmail($email)) {
					$this->mandarLinkEditarSenha($email);
					$this->dados['resposta'] = 3;
				} else
					$this->dados['resposta'] = 1;
		}
	}

	private function mandarLinkEditarSenha($email) {
		$id    = $this->modelo->pegarIdEmail($email);
		list($id, $token) = $this->modelo->gerarToken($id);
		$link  = URL . "login/mudarsenha/us:$id/token:$token";

		$this->mandarEmail($email, $link);
	}

	private function mandarEmail($email, $link)
	{
		$texto  = '<h2>Esqueceu sua senha?</h2>';
		$texto .= '<h3>Para alterá-la click no link abaixo:</h3>';
		$texto .= "<a href='$link'>$link</a>";

		new Email($email, 'Lucrativia - Alteração de Senha', $texto);
	}

	function mudarsenha()
	{
		$this->renderizar = false;
		$this->dados['resposta'] = 0;

		if(!$this->verificaToken()) {
			header('location: ' . URL);
			exit();
		}

		$this->dados['email'] = $this->modelo->pegarEmailIdToken($_GET['us']);

		$this->dados['erros'] = '';
		if(isset($_POST['entrar'])) {		

			$this->dados['erros'] = $this->validarSenhas();
			if($this->dados['erros'] == '') {
				$this->modelo->alterarSenha($_GET['us'], $_POST['senha']);
				$this->dados['resposta'] = 3;
			}
		}
	}

	private function validarSenhas()
	{
		$retorna = '';
		$senha1 = isset($_POST['senha'])  ? $_POST['senha']  : '';
		$senha2 = isset($_POST['senha2']) ? $_POST['senha2'] : '';

		if($senha1 == '*********' || $senha2 == '*********')
			return 'Informe a senha nos dois campos.';

		if($senha1 == '' || $senha2 == '')
			return 'Informe a senha nos dois campos.';

		if($senha1 != $senha2)
			return 'As senhas informadas não conferem';

		if(strlen($senha1) < 4)
			return 'A senha deve ter mais de 4 ou mais caracteres';

	}

	private function verificaToken()
	{
		$idT   = isset($_GET['us'])    ? $_GET['us'] : '';
		$token = isset($_GET['token']) ? $_GET['token'] : '';

		if($idT == '' || $token == '')
			return false;

		return $this->modelo->verificarIdToken($idT, $token);
	}
}
?>