<?php

	session_start();

	include '../database.php';

	error_reporting(0);

	header('Content-Type: application/json; charset=utf-8');

	global $pdo;

	$pdo = database::connect();

	$mensagemErro = "Pedido não pode ser inserido. Status de fluxo inicial de tratamento por equipe desconfigurado.";

	if ($pdo == null) {
		echo json_encode(array('valido' => false, 'mensagem' => 'Não foi possível conectar ao banco de dados.'), JSON_UNESCAPED_UNICODE);
		exit;
	}

	$sql = "SELECT 
			   status_trtmto.id_equipe
			 , equipe.ds_equipe
			 , equipe.nu_seq_equipe_pnel
			 , status_trtmto.id_status_trtmto	 
			 , status_trtmto.ds_status_trtmto
			 , status_trtmto.cd_cor_status_trtmto	
		FROM tratamento.tb_c_status_trtmto status_trtmto
		   , tratamento.tb_c_equipe equipe
		WHERE equipe.id_equipe = status_trtmto.id_equipe				  
		  and status_trtmto.fl_ativo = 1
		  and status_trtmto.fl_status_inicial_trtmto = 1
		ORDER BY equipe.nu_seq_equipe_pnel ";

	$ret = pg_query($pdo, $sql);

	if (!$ret) {
		echo json_encode(array('valido' => false, 'mensagem' => 'Erro ao validar o status de fluxo inicial de tratamento.'), JSON_UNESCAPED_UNICODE);
		exit;
	}

	$qtdStatusInicial = pg_num_rows($ret);

	if ($qtdStatusInicial < 6) {
		echo json_encode(array('valido' => false, 'mensagem' => $mensagemErro), JSON_UNESCAPED_UNICODE);
	} else {
		echo json_encode(array('valido' => true, 'mensagem' => ''), JSON_UNESCAPED_UNICODE);
	}

?>
