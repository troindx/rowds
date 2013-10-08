<?
class Session
{
	public function __construct()
	{
		session_start();
		if (!isset($_SESSION['AUTH_TOKEN']) )
		{
			$_SESSION['AUTH_TOKEN'] = AUTH_TOKEN_DEFAULT;
		}
	}
	
	public function start()
	{
		session_start();	
	}

	public function end()
	{

		// Unset all of the session variables.
		$_SESSION = array();

		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (ini_get("session.use_cookies")) 
		{
		    $params = session_get_cookie_params();
		    setcookie(session_name(), '', 100);
		}

		// Finally, destroy the session.
		session_destroy();
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