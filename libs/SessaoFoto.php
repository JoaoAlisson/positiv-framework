<?php
namespace Positiv;
class SessaoFoto implements \SessionHandlerInterface {

    private $savePath;

	private function apagaFoto()
	{
		$foto = Sessao::pegar('foto');
		$caminho = PASTA_IMAGENS . 'sessao' . SEPARADOR . $foto;
		if ($foto != '')
			if (file_exists($caminho))
				unlink($caminho);
	
	}    

    public function open($savePath, $sessionName)
    {
        $this->savePath = $savePath;
        if (!is_dir($this->savePath)) {
            mkdir($this->savePath, 0777);
        }     

        return true;
    }

    private function atualizarDataFoto()
    {   
        $caminho = session_save_path() . SEPARADOR . 'sess_' . Sessao::pegar('foto');
        touch($caminho);
    }    

    public function close()
    {   
        return true;
    }

    public function read($id)
    {   
        $this->touchFoto();

        $this->gc(1440);

        return (string)@file_get_contents("$this->savePath/sess_$id");
    }

    public function write($id, $data)
    {
        $this->touchFoto();

        return file_put_contents("$this->savePath/sess_$id", $data) === false ? false : true;
    }

    public function destroy($id)
    {   
        $this->apagaFoto();

        $file = "$this->savePath/sess_$id";
        if (file_exists($file)) {
            unlink($file);
        }

        return true;
    }

    private function touchFoto()
    {
        $foto = Sessao::pegar('foto');
        if($foto != '')
            $this->atualizarDataFoto();       
    }

    public function deletarGc($arquivo)
    {   
       // echo 'teste';
        $string = (string)@file_get_contents($arquivo);
        $array = Sessao::unserialize_session($string);

        if(isset($array['foto']))
            if($array['foto'] != '') {
                $caminho = PASTA_IMAGENS . 'sessao' . SEPARADOR . $array['foto'];
                if (file_exists($caminho))
                    unlink($caminho);
            }
    }

    public function gc($maxlifetime)
    {   
        $sess = system("ls $this->savePath/sess_$id");
        $arquivos = implode(' ', $sess);


        foreach (glob($this->savePath . '/sess_*') as $file) {

            $this->deletarGc($file);
            if (filemtime($file) + $maxlifetime < time() && file_exists($file)) {
                $this->deletarGc($file);
                unlink($file);
            }
        }

        return true;
    }
}
?>