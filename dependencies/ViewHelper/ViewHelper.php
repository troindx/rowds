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
		global $template, $action, $view, $name, $DBODB_GLOBAL;
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
		$tmpDBODB_GLOBAL = $DBODB_GLOBAL;
		//Restart the DBODBGlobal for PDO transacts
		$DBODB_GLOBAL = NULL;
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
		//RESTORE the DBODBGlobal Object for PDO
		$DBODB_GLOBAL = $tmpDBODB_GLOBAL;

		$_GET = $tmpGET;
	}

	public function __construct()
	{
		$this->errors = new ErrorModule();
		$this->translator = new Translator();
		$this->translator->load(get_class($this));
		$this->template = TEMPLATE_DEFAULT;
		$this->view = new stdClass;
		global $ErrorModule;
		global $Translator;
		$Translator = $this->translator;
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