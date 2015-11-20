<?php 
namespace Positiv;

class curriculos extends Controle 
{

	public $campos = array('nome' => 'Nome',
						  'email' => 'Email',
						  'facebook' => 'Facebook',
						  'foto' => 'foto',
						  'cpf' => 'CPF',
						  'rg' => 'RG',
						  'nomeMae' => 'Nome da Mãe',
						  'dataNascimento' => 'Nascimento',
						  'sexo' => 'Sexo',
						  'estadoCivil' => 'Estao Civil',
						  'qtdFilhos' => 'Qtd Filhos',
						  'cep' => 'CEP',
						  'endereco' => 'Endereço',
						  'numero' => 'Número',
						  'complemento' => 'Complemento',
						  'bairro' => 'Bairro',
						  'estado' => 'Estado',
						  'cidade' => 'Cidade',
						  'foneCell' => 'Telefone',
						  'foneFixo' => 'Telefone',
						  'foneComercial' => 'Telefone',
						  'empregado' => 'Empregado Atualmente',
						  'habilitacao' => 'Habilitado',
						  'categoria' => 'Categoria',
						  'deficiencia' => 'Deficiente',
						  'descricaoDeficiencia' => 'Descrição da Deficiência',
						  'cargoInteresse' => 'Cargo de Interesse',
						  'interNivel1' => 'nome',
						  'interSegmento1' => 'nome',
						  'interNivel2' => 'nome',
						  'interSegmento2' => 'nome',
						  'interNivel3' => 'nome',
						  'interSegmento3' => 'nome',
						  'pretensaoSalarial' => 'Pretensão Salarial',
						  'expNivel1' => 'nome',
						  'expSegmento1' => 'nome',
						  'expNomeDaEmpresa' => 'Empresa',
						  'expCargo' => 'Último Cargo',
						  'expInicio1' => 'Data da Experiência',
						  'expFim1' => 'data',
						  'expUltimoSalarioInt' => 'Último Salário',
						  'expAtribuicoes' => 'Atribuições',
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
						  'escDataInicio2' => 'nome',
						  'escDataConclusao2' => 'nome',
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
						  'interno' => 'Cadastro Interno',
						  'dataAtualizacao' => 'nome',
						  'areaformacao' => 'nome',
						  'areaformacao2' => 'nome');

	public $renderizar = false;					   

	function index()
	{	
		$tipoUsuario = Sessao::pegar('tipo');
		if($tipoUsuario != '0')
			$this->indexAdm();
	}

	private function indexAdm()
	{	
		//Hash::criar('lucra2015', CHAVE);
		if(!isset($_POST['filtraAjax']))
			$this->renderizar = true;

		foreach ($this->campos as $campo => $nome)
			$_GET[$campo] = isset($_GET[$campo]) ? $_GET[$campo] : '';

		$this->campos['expCargo5'] = 'Cargo - Experiência';
		$this->campos['escNomeCurso'] = 'Curso';
		$this->campos['escNomeInstituicao'] = 'Instituição de Ensino';

		$this->visao = 'indexAdm';

		$this->modelo->tipos['cargoInteresse'] = 'chaveEstrangeira';

		$this->dados['quantidade']   = $this->modelo->pegarQuantidade();
		$this->dados['curriculos']   = $this->modelo->pegarFiltrado();
		$this->dados['qtdPaginas']   = $this->modelo->pagina();
		$this->dados['qtdPaginas']   = $this->dados['qtdPaginas']['qtdPaginas'];
		$this->dados['vagas'] 		 = $this->modelo->pegarTodasVagas();
		$this->dados['areasAbertas'] = $this->modelo->pegarVagasAbertas();
	}

	function listaEmails()
	{
		$tipoUsuario = Sessao::pegar('tipo');
		if($tipoUsuario == '0')
			exit();
		else {
			$this->renderizar = true;

			foreach ($this->campos as $campo => $nome)
				$_GET[$campo] = isset($_GET[$campo]) ? $_GET[$campo] : '';

			$this->campos['expCargo5'] = 'Cargo - Experiência';
			$this->campos['escNomeCurso'] = 'Curso';
			$this->campos['escNomeInstituicao'] = 'Instituição de Ensino';

			$this->dados['emails'] = $this->modelo->pegarListaEmails();
		}
	}

