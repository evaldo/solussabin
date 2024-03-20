<?php

//include 'config.php';

class conexao_sqlserver
{
    private static $sqlserver;

    public function __construct()
    {
        die('Init function is not allowed');
    }

    public static function connectSqlServer()
    {
		
		$serverName = "52.67.44.208, 1433";
		$connectionInfo = array( "Database"=>"Sd_ClinVilaVerde", "UID"=>"vilaverde", "PWD"=>"*!zEtRebe6hA");
		$sqlserver = sqlsrv_connect( $serverName, $connectionInfo);
		
        if ( $sqlserver )
        {
			return $sqlserver;           				
        } else {
			echo "<div class=\"alert alert-warning alert-dismissible\">
				<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
				<strong>Erro de Conexão!</strong> Não foi possível conectar no Sistema de Prontuário Médico.</div>";
            die( print_r( sqlsrv_errors(), true));			
        }
        
    }

    public static function disconnectSqlServer()
    {
        return $sqlserver=null; 
	}
	
}
?>