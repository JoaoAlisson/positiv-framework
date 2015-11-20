<?php
namespace libs\tipos;

class senhaAntiga extends senha
{

	private $conexao = null;

	private function pegarConexao ()
	{
		if ($this->conexao == null)
			$this->conexao = $this->criaConexao();

		return $this->conexao;
	}

	private function criaConexao ()
	{
		\TTransaction::open();
		return \TTransaction::get();
	}

	private function query ($sql)
	{
		$pdo   = $this->pegarConexao();
		$query = $pdo->prepare($sql);
		$query->execute();

		return $query->fetchAll(\PDO::FETCH_ASSOC);	
	}

	private function pegarSenhaAntiga ()
	{
		$sql = 'SELECT senha FROM usuario WHERE id = 1';
		$senha = $this->query($sql);

		return $senha[0]['senha'];
	}	

	function validacao ()
	{
		$senhaInformada = $this->criptografa($_POST['senha']);
		$senhaAntiga    = $this->pegarSenhaAntiga();

		if ($senhaInformada != $senhaAntiga) {
			array_push($this->errosValidacao, 'Senha errada.');
			return false;
		}

		return true;
	}

	private function criptografa ($senha)
	{
		return \Positiv\Hash::criar($senha, CHAVE);
	}

	function trata_valor_para_salvar ()
	{
		return $this->criptografa($_POST['nova1']);
	}	
}
?>