	function imagens()
	{
		
	}

	function visualizar()
	{
		if(Sessao::pegar('tipo') != '0')
			$this->visualizarAdm();
		else {			
			$campos = array_keys($this->campos);
			//$this->dados['curriculo'] = $this->modelo->pesquisarId(Sessao::pegar('curriculo'), $campos);

			$this->dados['curriculo'] = $this->modelo->selectJoin(Sessao::pegar('curriculo'));	
		}

	}

	function pdf()
	{
		if(Sessao::pegar('tipo') != '0') {
			$this->visao = 'visualizar';
			$this->dados['curriculo'] = $this->modelo->selectJoin($_GET['id']);
		}
		else
			exit();
	}

	private function visualizarAdm()
	{	
		$this->visao = 'visualizarAdm';
		$this->renderizar = true;

		if(isset($_POST['vaga']))
			$this->modelo->adicionarCurriculoVaga($_POST['id'], $_POST['vaga']);

		if(isset($_POST['descandidatar']))
			$this->modelo->descandidatar($_POST['descandidatar']);		

		$this->dados['campos'] = $this->campos;
		$this->dados['curriculo']   = $this->modelo->selectJoinAcompanhamentoVagas($_GET['id']);
		$this->dados['vagas'] 	    = $this->modelo->curriculoVagas($_GET['id']);
		$this->dados['vagasAtivas'] = $this->modelo->vagasAtivas();
		$this->dados['arquivos']    = $this->modelo->pegarArquivos($this->dados['curriculo']['acompanhamento']);
	}

	function editar()
	{	
		if(Sessao::pegar('tipo') != '0')
			$this->editarAdm();
		else {	
			if (isset($_POST['cadastrar'])) {
				$_POST['email2'] = Sessao::pegar('email');
				$this->preparaPostEditar();
				$this->tratarPosts();
				$this->atualizar(Sessao::pegar('curriculo'));
			}

			$campos = array_keys($this->campos);
			$curriculo = $this->modelo->pesquisarId(Sessao::pegar('curriculo'), $campos);

			if(Sessao::pegar('cpf') == '' || isset($_POST['cadastrar']))
				$this->addSessaoEditar($curriculo);

			$this->dados['foto']      = $curriculo['foto'];
			$this->dados['estados']   = $this->modelo->estados();
			$this->dados['cidades']   = $this->modelo->cidades($curriculo['estado']);
			$this->dados['grauformacao']  = $this->modelo->grauformacao();
			$this->dados['areasformacao'] = $this->modelo->areasformacao();
			$this->dados['niveis']    = $this->modelo->niveis();
			$this->dados['segmentos'] = $this->modelo->segmentos();
			$this->dados['cargos']    = $this->modelo->cargos();		
		}		
	}

	private function addSessaoEditar($curriculo)
	{	
		$sessao = new \Controles\curriculoSessao($this->campos);
		$sessao->addSessaoEditar($curriculo);		
	}


	private function editarAdm()
	{		
		$this->visao = 'editarAdm';
		if (isset($_POST['cadastrar'])) {
			$this->tratarPosts();
			$this->atualizarAdm();
		}

		$campos = array_keys($this->campos);
		$this->dados['curriculo'] = $this->modelo->pesquisarId($_GET['id'], $campos);

		$this->dados['estados']   = $this->modelo->estados();
		$this->dados['cidades']   = $this->modelo->cidades($this->dados['curriculo']['estado']);
		$this->dados['grauformacao']  = $this->modelo->grauformacao();
		$this->dados['areasformacao'] = $this->modelo->areasformacao();
		$this->dados['niveis']    = $this->modelo->niveis();
		$this->dados['segmentos'] = $this->modelo->segmentos();
		$this->dados['cargos']    = $this->modelo->cargos();		
		
	}

