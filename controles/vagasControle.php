<?php
namespace Positiv;

class vagas extends Controle
{	
	public $campos = array('titulo'  	  => 'Título',
						   'empresa'      => 'Empresa',
						   'descricaopub' => 'Descrição',
						   'descricaopr'  => 'Descrição Privada',
						   'ativa'        => 'Ativa');

	function index()
	{
		if(Sessao::pegar('tipo') != '0')
			$this->indexAdm();
		
		if(Sessao::pegar('tipo') == '0')
			$this->indexCandidatos();
			//header('location: ' . URL);
	}

	private function indexCandidatos()
	{	
		$this->renderizar = false;
		$this->visao = 'indexCandidatos';

		if(isset($_POST['candidatar']))
			$this->modelo->candidatarse($_POST['vaga']);

		if(isset($_POST['descandidatar']))
			$this->modelo->descandidatarse($_POST['vaga']);

		$this->dados['vagas'] = $this->modelo->vagasPorCandidato(Sessao::pegar('curriculo'));
	}

	function adicionarcurriculos()
	{
		if(Sessao::pegar('tipo') == '0')
			exit();

		$this->renderizar = false;
		if(isset($_POST['id'])) {
			$curriculos = explode(',', $_POST['curriculos']);

			$this->modelo->adicionarCurriculos($_POST['id'], $curriculos);

			if(sizeof($curriculos) > 1)
				echo 'Os currículos foram adiconados com sucesso!';
			else
				echo 'O currículo foi adiconado com sucesso!';
		}
	}

	private function indexAdm()
	{	
		if(isset($_POST['filtraAjax']))
			$this->renderizar = false;

		if(isset($_POST['vaga']))
			$this->ativaVaga();

		if(isset($_POST['vaga_deletar']))
			$this->modelo->deletarVaga($_POST['vaga_deletar']);

		$this->dados['vagas'] = $this->modelo->pegarVagas();
		$pagina = $this->modelo->pagina();

		$this->dados['qtdPaginas'] = $pagina['qtdPaginas'];
		$this->dados['total']      = $this->modelo->pegarQuantidade();

	}

	private function ativaVaga()
	{
		$id  = (int)$_POST['vaga'];
		$ativa = (int)$_POST['ativa'];


		$this->modelo->atualizarVaga($id, $ativa);
	}

	function cadastrar()
	{
		if(Sessao::pegar('tipo') != '0')
			$this->cadastrarAdm();
	}	

	function editar()
	{
		if(Sessao::pegar('tipo') != '0') {
			$id = isset($_GET['id']) ? $_GET['id'] : 0;

			if(isset($_POST['enviado'])) {
				$_POST['ativa'] = isset($_POST['ativa']) ? '1' : '0';
				$this->atualizar($id);
			}

			$campos = array_keys($this->campos);
			$this->dados['vaga'] = $this->modelo->pesquisarId($id, $campos);			
		}
	}

	private function cadastrarAdm()
	{
		$this->visao = 'cadastrarAdm';

		if(isset($_POST['enviado'])) {
			$_POST['ativa'] = isset($_POST['ativa']) ? '1' : '0';
			if(empty($this->salvar()))
				$this->alerta('Vaga Cadastrada com Sucesso!');

		}
	}

	private function alerta($mensagem) {

		echo "<script type='text/javascript'>alert('$mensagem')</script>";
	}

	function visualizar()
	{
		if(Sessao::pegar('tipo') == '0') {
			header('location: ' . URL);
			exit();
		}

		if(isset($_POST['concorrente']))
			$this->modelo->deletarConcorrente($_POST['concorrente']);

		$campos = array_keys($this->campos);
		$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
		$this->dados['vaga']       = $this->modelo->pesquisarId($id, $campos);
		$this->dados['curriculos'] = $this->modelo->pegarVagaCurriculos($id);
		
	}
}
?>