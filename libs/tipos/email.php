<?php
namespace libs\tipos;

class email extends Tipos
{	
	function validacao ()
	{			

		$email = $this->trata_valor_para_salvar();
		//verifica se e-mail esta no formato correto de escrita
		if (!ereg('^([a-zA-Z0-9.-_])*([@])([a-z0-9]).([a-z]{2,3})', $email))
		{
			array_push($this->errosValidacao, 'E-mail Inválido');
			return false;
	    }
	    else
	    {

			//Valida o dominio
			$dominio=explode('@',$email);
			if(!checkdnsrr($dominio[1],'A')){
				array_push($this->errosValidacao, 'E-mail Inválido');
				return false;
			}
			else 
				return true; 
			
		}

	}		
}
?>