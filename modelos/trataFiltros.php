<?php
namespace Positiv;

class trataFiltros 
{	
	public $sql = '';

	private $camposPalavraChave = array('nome', 'email', 'facebook', 'cpf', 'rg', 'endereco', 
										'complemento', 'bairro', 'foneCell', 'foneFixo', 'foneComercial', 'descricaoDeficiencia',
										'expNomeDaEmpresa', 'expCargo', 'expAtribuicoes', 'expNomeDaEmpresa2', 'expCargo2', 'expAtribuicoes2',
										'expNomeEmpresa3', 'expCargo3', 'expAtribuicoes3', 'expNomeEmpresa4', 'expCargo4', 'expAtribuicoes4',
										'expNomeEmpresa5', 'expCargo5', 'expAtribuicoes5', 'expInformacoes', 'escNomeCurso', 'escNomeInstituicao',
										'escNomeCurso2', 'escNomeInstituicao2', 'interNivel1', 'interNivel2' , 'interNivel3');


	private $camposBooleanos = array('idiomaIngles'   => 'Inglês', 
									 'idiomaEspanhol' => 'Espanhol',
									 'idiomaFrances'  => 'Francês',
									 'idiomaAlemao'   => 'Alemão',
									 'idiomaItaliano' => 'Italiano',
									 'infOffice'      => 'Pacote Office (Windows, Word, Excel, Powerpoint)',
									 'infAplGraficas' => 'Aplicativos Gráficos (Corel, Photoshop, Illustrator)',
									 'infDes'		  => 'Desenvolvimento de software (Programação e Design)',
									 'infManut'       => 'Manutenção de computadores e redes');

	function __construct($relacionamentos) {

		$this->trataGets();

		$textos = array('nome');

		$this->textos($textos);

		$numeros = array('empregado', 'estado', 'cidade', 'cargoInteresse', 'deficiencia', 'cpf');

		$this->numeros($numeros);		

		$this->abilitacao();

		$this->habilidades();

		$this->sexo();

		$this->segmentoNivelInteresse();

		$this->segmentoNivelExperiencia();

		$this->empresa();

		$this->cargoExperiencia();

		$this->grauFormacao();

		$this->areaFormacao();

		$this->instituicaoEnsino();

		$this->curso();

		$this->cursando();

		$this->dataExperiencia();

		$this->curriculoInterno();

		$this->vagas();

		$this->dataCadastro();

		if(isset($_GET['palavrachave']))
			$this->palavrachave($relacionamentos);

		if($this->sql != '')
			$this->sql = 'WHERE ' . $this->sql;

		//echo $this->sql;
		$this->trataGetsDepois();

	}

	private function palavrachave($relacionamentos)
	{

		$sql = '';
		foreach ($relacionamentos as $campo => $relacionamento) {
			$campo = $this->textoPalavraChave($relacionamento['campo'], $campo, $_GET['palavrachave']);
			$sql .= ($sql != '') ? " OR $campo" : $campo;
		}
		
		$camposBooleanos  = $this->trataBooleanos();
		$nivelIdiomas     = $this->nivelIdiomas();
		$nivelInformatica = $this->nivelInformatica();

		$sql = "($sql OR " . $this->camposPalavraChave() . " $camposBooleanos $nivelIdiomas $nivelInformatica)";

		$this->sql .= ($this->sql != '') ? " AND $sql" : $sql;
	}

	private function trataBooleanos()
	{	
		$sql = '';

		$palavrachave = $_GET['palavrachave'];
		foreach ($this->camposBooleanos as $campo => $string)
			if($this->procuraEmString($palavrachave, $string))
				$sql .= ' OR ' . $this->campo($campo) . ' != 0 ';

		return $sql;
	}

