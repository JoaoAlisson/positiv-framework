<?php 
namespace Positiv;

class usuarios extends Controle 
{

	public $campos = array('login'     => 'Email',
						   'senha'     => 'Senha',
						   'tipo'      => 'Tipo',
						   'nome'      => 'Nome',
						   'curriculo' => 'curriculo');						   

	function index()
	{
		$tipo = Sessao::pegar('tipo');

		if ($tipo == '0')
			header('location: ' . URL);

		if ($tipo == '2')
			$this->indexDono();

		if ($tipo == '1')
			$this->indexAdm();

		//new Email('j_alisson_bass@hotmail.com', 'Teste de Envio - Gmail', 'Este foi um teste de envio de email');
	}

	private function indexAdm()
	{
		$this->visao = 'editar';
		$this->editar();
	}

	function cadastrar()
	{
		$tipo = Sessao::pegar('tipo');
		if ($tipo != '2')
			header('location: ' . URL);
		else {
			array_push($this->modelo->obrigatorios, 'nome');
			$this->modelo->tipos['login'] = 'email';
			if(isset($_POST['nome']))
				$this->modelo->cadastrarUsuario();
		
		}

	}

	function editar()
	{
		$tipo = Sessao::pegar('tipo');
		if ($tipo == '0')
			header('location: ' . URL);
		else {

			$id = Sessao::pegar('id');

			$this->modelo->obrigatorios = array('nome');
			$this->modelo->tipos['senha'] = 'senhaNova';
 			$this->campos['senha'] = 'Nova Senha';

			if(isset($_POST['nome'])) {
				$campos['nome'] = $_POST['nome'];
				if($_POST['senha'] != '')
					$campos['senha'] = $_POST['senha'];

				$this->modelo->atualizar($id, $campos);
			}
			$this->dados['usuario'] = $this->modelo->pesquisarId($id, array('nome'));
		}
	}

	private function indexDono()
	{	
		$campos = array('nome', 'login', 'id', 'tipo');

		if(isset($_POST['usuario_deletar']))
			$this->modelo->deletar($_POST['usuario_deletar']);

		$this->dados['usuarios'] = $this->modelo->pegarUsuarios();
	} 
}
?>