<?php

include 'config.php';

class conexao
{
    private static $pg;

    public function __construct()
    {
        die('Init function is not allowed');
    }

    public static function connect()
    {
        if ( null == self::$pg )
        {
            try
            {
				if(isset($_POST["usuario"]) and isset($_POST["senha"]))
				{
					self::$pg = @pg_connect("host=".Config::$dbHost." port=".Config::$dbPort." dbname=solussabin user=" .$_POST["usuario"]. " password=".$_POST["senha"]."") ;
					
				}
				session_start();
				
				$_SESSION['usuario']=$_POST["usuario"];
				$_SESSION['senha']=$_POST['senha'];	

				
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
        }
        return self::$pg;
    }

    public static function disconnect()
    {
        return @pg_close(self::$pg);
    }
	
	public static function getUserIP()
	{
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];

		if(filter_var($client, FILTER_VALIDATE_IP))
		{
			$ip = $client;
		}
		elseif(filter_var($forward, FILTER_VALIDATE_IP))
		{
			$ip = $forward;
		}
		else
		{
			$ip = $remote;
		}

		return $ip;
	}

}
?>