<?php
namespace Positiv;

class curriculosModelo extends Modelo
{	
	public $tipos = array('nome' => 'nome',
						  'email' => 'nome',
						  'facebook' => 'nome',
						  'foto' => 'foto',
						  'cpf' => 'nome',
						  'rg' => 'nome',
						  'nomeMae' => 'nome',
						  'dataNascimento' => 'data',
						  'sexo' => 'nome',
						  'estadoCivil' => 'nome',
						  'qtdFilhos' => 'nome',
						  'cep' => 'nome',
						  'endereco' => 'nome',
						  'numero' => 'nome',
						  'complemento' => 'nome',
						  'bairro' => 'nome',
						  'cidade' => 'nome',
						  'estado' => 'nome',
						  'foneCell' => 'nome',
						  'foneFixo' => 'nome',
						  'foneComercial' => 'nome',
						  'empregado' => 'nome',
						  'habilitacao' => 'nome',
						  'categoria' => 'nome',
						  'deficiencia' => 'nome',
						  'descricaoDeficiencia' => 'nome',
						  'cargoInteresse' => 'nome',
						  'interNivel1' => 'nome',
						  'interSegmento1' => 'nome',
						  'interNivel2' => 'nome',
						  'interSegmento2' => 'nome',
						  'interNivel3' => 'nome',
						  'interSegmento3' => 'nome',
						  'pretensaoSalarial' => 'moeda',
						  'expNivel1' => 'nome',
						  'expSegmento1' => 'nome',
						  'expNomeDaEmpresa' => 'nome',
						  'expCargo' => 'nome',
						  'expInicio1' => 'data',
						  'expFim1' => 'data',
						  'expUltimoSalarioInt' => 'moeda',
						  'expAtribuicoes' => 'nome',
						  'expNivel2' => 'nome',
						  'expSegmento2' => 'nome',
						  'expNomeDaEmpresa2' => 'nome',
						  'expCargo2' => 'nome',
						  'expInicio2' => 'data',
						  'expFim2' => 'data',
						  'expUltimoSalarioInt2' => 'moeda',
						  'expAtribuicoes2' => 'nome',
						  'expNivel3' => 'nome',
						  'expSegmento3' => 'nome',
						  'expNomeEmpresa3' => 'nome',
						  'expCargo3' => 'nome',
						  'expInicio3' => 'data',
						  'expFim3' => 'data',
						  'expUltimoSalarioInt3' => 'moeda',
						  'expAtribuicoes3' => 'nome',
						  'expNivel4' => 'nome',
						  'expSegmento4' => 'nome',
						  'expNomeEmpresa4' => 'nome',
						  'expCargo4' => 'nome',
						  'expInicio4' => 'data',
						  'expFim4' => 'data',
						  'expUltimoSalarioInt4' => 'moeda',
						  'expAtribuicoes4' => 'nome',
						  'expNivel5' => 'nome',
						  'expSegmento5' => 'nome',
						  'expNomeEmpresa5' => 'nome',
						  'expCargo5' => 'nome',
						  'expInicio5' => 'data',
						  'expFim5' => 'data',
						  'expUltimoSalarioInt5' => 'moeda',
						  'expAtribuicoes5' => 'nome',
						  'expInformacoes' => 'nome',
						  'escGrau' => 'nome',
						  'escNomeCurso' => 'nome',
						  'escNomeInstituicao' => 'nome',
						  'escDataInicio' => 'data',
						  'escDataConclusao' => 'data',
						  'escAno' => 'nome',
						  'escGrau2' => 'nome',
						  'escNomeCurso2' => 'nome',
						  'escNomeInstituicao2' => 'nome',
						  'escDataInicio2' => 'data',
						  'escDataConclusao2' => 'data',
						  'escAno2' => 'nome',
						  'idiomaIngles' => 'nome',
						  'nivelIdiomaIngles' => 'nome',
						  'idiomaEspanhol' => 'nome',
						  'nivelIdiomaEspanhol' => 'nome',
						  'idiomaFrances' => 'nome',
						  'nivelIdiomaFrances' => 'nome',
						  'idiomaAlemao' => 'nome',
						  'nivelIdiomaAlemao' => 'nome',
						  'idiomaItaliano' => 'nome',
						  'nivelIdiomaItaliano' => 'nome',
						  'infOffice' => 'nome',
						  'nivelInfOffice' => 'nome',
						  'infAplGraficas' => 'nome',
						  'nivelInfAplGraficas' => 'nome',
						  'infDes' => 'nome',
						  'nivelInfDes' => 'nome',
						  'infManut' => 'nome',
						  'nivelInfManut' => 'nome',
						  'acompanhamento' => 'nome',
						  'interno' => 'nome',
						  'dataCadastro' => 'nome',
						  'dataAtualizacao' => 'nome',
						  'areaformacao' => 'nome',
						  'areaformacao2' => 'nome');

