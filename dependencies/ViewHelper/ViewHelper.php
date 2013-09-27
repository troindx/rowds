<?php
global $view;
global $translator;
global $name;
global $actionView;
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
	
	public function generate($file ='view')
	{
		if ($this->errors->hasErrors())
		{
			$this->errors->printErrors();
			die();
			//TODO , this has to be made better on the next iteration
		}
		$view = $this->view;
		$translator = $this->translator;
		$name = get_class($this);
		$template = $this->getTemplate();
		$actionView = $file;
		include("templates/$template/$template.php");
		
	}

}
?>