<?php
namespace Dependencies;
Class Translator 
{
	protected $language;
	protected $strings;

	public function __construct()
	{

		if (isset($_COOKIE['language']))
		{
			$this->language = $_COOKIE['language'];
		}

		else if (isset($_SESSION['language']))
		{
			$this->language = $_SESSION['language'];
		}

		else 
		{
			$this->language = DEFAULT_LANGUAGE;
		}

	}

	public function setLanguage($lang)
	{
		$this->language = $lang;
		$_SESSION['language'] = $this->language;
		setcookie("language", $this->language, time()+8513600); 
	}

	public function getLanguage()
	{
		return $this->language;
	}

	public function load($route)
	{
		$tmp = $this->language;
		if (is_file("lang/$tmp/$route.php"))
		{
			include("lang/$tmp/$route.php");
			$this->strings = $var_strings;
		}
		else $this->strings = null;
		
	}

	public function trans($key)
	{
		return $this->strings[$key];
	}

}