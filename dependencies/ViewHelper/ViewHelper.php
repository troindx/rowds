<?php

use Dependencies\ErrorModule;
use Dependencies\Translator;
class ViewHelper
{
	protected $view;
	protected $errors;
	protected $translator;
	protected $template;

	public function getView()
	{
		return $this->view;
	}

	public function setView($v)
	{
		$this->view = $v;
	}
	
	public function __construct()
	{
		$this->errors = new ErrorModule();
		$this->translator = new Translator();
		$this->translator->load(get_class($this));
		$this->template = "default";
		$this->view = new stdClass;
		global $ErrorModule;
		$ErrorModule = $this->errors;
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
		global $translator, $view, $name, $template, $actionView;
		$view = $this->view;
		$translator = $this->translator;
		$name = get_class($this);
		$template = $this->getTemplate();
		if (func_num_args() == 0)
		{
			$actionView = $name."View";
		}
		else
		{
			$actionView = func_get_arg(0);
		}
		include("templates/$template/$template.php");
		
	}

	public function preEvent()
	{

	}

	public function postEvent()
	{

	}

}
?>