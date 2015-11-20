<?php 
namespace Positiv;
class Sessao
{

	public static function iniciar()
	{
		$handler = new SessaoFoto();

		session_set_save_handler($handler, true);

		// the following prevents unexpected effects when using objects as save handlers
		register_shutdown_function('session_write_close');		

		session_cache_expire(10);
		session_name(md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
		@session_start();		
	}

	public static function inserir($key, $valor)
	{
		$_SESSION[$key] = $valor;
	}

	public static function pegar($campo)
	{
		if(isset($_SESSION[$campo]))
			return $_SESSION[$campo];
	}

	public static function destruir(){
		session_destroy();
	} 

	public static function unserialize_session($val) {
	  $result = array();
	  
	  // prefixing with semicolon to make it easier to write the regular expression
	  $val = ';' . $val;
	  
	  // regularexpression to find the keys
	  $keyreg = '/;([^|{}"]+)\|/';
	  
	  // find all keys
	  $matches = array();
	  preg_match_all($keyreg, $val, $matches);
	  
	  // only go further if we found some keys
	  if (isset($matches[1])) {
	    $keys = $matches[1];
	    
	    // find the values by splitting the input on the key regular expression
	    $values = preg_split($keyreg, $val);
	    
	    // unshift the first value since it's always empty (due to our semicolon prefix)
	    if (count($values) > 1) {
	      array_shift($values);
	    }
	    
	    // combine the $keys and $values
	    $result = array_combine($keys, $values);
	  }
	  
	  return $result;
	}	
}
?>