	private function nivelIdiomas()
	{
		$sql = '';
		$nivel = 0;

		$palavrachave = $_GET['palavrachave'];

		if($this->procuraEmString($palavrachave, 'Básico'))
			$nivel = 3;

		if($this->procuraEmString($palavrachave, 'Intermediário'))
			$nivel = 2;

		if($this->procuraEmString($palavrachave, 'Fluente'))
			$nivel = 1;					

		if($nivel != 0) {
			$campos = array('nivelIdiomaIngles', 'nivelIdiomaEspanhol', 'nivelIdiomaFrances', 'nivelIdiomaAlemao', 'nivelIdiomaItaliano');

			foreach ($campos as $campo)
				$sql .= ' OR ' . $this->campo($campo) . " = $nivel";
				
		}

		return $sql;
	}

	private function nivelInformatica()
	{
		$sql = '';
		$nivel = 0;

		$palavrachave = $_GET['palavrachave'];

		if($this->procuraEmString($palavrachave, 'Básico'))
			$nivel = 3;

		if($this->procuraEmString($palavrachave, 'Intermediário'))
			$nivel = 2;

		if($this->procuraEmString($palavrachave, 'Avançado'))
			$nivel = 1;					

		if($nivel != 0) {
			$campos = array('nivelInfOffice', 'nivelInfAplGraficas', 'nivelInfDes', 'nivelInfManut');

			foreach ($campos as $campo)
				$sql .= ' OR ' . $this->campo($campo) . " = $nivel";
				
		}

		return $sql;
	}	

	private function procuraEmString($procura, $string)
	{	

		$procura = $this->removeAcentos($procura);
		$string  = $this->removeAcentos($string);

		$resultado = strpos($string, $procura);
		if($resultado === false)
			return false;
		else
			return true;
	}

	private function camposPalavraChave()
	{	
		$sql = '';
		foreach ($this->camposPalavraChave as $campo) {
			$camp = $this->textoPalavraChave($campo, 'curriculos', $_GET['palavrachave']);
			$sql .= ($sql != '') ? " OR $camp" : $camp;
		}

		return $sql;
	}

	private function textoPalavraChave($campo, $tabela = 'curriculos', $palavrachave)
	{
		return $this->campo($campo, $tabela) . " REGEXP '" .  $this->textoER($palavrachave) . "'";

		//return $this->campo($campo, $tabela) . " REGEXP 'o+[aã]+o'";
	}	

	private function cursando()
	{
		$cursando = $_GET['escAno'];

		if($cursando != '') {

			$this->sql .= ($this->sql != '') ? ' AND (' : '(';
			if($_GET['escAno'] == '1') {
				$this->sql .= '(' . $this->campo('escAno') . " > '0' AND " . $this->campo('escAno') . " < '7') OR (";
				$this->sql .= $this->campo('escAno2') . " > '0' AND " . $this->campo('escAno2') . " < '7')) ";		
			} else {
				if($_GET['escAno'] == '2') {
					$this->sql .= $this->campo('escAno') . " = '8' OR ";
					$this->sql .= $this->campo('escAno2') . " = '8') ";						
				} else {
					$this->sql .= $this->campo('escAno') . " = '7' OR ";
					$this->sql .= $this->campo('escAno2') . " = '7') ";						
				}
			}	
		}		
	}

	private function vagas()
	{
		if(isset($_GET['vaga'])) {
			$vaga = (int) $_GET['vaga'];
			$this->sql .= ($this->sql != '') 
							? " AND `vaga_curriculos`.`vaga` = '$vaga'" 
							: "`vaga_curriculos`.`vaga` = '$vaga'";
		}
	}

	private function curriculoInterno()
	{
		if(isset($_GET['interno'])) {
			if($_GET['interno'] == 1) {
				$this->sql .= ($this->sql != '') 
					? ' AND ' . $this->campo('interno') . " != '0' " 
					: ' '     . $this->campo('interno') . " != '0' ";
			} else {
				if($_GET['interno'] == 2) {
					$this->sql .= ($this->sql != '') 
						? ' AND ' . $this->campo('interno') . " = '0' " 
						: ' '     . $this->campo('interno') . " = '0' ";					
				}
			}
		}
	}

