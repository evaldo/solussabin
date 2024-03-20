<?php

include 'config.php';

class database
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
				if(isset($_SESSION['usuario']))
				{
					self::$pg = @pg_connect("host=".Config::$dbHost." port=".Config::$dbPort." dbname=solussabin user=".$_SESSION['usuario']. " password=".$_SESSION['senha']."");
				}				
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

}
?>