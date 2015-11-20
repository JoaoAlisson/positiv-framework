<?php
namespace Positiv;

class vagasModelo extends Modelo
{	
	public $tipos = array('titulo'  	 => 'nome',
						  'empresa'      => 'nome',
						  'descricaopub' => 'texto',
						  'descricaopr'  => 'texto',
						  'ativa'        => 'nome');

	public $obrigatorios = array('titulo', 'empresa', 'descricaopub');

	private $filtros = '';
	private $quantidade = '';
	private $pagina = array();

	function pegarVagas()
	{	
		$filtros = $this->filtros();
		$pagina = $this->pagina();
		$pagina = $pagina['inicio'] . ', ' . $pagina['quantidade'];

		$sql = "SELECT `vagas`.`id`, `vagas`.`titulo`, `vagas`.`empresa`, `vagas`.`ativa`,
		(SELECT COUNT(*) FROM `vaga_curriculos` WHERE `vaga_curriculos`.`vaga` = `vagas`.`id`) AS `qtd` FROM `vagas` $filtros ORDER BY id DESC LIMIT $pagina";

		$resultado = $this->query($sql);
	
		return $resultado->fetchAll(\PDO::FETCH_ASSOC);
	}

	function pegarVagaCurriculos($id)
	{
		$id  = (int)$id;

		$arquivos = '(SELECT COUNT(*) FROM `arquivos` WHERE `arquivos`.`acompanhamento` = `curriculos`.`acompanhamento`) AS `arquivos`';

		$sql = "SELECT `curriculos`.`id` AS `curriculo`, `curriculos`.`nome`, `curriculos`.`email`, `curriculos`.`acompanhamento`, `curriculos`.`foneCell`, `curriculos`.`dataAtualizacao`, `vaga_curriculos`.`id`, `vaga_curriculos`.`externo`, $arquivos FROM `vaga_curriculos` 
				LEFT JOIN `curriculos` ON `vaga_curriculos`.`curriculo` = `curriculos`.`id` WHERE `vaga_curriculos`.`vaga` = '$id' ORDER BY `vaga_curriculos`.`id` DESC";

		$resultado = $this->query($sql);
	
		return $resultado->fetchAll(\PDO::FETCH_ASSOC);
	}

	function adicionarCurriculos($vaga, $curriculos)
	{	
		$adicionados = $this->listaCurriculosAdicionados($vaga, $curriculos);

		foreach ($curriculos as $curriculo)
			if(!$this->verificaCurriculoAdicionado($vaga, $curriculo, $adicionados))
				$this->addCurriculo($curriculo, $vaga);
	}

	function vagasPorCandidato($id)
	{
		$sql = "SELECT `vagas`.`id`, `vagas`.`titulo`, `vagas`.`descricaopub`, 
				(SELECT COUNT(*) FROM `vaga_curriculos` 
					WHERE `vaga_curriculos`.`curriculo` = '$id' AND `vaga_curriculos`.`vaga` = `vagas`.`id`) as candidatado 
				FROM `vagas` WHERE `vagas`.`ativa` != 0";
		
		return $this->queryArray($sql);
	}	

	function candidatarse($vaga)
	{
		$vaga = (int)$vaga;
		$curriculo = Sessao::pegar('curriculo');

		$sql = "INSERT INTO vaga_curriculos (vaga, curriculo, externo) VALUES ($vaga, $curriculo, 0)";

   		$this->query($sql);		
	}

	function descandidatarse($vaga)
	{
		$vaga = (int)$vaga;
		$curriculo = Sessao::pegar('curriculo');

		$sql = "DELETE FROM vaga_curriculos WHERE vaga = '$vaga' AND curriculo = '$curriculo'";

		$this->query($sql);

	}

	private function addCurriculo($curriculo, $vaga)
	{
		$sql = "INSERT INTO vaga_curriculos (vaga, curriculo, externo) VALUES ($vaga, $curriculo, 1)";

   		$this->query($sql);
	}

	private function verificaCurriculoAdicionado($vaga, $curriculo, &$adicionados)
	{	
		$chave;
		$adicionado = false;
	
		foreach ($adicionados as $key => $curr)
			if($curr['vaga'] == $vaga && $curr['curriculo'] == $curriculo) {
				$adicionado = true;
				$chave = $key;
			}
	

		if($adicionado)
			unset($adicionados[$chave]);

		return $adicionado;
	}

	private function listaCurriculosAdicionados($vaga, $curriculos)
	{
		$sql = '';
		foreach ($curriculos as $curriculo)
			$sql .= ($sql == '') ? "(vaga = '$vaga' AND curriculo = '$curriculo')" : " OR (vaga = '$vaga' AND curriculo = '$curriculo')"; 
		
		$sql = "SELECT vaga, curriculo FROM vaga_curriculos WHERE $sql";
		
		$resultado = $this->query($sql);
	
		return $resultado->fetchAll(\PDO::FETCH_ASSOC);
	}

	private function pegarFiltros()
	{
		require_once(RAIZ . SEPARADOR . 'modelos' . SEPARADOR . 'trataFiltrosVagas.php');

		$filtros = new trataFiltrosVagas();
		return $filtros->sql;
	}

	private function filtros()
	{	
		if($this->filtros == '')
			$this->filtros = $this->pegarFiltros();

		return $this->filtros;
	}	

	function pegarQuantidade()
	{
		if($this->quantidade == '') {
			$filtros = $this->filtros();
			$sql = "SELECT COUNT(*) AS qtd FROM `vagas` $filtros;";

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

	function atualizarVaga($id, $ativa)
	{
		$sql = "UPDATE vagas SET ativa = '$ativa' WHERE id = '$id'";
		$this->query($sql);
	}

	function deletarVaga($id)
	{
		$id = (int)$id;

		$sql = "DELETE FROM vagas WHERE id = '$id'";
		if($this->query($sql))
			$this->deletaVagasCurriculos($id);
	}

	function deletarConcorrente($id)
	{
		$id = (int)$id;

		$sql = "DELETE FROM vaga_curriculos WHERE id = '$id'";
		
		$this->query($sql);
	}

	private function deletaVagasCurriculos($id) 
	{
		$sql = "DELETE FROM vaga_curriculos WHERE vaga = '$id'";
		$this->query($sql);
	}
}
?>