<?
class Session
{
	public function __construct()
	{
		Session_start();
		if (!isset($_SESSION['login']) )
		{
			$_SESSION['login'] = 'anon';
		}
	}
	
	public function start()
	{
		Session_start();	
	}
	
	public function get($key)
	{
		if (isset($_SESSION[$key]))
			return $_SESSION[$key];
		else
			return false;
	}

	public function set($key,$value)
	{
		return $_SESSION[$key] = $value;
	}
	
	public function checkAnon()
	{
		if ( !strcmp($_SESSION['login'] ,'anon') )
		{
			return true;
		}
		return false;
	}

}

?>