	private function dataCadastro()
	{
		if(isset($_GET['cadastro_submit'])){
			list($mes, $ano) = explode('-', $_GET['cadastro_submit']);
			$campo = $this->campo('dataCadastro');
			$cadastro = "(MONTH($campo) = '$mes' AND YEAR($campo) = '$ano')";

			$this->sql .= ($this->sql != '') ? ' AND ' . $cadastro : $cadastro;
		}	
	}	

	private function dataExperiencia()
	{
		$data = isset($_GET['expInicio1_submit']) ? $_GET['expInicio1_submit'] : '';
		if($data != '') {
			list($mes, $ano) = explode('-', $data);
			$mes = (int)$mes;
			$ano = (int)$ano;

			$this->sql .= ($this->sql != '') ? ' AND (' : '(';
	
			$campos = array(array('inicio' => 'expInicio1', 'fim' => 'expFim1'), 
							array('inicio' => 'expInicio2', 'fim' => 'expFim2'),
							array('inicio' => 'expInicio3', 'fim' => 'expFim3'),
							array('inicio' => 'expInicio4', 'fim' => 'expFim4'),
							array('inicio' => 'expInicio5', 'fim' => 'expFim5'));

			$this->sql .= $this->adicionaTodasDatasExp($campos, $mes, $ano);

			$this->sql .= ') ';
		}
	}

	private function adicionaTodasDatasExp($campos, $mes, $ano)
	{	
		$datas = '';
		foreach ($campos as $campo) {
			$datas .= ($datas == '') 
				? $this->adicionaDataExp($campo['inicio'], $campo['fim'], $mes, $ano)
				: ' OR ' . $this->adicionaDataExp($campo['inicio'], $campo['fim'], $mes, $ano);
		}
		
		return $datas;
	}

	private function adicionaDataExp($campoInicio, $campoFim, $mes, $ano)
	{	
		$campo  = "('$ano' >= YEAR(" . $this->campo($campoInicio) . ") AND '$mes' >= MONTH(" . $this->campo($campoInicio) . ") AND ";  
		$campo .= "'$ano' <= YEAR(" . $this->campo($campoFim)     . ") AND '$mes' <= MONTH(" . $this->campo($campoFim)    . "))";   
		
		return $campo;
	}

	private function curso()
	{
		$curso = $_GET['escNomeCurso'];

		if($curso != '') {
			$curso = $this->textoER($curso);
			$this->sql .= ($this->sql != '') ? ' AND (' : '(';
			$this->sql .= $this->campo('escNomeCurso')  . " REGEXP '$curso' OR ";
			$this->sql .= $this->campo('escNomeCurso2') . " REGEXP '$curso') ";				
		}		
	}

	private function instituicaoEnsino()
	{
		$instituicao = $_GET['escNomeInstituicao'];

		if($instituicao != '') {
			$instituicao = $this->textoER($instituicao);
			$this->sql .= ($this->sql != '') ? ' AND (' : '(';
			$this->sql .= $this->campo('escNomeInstituicao')  . " REGEXP '$instituicao' OR ";
			$this->sql .= $this->campo('escNomeInstituicao2') . " REGEXP '$instituicao') ";				
		}
	}

	private function grauFormacao()
	{
		$escolaridade = $_GET['escGrau'];
		if($escolaridade != '') {
			$this->sql .= ($this->sql != '') ? ' AND (' : '(';
			$this->sql .= $this->campo('escGrau')  . " = '$escolaridade' OR ";
			$this->sql .= $this->campo('escGrau2') . " = '$escolaridade') ";			
		}
	}

	private function areaFormacao()
	{
		$area = isset($_GET['areaformacao']) ? $_GET['areaformacao'] : '';

		if($area != '') {
			$this->sql .= ($this->sql != '') ? ' AND (' : '(';
			$this->sql .= $this->campo('areaformacao')  . " = '$area' OR ";
			$this->sql .= $this->campo('areaformacao2') . " = '$area') ";					
		}
	}

