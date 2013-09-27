<?php

Class DBConn 
{
	protected $username, $password,$database,$host, $DBODB;

	public function __construct($host,$db,$user,$pw)
	{
		$this->host = DBHOST;
		$this->database = DB;
		$this->username = DBUSERNAME;
		$this->password = DBPASSWORD;

		$this->DBODB = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pw);
	}



}