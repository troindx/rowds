<?php 
namespace Dependencies;
class ErrorModule
{
	protected $number;
	protected $errors;
	
	public function __construct()
	{
		$this->errors = array();
		$this->number = 0;
	}

	public function getNumber()
	{
		return $number;
	}
	
	public function addError($msg)
	{
		
		$this->errors[$this->number]= $msg;
		$this->number++;
	}
	
	public function getErrors()
	{
		return $errors;
	}
	
	public function printErrors()
	{
		echo '<p class="errors"> ';
		foreach ($this->errors as $error)
		{
			echo $error;
			echo '<br/>';
		}
		echo '</p>';
	}
	
	public function hasErrors()
	{
		if ($this->number) return true;
		else return false;
	}
}

?>