	protected function atualizarAdm()
	{	
		$curriculo = (int)$_GET['id'];

		if($curriculo != 0)
			if($this->modelo->verificaCpfEditar($_POST['cpf'], $curriculo) && 
			   $this->modelo->verificaEmailEditarAdm($_POST['email'])) {
				
				$_POST['dataAtualizacao'] = date('Y-m-d G:i:s');
				$_POST['interno'] = 1;
				$retorna = parent::atualizar($curriculo);
			}
	}


	protected function atualizar($id)
	{	
		if($this->modelo->verificaCpfEditar($_POST['cpf'], Sessao::pegar('curriculo')) && $this->modelo->verificaEmailEditar($_POST['email'], Sessao::pegar('id'))) {

			$_POST['dataAtualizacao'] = date('Y-m-d G:i:s');
			$_POST['interno'] = 0;

			$retorna = parent::atualizar(Sessao::pegar('curriculo'));
			if(empty($retorna))
				$this->atualizarUsuario(Sessao::pegar('curriculo'));
		}
	}	

	private function atualizarUsuario($idCurriculo)
	{
		$this->addArquivosUsuario();

		require RAIZ . SEPARADOR . 'controles'   . SEPARADOR . 'usuariosControle.php';

 		$controle = new \Positiv\usuarios;
		$controle->modelo = new \Positiv\usuariosModelo;
		$_POST['login'] = $_POST['email2'];
		$_POST['tipo'] = '0';
		$_POST['curriculo'] = $idCurriculo;
		Sessao::inserir('email', $_POST['login']);
		$controle->atualizar(Sessao::pegar('id'));
	}	

	function cadastrar()
	{	
		if(Sessao::pegar('logado')) {
			if(Sessao::pegar('tipo') == '0')
				header('location: ' . URL);
			else
				$this->cadastrarAdm();
		} else {

			$this->trataPassos();

			if (isset($_POST['cadastrar'])) {
				$this->tratarPosts();

				$passo = isset($_POST['passo']) ? $_POST['passo'] : 1;
				if($passo != 5)
					$this->salvarNaSessao();
				else {
			
					$this->preparaPostParaSalvar();
					if($this->modelo->verificaCpf($_POST['cpf']) && $this->modelo->verificaEmail($_POST['email']))
						$this->salvar();					

				}

				if($_POST['passo'] == 2 && Sessao::pegar('interNivel1') == 'Primeiro Emprego')
					$_POST['passo'] = 3;
				header('location: ' . URL . 'curriculos/cadastrar/passo:' . ($_POST['passo'] + 1));
				exit();
			}

			$this->dados['grauformacao']  = $this->modelo->grauformacao();
			$this->dados['areasformacao'] = $this->modelo->areasformacao();
			$this->dados['estados']       = $this->modelo->estados();
			$this->dados['niveis']        = $this->modelo->niveis();
			$this->dados['segmentos']     = $this->modelo->segmentos();
			$this->dados['cargos']        = $this->modelo->cargos();
			if(Sessao::pegar('estado') != '')
				$this->dados['cidades']   = $this->modelo->cidades(Sessao::pegar('estado'));
		}
	}

	private function uploadImgDaSessao()
	{	
		if(Sessao::pegar('foto') != '') {
			$foto = 'sess_' . Sessao::pegar('foto');
			$tmp = ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir();

			rename($_FILES['foto']['tmp_name'], PASTA_IMAGENS . $_POST['foto']);		
		}
	}

