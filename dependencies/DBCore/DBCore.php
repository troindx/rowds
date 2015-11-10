<?php
//Middleware para la base de datos, Usa el driver PDO,
// Core, del que saldrán todos los demás DBHandlers
$DBODB_GLOBAL = NULL;
Class DBCore
{
	protected $username, $password,$database,$host, $DBODB;

	public function __construct()
	{
		global $DBODB_GLOBAL;
		$this->host = DBHOST;
		$this->database = DB;
		$this->username = DBUSERNAME;
		$this->password = DBPASSWORD;
		if  ( NULL === $DBODB_GLOBAL )
		{	
			$this->DBODB = new PDO("mysql:host=".$this->host.";dbname=".$this->database.";charset=utf8", $this->username, $this->password);
			$this->DBODB->exec("set names utf8");
			$DBODB_GLOBAL = $this->DBODB;
		}
		else
		{
			$this->DBODB = $DBODB_GLOBAL;
		}
	}
}