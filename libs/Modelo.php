<?php
namespace Positiv;

class Modelo
{
	public $tipos 		     = array();
	public $obrigatorios     = array();
	public $errosDeValidacao = array();

	function __construct()
	{
		$this->pdo = new Pdo();
	}

	protected function nomeClasse ()
	{
		$array  = explode('\\', get_class($this));
		$classe = array_pop($array);

		return str_replace('Modelo', '', $classe);
	}

	function deletar ($id, $tabela = null)
	{	
		$id = (int)$id;
		$this->deletarOnde('id', $id, $tabela);
	}

	function deletarOnde ($campo, $valor, $tabela = null)
	{
		$this->antesDeletar($valor);

		$tabela = $tabela ? $tabela : $this->nomeClasse();

		$sql = "DELETE FROM $tabela WHERE $campo = :valor";
	
		$stmt = $this->pdo->prepare($sql);

		$stmt->bindParam(':valor', $valor);

		$stmt->execute();

		$this->depoisDeletar($valor);
	} 

	function pesquisar ($onde, $campos, $tabela = null)
	{	
		$campos = $this->camposQuery($campos);

		$tabela = $tabela ? $tabela : $this->nomeClasse();

		$ondeStr = '';
		foreach ($onde as $campo => $valor)
			$ondeStr .= ($ondeStr == '') ? "$campo = "   . $this->pdo->quote($valor) 
										 : " AND $campo = " . $this->pdo->quote($valor);

		$where = ($ondeStr != '') ? "WHERE $ondeStr" : '';

		$sql = "SELECT $campos FROM $tabela $where";

		return $this->queryArray($sql);
	}

	function pesquisarId ($id, $campos, $tabela = null, $formatado = true)
	{		
		$id = (int)$id;

		$resultado = $this->pesquisar(array('id' => $id), $campos, $tabela);

		if(empty($resultado))
			return '';

		if($formatado)
			$resultado[0] = $this->formarCampos($resultado[0]);

		return $resultado[0];		
	}

	private function formarCampos($dados)
	{	
		$retorna;

		foreach ($dados as $campo => $valor) {

			$campoClass = $this->pegaTipo($campo);

			$campoClass->setaCampoNome($campo);

			$campoClass->setaValor($valor);

			$retorna[$campo] = $campoClass->trata_valor_para_mostrar();
		}

		return $retorna;
	}

	function inserir ($valores)
	{	
		$this->validaDados($valores);

		if (empty($this->errosDeValidacao)) {

			$this->antesSalvar($valores);

			new uploadImagens($this->tipos, $valores);

			$tabela     = $this->nomeClasse();

			$campos     = $this->camposQuery(array_keys($valores));

			$valoresStr = $this->valoresQuery($valores);

			$sql = "INSERT INTO $tabela ($campos) VALUES ($valoresStr)";

			$stmt = $this->pdo->prepare($sql);

			$this->valoresPdo($valores, $stmt);

			$stmt->execute();

			$this->depoisSalvar($valores);

		}

		return $this->errosDeValidacao;
	}

	private function valoresQuery($valores)
	{
		$string = '';
		foreach ($valores as $campo => $valor)
			$string .= ($string != '') ? ", :$campo" : ":$campo";
		
		return $string;
	}

	private function valoresPdo($valores, &$stmt)
	{
		$this->pdo->valoresPdo($valores, $stmt);

	}

	function atualizar ($id, $dados, $tabela = null, $evitarLoop = false, $uploadImagens = true)
	{	

		$this->validaDados($dados);

		if (empty($this->errosDeValidacao)) {		
			$id = (int)$id;

			$this->antesEditar($id);

			if($uploadImagens)
				new uploadImagens($this->tipos, $dados, true, $this, $id);

			$tabela = $tabela ? $tabela : $this->nomeClasse();

			$this->pdo->atualizar($id, $dados, $tabela);	 

			$this->depoisEditar($id);
		}
		else
			return $this->errosDeValidacao;
	}

	function atualizar2 ($id, $dados, $tabela = null)
	{	
		$tabela = $tabela ? $tabela : $this->nomeClasse();

		$this->pdo->atualizar($id, $dados, $tabela);
			
	}


	protected function query ($sql) 
	{	
		return $this->pdo->query($sql);	
	}

	protected function queryArray ($sql)
	{
		return $this->pdo->queryArray($sql);	
	}

	protected function validaDados (&$valores)
	{	
		foreach ($valores as $campo => $valor) {

			$campoClass = $this->pegaTipo($campo);

			$campoClass->setaCampoNome($campo);

			$campoClass->setaValor($valor);

			$obrigatorio = in_array($campo, $this->obrigatorios);

			$campoClass->setaObrigatorio($obrigatorio);

			$errosDoCampo = $campoClass->pegaErrosValidacoes();

			$valores[$campo] = $campoClass->trata_valor_para_salvar();

			if (!empty($errosDoCampo))
				$this->errosDeValidacao[$campo] = $errosDoCampo;
		}
	}

	function ultimoId ()
	{	
		return $this->pdo->ultimoId();
	}	

	private function camposQuery($campos)
	{
		if(!is_array($campos))
			return (String)$campos;

		$retorna = '';

		foreach ($campos as $campo)
			$retorna .= ($retorna != '') ? ", $campo" : $campo;

		return $retorna;
	}

	function todos($campos, $tabela = null)
	{	
		if(!$tabela)
			$tabela = $this->nomeClasse();

		$campos = $this->camposQuery($campos);
	
		$sql = "SELECT $campos FROM $tabela";

		return $this->queryArray($sql);	
	
	}

	private function sqlConta($onde, $tabela)
	{	
		$onde = ($onde != '') ? 'WHERE ' . $onde : '';
		return "SELECT COUNT(*) as quantidade FROM $tabela $onde";
	}

	function conta($onde = '', $tabela = null)
	{	
		$tabela = $tabela ? $tabela : $this->nomeClasse();
		$sql = $this->sqlConta($onde, $tabela);
		$quantidade = $this->queryArray($sql);

		return $quantidade[0]['quantidade'];
	}

	function limpaSql ($valor) 
	{	
		$retorna;
		mysql_connect(DB_HOST, DB_USER, DB_PASS);

		if (is_array($valor))
			foreach ($valor as $key => $value)
				$retorna[$key] = mysql_real_escape_string($value);
		else
			$retorna = mysql_real_escape_string($valor);

		return $retorna;
			
	}

	private function pegaTipo ($campo)
	{	
		$tipoFabrica = new TipoFabrica();

		$tipo = $this->tipos[$campo];	

		return $tipoFabrica->pegaTipo($tipo);
	}	

	protected function antesSalvar ($valores)
	{

	}

	protected function depoisSalvar ($valores)
	{
		
	}

	protected function antesDeletar ($valor)
	{

	}

	protected function depoisDeletar ($valor)
	{

	}

	protected function antesEditar ($id)
	{

	}
	
	protected function depoisEditar ($id)
	{

	}
}
?>