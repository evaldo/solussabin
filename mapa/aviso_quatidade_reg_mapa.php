<?php
	
	//error_reporting(0); 
	
	$pdo = @pg_connect("host=127.0.0.1 port=5432 dbname=solussabin user=postgres password=so1uz!2e");
		
	$sqlqtderegatual = 'SELECT count(1)	FROM tratamento.tb_hstr_obs_pnel_mapa_risco ';		
    $retqtderegatual = pg_query($pdo, $sqlqtderegatual);
    if(!$retqtderegatual) {
        echo pg_last_error($pdo);
        exit;
    }
    $rowqtderegatual = pg_fetch_row($retqtderegatual);
	
	
	$sqlqtdereganterior = 'SELECT nu_rgtr_trtmto_antr FROM tratamento.tb_param_trtmto ';		
    $retqtdereganterior = pg_query($pdo, $sqlqtdereganterior);
    if(!$retqtdereganterior) {
        echo pg_last_error($pdo);
        exit;
    }
    $rowqtdereganterior = pg_fetch_row($retqtdereganterior);
	
	if ($rowqtderegatual[0] > $rowqtdereganterior[0]){
	
		$sql = "update tratamento.tb_param_trtmto set nu_rgtr_trtmto_antr = ".$rowqtderegatual[0]. " ";			
		$result = pg_query($pdo, $sql);
		if($result){
			echo "";
		} 	
		
		$qtderegsinseridos = $rowqtderegatual[0] - $rowqtdereganterior[0];
		
		echo "Mapa de Tratamento - <img src='../img/alarm.gif' alt='".$qtderegsinseridos." inseridos'  width='50' />";
	} else {
		echo "Mapa de Tratamento";
	}
	
?>