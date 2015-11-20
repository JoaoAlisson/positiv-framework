<?php
namespace libs\tipos;

class chaveEstrangeira2 extends select
{	
	public  $tabela;
	public  $campo   = 'nome';
	private $conexao = null;

	private function pegarConexao ()
	{
		if ($this->conexao == null)
			$this->conexao = $this->criaConexao();

		return $this->conexao;
	}

	private function criaConexao ()
	{
		return new \Positiv\Pdo();
	}

	protected function buscaValores ()
	{	
		$sql = 'SELECT id, ' . $this->campo . ' FROM ' . $this->tabela;

		$valores = $this->query($sql);	

		$this->valores['Primeiro Emprego'] = 'Primeiro Emprego';
		foreach ($valores as $campos) 
			$this->valores[$campos['id']] = $campos[$this->campo];

	}

	private function query ($sql)
	{
		$pdo   = $this->pegarConexao();
		$query = $pdo->prepare($sql);
		$query->execute();

		return $query->fetchAll(\PDO::FETCH_ASSOC);	
	}

	function trata_valor_para_mostrar ()
	{
		$id = $this->valor;
		$sql = 'SELECT ' . $this->campo . ' FROM ' . $this->tabela . ' WHERE id = ' . $id;

		$valor = $this->query($sql);
		return $valor[0][$this->campo];

	}	

	function campo ($icone = 'pencil', $id = '', $complemento = '')
	{	
		$this->buscaValores();
		return parent::campo($icone, $id, $complemento);
	}

}
?>