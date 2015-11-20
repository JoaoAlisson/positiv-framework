<?php
namespace Positiv;

class acompanhamentosModelo extends Modelo
{	
	public $tipos = array('curriculo'     => 'nome',
						  'alteradopor'   => 'nome',
						  'comentario'    => 'nome',
						  'dataalteracao' => 'nome',
						  'status'        => 'nome');

	private $idArquivo   = '';
	private $nomeArquivo = '';


	function pesquisarId($id, $campos, $tabela = NULL, $formatado = true)
	{
		$sql = "SELECT `usuarios`.`nome` AS `alteradopor`, `acompanhamentos`.`dataalteracao` FROM `acompanhamentos` 
				LEFT JOIN `usuarios` ON `acompanhamentos`.`alteradopor` = `usuarios`.`id` WHERE `acompanhamentos`.`id` = '$id'";

		$resultado = $this->query($sql);
	
		$resultado = $resultado->fetchAll(\PDO::FETCH_ASSOC);	

		return $resultado[0];
	}	

	function pegarTodosArquivos($id)
	{
		$id = (int)$id;
		$sql = "SELECT id, arquivo FROM arquivos WHERE acompanhamento = '$id'";
		$resultado = $this->query($sql);
	
		return $resultado->fetchAll(\PDO::FETCH_ASSOC);			
	}

	function pegarArquivoPeloId($id)
	{	
		$id = (int)$id;	
		$sql = "SELECT arquivo FROM arquivos WHERE id = '$id'";
		$resultado = $this->query($sql);
	
		$resultado = $resultado->fetchAll(\PDO::FETCH_ASSOC);	

		return $resultado[0]['arquivo'];		
	}

	function salvaArquivo($id)
	{
		$nome = $this->uploadDoArquivo();
		
		if($nome == '')
			return false;
		else 
			return $this->salvaArquivoNoDB($id, $nome);
	}

	function idArquivo()
	{
		return $this->idArquivo;
	}

	function nomeArquivo()
	{
		return $this->nomeArquivo;
	}

	function deltarArquivo($id, $arquivo)
	{
		$this->deletarAquiv($arquivo);
		$this->deletar($id, 'arquivos');

		return true;
	}

	private function deletarAquiv ($arquivo)
	{	
		$caminho = PASTA_ARQUIVOS_ACOMP . $arquivo;
		if(file_exists($caminho))
			unlink($caminho);
	}	

	private function salvaArquivoNoDB($id, $nome)
	{
		$valores = array('acompanhamento' => $id, 'arquivo' => $nome);

		$insert = new \TSqlInsert();
		$tabela = 'arquivos';

		$insert->setEntity($tabela);

		foreach ($valores as $campo => $valor)
			$insert->setRowData($campo, $valor);

		$sql = $insert->getInstruction();	
		
		$retorna = $this->query($sql);

		$this->idArquivo = $this->ultimoId();

		return $retorna;
	}


	private function uploadDoArquivo()
	{	
		$nome = $this->nomeValido($_FILES['arquivo']['name']);
		$this->upload('arquivo', $nome);

		$this->nomeArquivo = $nome;

		return $nome;
	}

	private function nomeValido($nome)
	{	
		while (file_exists(PASTA_ARQUIVOS_ACOMP . $nome)) {
			$apenasNome = $this->pegaNome($nome);
			if(substr($apenasNome, -1) != ')')
				$nome = $apenasNome . '(1).' . $this->pegaExtensao($nome);
			else
				$nome = $this->incrementaNome($apenasNome) . '.' .  $this->pegaExtensao($nome);
		}

		return $nome;
	}

	private function incrementaNome($nome)
	{	
		$nomeIntegro = $nome;
		if(!strpos($nome,'('))
			$nome .= '(1)';
		else {
			$numero = substr(strrchr($nome, "("), 1);
			$numero = str_replace(')', '', $numero);
			$numero = (int)$numero;
			$numero++;
			$nome = substr($nome, 0, strrpos($nome, '(')) . "($numero)";
		}

		return $nome;

	}

	private function pegaNome($arquivo)
	{
		$info = new \SplFileInfo($arquivo);
		return strtolower($info->getBasename('.' . $this->pegaExtensao($arquivo)));		
	}

	private function pegaExtensao($arquivo){
		$info = new \SplFileInfo($arquivo);
		return strtolower($info->getExtension());
	}	

	private function upload($campo, $novoNome){

        move_uploaded_file(
            $_FILES[$campo]['tmp_name'],
            PASTA_ARQUIVOS_ACOMP . $novoNome
        );
	}
}
?>