	private $relacionamentos = array('estado'         => array('tabela' => 'estados',  'campo' => 'estado'),
									 'cidade'         => array('tabela' => 'cidades',  'campo' => 'cidade'),
									 'cargoInteresse' => array('tabela' => 'cargos',   'campo' => 'cargo'),
									 'interNivel1'    => array('tabela' => 'niveis',   'campo' => 'nivel'),
									 'interNivel2'    => array('tabela' => 'niveis',   'campo' => 'nivel'),
									 'interNivel3'    => array('tabela' => 'niveis',   'campo' => 'nivel'),
									 'expNivel1'      => array('tabela' => 'niveis',   'campo' => 'nivel'),
									 'expNivel2'      => array('tabela' => 'niveis',   'campo' => 'nivel'),
									 'expNivel3'      => array('tabela' => 'niveis',   'campo' => 'nivel'),
									 'expNivel4'      => array('tabela' => 'niveis',   'campo' => 'nivel'),
									 'expNivel5'      => array('tabela' => 'niveis',   'campo' => 'nivel'),
									 'interSegmento1' => array('tabela' => 'segmentos','campo' => 'segmento'),
									 'interSegmento2' => array('tabela' => 'segmentos','campo' => 'segmento'),
									 'interSegmento3' => array('tabela' => 'segmentos','campo' => 'segmento'),
									 'expSegmento1'   => array('tabela' => 'segmentos','campo' => 'segmento'),
									 'expSegmento2'   => array('tabela' => 'segmentos','campo' => 'segmento'),
									 'expSegmento3'   => array('tabela' => 'segmentos','campo' => 'segmento'),
									 'expSegmento4'   => array('tabela' => 'segmentos','campo' => 'segmento'),
									 'expSegmento5'   => array('tabela' => 'segmentos','campo' => 'segmento'),
									 'escGrau'		  => array('tabela' => 'grauformacao', 'campo' => 'grau'),
									 'escGrau2'		  => array('tabela' => 'grauformacao', 'campo' => 'grau'),
									 'areaformacao'	  => array('tabela' => 'areaformacao', 'campo' => 'areaformacao'),
									 'areaformacao2'  => array('tabela' => 'areaformacao', 'campo' => 'areaformacao'));

	//public $obrigatorios = array('login', 'senha');

	private $filtros = '';
	private $quantidade = '';
	private $pagina = array();

	function pegarFiltrado ()
	{	
		$filtros = $this->filtros();
		$pagina = $this->pagina();
		$pagina = $pagina['inicio'] . ', ' . $pagina['quantidade'];
		$ordem  = $this->ordem();

		$join = $this->joinFiltros();
		if(isset($_GET['palavrachave']))
			$join .= ' ' . $this->join();

		$arquivos = '(SELECT COUNT(*) FROM `arquivos` WHERE `arquivos`.`acompanhamento` = `curriculos`.`acompanhamento`) AS `arquivos`';

		$campos = "`curriculos`.`nome`, `curriculos`.`acompanhamento`, `curriculos`.`email`, `curriculos`.`foneCell`, `curriculos`.`dataAtualizacao`, `curriculos`.`id`, `curriculos`.`interno`, $arquivos";
		$sql = "SELECT $campos FROM `curriculos` $join $filtros $ordem LIMIT $pagina";
		
		return $this->queryArray($sql);
	}

	private function joinFiltros()
	{
		$join = '';

		if(isset($_GET['vaga']))
			$join .= 'LEFT JOIN `vaga_curriculos` ON `curriculos`.`id` = `vaga_curriculos`.`curriculo`';
					 // LEFT JOIN `vagas` ON `vaga_curriculos`.`vaga` = `vagas`.`id`';

		return $join; 
	}

	function pegarListaEmails()
	{
		$filtros = $this->filtros();
		$join = $this->joinFiltros();
		if(isset($_GET['palavrachave']))
			$join .= ' ' . $this->join();	

		$sql = "SELECT `curriculos`.`email` FROM `curriculos` $join $filtros";
		$resultado = $this->query($sql);
	
		return $resultado->fetchAll(\PDO::FETCH_ASSOC);				
	}

	function curriculoVagas($id)
	{
		$id = (int)$id;

		$sql = "SELECT `vaga_curriculos`.`id`, `vagas`.`titulo`, `vagas`.`empresa`, `vaga_curriculos`.`externo`, `vagas`.`id` AS `vaga`
				FROM `vaga_curriculos` 
				LEFT JOIN `vagas` ON `vaga_curriculos`.`vaga` = `vagas`.`id` 
				WHERE `vaga_curriculos`.`curriculo` = '$id' 
				ORDER BY `vagas`.`id` DESC";

		return $this->queryArray($sql);

	}	

