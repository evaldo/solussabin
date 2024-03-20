<?php
	
	class Config 
	{
			
		static $dbHost = 'localhost';
		static $dbPort = '5432';
		static $webServer = 'Location: http://192.168.1.250:8192/solussabin/index.php';		
		static $webLogin = 'Location: http://192.168.1.250:8192/solussabin/login.php';	
		static $webLogout = 'Location: http://192.168.1.250:8192/solussabin/logout.php';	
		
		static $destroy="N";
		
		public static function destroy()
		{
			$destroy="S";
		}
		
	}
?>