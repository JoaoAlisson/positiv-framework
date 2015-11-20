<?php
namespace Positiv;

class HTML
{
	public $nomesCampos      = array();
	public $tiposCampos      = array();
	public $obrigatorios     = array();
	public $errosDeValidacao = array();

	function __construct (&$nomesCampos, &$tiposCampos, &$obrigatorios, &$errosDeValidacao)
	{	
		$this->nomesCampos      = $nomesCampos;
		$this->tiposCampos      = $tiposCampos;
		$this->obrigatorios     = $obrigatorios;
		$this->errosDeValidacao = $errosDeValidacao;
	}

	function formulario ($id = '')
	{
		echo "<script type='text/javascript'>
				$(document).ready(function(){ 
					$('.ui.selection.dropdown').dropdown(); 
					$('.ui.dropdown').dropdown(); 
				});
			  </script>
		<form action='' enctype='multipart/form-data' class='ui form formulario' id='$id' method='POST'>";
	}	

	function formularioFim ()
	{
		echo '</form>';
	}	

	function submeter($controler = null, $visao = null, $nomeBotao = null, $icone = null, $id = 'submeter', $idForm = '')
	{

		$controle  = isset($controle)  ? $controller : CONTROLE;
		$visao     = isset($visao)     ? $visao      : VISAO;
		$nomeBotao = isset($nomeBotao) ? $nomeBotao  : 'Cadastrar';
		$icone 	   = isset($icone)     ? $icone      : 'save';

		echo    "<input type='text' name='enviado' hidden />
				 <div class='ui green vertical labeled icon submit button submeterForm' id='$id' style='margin-top:10px;' onClick=\"$('.formulario').submit();\">
					<i class='$icone icon'></i>$nomeBotao
				 </div>";
	}

	function campoFiltro ($campo, $valor = '', $icone = 'pencil', $id = null)
	{
		$this->campo($campo, $valor, $icone, $id, true);
	}

	function campo ($campo, $valor = '', $icone = 'pencil', $id = null, $filtro = false)
	{	
		$campoClass  = $this->pegaTipo($campo);

		$id          = ($id) ? $id : $campo;

		if (!empty($this->errosDeValidacao))
			$valor = isset($_POST[$id]) ? $_POST[$id] : '';

		if (isset($this->errosDeValidacao[$campo]))
			$campoClass->errosValidacao = $this->errosDeValidacao[$campo];
			

		$nome        = $this->nomesCampos[$campo];
		$obrigatorio = ($filtro) ? false : in_array($campo, $this->obrigatorios);
		

		$campoClass->setaCampo($nome, $valor, $obrigatorio);

		echo $campoClass->campoCompleto($icone, $id, $filtro);
	}

	function campoVisualizar ($campo, $valor)
	{
		$campoClass = $this->pegaTipo($campo);
		$campoClass->setaValor($valor);
		$valor = $campoClass->trata_valor_para_mostrar();
		$nome  = $this->nomesCampos[$campo];

		echo   "<div class='' style='float: left; margin:6px; width: auto; min-width:100px; color: #706d6d; border-color: #c6c2c2 !important; border-radius: 5px; border-bottom: 2px solid;'>
				    <h4>$nome</h4><p>$valor</p>
			    </div>";
	}

	private function pegaTipo ($campo)
	{	
		$tipoFabrica = new TipoFabrica();

		$tipo = $this->tiposCampos[$campo];	

		return $tipoFabrica->pegaTipo($tipo);
	}

	function iniciarTabela ()
	{
		echo "<table class='ui table segment' id='tabelaListagem' style='width:auto;'>";
	}

	function finalizarTabela ()
	{
		echo '</tbody></table>';
	}	

	function iniciarCabecalho ()
	{
		echo '<thead><tr>';
	}

	function finalizarCabecalho ()
	{
		echo '</tr></thead><tbody id=\'listagem\'>';
	}	

	function iniciarLinha ($id = '')
	{	
		$id = ($id != '') ? " id='$id'" : '';
		echo "<tr{$id}>";
	}

	function finalizarLinha ()
	{
		echo '</tr>';
	}

	function celula ($texto = '')
	{
		echo "<td>$texto</td>";
	}

	function titulo ($titulo = '')
	{
		echo "<th>$titulo</th>";
	}
}
?>