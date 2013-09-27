<?php

class main extends ViewHelper
{
	
	public function mainController()
	{
		//This loads the main page
		$this->generate();
	}

	public function registerController()
	{
		if (!isset($_GET['k']))
		{
			$this->errors->addError($this->translator->trans('NOACCESS'));
		}
		$var = $_GET['k'];
		if (strlen($var) > 13 )
		{
			$this->errors->addError($this->translator->trans('HACK_ATTEMPT'));
		}

		$db = new DatabaseHandler();
		if ( $db->checkSecurityCode($var) != TRUE)
		{
			$this->errors->addError($this->translator->trans('NO_USER'));
		}
		$assassin = $db->getAssassinInfo($var);
		if (!$assassin)
		{
			$this->errors->addError($this->translator->trans('NO_USER'));
		}
		$this->view->mail = $assassin['mail'];
		$this->view->info = $assassin['info'];
		$this->view->name = $assassin['name'];
		$this->view->imageURL = $assassin['imageURL'];

		$this->generate('register');
	}

	public function loginController()
	{

		if (!isset($_GET['code']))
		{
			json_encode(-1);
			return;
		}
		$var = $_GET['code'];
		$db = new DatabaseHandler();
		$tmp = $db->checkLogin($var);
		if ( !$tmp)
		{
			echo json_encode(-1);
			return;
		}
		else
		{
			global $Session;
			$Session->set('login',$tmp['name']);
			$Session->set('id',$tmp['id']);
			$Session->set('code',$tmp['code']);
			echo json_encode($tmp);
			return;
		}
	}

	public function getVictimsController()
	{
		global $Session;
		if (!isset($_GET['code']) || !isset($_GET['id']))
		{
			echo json_encode(-1);
			return;
		}
		$code = $_GET['code'];
		$id = $_GET['id'];
		if ($Session->get('id') == $id && $Session->get('code') == $code)
		{
			$db = new DatabaseHandler();
			$tmp = $db->getVictim($id);
			echo json_encode($tmp);
			return;
		}

	}

	public function killController()
	{
		global $Session;
		if(!isset($_GET['code']))
		{
			echo json_encode(-1);
			return;
		}
		$code = $_GET['code'];
		$db = new DatabaseHandler();
		echo json_encode($db->kill($code));
	}

	public function reportCheaterController()
	{
		if(isset($_GET['id']) && isset($_GET['code']) )
		{
			$db = new DatabaseHandler();
			$db->reportCheater($_GET['id'], $_GET['code']);
			return;
		}
	}
	
}

?>
