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
	
	/*
	 * Si die = 0 no hace nada, si die = 1 escupe los errores y muere
	 * si die = 2 los imprime en json y muere
	 */
	public function addError($msg, $die = 0)
	{
		
		$this->errors[$this->number]= $msg;
		$this->number++;
		if ($die == 1)
		{
			$this->printErrors();
			die(10);
		}
		if ($die == 2)
		{
			JSONHandler::sendResponse(0,$this->errors);
			die(10);
		}
	}

	public function addErrorAndDie($msg)
	{
		$this->addError($msg,1);
	}

	public function addErrorAndDieJSON($msg)
	{
		$this->addError($msg,2);
	}
	
	public function getErrors()
	{
		return $errors;
	}
	
	public function printErrors()
	{
		global $Translator;

		echo '<div class="errorContainer"><h1 class="error">'.$Translator->trans('ERROR_IN_ROWDS').'</h1>';
		echo '<p class="errors"> ';
		foreach ($this->errors as $error)
		{
			echo $error;
			echo '<br/>';
		}
		echo '</p></div>';
	}
	
	public function hasErrors()
	{
		if ($this->number) return true;
		else return false;
	}
}

?>