	function pegarTodasVagas()
	{
		$sql = "SELECT id, titulo FROM vagas ORDER BY id DESC";

		return $this->queryArray($sql);
	}

	function vagasAtivas()
	{
		$sql = "SELECT id, titulo FROM vagas WHERE ativa != 0 ORDER BY id DESC";

		return $this->queryArray($sql);
	}

	function adicionarCurriculoVaga($id, $vaga)
	{

		$id = (int)$id;
		$vaga = (int)$vaga;

		if($this->verificaCurriculoAdicionadoVaga($id, $vaga) == 0)
			$this->addCurriculoVaga($id, $vaga);
	}

	function descandidatar($id)
	{
		$id = (int)$id;

		$sql = "DELETE FROM vaga_curriculos WHERE id = '$id'";

		$this->query($sql);
	}

	private function verificaCurriculoAdicionadoVaga($id, $vaga)
	{
		$sql = "SELECT COUNT(*) FROM vaga_curriculos WHERE curriculo = '$id' AND vaga = '$vaga'";

		$resultado = $this->queryArray($sql);
	}

	private function addCurriculoVaga($curriculo, $vaga)
	{
		$sql = "INSERT INTO vaga_curriculos (vaga, curriculo, externo) VALUES ($vaga, $curriculo, 1)";

   		$this->query($sql);
	}

	private function ordem()
	{
		$ordem = isset($_GET['ordem']) ? $_GET['ordem'] : '';

		if($ordem == '')
			return 'ORDER BY `curriculos`.`id` DESC';
		else 
			return 'ORDER BY `curriculos`.`' . $_GET['ordem'] . '` ' . $_GET['ordenacao'];
	}

	function pegarQuantidade()
	{
		if($this->quantidade == '') {
			$filtros = $this->filtros();
			$join = $this->joinFiltros();

			if(isset($_GET['palavrachave']))
				$join .= ' ' . $this->join();

			$sql = "SELECT COUNT(*) AS qtd FROM `curriculos` $join $filtros;";


			$resultado = $this->query($sql);
		
			$resultado = $resultado->fetchAll(\PDO::FETCH_ASSOC);

			$this->quantidade = $resultado[0]['qtd'];
		}

		return $this->quantidade;
	}

	function pagina()
	{	

		if(empty($this->pagina)) {
			$quantidadeTodos = $this->pegarQuantidade();

			//quantidade de páginas
			$quantidade = 20;
			$quantidadeDePaginas = ($quantidadeTodos == 0) ? 1 : ceil($quantidadeTodos/$quantidade);

			//início
			$pagina = isset($_GET['pg']) ? $_GET['pg'] : 1;
			if($pagina == '')
				$pagina = 1;

			$pagina--;
			$inicio = $pagina*$quantidade;

			$this->pagina = array('inicio' => $inicio, 'quantidade' => $quantidade, 'qtdPaginas' => $quantidadeDePaginas);
		}

		return 	$this->pagina;
	}

	private function filtros()
	{	
		if($this->filtros == '') {
			require_once(RAIZ . SEPARADOR . 'modelos' . SEPARADOR . 'trataFiltros.php');

			$filtros = new trataFiltros($this->relacionamentos);

			$this->filtros = $filtros->sql;

		}

		return $this->filtros;
	}

	private function camposJoin ()
	{	
		$tabelaModelo = 'curriculos';
		$campos = '`curriculos`.`interNivel1` AS `primeiro`';
		foreach ($this->tipos as $campo => $tipo) 
			if(!isset($this->relacionamentos[$campo]))
				$campos .= ($campos == '') 
					? "`$tabelaModelo`.`$campo`" 
					: ", `$tabelaModelo`.`$campo`";
			else
				$campos .= ($campos == '') 
					? '`'   . $campo . '`.' . '`' . $this->relacionamentos[$campo]['campo'] . '` AS `' . $campo . '`'  
					: ', `' . $campo . '`.' . '`' . $this->relacionamentos[$campo]['campo'] . '` AS `' . $campo . '`';

		return $campos;				
	}

	private function join ()
	{	
		$tabelaModelo = 'curriculos';
		$join = '';
		foreach ($this->relacionamentos as $campo => $relacionamento)
			$join .= ' LEFT JOIN `' . $relacionamento['tabela'] . "` AS `$campo` ON `$tabelaModelo`.`$campo` = `" . $campo . '`.`id`';
		
		return $join;
	}

	function selectJoin($id)
	{	
		$sql = 'SELECT ' . $this->camposJoin() . ' FROM `curriculos`' . $this->join() . " WHERE `curriculos`.`id` = '$id'";

		$resultado = $this->query($sql);
	
		return $resultado->fetchAll(\PDO::FETCH_ASSOC)[0];

		//return 'SELECT ' . $this->camposJoin() . ' FROM `curriculos`' . $this->join() . " WHERE `curriculos`.`id` = '$id'";
	}

