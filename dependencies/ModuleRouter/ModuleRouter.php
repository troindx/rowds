<?php 
class ModuleRouter
{
	public function loadRoute()
	{
		if (isset($_GET["option"]))
		{
			$variable = $_GET["option"];
			if (file_exists("modules/$variable/$variable"."Controller.php"))
			{
				
				return $variable;
			}
			else
			{
				
				return MODULE_NOT_FOUND;
			}
		}
		else
		{
			
			return MODULE_DEFAULT;
		}
	}
	
public function loadAction($m)
	{
		if (isset($_GET["action"]))
		{
			$variable = $_GET["action"];
			if (method_exists($m,$variable."Controller"))
			{
				
				return $variable.'Controller';
			}
			else
			{
				
				return ACTION_DEFAULT."Controller";
			}
		}
		else
		{
			return ACTION_DEFAULT."Controller";
		}
	}
}
?>