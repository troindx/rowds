<?php

class ajax extends ViewHelper
{
	//protected $ajaxHelper;
	
	public function __construct__()
	{
		super(); 
	}
	
	public function mainController()
	{	
		$this->view['response'] = "blabla";
		$this->generate();
	}

	public function verifyregistrationController()
	{
		$security = $_GET['security'];
		$mail = $_GET['mail'];
		//Aqui verificamos el registro correcto
		$db = new DatabaseHandler();
		if ( $db->checkSecurityCode($security) != TRUE)
		{
			echo json_encode(-1);
			return;
		}
		$code = $db->insertMail($mail,$security);
		echo json_encode($code);
	}
	
	public function getTemplate()
	{
		return "white";
	}
	

}

?>