	function pegarArquivos($idCurriculo) {
		$sql = "SELECT id, arquivo FROM arquivos WHERE acompanhamento = '$idCurriculo' ORDER BY id DESC";

		$resultado = $this->query($sql);

		return $resultado->fetchAll(\PDO::FETCH_ASSOC);
	}

	function selectJoinAcompanhamentoVagas($id)
	{
		$sql = 'SELECT ' . $this->camposAcompanhamentosVagas() . ' FROM `curriculos`' . $this->joinAcompanhamentosVagas() . " WHERE `curriculos`.`id` = '$id'";
		$resultado = $this->query($sql);

		return $resultado->fetchAll(\PDO::FETCH_ASSOC)[0];		
	}	

	/*	
	*	adiciona os campos da tabela Acompanhamentos e Vagas e os relacionamentos
	*/
	private function camposAcompanhamentosVagas()
	{			
		$tabela = "`acompanhamentos`";
		$sql = ",`curriculos`.`acompanhamento` ,$tabela.`dataalteracao`, $tabela.`comentario`, `usuarios`.`nome` AS `alteradopor` ";

		return $this->camposJoin() . $sql;
	}

	private function joinAcompanhamentosVagas()
	{
		$tabela = "`acompanhamentos`";
		$sql  = " LEFT JOIN $tabela ON `curriculos`.`acompanhamento` = $tabela.`id` ";
		$sql .= " LEFT JOIN `usuarios` ON $tabela.`alteradopor` = `usuarios`.`id` ";

		return $this->join() . $sql;	
	}


	public function estados ()
	{	
		require_once(RAIZ . SEPARADOR . 'modelos' . SEPARADOR . 'estadosModelo.php');
		$estados = new estadosModelo();
		return $estados->estados();
	}

	public function cidades ($estado)
	{	
		require_once(RAIZ . SEPARADOR . 'modelos' . SEPARADOR . 'cidadesModelo.php');
		$cidades = new cidadesModelo();
		return $cidades->cidades($estado);
	}	

	public function areasformacao ()
	{
		require_once(RAIZ . SEPARADOR . 'modelos' . SEPARADOR . 'areaformacaoModelo.php');
		$areas = new areaformacaoModelo();
		return $areas->areasformacao();		
	}

	public function segmentos ()
	{	
		require_once(RAIZ . SEPARADOR . 'modelos' . SEPARADOR . 'segmentosModelo.php');
		$segmentos = new segmentosModelo();
		return $segmentos->segmentos();
	}

	public function cargos ()
	{	
		require_once(RAIZ . SEPARADOR . 'modelos' . SEPARADOR . 'cargosModelo.php');
		$cargos = new cargosModelo();
		return $cargos->cargos();
	}

	public function niveis ()
	{	
		require_once(RAIZ . SEPARADOR . 'modelos' . SEPARADOR . 'niveisModelo.php');
		$niveis = new niveisModelo();
		return $niveis->niveis();
	}	

	public function grauformacao ()
	{	
		require_once(RAIZ . SEPARADOR . 'modelos' . SEPARADOR . 'grauformacaoModelo.php');
		$grauformacao = new grauformacaoModelo();
		return $grauformacao->grauformacao();
	}		

	public function verificaCpf ($cpf)
	{

		$cpf = $this->limpaSql($cpf);
		$onde = "cpf = '$cpf'";

		$qtd = $this->conta($onde);
		
		if($qtd == 0)
			return true;
		else
			return false;

	}

	public function verificaCpfEditar ($cpf, $id)
	{

		$cpf = $this->limpaSql($cpf);
		$onde = "cpf = '$cpf' AND id != '$id'";

		$qtd = $this->conta($onde);
		
		if($qtd == 0)
			return true;
		else
			return false;

	}

	function verificaEmail ($email)
	{

		$email = $this->limpaSql($email);
		$onde = "login = '$email'";

		$qtd = $this->conta($onde, 'usuarios');
		
		if($qtd == 0)
			return true;
		else
			return false;		
	}


	function verificaEmailEditar ($email, $id)
	{

		$email = $this->limpaSql($email);
		$onde = "login = '$email' AND id != '$id'";

		$qtd = $this->conta($onde, 'usuarios');
		
		if($qtd == 0)
			return true;
		else
			return false;		
	}

	function pegarVagasAbertas()
	{
		$sql = 'SELECT id, titulo FROM vagas WHERE ativa != \'0\' ORDER BY id DESC';

		$resultado = $this->query($sql);	

		return $resultado->fetchAll(\PDO::FETCH_ASSOC);
	}
}
?>