<?php
namespace Positiv;

Class Pdo extends \PDO
{

	private $conectado = false;

	function __construct()
	{

	}

	private function conecta ()
	{
		if(!$this->conectado)
		{
			parent::__construct(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
			$this->conectado = true;
		}
	}

	function atualizar($id, $dados, $tabela)
	{
		$campos = '';
		foreach ($dados as $campo => $valor)
			$campos .= ($campos == '') ? "$campo = :$campo" : ", $campo = :$campo";

		$id = (int)$id;
		$sql = "UPDATE $tabela SET $campos WHERE id = $id";
		$stmt = $this->prepare($sql);
		$this->valoresPdo($dados, $stmt);
		$stmt->execute();	
	}

	function valoresPdo($valores, &$stmt)
	{
		foreach ($valores as $campo => $valor)
			$stmt->bindValue(":$campo", $valor);

	}	

	function prepare ($sql)
	{
		$this->conecta();
		return parent::prepare($sql);
	}	

	function query ($sql)
	{
		$this->conecta();
		return parent::query($sql);
	}

	function queryArray ($sql)
	{	
		$query = $this->query($sql);
		return $query->fetchAll(\PDO::FETCH_ASSOC);
	}

	function quote($string)
	{
		$this->conecta();
		return parent::quote($string);
	}

	function ultimoId ()
	{
		return $this->lastInsertId();
	}	



}
?>