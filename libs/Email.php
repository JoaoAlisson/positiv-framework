<?php
namespace Positiv;

class Email 
{
	function __construct($email, $assunto, $texto)
	{
		if($email && $assunto && $texto)
			$this->enviar($email, $assunto, $texto);
	}

	function enviar($email, $assunto, $texto)
	{	

		$headers  = "From: Lucrativa <curriculos@lucrativia.com.br>\r\n";

		$headers .= "Organization: Lucrativa\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "X-Priority: 3\r\n";

		$assunto = '=?UTF-8?B?'.base64_encode($assunto).'?=';

		$texto = "<html><body>$texto</body></html>";
		mail($email, $assunto, $texto, $headers);
	}
}