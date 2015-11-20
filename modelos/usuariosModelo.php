<?php
namespace Positiv;

class usuariosModelo extends Modelo
{
	public $tipos = array('login' => 'nome',
						  'senha' => 'senha',
						  'nome'  => 'nome',
						  'tipo'  => 'nome',
						  'curriculo' => 'nome');

	public $obrigatorios = array('login', 'senha');

	private $senha = '';
	private $login = '';


	function atualizar ($id, $dados, $tabela = null, $evitarLoop = false)
	{	

		$this->validaDados($dados);

		if (empty($this->errosDeValidacao)) {		
			$id = (int)$id;

			$this->antesEditar($id);

			$criterio = new \TCriteria;
			$criterio->add(new \TFilter('id', '=', $id));

			$sql = new \TSqlUpdate;

			$tabela = $tabela ? $tabela : $this->nomeClasse();

			$sql->setEntity($tabela);

			unset($dados['nova1']);
			unset($dados['nova2']);

			foreach ($dados as $campo => $valor)
				$sql->setRowData($campo, $valor);

			$sql->setCriteria($criterio);

			$sql = $sql->getInstruction();

			$this->query($sql);	

			$this->depoisEditar($id);
		}
	}

	function pegarUsuarios()
	{
		$sql = "SELECT nome, id, tipo, login FROM usuarios WHERE tipo != 0 ORDER BY id DESC";
		return $this->queryArray($sql);
	}

	function deletar($id)
	{
		$id  = (int)$id;
		$sql = "DELETE FROM usuarios WHERE id = '$id' AND tipo != '2'";

		$this->query($sql);
	}

	function cadastrarUsuario()
	{
		$senha    = $this->senhaAleatoria();
		$nome     = $_POST['nome'];
		$login    = $_POST['login'];

		$this->senha = $senha;
		$this->login = $login;		

		$valores = array('login' => $login, 'nome' => $nome, 'tipo' => 1, 'curriculo' => 0, 'senha' => $senha);
		$this->inserir($valores);
	}

	private function enviarEmail()
	{
		$email = $this->login;
		$senha = $this->senha;

		$texto  = '<h2>Você foi cadastrado no sistema de currículos da Lucrativia</h2>';
		$texto .= "<strong>Login: </strong>$email<br>";
		$texto .= "<strong>Senha: </strong>$senha<br><br>";
		$texto .= '<a href="' . URL . '">' . URL . '</a>';

		new Email($email, 'Lucrativia - Cadastro de Usuário', $texto);
	}

	private function senhaAleatoria()
	{
		$string  = 'abcdefghijlmnopqrstuvxz';
		$string .= strtoupper($string);
		$string .= '0123456789@#%&*-';

		$tamanho = strlen($string);

		$senha = '';
		for($i = 0; $i < 5; $i++)
			$senha .= $string[rand(0, $tamanho - 1)];

		return $senha;
	}

	protected function depoisEditar($id)
	{
		Sessao::inserir('usuario', $_POST['nome']);
	}

	protected function depoisSalvar()
	{	
		$this->enviarEmail();
		header('location: ' . URL . 'usuarios/');
	}
}
?>