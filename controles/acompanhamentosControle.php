<?php 
namespace Positiv;

class acompanhamentos extends Controle 
{
	public $campos = array('curriculo'     => 'nome',
						   'alteradopor'   => 'nome',
						   'comentario'    => 'nome',
						   'dataalteracao' => 'nome',
						   'status'        => 'nome');
			   

	function index()
	{
		
	}

	function salvarcomentario()
	{
		if(Sessao::pegar('tipo') == '0')
			exit();
		else {
			$this->renderizar = false;

			if(isset($_POST['id'])) {

				$id = (int)$_POST['id'];

				$alteradopor = Sessao::pegar('id');
				$this->modelo->atualizar($id, array('alteradopor' => $alteradopor, 'comentario' => $_POST['comentario'], 'curriculo' => NULL));

				$retorna = $this->modelo->pesquisarId($id, array('alteradopor', 'dataalteracao'));

				$data = $retorna['dataalteracao'];

				list($data, $hora) = explode(' ', $data);
				list($ano, $mes, $dia) = explode('-', $data);

				$retorna['dataalteracao'] = "$dia/$mes/$ano às $hora";


				echo json_encode($retorna);
			}
 		}
	}

	function pegararquivos()
	{	
		$this->renderizar = false;

		if(Sessao::pegar('tipo') == '0')
			exit();
		else {
			if(isset($_POST['id'])) {
				$arquivos = $this->modelo->pegarTodosArquivos($_POST['id']);

				$html = '';
				foreach ($arquivos as $arquivo) {
					$link  = "<a target='_blank' href='" . URL . "acompanhamentos/baixar/id:" . $arquivo['id'] . "'>" . $arquivo['arquivo'] . "</a>";
					$html .= ($html == '') ?$link : '<br>' . $link;
				}

				echo $html;
			}
		}		
	}

	function salvararquivo()
	{	
		if(Sessao::pegar('tipo') == '0')
			exit();
		else {
			$this->renderizar = false;

			if(isset($_FILES['arquivo']['name'])) {

				$id = (int)$_POST['id'];

				$alteradopor = Sessao::pegar('id');

				if ($this->modelo->salvaArquivo($id))
					$this->modelo->atualizar($id, array('alteradopor'   => $alteradopor,
														'comentario'    => NULL, 
														'curriculo'     => NULL, 
														'dataalteracao' => date('Y-m-d G:i:s')));

				$retorna = $this->modelo->pesquisarId($id, array('alteradopor', 'dataalteracao'));

				$data = $retorna['dataalteracao'];

				list($data, $hora) = explode(' ', $data);
				list($ano, $mes, $dia) = explode('-', $data);

				$retorna['dataalteracao'] = "$dia/$mes/$ano às $hora";

				$retorna['id']           = $this->modelo->idArquivo();
				$retorna['arquivo']      = $this->modelo->nomeArquivo();
				$retorna['arquivoAbrev'] = $this->formataText($this->modelo->nomeArquivo());

				echo json_encode($retorna);
			}
 		}
	}	

	private function formataText($texto)
	{
		if(strlen($texto) > 40) {
			$formato = substr(strrchr($texto, "."), 1);
			$texto = substr($texto, 0, 30) . '... .' . $formato;
		}

		return $texto;
	}


	function baixar()
	{
		if(Sessao::pegar('tipo') == '0')
			exit();
		else {

			$this->renderizar = false;

			define('HTML', false);

			$arquivo = '';
			//$arquivo = $_GET['arquivo'];

			$arquivo = $this->modelo->pegarArquivoPeloId($_GET['id']);
			
			$nome = $arquivo;
			$caminho = PASTA_ARQUIVOS_ACOMP;
			$caminhoCompleto = $caminho.$arquivo;

			$savename = (basename($caminhoCompleto));

			if(file_exists($caminhoCompleto)){

				header('Content-Description: File Transfer');
				header('Content-Disposition: attachment; filename='.$savename);
				header('Content-Type: application/octet-stream');
				header('Content-Transfer-Encoding: binary');
				header('Content-Length: ' . filesize($caminhoCompleto));
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');

				ob_clean();
				flush();

				readfile($caminhoCompleto);
			}
		}
	}

	function deletararquivo()
	{
		if(Sessao::pegar('tipo') == '0')
			exit();
		else {
			
			if(isset($_POST['id'])) {

				$this->renderizar = false;

				$id = (int)$_POST['id'];

				$alteradopor = Sessao::pegar('id');

				if ($this->modelo->deltarArquivo($_POST['idArquivo'], $_POST['arquivo']))
					$this->modelo->atualizar($id, array('alteradopor'   => $alteradopor,
														'comentario'    => NULL, 
														'curriculo'     => NULL, 
														'dataalteracao' => date('Y-m-d G:i:s')));

				$retorna = $this->modelo->pesquisarId($id, array('alteradopor', 'dataalteracao'));

				$data = $retorna['dataalteracao'];

				list($data, $hora) = explode(' ', $data);
				list($ano, $mes, $dia) = explode('-', $data);

				$retorna['dataalteracao'] = "$dia/$mes/$ano às $hora";

				$retorna['id'] = $this->modelo->idArquivo();

				echo json_encode($retorna);

			}
		}
	}

}
?>