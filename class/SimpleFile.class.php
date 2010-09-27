<?php 
class SimpleFile 
{   
	var $archivo;
	var $archivo_type;
	var $archivo_name;
	var $archivo_name_out;
	var $archivo_size;
	var $archivo_tmp_name;
	var $archivo_ext;
	
	function SimpleFile()
	{
		$this->archivo = NULL;
		$this->archivo_type = NULL;
		$this->archivo_name = NULL;
		$this->archivo_name_out = NULL;
		$this->archivo_size = NULL;
		$this->archivo_tmp_name = NULL;
		$this->archivo_ext = NULL;
	}
	function setCopyFile($archivo)
	{
		$this->archivo = $archivo;
		$this->archivo_type = $archivo['type'];
		$this->archivo_name = $archivo['name'];
		$this->archivo_size = $archivo['size'];
		$this->archivo_tmp_name = $archivo['tmp_name'];
		$this->archivo_ext = $this->getExtension();
	}
	function getExtension()
	{
		return strtolower(end(explode(".",$this->archivo_name)));
	}
	function setFileName($nombre)
	{
		$this->archivo_name_out = $nombre.'.'.$this->archivo_ext;
	}
	function copyFileTo($ruta)
	{
		if(!copy($this->archivo_tmp_name,$ruta.$this->archivo_name_out))
		{
			echo 'Error al copiar el archivo. '.$ruta.$this->archivo_name_out;
		}
	}
	function getFileName()
	{
		return $this->archivo_name_out;
	}
    function getFileSize()
    {
        return $this->archivo_size;
    }
}
?>