	private function empresa()
	{
		$empresa = $_GET['expNomeDaEmpresa'];
		if($empresa != '') {
			$empresa = $this->textoER($empresa);
			$this->sql .= ($this->sql != '') ? ' AND (' : '(';
			$this->sql .= $this->campo('expNomeDaEmpresa')  . " REGEXP '$empresa' OR ";
			$this->sql .= $this->campo('expNomeDaEmpresa2') . " REGEXP '$empresa' OR ";
			$this->sql .= $this->campo('expNomeEmpresa3')   . " REGEXP '$empresa' OR ";
			$this->sql .= $this->campo('expNomeEmpresa4')   . " REGEXP '$empresa' OR ";
			$this->sql .= $this->campo('expNomeEmpresa5')   . " REGEXP '$empresa') ";
		}
	}

	private function cargoExperiencia()
	{
		$cargo = $_GET['expCargo5'];
		if($cargo != '') {
			$cargo = $this->textoER($cargo);
			$this->sql .= ($this->sql != '') ? ' AND (' : '(';
			$this->sql .= $this->campo('expCargo')  . " REGEXP '$cargo' OR ";
			$this->sql .= $this->campo('expCargo2') . " REGEXP '$cargo' OR ";
			$this->sql .= $this->campo('expCargo3') . " REGEXP '$cargo' OR ";
			$this->sql .= $this->campo('expCargo4') . " REGEXP '$cargo' OR ";
			$this->sql .= $this->campo('expCargo5') . " REGEXP '$cargo') ";
		}
	}	

	private function segmentoNivelInteresse()
	{

		$segmento = $_GET['interSegmento1'];
		$nivel    = $_GET['interNivel1'];

		$sql = '';

		if($segmento != '' || $nivel != '') {
			$this->sql .= ($this->sql != '') ? ' AND ' : '';
			$this->sql .= '(';			

			if($segmento != '' && $nivel != '') {
				$this->sql .= $this->segmentoAndNivel('interSegmento1', 'interNivel1') . ' OR ';
				$this->sql .= $this->segmentoAndNivel('interSegmento2', 'interNivel2') . ' OR ';
				$this->sql .= $this->segmentoAndNivel('interSegmento3', 'interNivel3') . ')';
			} else {
				if($segmento != '') {
					$this->sql .= $this->campo('interSegmento1') . " = '" . $_GET['interSegmento1'] . "' OR ";
					$this->sql .= $this->campo('interSegmento2') . " = '" . $_GET['interSegmento1'] . "' OR ";
					$this->sql .= $this->campo('interSegmento3') . " = '" . $_GET['interSegmento1'] . "')";
				} else {
					$this->sql .= $this->campo('interNivel1') . " = '" . $_GET['interNivel1'] . "' OR ";
					$this->sql .= $this->campo('interNivel2') . " = '" . $_GET['interNivel1'] . "' OR ";
					$this->sql .= $this->campo('interNivel3') . " = '" . $_GET['interNivel1'] . "')";					
				}
			}
		}
	
	}