	private function trataPassos()
	{	
		if(!isset($_GET['passo']))
			header('location: ' . URL . 'curriculos/cadastrar/passo:1');

		$passo = isset($_POST['passo']) ? $_POST['passo'] : 1;
		if($passo > 5)
			$passo = 5;

		if($passo == 2)
			if($_POST['interNivel1'] == 'Primeiro Emprego')
				$passo = 3;
			else
				if(Sessao::pegar('interNivel1') == 'Primeiro Emprego' && $_POST['interNivel1'] != 'Primeiro Emprego')
					Sessao::inserir('passo', 2);

		if(isset($_POST['passo']))
			if($passo > Sessao::pegar('passo'))
				Sessao::inserir('passo', $passo);

		$passoSessao = (int) Sessao::pegar('passo');
		$getPasso = isset($_GET['passo']) ? $_GET['passo'] : 1;
		if(($getPasso - $passoSessao) > 1) {
			$proximo = $passoSessao + 1;
			header('location: ' . URL . 'curriculos/cadastrar/passo:' . $proximo);
			exit();
		}	
	}

	private function classeSessao()
	{
		return new \Controles\curriculoSessao($this->campos);		
	}

	private function preparaPostEditar()
	{	
		$salvar = $this->classeSessao();
		$salvar->preparaPostEditar();		
	}

	private function preparaPostParaSalvar()
	{
		$salvar = $this->classeSessao();
		$salvar->preparaPost();
	}

	private function salvarNaSessao()
	{
		$salvar = $this->classeSessao();
		$salvar->salvarSessao();
	}

	private function cadastrarAdm()
	{	

		if (isset($_POST['cadastrar'])) {
			$this->tratarPosts();

			$this->salvarAdm();	
		}	

		$this->visao = 'cadastrarAdm';
		$this->dados['grauformacao']  = $this->modelo->grauformacao();
		$this->dados['areasformacao'] = $this->modelo->areasformacao();
		$this->dados['estados']       = $this->modelo->estados();
		$this->dados['niveis']        = $this->modelo->niveis();
		$this->dados['segmentos']     = $this->modelo->segmentos();
		$this->dados['cargos']        = $this->modelo->cargos();		
	}

	private function tratarPosts() 
	{	
		//$_POST['email'] = $_POST['email2'];
		
		$campos = array('idiomaIngles', 'idiomaEspanhol', 'idiomaFrances', 'idiomaAlemao', 'idiomaItaliano', 
						'infOffice', 'infAplGraficas', 'infDes', 'infManut');

		foreach ($campos as $campo)
			$_POST[$campo] = isset($_POST[$campo]) ? 1 : 0;

	}

	protected function salvarAdm()
	{
		if($this->modelo->verificaCpf($_POST['cpf']) && $this->modelo->verificaEmail($_POST['email'])) {
			$_POST['interno'] = '1';
			$_POST['dataAtualizacao'] = date('Y-m-d G:i:s');
			$retorna = parent::salvar();			
			if(empty($retorna)) {
				$idCurriculo = $this->modelo->ultimoId();
				$this->salvaAcompanhamento($idCurriculo );
			}
		}		
	}

	protected function salvar()
	{	

		$_POST['email'] = $_POST['email2'];
		if($this->modelo->verificaCpf($_POST['cpf']) && $this->modelo->verificaEmail($_POST['email'])) {
			$_POST['interno'] = '0';
			$_POST['dataAtualizacao'] = date('Y-m-d G:i:s');
			$retorna = parent::salvar();			
			if(empty($retorna)) {
				$this->uploadImgDaSessao();
				$idCurriculo = $this->modelo->ultimoId();
				$idUsuario = $this->salvaUsuario($idCurriculo);
				$this->salvaAcompanhamento($idCurriculo);

				$this->logar($idUsuario, $idCurriculo, $_POST['email']);
			}
		}
	}

	private function addArquivosUsuario()
	{
		require RAIZ . SEPARADOR . 'modelos'   . SEPARADOR . 'usuariosModelo.php';
		
	}

	private function addArquivosAcompanhamento()
	{
		require RAIZ . SEPARADOR . 'modelos'   . SEPARADOR . 'acompanhamentosModelo.php';
	}	

	private function salvaUsuario($idCurriculo)
	{
		$this->addArquivosUsuario();

		$modelo = new \Positiv\usuariosModelo;	

		$modelo->inserir(array('login' => $_POST['email2'], 'tipo' => '0', 'curriculo' => $idCurriculo, 'senha' => $_POST['senha']));

		$id = $modelo->ultimoId();

		$this->enviarEmail($_POST['email2'], $_POST['senha']);

		return $id;
	}

