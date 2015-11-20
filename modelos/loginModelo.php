<?php
namespace Positiv;

class loginModelo extends Modelo
{	
	public $tipos = array('login' => 'login',
						  'senha' => 'senha');

	public $obrigatorios = array('login', 'senha');

	private $email = '';

	function pegarUsuario($login, $senha)
	{	
		$senha = \Positiv\Hash::criar($senha, CHAVE);
		$dados = array('login' => $login);
		$dados = $this->limpaSql($dados);

		$sql = 'SELECT id, login, senha, nome, tipo, curriculo FROM usuarios WHERE login = \'' . $dados['login'] . '\' AND senha = \''. $senha .'\'';
		$dados = $this->query($sql);

		$dados = $dados->fetchAll(\PDO::FETCH_ASSOC);

		if(empty($dados))
			return array();
		else {
			if($login == $dados[0]['login'] && $senha == $dados[0]['senha'])
				return $dados[0];
			else
				return array();
		} 
	}

	function ferificaExisteEmail($email)
	{
		$email = $this->pegarEmailLimpo($email);
		$onde = "login = '$email'";

		$qtd = $this->conta($onde, 'usuarios');
		
		if($qtd == 1)
			return true;
		else
			return false;			
	}

	function pegarEmailLimpo($email)
	{
		if($this->email == '')
			$this->email = $this->limpaSql($email);

		return $this->email;
	}


	function pegarIdEmail($email)
	{
		$email = $this->pegarEmailLimpo($email);

		$sql = "SELECT id FROM usuarios WHERE login = '$email'";

		$dados = $this->query($sql);
		$dados = $dados->fetchAll(\PDO::FETCH_ASSOC);		

		return $dados[0]['id'];
	}

	function gerarToken($id)
	{
		
		$token = $this->token();
		$this->deletaAntigosTokens($id);
		$this->cadastrarToken($id, $token);
		$id = $this->ultimoId();

		return array($id, $token);

	}

	private function token()
	{
		$string = 'abcdefghijlmnopqrstuvxz';
		$string .= strtoupper($string) . '0123456789';

		$tamanho = strlen($string);

		$palavra = '';
		for($i = 0; $i <= 10; $i++)
			$palavra[$i] = $string[rand(0, $tamanho - 1)];

		$palavra = implode('', $palavra);

		return Hash::criar($palavra, 'tokensenha');
	}

	private function cadastrarToken($id, $token)
	{	
		$data = date('Y-m-d G:i:s');
		$sql = "INSERT INTO alterarsenha VALUES ('', '$id', '$token', '$data')";
		$this->query($sql);
	}

	private function deletaAntigosTokens($id)
	{
		$sql = "DELETE FROM alterarsenha WHERE idlogin = '$id'";
		$this->query($sql);

	}

	function verificarIdToken($id, $token)
	{	
		$id  = (int)$id;
		$token = $this->limpaSql($token);

		$onde = "id = '$id' AND token = '$token'";
		
		if($this->conta($onde, 'alterarsenha') == 1)
			return true;
		else 
			return false;
	}

	function pegarEmailIdToken($idToken) {
		$idToken = (int)$idToken;

		$sql = "SELECT `usuarios`.`login` FROM `alterarsenha` LEFT JOIN `usuarios` ON `alterarsenha`.`idlogin` = `usuarios`.`id` WHERE `alterarsenha`.`id` = '$idToken'";

		$dados = $this->query($sql);
		$dados = $dados->fetchAll(\PDO::FETCH_ASSOC);		

		return $dados[0]['login'];		
	}

	function alterarSenha($idToken, $senha) 
	{
		$senha = \Positiv\Hash::criar($senha, CHAVE);
		$id    = $this->pegarIdUsuariosIdToken($idToken);
		$sql = "UPDATE usuarios SET senha = '$senha' WHERE id = '$id'";
		$this->query($sql);

		$this->deletaAntigosTokens($id);
	}

	private function pegarIdUsuariosIdToken($id)
	{
		$id  = (int)$id;
		$sql = "SELECT idlogin FROM alterarsenha WHERE id = '$id'";

		$dados = $this->query($sql);
		$dados = $dados->fetchAll(\PDO::FETCH_ASSOC);		

		return $dados[0]['idlogin'];			 
	}
}
?>