	private function segmentoNivelExperiencia()
	{

		$segmento = $_GET['expSegmento1'];
		$nivel    = $_GET['expNivel1'];

		$sql = '';

		if($segmento != '' || $nivel != '') {
			$this->sql .= ($this->sql != '') ? ' AND ' : '';
			$this->sql .= '(';			

			if($segmento != '' && $nivel != '') {
				$this->sql .= $this->segmentoAndNivelExp('expSegmento1', 'expNivel1') . ' OR ';
				$this->sql .= $this->segmentoAndNivelExp('expSegmento2', 'expNivel2') . ' OR ';
				$this->sql .= $this->segmentoAndNivelExp('expSegmento3', 'expNivel3') . ' OR ';
				$this->sql .= $this->segmentoAndNivelExp('expSegmento4', 'expNivel4') . ' OR ';
				$this->sql .= $this->segmentoAndNivelExp('expSegmento5', 'expNivel5') . ')';
			} else {
				if($segmento != '') {
					$this->sql .= $this->campo('expSegmento1') . " = '" . $_GET['expSegmento1'] . "' OR ";
					$this->sql .= $this->campo('expSegmento2') . " = '" . $_GET['expSegmento1'] . "' OR ";
					$this->sql .= $this->campo('expSegmento3') . " = '" . $_GET['expSegmento1'] . "' OR ";
					$this->sql .= $this->campo('expSegmento4') . " = '" . $_GET['expSegmento1'] . "' OR ";
					$this->sql .= $this->campo('expSegmento5') . " = '" . $_GET['expSegmento1'] . "')";
				} else {
					$this->sql .= $this->campo('expNivel1') . " = '" . $_GET['expNivel1'] . "' OR ";
					$this->sql .= $this->campo('expNivel2') . " = '" . $_GET['expNivel1'] . "' OR ";
					$this->sql .= $this->campo('expNivel3') . " = '" . $_GET['expNivel1'] . "' OR ";
					$this->sql .= $this->campo('expNivel4') . " = '" . $_GET['expNivel1'] . "' OR ";
					$this->sql .= $this->campo('expNivel5') . " = '" . $_GET['expNivel1'] . "')";					
				}
			}
		}
	
	}	

	private function segmentoAndNivelExp($segmento, $nivel){
		$sql  = '(' . $this->campo($segmento) . " = '" . $_GET['expSegmento1'] . "' AND ";
		$sql .=       $this->campo($nivel)    . " = '" . $_GET['expNivel1']    . "')";

		return $sql;
	}

	private function segmentoAndNivel($segmento, $nivel){
		$sql  = '(' . $this->campo($segmento) . " = '" . $_GET['interSegmento1'] . "' AND ";
		$sql .=       $this->campo($nivel)    . " = '" . $_GET['interNivel1']    . "')";

		return $sql;
	}

	private function sexo()
	{
		if($_GET['sexo'] != '') {
			$sexo = ($_GET['sexo'] == 1) ? 'masculino' : 'feminino';
			$this->sql .= ($this->sql == '') 
				? $this->campo('sexo') . " = '$sexo'" 
				: ' AND ' . $this->campo('sexo') . " = '$sexo'";
		}
	}

	private function trataGets()
	{
		$_GET['empregado']   = ($_GET['empregado'] == '3')   ? '0' : $_GET['empregado'];
		$_GET['deficiencia'] = ($_GET['deficiencia'] == '3') ? '0' : $_GET['deficiencia'];
	}

	private function habilidades()
	{
		$campos = array(array('campo' => 'idiomaIngles',   'nivel' => 'nivelIdiomaIngles'),
					    array('campo' => 'idiomaEspanhol', 'nivel' => 'nivelIdiomaEspanhol'),
					    array('campo' => 'idiomaFrances',  'nivel' => 'nivelIdiomaFrances'),
					    array('campo' => 'idiomaAlemao',   'nivel' => 'nivelIdiomaAlemao'),
					    array('campo' => 'idiomaItaliano', 'nivel' => 'nivelIdiomaItaliano'),
					    array('campo' => 'infOffice',      'nivel' => 'nivelInfOffice'),
					    array('campo' => 'infAplGraficas', 'nivel' => 'nivelInfAplGraficas'),
					    array('campo' => 'infDes',         'nivel' => 'nivelInfDes'),
					    array('campo' => 'infManut',       'nivel' => 'nivelInfManut'));

		foreach ($campos as $campo) 
			$this->habilidade($campo['campo'], $campo['nivel']);

	}

	private function habilidade($campo, $nivel)
	{	
		if($_GET[$campo] != '')
			if($_GET[$campo] == 4)
				$this->sql .= ($this->sql == '') ? $this->campo($campo) . ' = \'1\'' : ' AND ' . $this->campo($campo) . ' = \'1\'';
			else
				$this->sql .= ($this->sql == '') ? $this->campo($nivel) . ' = \'' . $_GET[$campo] . '\'' : ' AND ' . $this->campo($nivel) . ' = \'' . $_GET[$campo] . '\'';
	}

