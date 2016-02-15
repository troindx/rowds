<?php

class AutoLoader
{
	var $route = null;
	var $action = null;
	var $scripts = null;
	
	public function getRoute()
	{
		return $this->route;
	}
	
	public function getAction()
	{
		return $this->action;
	}
	
	public function setRoute($r)
	{
		$this->route = $r;
	}
	
	public function setAction($a)
	{
		$this->action = $a;
	}
	
	public function loadDir($dir)
	{
		$classes = scandir ($dir);
		$bad = array(".", "..", ".DS_Store", "_notes", "Thumbs.db","index.html");
		$classes = array_diff($classes, $bad);
		foreach ($classes as $class)
		{	
			if(is_dir("$dir/".$class))
			{		
				if ($class[0]!='.' && !is_dir($class))
				{			
					require_once ("$dir/$class/$class.php");
				}
			}
		}
	}
	
	public function loadHandlers($dir)
	{
		$classes = scandir ($dir);
		$bad = array(".", "..", ".DS_Store", "_notes", "Thumbs.db","index.html");
		$classes = array_diff($classes, $bad);
		foreach ($classes as $class)
		{
			if ($class[0]!='.' && !is_dir($class))
			{
				
				require_once ("$dir/$class");
			}
			
		}
	}
	
	public function loadScripts($view)
	{
		if (is_dir("modules/$view/js/common"))
		{
			$this->scripts = scandir ("modules/$view/js/common");
			$bad = array(".", "..", ".DS_Store", "_notes", "Thumbs.db","index.html");
			$this->scripts = array_diff($this->scripts, $bad);
		}
		else $this->scripts = null;
	}

	public function printScripts($view)
	{
		if ($this->scripts != null)
		{
			
			foreach($this->scripts as $script)
			{
				echo "<script language='javascript' src='".BASE_URL."modules/$view/js/common/$script'></script>";
			}
		}
		global $action;
		if (is_file("modules/$view/js/$action.js"))
		{
			echo "<script language='javascript' src='".BASE_URL."modules/$view/js/$action.js'></script>";
		}
	}

	public function printJSController($view)
	{
		global $action;
		if (is_file("modules/$view/js/$action.js"))
		{
			echo "<script language='javascript' src='".BASE_URL."modules/$view/js/$action.js'></script>";
		}
	}

	public static function loadLibrary($lib, $autoloader= null )
	{
		if (file_exists("libraries/$lib/$lib".".php"))
		{
			global $loader;
			if(is_dir("libraries/$lib/handlers"))
			{
				$loader->loadHandlers("libraries/$lib/handlers");
			}
			require_once("libraries/$lib/$lib".".php");
		}
		else if ($autoloader != null)
		{
			if (file_exists("libraries/$lib/$autoloader".".php"))
			{
				global $loader;
				if(is_dir("libraries/$lib/handlers"))
				{
					$loader->loadHandlers("libraries/$lib/handlers");
				}
				require_once("libraries/$lib/$autoloader".".php");
			}
		}
		else
		{
			
			if (array_key_exists('ErrorModule', $GLOBALS) && array_key_exists('Translator', $GLOBALS))
			{
				global $ErrorModule, $Translator;
				$ErrorModule->addErrorAndDie($Translator->trans('NO_LIB'));
			}
		}
	}
}


?>
