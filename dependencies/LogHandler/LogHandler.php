<?php

Class LogHandler
{
	
    /**
	 * Escribe lo que le pasen a un archivo de logs
	 * @param string $cadena texto a escribir en el log
	 * @param string $tipo texto que indica el tipo de mensaje. Los valores normales son Info, Error,  
	 *                                       Warn Debug, Critical... pero se le puede poner cualquier valor.
	 */
	public static function log($cadena,$tipo)
	{
		$arch = fopen(realpath( '.' )."/logs/log_".date("Y-m").".txt", "a+"); 

		fwrite($arch, "[".date("Y-m-d H:i:s.u")." ".$_SERVER['REMOTE_ADDR']." - $tipo ] ".$cadena."\n");
		fclose($arch);
	}
}