	private function trataGetsDepois()
	{
		$_GET['empregado']   = ($_GET['empregado'] == '0')   ? '3' : $_GET['empregado'];
		$_GET['deficiencia'] = ($_GET['deficiencia'] == '0') ? '3' : $_GET['deficiencia'];
	}

	private function abilitacao()
	{
		if($_GET['habilitacao'] != '') {
			if($_GET['habilitacao'] == '1')
				$this->sql .= ($this->sql == '') ? $this->campo('habilitacao') . ' = \'2\'' : ' AND ' . $this->campo('habilitacao') . ' = \'2\'';
			else
				$this->sql .= ($this->sql == '') ? $this->campo('categoria') . ' = \'' . $_GET['habilitacao'] . '\'' : ' AND ' . $this->campo('categoria') . ' = \'' . $_GET['habilitacao'] . '\'';
		}
	}

	private function textos($campos)
	{
		foreach ($campos as $campo)
			if($_GET[$campo] != '')
				$this->sql .= ($this->sql == '') ? $this->texto($campo) : ' AND ' . $this->texto($campo);

	}

	private function numeros($campos)
	{
		foreach ($campos as $campo)
			if($_GET[$campo] != '')
				$this->sql .= ($this->sql == '') ? $this->numero($campo) : ' AND ' . $this->numero($campo);

	}

	private function numero($campo, $tabela = 'curriculos')
	{
		return $this->campo($campo, $tabela) . " = '" . $_GET[$campo] . "'";
	}

	private function texto($campo, $tabela = 'curriculos')
	{
		return $this->campo($campo, $tabela) . " REGEXP '" .  $this->textoER($_GET[$campo]) . "'";
		//return $this->campo($campo, $tabela) . " REGEXP 'o+[aã]+o'";
	}

	private function campo($campo, $tabela = 'curriculos')
	{
		return "`$tabela`.`$campo`";
	}

	private function textoER($texto)
	{	
		//echo strtolower($texto);
		$texto = $this->removeAcentos($texto);
		$texto = $this->addMais($texto);
		return str_replace(array('a', 'e', 'i', 'o', 'u', 'c'), 
						   array('[aãâáàäAÃÂÁÀÄ]', '[eéêèëEÉÊẼÈË]', '[iĩîíìïIÎÎÍÌÏ]', '[oõôóòöOÕÔÓÒÖ]', '[uũûúùüUŨÛÚÙÜ]', '[cçCÇ]'),
						   $texto);
	}

	private function addMais($texto)
	{	
		$retorna = '';

		for($i = 0; $i < strlen($texto); $i++)
			$retorna .= ($i + 1 < strlen($texto)) ? $texto[$i] . '+' : $texto[$i];

		return $retorna; 

	}

	private function removeAcentos($string)
	{	

		$string = mb_strtolower($string, 'UTF-8');

	    $string = preg_replace("/[áàâãä]/u", "a", $string);
	    $string = preg_replace("/[ÁÀÂÃÄ]/u", "a", $string);
	    $string = preg_replace("/[éèê]/u", "e", $string);
	    $string = preg_replace("/[ÉÈÊ]/u", "e", $string);
	    $string = preg_replace("/[íì]/u", "i", $string);
	    $string = preg_replace("/[ÍÌ]/u", "i", $string);
	    $string = preg_replace("/[óòôõö]/u", "o", $string);
	    $string = preg_replace("/[ÓÒÔÕÖ]/u", "o", $string);
	    $string = preg_replace("/[úùü]/u", "u", $string);
	    $string = preg_replace("/[ÚÙÜ]/u", "u", $string);
	    $string = preg_replace("/ç/u", "c", $string);
	    $string = preg_replace("/Ç/u", "c", $string);	
	    
	    return $string;	
	}

}
?>