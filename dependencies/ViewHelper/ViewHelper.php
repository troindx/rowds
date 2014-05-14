<?php

use Dependencies\ErrorModule;
use Dependencies\Translator;
class ViewHelper
{
	protected $view;
	protected $errors;
	protected $translator;
	protected $template;
	protected $generated;

	public function getView($controller, $options = null)
	{
		global $template, $action, $view, $name;
		$tmpGET = $_GET;
		if ($options != null)
		{
			foreach ($options as $key => $value)
			{
				$_GET[$key] = $value;
			}
		}
		$controller.='Controller';
		//Guardamos el estado del framework
		$tmpView = $view;
		$tmpName = $name;
		$tmpTemplate = $template;
		$tmpAction = $action;
		//Ejecutamos la acción invocando a su correspondiente controlador
		$action = $controller;
		$this->$controller();
		//Restauramos el estado del framework a como si no se hubiese hecho nada
		$action = $tmpAction;
		$template = $tmpTemplate;
		$view = $tmpView;
		$name = $tmpName;

		$_GET = $tmpGET;
	}

	public static function loadLibrary($lib)
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
		else
		{
			$this->errors->addError($this->translator->trans('NO_LIB'));
		}
	}

	public function __construct()
	{
		$this->errors = new ErrorModule();
		$this->translator = new Translator();
		$this->translator->load(get_class($this));
		$this->template = TEMPLATE_DEFAULT;
		$this->view = new stdClass;
		global $ErrorModule;
		$ErrorModule = $this->errors;
		$generated = 0;
	}
	
	function super() {
		$par = get_parent_class($this);
		$this->$par();
	}
	
	public function getTemplate()
	{
		return $this->template;
	}
	
	public function setTemplate($t)
	{
		$this->template = $t;
	}

	public function defaultController()
	{	
		$this->generate();
	}
	
	public function generate()
	{
		if ($this->errors->hasErrors())
		{
			$this->errors->printErrors();
			exit(10);
			//TODO , this has to be made better on the next iteration
		}
		global $translator, $view, $name, $template, $actionView, $action;
		$view = $this->view;
		$translator = $this->translator;
		$name = get_class($this);
		$template = $this->getTemplate();
		$this->generated = 1;
		if (func_num_args() == 0)
		{
			//Quitamos el "Controller" del nombre.
			//Más rápido que str_replace
			$tmp = substr($action,0, -10);
			$actionView = $tmp."View";
		}
		else
		{
			$actionView = func_get_arg(0);
		}
		include("templates/$template/$template.php");
		
	}

	public function hasBeenGenerated()
	{
		return $this->generated;
	}

	public function preEvent()
	{

	}

	public function postEvent()
	{

	}

}
?>