<?php
class Session
{
	public function __construct()
	{
		//session_set_cookie_params(DEFAULT_SESSION_TIME);
		session_start();
		if (!isset($_SESSION['AUTH_TOKEN']) )
		{
			$_SESSION['AUTH_TOKEN'] = AUTH_TOKEN_DEFAULT;
		}
		//Esto altera la cookie ya enviada con el session_start() . asi supuestamente es la forma correcta.
		//Porque el session_set_cookie_params solo altera el script en T.ejec y no la cookie en si
		// nose, puta mierda...
		setcookie(session_name(),session_id(),time()+DEFAULT_SESSION_TIME,'' ,BASE_URL);
	}
	
	public function start()
	{
		//session_set_cookie_params(DEFAULT_SESSION_TIME);
		session_start();	
		setcookie(session_name(),session_id(),time()+DEFAULT_SESSION_TIME,'', BASE_URL);
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
