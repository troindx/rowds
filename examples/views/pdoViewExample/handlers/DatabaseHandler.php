<?php

//Middleware para la base de datos, Usa el driver PDO
Class DatabaseHandler
{
	protected $username, $password,$database,$host, $DBODB;
	protected $assassin;

	public function DatabaseHandler()
	{
		$this->host = DBHOST;
		$this->database = DB;
		$this->username = DBUSERNAME;
		$this->password = DBPASSWORD;
		$this->assassin = FALSE;

		$this->DBODB = new PDO("mysql:host=".$this->host.";dbname=".$this->database.";charset=utf8", $this->username, $this->password);
	}

	public function checkSecurityCode($security)
	{
		$stmt = $this->DBODB->prepare("SELECT * FROM users WHERE security=?");
		$stmt->execute(array($security));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if ( $stmt->rowCount() == 1)
		{
			$this->assassin = $rows[0];
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}

	public function getAssassinInfo($code)
	{
		if ($this->assassin)
			return $this->assassin;
		else
			return FALSE;
	}

	public function insertMail($mail,$security)
	{
		$stmt = $this->DBODB->prepare("UPDATE users SET mail=?, security = 0 WHERE security=?");
		$stmt->execute(array($mail,$security));
		$stmt = $this->DBODB->prepare("SELECT code FROM users WHERE mail=?");
		$stmt->execute(array($mail));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows[0]['code'];
		
	}

	public function reportCheater($id, $code)
	{
		$stmt = $this->DBODB->prepare("UPDATE users SET security = ? WHERE id=? and code = ?");
		$stmt->execute(array("tramposo" , $id, $code));
	}

	public function getVictim($id)
	{
		$stmt = $this->DBODB->prepare("SELECT name, info, imageURL FROM users WHERE id = (SELECT victima FROM asesina WHERE id=?)");
		$stmt->execute(array($id));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows[0];
	}

	public function checkLogin($code)
	{
		$stmt = $this->DBODB->prepare("SELECT * FROM users WHERE code=?");
		$stmt->execute(array($code));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if ( $stmt->rowCount() == 1)
		{
			$this->assassin = $rows[0];
			return $this->assassin;
		}
		else 
		{
			return FALSE;
		}
	}

	public function kill($code)
	{
		global $Session;

		//$id es el asesino.
		$id = $Session->get('id');
		$stmt = $this->DBODB->prepare("SELECT id FROM users WHERE code=?");

		$stmt->execute(array($code));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if ( $stmt->rowCount() != 1)
		{
			//si el código no existe
			$stmt = $this->DBODB->prepare("UPDATE users SET count=count +1 WHERE id=?");
			$stmt->execute(array($id));
			return -1;
		}

		$stmt = $this->DBODB->prepare("SELECT id FROM asesina WHERE victima=?");
		$stmt->execute(array($rows[0]['id']));
		$rows2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if ( $rows2[0]['id'] != $id)
		{
			//o pones el que no toca...
			$stmt = $this->DBODB->prepare("UPDATE users SET count=count +1 WHERE id=?");
			$stmt->execute(array($id));
			return -1;
		}

		$stmt = $this->DBODB->prepare("SELECT victima FROM asesina WHERE id=?");
		$stmt->execute(array($rows[0]['id']));
		$rows3 = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$stmt = $this->DBODB->prepare("UPDATE asesina SET killedby=? WHERE id=?");
		$stmt->execute(array($id,$rows[0]['id']));
		$stmt = $this->DBODB->prepare("UPDATE asesina SET victima=? WHERE id=?");
		$stmt->execute(array($rows3[0]['victima'],$id));

		return $this->getVictim($id);
	}

}