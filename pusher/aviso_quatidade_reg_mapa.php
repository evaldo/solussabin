<?php
	
	//error_reporting(0); 
	
	$pdo = @pg_connect("host=127.0.0.1 port=5433 dbname=solus user=postgres password=so1uz!2e");
		
	$sql = 'SELECT count(1)	FROM tratamento.tb_log_alrt ';
		
    $ret = pg_query($pdo, $sql);
    if(!$ret) {
        echo pg_last_error($pdo);
        exit;
    }
    $row = pg_fetch_row($ret);
	
	echo $row[0];
	
?>