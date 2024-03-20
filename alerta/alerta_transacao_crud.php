<?php
	
	error_reporting(0);

	session_start();		
	
    include '../database.php';
	
    global $pdo;	
	
	$pdo = database::connect();	
	
	if ($_GET["tipoconsultaalerta"] == 'telaprincipal'){
	
		$sql = "select count(1)
				from tratamento.tb_log_alrt
				where id_log_alrt not in (
											select id_log_alrt
											  from tratamento.tb_usua_alrt_manut manut
												 , tratamento.tb_c_usua_acesso acesso
											where manut.cd_usua_acesso = acesso.cd_usua_acesso
											  and acesso.nm_usua_acesso = '".$_SESSION['usuario']."'
											  and (
												   manut.fl_alrt_leitura = 1
												   or 
												   manut.fl_alrt_excluido = 1
												   )
										 ) ";
	}
	
	if ($_GET["tipoconsultaalerta"] == 'pedidotratamento'){
	
		$sql = "select count(1)
				from tratamento.tb_log_alrt
				where id_log_alrt not in (
											select id_log_alrt
											  from tratamento.tb_usua_alrt_manut manut
												 , tratamento.tb_c_usua_acesso acesso
											where manut.cd_usua_acesso = acesso.cd_usua_acesso
											  and acesso.nm_usua_acesso = '".$_SESSION['usuario']."'
											  and (
												   manut.fl_alrt_leitura = 1
												   or 
												   manut.fl_alrt_excluido = 1
												   )
										 )
				and cd_alrt in ('INSERCAO DE PEDIDO DE TRATAMENTO', 'ALTERACAO DE PEDIDO DE TRATAMENTO', 'DELEÇÃO DE PEDIDO DE TRATAMENTO')";
	}
		
    $ret = pg_query($pdo, $sql);
    if(!$ret) {
        echo pg_last_error($pdo);
        exit;
    }
    $row = pg_fetch_row($ret);
	
	echo $row[0];
	
?>