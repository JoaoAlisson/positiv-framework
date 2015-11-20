<?php
   
	define('SEPARADOR', DIRECTORY_SEPARATOR);
	define('RAIZ', dirname(__FILE__));

	require RAIZ . SEPARADOR . 'config' . SEPARADOR . 'config.php';
	
    function autoloader ($classe)
    {	
    	$classeArray = explode('\\', $classe);

    	$caminho;

    	if (isset($classeArray[1])) {
            if($classeArray[0] == 'Positiv')
                $caminho = 'libs' . SEPARADOR . $classeArray[1];
            else
                $caminho = lcfirst(str_replace('\\', SEPARADOR, $classe));
    	} else
            $caminho = $classe; 
	   	

	    include_once(RAIZ . SEPARADOR . $caminho . '.php');
    }
   
    spl_autoload_register('autoloader');

	$app = new \Positiv\Bootstrap();

?>