	private function salvaAcompanhamento($idCurriculo)
	{
		$this->addArquivosAcompanhamento();

		$modelo = new \Positiv\acompanhamentosModelo;
		$modelo->inserir(array('curriculo' => $idCurriculo, 'status' => 0));

		$acompanhamentoId = $modelo->ultimoId();

		$this->modelo->atualizar($idCurriculo, array('acompanhamento' => $acompanhamentoId), null, null, false);
	}	


	function verificaCpf ()
	{	
		if(!isset($_POST['cpf']))
			exit();

		$cpf = $_POST['cpf'];

		$resultado;

		if($this->modelo->verificaCpf($cpf))
			$resultado['resultado'] = 'ok';
		else
			$resultado['resultado'] = 'error';

		//$resultado['resultado'] = 'ok'; //excluir essa linha
		echo json_encode($resultado);
	}


	function verificaCpfEditar ()
	{	
		if(!isset($_POST['cpf']))
			exit();

		$cpf = $_POST['cpf'];

		$resultado;

		if($this->modelo->verificaCpfEditar($cpf, Sessao::pegar('curriculo')))
			$resultado['resultado'] = 'ok';
		else
			$resultado['resultado'] = 'error';

		echo json_encode($resultado);
	}

	function verificaEmail ()
	{
		if(!isset($_POST['email']))
			exit();

		$email = $_POST['email'];

		$resultado;

		if($this->modelo->verificaEmail($email))
			$resultado['resultado'] = 'ok';
		else
			$resultado['resultado'] = 'error';

		//$resultado['resultado'] = 'ok'; //excluir essa linha
		echo json_encode($resultado);		
	}

	function verificaEmailEditar ()
	{
		if(!isset($_POST['email']))
			exit();

		$email = $_POST['email'];

		$resultado;

		if($this->modelo->verificaEmailEditar($email, Sessao::pegar('id')))
			$resultado['resultado'] = 'ok';
		else
			$resultado['resultado'] = 'error';

		echo json_encode($resultado);		
	}	


	function verificaCpfEditarAdm ()
	{	
		if(!isset($_POST['cpf']))
			exit();

		$cpf = $_POST['cpf'];
		$id = $_POST['id'];

		$resultado;

		if($this->modelo->verificaCpfEditar($cpf, $id))
			$resultado['resultado'] = 'ok';
		else
			$resultado['resultado'] = 'error';

		echo json_encode($resultado);
	}


	function verificaEmailEditarAdm ()
	{
		if(!isset($_POST['email']))
			exit();

		$email = $_POST['email'];
		$id = $_POST['id'];

		$resultado;

		if($this->modelo->verificaEmailEditar($email, $id))
			$resultado['resultado'] = 'ok';
		else
			$resultado['resultado'] = 'error';

		echo json_encode($resultado);		
	}	

	private function enviarEmail($email, $senha)
	{
		$texto  = '<h2>Seu currículo foi cadastrado com sucesso!</h2>';
		$texto .= '<h3>Informações para Acesso:</h3>';
		$texto .= "<strong>Login: </strong>$email<br>";
		$texto .= "<strong>Senha: </strong>$senha<br><br>";
		$texto .= '<a href="' . URL . '">' . URL . '</a>';

		new Email($email, 'Lucrativia - Cadastro de Currículo', $texto);
	}	

	private function logar($idUsuario, $idCurriculo, $email)
	{
		Sessao::iniciar();
		Sessao::inserir('logado', true);
		Sessao::inserir('usuario', $usuario['nome']);
		Sessao::inserir('id', $idUsuario);
		Sessao::inserir('tipo', '0');
		Sessao::inserir('curriculo', $idCurriculo);
		Sessao::inserir('email', $email);

		//header('location: ' . URL);
		//exit();
	}
}
?>