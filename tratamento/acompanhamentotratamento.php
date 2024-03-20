<?php
	
	session_start();		
	
    include '../database.php';
    $pdo = database::connect();
	
	error_reporting(0); 	
		
	$textoconsulta = "";
	$retSqlServer = "";
	$sql = '';
	
		
	//$sql ="select * from tratamento.vw_painel_trtmto order by id_hstr_pnel_solic_trtmto DESC";
		
	$sql ="select distinct * from tratamento.vw_painel_trtmto_altr_pddo painel
			where tempo_ordenacao_pedido in (select min(tempo_ordenacao_pedido)
								 from tratamento.vw_painel_trtmto_altr_pddo
								 where id_hstr_pnel_solic_trtmto = painel.id_hstr_pnel_solic_trtmto) 
			order by tempo_ordenacao_pedido";
			
	$ret = pg_query($pdo, $sql);
	
	if(!$ret) {
		echo pg_last_error($pdo);		
		exit;
	}
	
	if(isset($_POST['inserestatus'])){					
		
		if ($pdo==null){
			header(Config::$webLogin);
		}
		
		try
		{
		
			
			$sql = "select count(1) from tratamento.tb_c_equipe_usua where id_equipe = ".$_POST['id_equipe']." and cd_usua_acesso = (SELECT cd_usua_acesso FROM tratamento.tb_c_usua_acesso where nm_usua_acesso = '".$_SESSION['usuario']."') ";
				
			//echo $sql;

			$retequipeusua = pg_query($pdo, $sql);
			
			if(!$retequipeusua) {
				echo pg_last_error($pdo);		
				exit;
			}
			
			$rowequipeusua = pg_fetch_row($retequipeusua);
			
			if ($rowequipeusua[0]==0 && $_SESSION['fl_sist_admn']=='N'){
				echo "<div class=\"alert alert-warning alert-dismissible\">
						<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
						<strong>Atenção!</strong> Usuário não pode manter o status para esta equipe.	</div>";
			} else {			
			
			
				$sql = "select count(1) from tratamento.tb_c_status_trtmto where id_status_trtmto = ".$_POST['id_status_trtmto']." and id_equipe = ".$_POST['id_equipe']." ";
					
				//echo $sql;

				$retstatusequipe = pg_query($pdo, $sql);
				
				if(!$retstatusequipe) {
					echo pg_last_error($pdo);		
					exit;
				}
				
				$rowstatusequipe = pg_fetch_row($retstatusequipe);
				
				if ($rowstatusequipe[0]==0){
					echo "<div class=\"alert alert-warning alert-dismissible\">
							<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
							<strong>Atenção!</strong> Inserção não realizada. Selecione o status para Equipe correta.</div>";
				
				} else {
					$sql = "SELECT MAX(id_hstr_obs_pnel_solic_trtmto) FROM tratamento.tb_hstr_obs_pnel_solic_trtmto WHERE cd_pcnt = '".$_POST['cd_pcnt']."' and id_status_equipe = ".$_POST['id_equipe']." ";
						
					//echo $sql;

					$retmaxstatusequipe = pg_query($pdo, $sql);
					
					if(!$retmaxstatusequipe) {
						echo pg_last_error($pdo);		
						exit;
					}
					
					$rowmaxstatusequipe = pg_fetch_row($retmaxstatusequipe);
					
					$sql = "SELECT count(1) FROM tratamento.tb_hstr_pnel_solic_trtmto WHERE cd_pcnt = '".$_POST['cd_pcnt']."' and id_equipe = ".$_POST['id_equipe']." and id_status_trtmto = ".$_POST['id_status_trtmto']." and fl_trtmto_fchd = 0 ";
					
					//echo $sql;

					$rethstrobs = pg_query($pdo, $sql);
					
					if(!$rethstrobs) {
						echo pg_last_error($pdo);		
						exit;
					}
					
					$rowhstrobs = pg_fetch_row($rethstrobs);
					
					if ($rowhstrobs[0]==0){
							
						$sql = "SELECT id_hstr_pnel_solic_trtmto, dt_inicial_trtmto 
								  FROM tratamento.tb_hstr_pnel_solic_trtmto 
								WHERE cd_pcnt = '".$_POST['cd_pcnt']."' and id_equipe = ".$_POST['id_equipe']." and fl_trtmto_fchd = 0 ";
						
						//echo $sql;

						$rethstrtratamento = pg_query($pdo, $sql);
						
						if(!$rethstrtratamento) {
							echo pg_last_error($pdo);		
							exit;
						}
						
						$rowhstrtratamento = pg_fetch_row($rethstrtratamento);
						
						$id_hstr_pnel_solic_trtmto = $rowhstrtratamento[0];
						$dt_inicial_trtmto = $rowhstrtratamento[1];
						
						$sql = "update tratamento.tb_hstr_pnel_solic_trtmto set ds_utlma_obs_pcnt = upper('".$_POST['ds_obs_pcnt']."'), id_status_trtmto = ".$_POST['id_status_trtmto'].", ds_status_trtmto = (select ds_status_trtmto from tratamento.tb_c_status_trtmto where id_status_trtmto = ".$_POST['id_status_trtmto']."), cd_cor_status_trtmto = (select cd_cor_status_trtmto from tratamento.tb_c_status_trtmto where id_status_trtmto = ".$_POST['id_status_trtmto']."), cd_usua_altr = '".$_SESSION['usuario']."', dt_altr = current_timestamp where id_hstr_pnel_solic_trtmto = ".$id_hstr_pnel_solic_trtmto."";
						
						//echo $sql;

						$result = pg_query($pdo, $sql);

						if($result){
							echo "";
						}
						
						$sql = "insert into tratamento.tb_log_alrt (id_log_alrt, cd_alrt, ds_alrt, cd_usua_incs_alrt, dt_incs_alrt, nm_pcnt) values ((select NEXTVAL('tratamento.sq_log_alrt')),'INSERCAO DE STATUS DE TRATAMENTO', (select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."')||' - '||(select ds_equipe from tratamento.tb_c_equipe where id_equipe = ".$_POST['id_equipe'].")||' - '||(select ds_status_trtmto from tratamento.tb_c_status_trtmto where id_status_trtmto = ".$_POST['id_status_trtmto'].")||' - '||upper('".$_POST['ds_obs_pcnt']."'), '".$_SESSION['usuario']."', current_timestamp, (select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."'))";
						
						$result = pg_query($pdo, $sql);

						if($result){
							echo "";
						}
			

						$sql = "INSERT INTO tratamento.tb_hstr_obs_pnel_solic_trtmto(id_hstr_obs_pnel_solic_trtmto, id_hstr_pnel_solic_trtmto, id_status_equipe, ds_status_equipe, dt_inic_status_equipe_trtmto, dt_final_status_equipe_trtmto, ds_obs_pcnt, tp_minuto_status_equipe_trtmto, cd_usua_incs, dt_incs, dt_inicial_trtmto, cd_pcnt, nm_pcnt, id_status_trtmto, ds_status_trtmto)
				VALUES ((select NEXTVAL('tratamento.sq_hstr_obs_pnel_solic_trtmto')), ".$id_hstr_pnel_solic_trtmto.", ".$_POST['id_equipe'].", (select ds_equipe from tratamento.tb_c_equipe where id_equipe = ".$_POST['id_equipe']."), current_timestamp, null, upper('".$_POST['ds_obs_pcnt']."'), 0, '".$_SESSION['usuario']."', current_timestamp, '".$dt_inicial_trtmto."', '".$_POST['cd_pcnt']."', '".$_POST['nm_pcnt']."',".$_POST['id_status_trtmto'].", (select ds_status_trtmto from tratamento.tb_c_status_trtmto where id_status_trtmto = ".$_POST['id_status_trtmto']."));";

						//echo $sql;

						$result = pg_query($pdo, $sql);

						if($result){
							echo "";
						} 
						
						$sql = "UPDATE tratamento.tb_hstr_obs_pnel_solic_trtmto set dt_final_status_equipe_trtmto= current_timestamp, tp_minuto_status_equipe_trtmto = round((SELECT date_part( 'day', age(current_timestamp::timestamp WITHOUT TIME ZONE , dt_inic_status_equipe_trtmto))*24*60 + date_part( 'hour', age(current_timestamp::timestamp WITHOUT TIME ZONE , dt_inic_status_equipe_trtmto))*60 + date_part( 'minute', age(current_timestamp::timestamp WITHOUT TIME ZONE , dt_inic_status_equipe_trtmto)))), cd_usua_altr = '".$_SESSION['usuario']."', dt_altr = current_timestamp where id_hstr_obs_pnel_solic_trtmto = ".$rowmaxstatusequipe[0]."";

						//echo $sql;

						$result = pg_query($pdo, $sql);

						if($result){
							echo "";
						} 

						$secondsWait = 0;
						header("Refresh:$secondsWait");
					
					} else {
						
						echo "<div class=\"alert alert-warning alert-dismissible\">
							<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
							<strong>Atenção!</strong> Status já existe para o paciente e equipe. Tente novamente com outro stauts.	</div>";

					}
				}
			}
		
		} catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
	
	if(isset($_POST['insere'])){					
		
		if ($pdo==null){
			header(Config::$webLogin);
		}
		
		try
		{	
			
			$sqlpaciente = "SELECT count(1)			 
							FROM tratamento.tb_c_pcnt pcnt 
							WHERE pcnt.cd_pcnt = '". $_POST['cd_pcnt'] ."'" ;
										  
			$retpaciente = pg_query($pdo, $sqlpaciente);
								
			if(!$retpaciente) {
				echo pg_last_error($pdo);		
				exit;
			}
			
			$rowpaciente = pg_fetch_row($retpaciente);
									
			if($rowpaciente[0]==0){
				$sqlinsertpcnt = "INSERT INTO tratamento.tb_c_pcnt(cd_pcnt, nm_pcnt, dt_nasc_pcnt, ds_mncp_pcnt, cd_usua_incs, dt_incs, id_cnvo, cd_cnvo)
		VALUES ('". $_POST['cd_pcnt'] ."', upper('". $_POST['nm_pcnt'] ."'), '". $_POST['dt_nasc_pcnt'] ."', '". $_POST['ds_mncp'] ."', '".$_SESSION['usuario']."', current_timestamp, (select id_cnvo from tratamento.tb_c_cnvo where cd_cnvo = '". $_POST['cd_cnvo'] ."'), '". $_POST['cd_cnvo'] ."')";
		
				//echo $sqlinsertpcnt;		
		
				$result = pg_query($pdo, $sqlinsertpcnt);

				if($result){
					echo "";
				}  
				
			} else {
				$sqlupdatepcnt = "UPDATE tratamento.tb_c_pcnt SET nm_pcnt=upper('". $_POST['nm_pcnt'] ."'), id_cnvo = (select id_cnvo from tratamento.tb_c_cnvo where cd_cnvo = '". $_POST['cd_cnvo'] ."'), cd_cnvo = '". $_POST['cd_cnvo'] ."', dt_nasc_pcnt = '". $_POST['dt_nasc_pcnt'] ."', ds_mncp_pcnt= '". $_POST['ds_mncp'] ."', cd_usua_altr = '".$_SESSION['usuario']."', dt_altr = current_timestamp WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."'";
				
				$result = pg_query($pdo, $sqlupdatepcnt);

				if($result){
					echo "";
				}  
			
			}				
			
			$sqldataatual = "SELECT to_char(current_timestamp, 'dd/mm/yyyy hh24:mi') ";
										  
			$retdataatual = pg_query($pdo, $sqldataatual);
			
			if(!$retdataatual) {
				echo pg_last_error($pdo);		
				exit;
			}
			
			$rowdataatual = pg_fetch_row($retdataatual);
			
			$sqlqtdeequipetratamento = "SELECT count(1)			 
										FROM tratamento.tb_hstr_pnel_solic_trtmto 
										WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."' 
										  and fl_trtmto_fchd = 0 ";
										  
			$retqtdeequipetratamento = pg_query($pdo, $sqlqtdeequipetratamento);
			
			//echo $sqlqtdeequipetratamento;
			
			if(!$retqtdeequipetratamento) {
				echo pg_last_error($pdo);		
				exit;
			}
			
			$rowretequipetratamento = pg_fetch_row($retqtdeequipetratamento);
			
			if($rowretequipetratamento[0]==0){
				
				$sqlequipetratamento = "SELECT status_trtmto.id_equipe
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
				
				$retequipetratamento = pg_query($pdo, $sqlequipetratamento);
									
				if(!$retequipetratamento) {
					echo pg_last_error($pdo);		
					exit;
				}
									
				while($rowretequipetratamento = pg_fetch_row($retequipetratamento)) {
				
					$sql = "INSERT INTO tratamento.tb_hstr_pnel_solic_trtmto(
		id_hstr_pnel_solic_trtmto, cd_pcnt, nm_pcnt, dt_nasc_pcnt, ds_mncp_pcnt, id_equipe, ds_equipe, nu_seq_equipe_pnel, id_status_trtmto, ds_status_trtmto, fl_trtmto_fchd, dt_inicial_trtmto, dt_final_trtmto, ds_utlma_obs_pcnt, tp_dia_trtmto, tp_hora_trtmto, tp_minuto_trtmto, cd_usua_incs, dt_incs, cd_usua_altr, dt_altr, cd_cor_status_trtmto, cd_cnvo)
		VALUES ((select NEXTVAL('tratamento.sq_hstr_pnel_solic_trtmto')), '". $_POST['cd_pcnt'] ."', '". $_POST['nm_pcnt'] ."', '". $_POST['dt_nasc_pcnt'] ."', '". $_POST['ds_mncp'] ."',".$rowretequipetratamento[0].", '".$rowretequipetratamento[1]."', ".$rowretequipetratamento[2].", ".$rowretequipetratamento[3].", '".$rowretequipetratamento[4]."', 0, '".$rowdataatual[0]."', null, 'INICIO DO TRATAMENTO', 0, 0, 0, '".$_SESSION['usuario']."', current_timestamp, null, null, '".$rowretequipetratamento[5]."', '". $_POST['cd_cnvo'] ."');";
		
					//echo $sql;
		
					$result = pg_query($pdo, $sql);
					
					if($result){
						echo "";
					}
					
					$sql = "insert into tratamento.tb_log_alrt (id_log_alrt, cd_alrt, ds_alrt, cd_usua_incs_alrt, dt_incs_alrt, nm_pcnt) values ((select NEXTVAL('tratamento.sq_log_alrt')),'INSERCAO DE TRATAMENTO', (select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."')||' - INICIO DE TRATAMENTO - ".$rowretequipetratamento[1]."', '".$_SESSION['usuario']."', current_timestamp, (select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."'))";
						
					$result = pg_query($pdo, $sql);

					if($result){
						echo "";
					}
					
					
					$sql = "INSERT INTO tratamento.tb_hstr_obs_pnel_solic_trtmto(id_hstr_obs_pnel_solic_trtmto, id_hstr_pnel_solic_trtmto, id_status_equipe, ds_status_equipe, dt_inic_status_equipe_trtmto, dt_final_status_equipe_trtmto, ds_obs_pcnt, tp_minuto_status_equipe_trtmto, cd_usua_incs, dt_incs, dt_inicial_trtmto, cd_pcnt, nm_pcnt, id_status_trtmto, ds_status_trtmto)
	VALUES ((select NEXTVAL('tratamento.sq_hstr_obs_pnel_solic_trtmto')), (SELECT currval('tratamento.sq_hstr_pnel_solic_trtmto')), ".$rowretequipetratamento[0].", '".$rowretequipetratamento[1]."', '".$rowdataatual[0]."', null, 'INICIO DO TRATAMENTO', 0, '".$_SESSION['usuario']."', current_timestamp, '".$rowdataatual[0]."', '".$_POST['cd_pcnt']."', '".$_POST['nm_pcnt']."',".$rowretequipetratamento[3].", '".$rowretequipetratamento[4]."') ";

					//echo $sql;

					$result = pg_query($pdo, $sql);
					
					if($result){
						echo "";
					}
					
				}
				
				
				$secondsWait = 0;
				header("Refresh:$secondsWait");
				
				
			} else {
				echo "<div class=\"alert alert-warning alert-dismissible\">
					<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
					<strong>Atenção!</strong>Paciente cadastrado em algum tratamento. Exclua o tratamento para este paciente para incluí-lo novamente.	</div>";
				
				
			}
			
			
		} catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
	
	if(isset($_POST['finaliza'])){					
		
		if ($pdo==null){
			header(Config::$webLogin);
		}
		
		try
		{	
			
			if ($_POST['fl_trtmto_fchd'] == 1){
							
				$sql = "UPDATE tratamento.tb_hstr_pnel_solic_trtmto SET tp_minuto_trtmto = round((SELECT date_part( 'day', age(current_timestamp::timestamp WITHOUT TIME ZONE , dt_inicial_trtmto))*24*60 + date_part( 'hour', age(current_timestamp::timestamp WITHOUT TIME ZONE , dt_inicial_trtmto))*60 + date_part( 'minute', age(current_timestamp::timestamp WITHOUT TIME ZONE , dt_inicial_trtmto)))), tp_hora_trtmto = round((SELECT date_part( 'day', age(current_timestamp::timestamp WITHOUT TIME ZONE , dt_inicial_trtmto))*24 + date_part( 'hour', age(current_timestamp::timestamp WITHOUT TIME ZONE , dt_inicial_trtmto)))), tp_dia_trtmto = round((SELECT date_part( 'day', age(current_timestamp::timestamp WITHOUT TIME ZONE , dt_inicial_trtmto)))), fl_trtmto_fchd = 1, cd_usua_altr = '".$_SESSION['usuario']."', dt_altr = current_timestamp, dt_final_trtmto = current_timestamp WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."' and fl_trtmto_fchd = 0";
				
				//echo $sql;
				
				$result = pg_query($pdo, $sql);
				
				if($result){
					echo "";
				}

				$sql = "insert into tratamento.tb_log_alrt (id_log_alrt, cd_alrt, ds_alrt, cd_usua_incs_alrt, dt_incs_alrt, nm_pcnt) values ((select NEXTVAL('tratamento.sq_log_alrt')),'FINALIZAÇÃO DE TRATAMENTO', (select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."')||' - FINALIZAÇÃO DE TRATAMENTO', '".$_SESSION['usuario']."', current_timestamp, (select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."'))";
						
				$result = pg_query($pdo, $sql);

				if($result){
					echo "";
				}
				
				
			} else {
			
				$sql = "SELECT distinct to_char(dt_inicial_trtmto, 'dd/mm/yyyy hh24:mi')
						  FROM tratamento.tb_hstr_pnel_solic_trtmto 
						WHERE cd_pcnt = '".$_POST['cd_pcnt']."' and fl_trtmto_fchd = 0 ";
				
				//echo $sql;

				$rethstrtratamento = pg_query($pdo, $sql);
				
				if(!$rethstrtratamento) {
					echo pg_last_error($pdo);		
					exit;
				}
				
				$rowhstrtratamento = pg_fetch_row($rethstrtratamento);
								
				$dt_inicial_trtmto = $rowhstrtratamento[0];
			
				$sql = "DELETE FROM tratamento.tb_hstr_obs_pnel_solic_trtmto WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."' and to_char(dt_inicial_trtmto, 'dd/mm/yyyy hh24:mi') = '".$dt_inicial_trtmto."' ";
				
				//echo $sql;
				
				$result = pg_query($pdo, $sql);

				if($result){
					echo "";
				} 
				
				$sql = "DELETE FROM tratamento.tb_hstr_pnel_solic_trtmto WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."' and fl_trtmto_fchd = 0 and to_char(dt_inicial_trtmto, 'dd/mm/yyyy hh24:mi') = '".$dt_inicial_trtmto."' ";
				
				//echo $sql;
				
				$result = pg_query($pdo, $sql);

				if($result){
					echo "";
				} 
				
				$sql = "insert into tratamento.tb_log_alrt (id_log_alrt, cd_alrt, ds_alrt, cd_usua_incs_alrt, dt_incs_alrt, nm_pcnt) values ((select NEXTVAL('tratamento.sq_log_alrt')),'EXCLUSÃO DE TRATAMENTO', (select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."')||' - EXCLUSÃO DE TRATAMENTO', '".$_SESSION['usuario']."', current_timestamp, (select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."'))";
						
				$result = pg_query($pdo, $sql);

				if($result){
					echo "";
				}
			
			}
			//voltar aqui
			$secondsWait = 0;
			header("Refresh:$secondsWait");

				
		} catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
	
	if(isset($_POST['alterastatus'])){					
		
		if ($pdo==null){
			header(Config::$webLogin);
		}
		
		try
		{	
			
			
			$sql = "select count(1) from tratamento.tb_c_equipe_usua where id_equipe = ".$_POST['id_equipe']." and cd_usua_acesso = (SELECT cd_usua_acesso FROM tratamento.tb_c_usua_acesso where nm_usua_acesso = '".$_SESSION['usuario']."') ";
				
			//echo $sql;

			$retequipeusua = pg_query($pdo, $sql);
			
			if(!$retequipeusua) {
				echo pg_last_error($pdo);		
				exit;
			}
			
			$rowequipeusua = pg_fetch_row($retequipeusua);
			
			if ($rowequipeusua[0]==0 && $_SESSION['fl_sist_admn']=='N'){
				echo "<div class=\"alert alert-warning alert-dismissible\">
						<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
						<strong>Atenção!</strong> Usuário não pode manter o status para esta equipe.	</div>";
			} else {			
			
				$sql = "SELECT distinct to_char(dt_inicial_trtmto, 'dd/mm/yyyy hh24:mi')
							  FROM tratamento.tb_hstr_pnel_solic_trtmto 
							WHERE cd_pcnt = '".$_POST['cd_pcnt']."' and fl_trtmto_fchd = 0 ";
					
				//echo $sql;

				$rethstrtratamento = pg_query($pdo, $sql);
				
				if(!$rethstrtratamento) {
					echo pg_last_error($pdo);		
					exit;
				}
				
				$rowhstrtratamento = pg_fetch_row($rethstrtratamento);
								
				$dt_inicial_trtmto = $rowhstrtratamento[0];
				
				$sql = "UPDATE tratamento.tb_hstr_pnel_solic_trtmto SET ds_utlma_obs_pcnt = UPPER('". $_POST['ds_utlma_obs_pcnt'] ."'), cd_usua_altr = '".$_SESSION['usuario']."', dt_altr = current_timestamp WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."' and id_equipe = ". $_POST['id_equipe'] ." and id_status_trtmto = ". $_POST['id_status_trtmto'] ." and fl_trtmto_fchd = 0 ";
				
				//echo $sql;
				
				$result = pg_query($pdo, $sql);
				
				if($result){
					echo "";
				} 
				
				$sql = "UPDATE tratamento.tb_hstr_obs_pnel_solic_trtmto SET ds_obs_pcnt = UPPER('". $_POST['ds_utlma_obs_pcnt'] ."'), cd_usua_altr = '".$_SESSION['usuario']."', dt_altr = current_timestamp WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."' and id_status_equipe = ". $_POST['id_equipe'] ." and id_status_trtmto = ". $_POST['id_status_trtmto'] ." and to_char(dt_inicial_trtmto, 'dd/mm/yyyy hh24:mi') = '".$dt_inicial_trtmto."' ";
				
				//echo $sql;
				
				$result = pg_query($pdo, $sql);
				
				if($result){
					echo "";
				} 
				
				$sql = "insert into tratamento.tb_log_alrt (id_log_alrt, cd_alrt, ds_alrt, cd_usua_incs_alrt, dt_incs_alrt, nm_pcnt) values ((select NEXTVAL('tratamento.sq_log_alrt')),'ALTERACAO DE STATUS DE TRATAMENTO', (select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."')||' - '||(select ds_equipe from tratamento.tb_c_equipe where id_equipe = ".$_POST['id_equipe'].")||' - '||(select ds_status_trtmto from tratamento.tb_c_status_trtmto where id_status_trtmto = ".$_POST['id_status_trtmto'].")||' - '||upper('".$_POST['ds_utlma_obs_pcnt']."'), '".$_SESSION['usuario']."', current_timestamp, (select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."'))";
						
						$result = pg_query($pdo, $sql);

						if($result){
							echo "";
						}
					
				//voltar aqui
				$secondsWait = 0;
				header("Refresh:$secondsWait");
			}
				
		} catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
	
	
	if(isset($_POST['excluistatus'])){					
		
		if ($pdo==null){
			header(Config::$webLogin);
		}
		
		try
		{	
			
			
			$sql = "select count(1) from tratamento.tb_c_equipe_usua where id_equipe = ".$_POST['id_equipe']." and cd_usua_acesso = (SELECT cd_usua_acesso FROM tratamento.tb_c_usua_acesso where nm_usua_acesso = '".$_SESSION['usuario']."') ";
				
			//echo $sql;

			$retequipeusua = pg_query($pdo, $sql);
			
			if(!$retequipeusua) {
				echo pg_last_error($pdo);		
				exit;
			}
			
			$rowequipeusua = pg_fetch_row($retequipeusua);
			
			if ($rowequipeusua[0]==0 && $_SESSION['fl_sist_admn']=='N'){
				echo "<div class=\"alert alert-warning alert-dismissible\">
						<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
						<strong>Atenção!</strong> Usuário não pode manter o status para esta equipe.	</div>";
			} else {
						
				$sql = "SELECT distinct to_char(dt_inicial_trtmto, 'dd/mm/yyyy hh24:mi')
						  FROM tratamento.tb_hstr_pnel_solic_trtmto 
						WHERE cd_pcnt = '".$_POST['cd_pcnt']."' and fl_trtmto_fchd = 0 ";
				
				//echo $sql;

				$rethstrtratamento = pg_query($pdo, $sql);
				
				if(!$rethstrtratamento) {
					echo pg_last_error($pdo);		
					exit;
				}
				
				$rowhstrtratamento = pg_fetch_row($rethstrtratamento);
								
				$dt_inicial_trtmto = $rowhstrtratamento[0];
			
				$sql = "DELETE FROM tratamento.tb_hstr_obs_pnel_solic_trtmto WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."' and to_char(dt_inicial_trtmto, 'dd/mm/yyyy hh24:mi') = '".$dt_inicial_trtmto."' and id_status_equipe = ". $_POST['id_equipe'] ." and id_status_trtmto = ". $_POST['id_status_trtmto'] ." ";
				
				//echo $sql;
				
				$result = pg_query($pdo, $sql);

				if($result){
					echo "";
				} 
							
				$sql = "SELECT distinct trtmto_obs.id_status_equipe
									  , trtmto_obs.id_status_trtmto
									  , trtmto_obs.ds_status_trtmto
									  , trtmto_status.cd_cor_status_trtmto
						  FROM tratamento.tb_hstr_obs_pnel_solic_trtmto trtmto_obs
							 , tratamento.tb_c_status_trtmto trtmto_status
						WHERE trtmto_obs.id_status_trtmto = trtmto_status.id_status_trtmto					  
						  and trtmto_obs.cd_pcnt = '".$_POST['cd_pcnt']."' 
						  and trtmto_obs.id_status_equipe = ". $_POST['id_equipe'] ." 
						  and to_char(trtmto_obs.dt_inicial_trtmto, 'dd/mm/yyyy hh24:mi') = '".$dt_inicial_trtmto."'
						  and trtmto_obs.id_hstr_obs_pnel_solic_trtmto = (SELECT MAX(id_hstr_obs_pnel_solic_trtmto) 
																  FROM tratamento.tb_hstr_obs_pnel_solic_trtmto 
																WHERE cd_pcnt = '".$_POST['cd_pcnt']."' 
																  and id_status_equipe = ". $_POST['id_equipe'] ." 
																  and to_char(dt_inicial_trtmto, 'dd/mm/yyyy hh24:mi') = '".$dt_inicial_trtmto."')";
				
				//echo $sql;

				$retultimostatus = pg_query($pdo, $sql);
				
				if(!$retultimostatus) {
					echo pg_last_error($pdo);		
					exit;
				}
				
				$rowretultimostatus = pg_fetch_row($retultimostatus);
								
				$id_status_equipe = $rowretultimostatus[0];
				$id_status_trtmto = $rowretultimostatus[1];
				$ds_status_trtmto = $rowretultimostatus[2];
				$cd_cor_status_trtmto = $rowretultimostatus[3];
						
				$sql = "UPDATE tratamento.tb_hstr_pnel_solic_trtmto set id_status_trtmto = ".$id_status_trtmto.", ds_status_trtmto = '".$ds_status_trtmto."', cd_cor_status_trtmto = '".$cd_cor_status_trtmto."' WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."' and fl_trtmto_fchd = 0 and to_char(dt_inicial_trtmto, 'dd/mm/yyyy hh24:mi') = '".$dt_inicial_trtmto."' and id_equipe = ". $_POST['id_equipe'] ." ";
				
				//echo $sql;
				
				$result = pg_query($pdo, $sql);

				if($result){
					echo "";
				} 
				
				$sql = "insert into tratamento.tb_log_alrt (id_log_alrt, cd_alrt, ds_alrt, cd_usua_incs_alrt, dt_incs_alrt, nm_pcnt) values ((select NEXTVAL('tratamento.sq_log_alrt')),'EXCLUSAO DE STATUS DE TRATAMENTO', (select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."')||' - '||(select ds_equipe from tratamento.tb_c_equipe where id_equipe = ".$_POST['id_equipe'].")||' - '||(select ds_status_trtmto from tratamento.tb_c_status_trtmto where id_status_trtmto = ".$id_status_trtmto."), '".$_SESSION['usuario']."', current_timestamp, (select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."'))";
						
				$result = pg_query($pdo, $sql);

				if($result){
					echo "";
				}
			
				//voltar aqui
				$secondsWait = 0;
				header("Refresh:$secondsWait");
			}
				
		} catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
	
	$inserestatus="";
	$alterastatus="";
	$excluistatus="";
	$novotratamento="";
	$finalizatratamento="";
		
	$sql = "SELECT fl_sist_admn from tratamento.tb_c_usua_acesso where nm_usua_acesso = '".$_SESSION['usuario']."'";
	
	$ret_usua = pg_query($pdo, $sql);	
	if(!$ret_usua) {
		echo pg_last_error($pdo);
		exit;
	}
	
	$ret_usua_row = pg_fetch_row($ret_usua);
	
	if ($ret_usua_row[0]=="S"){
		$fl_sist_admn="S";						
	}else{
		
		$fl_sist_admn="N";			
		
		$sql = "SELECT distinct cd_transac_tratamento from tratamento.vw_acesso_transac_tratamento where nm_usua_acesso = '".$_SESSION['usuario']."' and cd_transac_tratamento = 'btn-xs telainserestatus' ";	
		
		$rettransac = pg_query($pdo, $sql);
		if(pg_num_rows($rettransac)==0) {
			$inserestatus = "nao_inserestatus";
		} else {
			$rettransac_row = pg_fetch_row($rettransac);
			$inserestatus = $rettransac_row[0];						
		}
		
		$sql = "SELECT distinct cd_transac_tratamento from tratamento.vw_acesso_transac_tratamento where nm_usua_acesso = '".$_SESSION['usuario']."' and cd_transac_tratamento = 'btn-xs alterastatus' ";	
		
		$rettransac = pg_query($pdo, $sql);
		if(pg_num_rows($rettransac)==0) {
			$alterastatus = "nao_alterastatus";
		} else {
			$rettransac_row = pg_fetch_row($rettransac);
			$alterastatus = $rettransac_row[0];						
		}
		
		$sql = "SELECT distinct cd_transac_tratamento from tratamento.vw_acesso_transac_tratamento where nm_usua_acesso = '".$_SESSION['usuario']."' and cd_transac_tratamento = 'btn-xs excluistatus' ";	
		
		$rettransac = pg_query($pdo, $sql);
		if(pg_num_rows($rettransac)==0) {
			$excluistatus = "nao_excluistatus";
		} else {
			$rettransac_row = pg_fetch_row($rettransac);
			$excluistatus = $rettransac_row[0];						
		}
		
		$sql = "SELECT distinct cd_transac_tratamento from tratamento.vw_acesso_transac_tratamento where nm_usua_acesso = '".$_SESSION['usuario']."' and cd_transac_tratamento = 'btn btn-primary btn-xs insere' ";	
		
		$rettransac = pg_query($pdo, $sql);
		if(pg_num_rows($rettransac)==0) {
			$novotratamento = "nao_novotratamento";
		} else {
			$rettransac_row = pg_fetch_row($rettransac);
			$novotratamento = $rettransac_row[0];						
		}
		
		$sql = "SELECT distinct cd_transac_tratamento from tratamento.vw_acesso_transac_tratamento where nm_usua_acesso = '".$_SESSION['usuario']."' and cd_transac_tratamento = 'btn btn-primary btn-xs finaliza' ";	
		
		$rettransac = pg_query($pdo, $sql);
		if(pg_num_rows($rettransac)==0) {
			$finalizatratamento = "nao_finalizatratamento";
		} else {
			$rettransac_row = pg_fetch_row($rettransac);
			$finalizatratamento = $rettransac_row[0];						
		}		
		
	}
	
		
?>	

	<!DOCTYPE html>
	<html lang="pt-br">
		<head>			
			<script type="text/javascript">
				var auto_refresh = setInterval(
						function ()
							{
								$('#alerta').load('../alerta/alerta_transacao_crud.php?tipoconsultaalerta=pedidotratamento').fadeIn("slow");
							}
							, 1000
						); 
							//refresh every 1000 milliseconds
							
			
			</script>	
		
			<style>
				/* tables */
				
				.table {
					border-radius: 0px;
					width: 50%;					
					margin-left: auto; 
					margin-right: auto;
					float: none;
					border: 1px solid black;			
				}
								
				.table-condensed{
				  font-size: 9.5px;
				}
				
				.gif_loader_image{
				  position: fixed;
				  width: 100%;
				  height: 100%;
				  left: 0px;
				  bottom: 0px;
				  z-index: 1001;
				  background:rgba(0,0,0,.8);
				  text-align:center;
				}
				.gif_loader_image img{
				  width:30px;
				  margin-top:40%;
				}
				
				.notification {
				  background-color: white;
				  color: black;
				  text-decoration: none;
				  padding: 3px 21px;
				  position: relative;
				  display: inline-block;
				  border-radius: 5px;
				}

				.notification:hover {
				  background: gray;
				}
				
				.notification .badge {
				  position: absolute;
				  top: 0px;
				  right: -10px;
				  padding: 5px 10px;
				  border-radius: 50%;
				  background-color: red;
				  color: white;
				}

					
			
			</style>
			 <meta charset="utf-8">
			 <meta http-equiv="X-UA-Compatible" content="IE=edge">
			 <meta name="viewport" content="width=device-width, initial-scale=1">
			 <title>Processo de Solicitação e Agendamento de Quimioterapia</title>			 
			 <link href="../css/bootstrap.min.css" rel="stylesheet">
			 <link rel="stylesheet" href="../css/font-awesome.min.css">			 
			 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">  
			 <link href="../css/style.css" rel="stylesheet">	 			 		 			 
	  
		</head>
		<body id="aplicacao" onload="removeDivsEtapasCarga();">			
			<div class="container" style="margin-left: 5px; margin-right: 5px; position:fixed; margin-top: 0px; background-color:white; max-width: 5000px; height: 60px; border: 1px solid #E6E6E6;font-size: 11px;">
				
				<br>
				
				<?php
				if ($novotratamento=="nao_novotratamento"){
				?>
					&nbsp;
				<?php } else { ?> 				
					<input type="button" style="font-size: 11px;" value="Novo Tratamento" class="btn btn-primary btn-xs insere"/>
				<?php } ?>
				
				<?php
				if ($finalizatratamento=="nao_finalizatratamento"){
				?>
					&nbsp;
				<?php } else { ?> 
					<input type="button" style="font-size: 11px;" value="Finalizar Tratamento" class="btn btn-primary btn-xs finaliza"/>
				<?php } ?>
				
				<input class="btn btn-primary" style="font-size: 11px;" type="button" value="Exportar Tratamentos" id="exportarpaineltratamento" style="display:none">&nbsp;
				
				<input class="btn btn-primary" style="font-size: 11px;" type="submit" value="Imprimir Tratamentos" id="exportarplanejamentopdf" onclick="window.open('../tcpdf/relatorio/impressao_relatoriotratamento.php');">&nbsp;
				
				<input class="btn btn-primary" style="font-size: 11px;" type="button" value="Histórico de Obs." name="hstrobs" data-toggle="modal" data-target="#modalhstrstatus">&nbsp;&nbsp;&nbsp;&nbsp;
				
				<a href="#" class="notification" style="font-size:20px;" title="Alerta da manutenção de pedidos de tratamento" data-toggle="modal" data-target="#alertasomentepedido""><span class="badge" id="alerta"></span><i class="fa fa-book" aria-hidden="true"></i>
			</a>			
				
			</div>
			
			<div id="list" class="row" style="margin-left: 5px; margin-right: 5px">
				
				<div class="table-responsive" style="margin-top: 60px;">				
					<table id="tabela" class="table table-bordered">
						<thead class="thead-dark">
							<tr style="font-size: 11px;">
								<?php
									$sqlequipe ="select ds_equipe from tratamento.tb_c_equipe order by nu_seq_equipe_pnel asc";
					
									$retequipe = pg_query($pdo, $sqlequipe);
									
									if(!$retequipe) {
										echo pg_last_error($pdo);		
										exit;
									}
								?>
									<th style="text-align:center">Id</th>
									<th style="text-align:center">Paciente</th>
									<th style="text-align:center">Pedido</th>
									<th style="text-align:center">Inclusão</th>
								<?php	
									while($rowequipe = pg_fetch_row($retequipe)) {
									
								?>
										<th style="text-align:center"><?php echo $rowequipe[0]; ?></th>
								<?php 							
									
								}  ?>
								<th colspan="3" style="text-align:center">Ações</th>
							</tr>
						</thead>
						
						<tbody>
						<?php
							
							$cont=1;										
							while($row = pg_fetch_row($ret)) {
								?>											
								<tr style="font-size: 11px;">
									<td data-toggle="tooltip" data-placement="top" title="<?php echo $row[8];?>" style="text-align:center" id="<?php echo $row[0];?>" value="<?php echo $row[0];?>" ><?php echo $row[0];?></td>
									
									<td data-toggle="tooltip" data-placement="top" title="<?php echo $row[1];?>" id="<?php echo $row[1];?>" value="<?php echo $row[1];?>" ><?php echo $row[1];?></td>
									
									<?php
									$sqlpddotrtmto = "SELECT count(pnel.cd_pcnt) as qtde_pcnt_pddo_trtmto 
													from tratamento.tb_hstr_pnel_solic_trtmto pnel
													   , tratamento.tb_pddo_trtmto pddo
													where pnel.id_hstr_pnel_solic_trtmto = pddo.id_hstr_pnel_solic_trtmto
													  and pnel.fl_trtmto_fchd = 0
													  and pnel.cd_pcnt = '".$row[0]."' ";	
									
									$retpddotrtmto = pg_query($pdo, $sqlpddotrtmto);
									
									if(!$retpddotrtmto) {
										echo pg_last_error($pdo);		
										exit;
									}	

									$rowpddotrtmto = pg_fetch_row($retpddotrtmto);
									
									if($rowpddotrtmto[0]==0) {
										?>
										
										<td data-toggle="tooltip" data-placement="top" title="<?php echo $row[1];?>" id="pedido" value="pedido" ></td>
										
										<?php
									} else {										
										?>
										
										<td data-placement="top" id="pedido" value="pedido"><input type="image" src="../img/printpedido.png" height="21" width="21" class="imprimirpdf"/>&nbsp;<?php echo $rowpddotrtmto[0] ?></td>
										
										<?php						
									}
									?>
									
									<td data-toggle="tooltip" data-placement="top" title="<?php echo $row[20];?>" style="text-align:center" id="<?php echo $row[20];?>" value="<?php echo $row[20];?>" ><?php echo $row[20];?></td>
									
									<td data-toggle="tooltip" data-placement="top" title="<?php echo $row[8];?>" style="text-align:center;background-color:<?php echo $row[14] ;?>" id="<?php echo $row[2];?>" value="<?php echo $row[2];?>" ><?php echo $row[2];?></td>
									
									<td data-toggle="tooltip" data-placement="top" title="<?php echo $row[9];?>" style=" text-align:center;background-color:<?php echo $row[15] ;?>" id="<?php echo $row[3];?>" value="<?php echo $row[3];?>" ><?php echo $row[3];?></td>
									
									<td data-toggle="tooltip" data-placement="top" title="<?php echo $row[10];?>" style="text-align:center;background-color:<?php echo $row[16] ;?> " id="<?php echo $row[4];?>" value="<?php echo $row[4];?>" ><?php echo $row[4];?></td>
									
									<td data-toggle="tooltip" data-placement="top" title="<?php echo $row[11];?>" style="text-align:center;background-color:<?php echo $row[17] ;?> " id="<?php echo $row[5];?>" value="<?php echo $row[5];?>" ><?php echo $row[5];?></td>				
									
									<td data-toggle="tooltip" data-placement="top" title="<?php echo $row[12];?>" style=" text-align:center;background-color:<?php echo $row[18] ;?>" id="<?php echo $row[6];?>" value="<?php echo $row[6];?>" ><?php echo $row[6];?></td>
									
									<td data-toggle="tooltip" data-placement="top" title="<?php echo $row[13];?>" style=" text-align:center;background-color:<?php echo $row[19] ;?>" id="<?php echo $row[7];?>" value="<?php echo $row[7];?>" ><?php echo $row[7];?></td>
	
									<?php
									if ($inserestatus=="nao_inserestatus"){
									?>
										<td class="actions">
											<input type="image" src="../img/update_bloqueado.png" title="Funcionalidade Bloqueada"  height="23" width="23" name="atualizaleito" data-toggle="modal" data-target="#atualizaleito"/>
												</td>
									<?php } else { ?>
										<td class="actions">
											<input type="image" title="Inserir Status" src="../img/insertstatus.png"  height="20" width="20" name="telainserestatus" data-toggle="modal" data-target="#telainserestatus" class="btn-xs telainserestatus"/>
										</td>
									
									<?php } ?>
									
									<?php
									if ($alterastatus=="nao_alterastatus"){
									?>
										<td class="actions">
											<input type="image" src="../img/update_bloqueado.png" title="Funcionalidade Bloqueada"  height="23" width="23" name="atualizaleito" data-toggle="modal" data-target="#atualizaleito"/>
												</td>
									<?php } else { ?>
										<td class="actions">
											<input type="image" title="Alterar Observação do Status" src="../img/alterarstatus.png"  height="20" width="20"  class="btn-xs alterastatus"/>
										</td>
									
									<?php } ?>
									
									
									<?php
									if ($excluistatus=="nao_excluistatus"){
									?>
										<td class="actions">
											<input type="image" src="../img/update_bloqueado.png" title="Funcionalidade Bloqueada"  height="23" width="23" name="atualizaleito" data-toggle="modal" data-target="#atualizaleito"/>
												</td>
									<?php } else { ?>
										<td class="actions">
										<input type="image" title="Excluir Status" src="../img/deletestatus2.png"  height="20" width="20" class="btn-xs excluistatus"/>
									</td>
									
									<?php } ?>
									
							</tr>
							<?php 
							
								$cont=$cont+1;
							}  ?>
									
						</tbody>
					</table>
				</div>
				
			</div> 
			 <script src="../js/jquery.min.js"></script>
			 <script src="../js/bootstrap.min.js"></script>
			 <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
			
	</body>
	
</html>

<div id="dataModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Detalhes do Paciente</h4>
			</div>
			<div class="modal-body" id="detalhe_paciente">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>
<div id="imprimir" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Impressão</h4>
			</div>
			<div class="modal-body" id="impressao">
			</div>				
		</div>
	</div>
</div>
<div class="modal fade" id="modalhstrstatus" role="dialog">
	<div class="modal-dialog modal-lg" >
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="model-title" id="leito_acmpte_rtgrd">Histórico de Observações do Tratamento</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>				
			</div>			
			<form action=""> 
			
				<div class="modal-body">
					
					<div class="form-group">
						<label>Escolha o Paciente:</label></td>
						<?php
						
						$sql = "SELECT cd_pcnt, nm_pcnt from tratamento.tb_c_pcnt order by 2";
						
						if ($pdo==null){
								header(Config::$webLogin);
						}	
						$ret = pg_query($pdo, $sql);
						if(!$ret) {
							echo pg_last_error($pdo);
							exit;
						}
						?>						
						<select  id="pcnt" class="form-control" onchange=" 
									var selObj = document.getElementById('pcnt');
									var selValue = selObj.options[selObj.selectedIndex].value;
									document.getElementById('cd_pcnt').value = selValue;">
									<option value="">Selecione o paciente</option></option>
																				
						<?php
							$cont=1;																	
						
							while($row = pg_fetch_row($ret)) {
							?>												
								<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>																		
						<?php $cont=$cont+1;} ?>	
						</select>
						<!--style="display:none"-->
						<input type="text" id="cd_pcnt" name="cd_pcnt" style="display:none">
					</div>
					<div class="form-group">
						<label>Escolha a Equipe:</label></td>
						<select class="form-control" name="tipoconsultaequipe" onchange="mostrahistoricoobs(this.value)">
							<option value="">Selecione a Equipe:</option>
							<option value="13">Oncologistas</option>
							<option value="7">Autorização</option>
							<option value="8">Nutrição</option>
							<option value="9">Psicologia</option>
							<option value="10">Farmárcia</option>
							<option value="11">Enfermagem</option>
						</select>
					</div>
					<div class="form-group" id="retornoconsulta">
						
					</div>					
				</div>
			</form>	
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>



<div class="modal fade" id="alertasomentepedido" role="dialog" style="width:1100px;">
	<div class="modal-dialog modal-lg" style="width:1100px;" >
		<div class="modal-content" style="width:950px;">
			<div class="modal-header" >
				<h5 class="model-title" id="leito_acmpte_rtgrd">Alerta da manutenção de pedidos de tratamento</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>				
			</div>			
			<form action=""> 
				<div class="modal-body">
					<?php
						$sql = "select id_log_alrt as id_alerta
									 , cd_alrt as assunto
									 , ds_alrt as corpo_mensagem
									 , cd_usua_incs_alrt as usuario_que_gerou_alerta
									 , to_char(dt_incs_alrt, 'dd/mm/yyyy hh24:mi') as data_geracao_alerta
									 , nm_pcnt
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
						and cd_alrt in ('INSERCAO DE PEDIDO DE TRATAMENTO', 'ALTERACAO DE PEDIDO DE TRATAMENTO', 'DELEÇÃO DE PEDIDO DE TRATAMENTO', '')";
						
						$ret = pg_query($pdo, $sql);
						if(!$ret) {
							echo pg_last_error($pdo);
							exit;
						}
					?>
					<table class="table table-striped" cellspacing="0" cellpadding="0" id="tabela">
					<thead>
						<tr>
							<th>Id. do Alerta</th>
							<th>Paciente</th>
							<th>Assunto</th>												
							<th>Corpo da Mensagem</th>											
							<th>Responsável pelo Alerta</th>
							<th>Data/Hora do Alerta</th>						
						</tr>
					</thead>				
					<tbody>
					
						<?php

							$cont=1;										
							while($row = pg_fetch_row($ret)) {
							?>						
								<tr>
									<td width="10%" id="id_log_alrt" value="<?php echo $row[0];?>"><?php echo $row[0];?></td>
									<td width="10%" id="nm_pcnt" value="<?php echo $row[5];?>"><?php echo $row[5];?></td>
									<td width="15%" id="cd_alrt" value="<?php echo $row[1];?>"><?php echo $row[1];?></td>
									<?php
									if (strlen($row[2])<=50) {
									?>
									<td width="150%" data-toggle="tooltip" data-placement="top" id="ds_alrt" value="<?php echo $row[2];?>" title= "<?php echo $row[2];?>"><?php echo $row[2];?></td>
									<?php
									} else {
										?>
										<td width="150%" data-toggle="tooltip" data-placement="top" id="ds_alrt" value="<?php echo $row[2];?>" title= "<?php echo $row[2];?>"><?php echo substr($row[2], 0, 70);?><b>...</b></td> 
									<?php
									}
									?>							
									<td width="55%" id="cd_usua_incs_alrt" value="<?php echo $row[3];?>"><?php echo $row[3];?></td>
									<td width="30%" id="dt_incs_alrt" value="<?php echo $row[4];?>"><?php echo $row[4];?></td>
									
								</tr>						
						<?php 
						
							//$sql = "INSERT INTO tratamento.tb_usua_alrt_manut(id_usua_alrt_manut, cd_usua_acesso, id_log_alrt, fl_alrt_leitura, fl_alrt_excluido, cd_usua_altr, dt_altr) VALUES ((select NEXTVAL('tratamento.sq_usua_alrt_manut')), (select cd_usua_acesso from tratamento.tb_c_usua_acesso where nm_usua_acesso = '".$_SESSION['usuario']."'), ".$row[0].", 1, 0, '".$_SESSION['usuario']."', current_timestamp) ";

							//$result = pg_query($pdo, $sql);

							//if($result){
							//	echo "";
							//}  
							
							$cont=$cont+1;
						} ?>	
						</tbody>
					</table>
								
				</div>
			</form>	
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>





<script>
	
	$(document).ready(function(){
		$(document).on('click', '.telainserestatus', function(){
			
			var currentRow=$(this).closest("tr"); 							
			var cd_pcnt = currentRow.find("td:eq(0)").text();
			var nm_pcnt = currentRow.find("td:eq(1)").text();
			
			event.preventDefault();			
			$.ajax({
				type: "POST",
				url:"../tratamento/insercao_status.php",
				data:{cd_pcnt:cd_pcnt, nm_pcnt:nm_pcnt},			
				success : function(completeHtmlPage) {									
					$("html").empty();					
					$("html").append(completeHtmlPage);										
				}
			});			
		});	
	});
	
	function mostrahistoricoobs(strEquipe) {
	  var xhttp;   
	  var cd_pcnt = document.getElementById("cd_pcnt").value;
	  
	  if (strEquipe == "") {
		document.getElementById("retornoconsulta").innerHTML = "";
		return;
	  }
	  xhttp = new XMLHttpRequest();
	  xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		  document.getElementById("retornoconsulta").innerHTML = this.responseText;
		}
	  };	  	  
	 
	  xhttp.open("GET", "../tratamento/recupera_hstr_obs_tratamento.php?equipe="+strEquipe+"&pac="+cd_pcnt, true);
	  
	  xhttp.send();
	}
	
	$(document).ready(function(){
		$(document).on('click', '.insere', function(){
			
			var currentRow=$(this).closest("tr"); 							
			var cd_pcnt = currentRow.find("td:eq(0)").text();
			var nm_pcnt = currentRow.find("td:eq(1)").text();
			
			event.preventDefault();			
			$.ajax({
				type: "POST",
				url:"../tratamento/insercao_paciente.php",
				data:{cd_pcnt:cd_pcnt, nm_pcnt:nm_pcnt},			
				success : function(completeHtmlPage) {									
					$("html").empty();					
					$("html").append(completeHtmlPage);										
				}
			});			
		});	
	});
	
	$(document).ready(function(){
		$(document).on('click', '.finaliza', function(){
			
			event.preventDefault();			
			$.ajax({
				type: "POST",
				url:"../tratamento/finaliza_tratamento.php",					
				success : function(completeHtmlPage) {									
					$("html").empty();					
					$("html").append(completeHtmlPage);										
				}
			});			
		});	
	});
	
	$(document).ready(function(){
		$(document).on('click', '.alterastatus', function(){
			
			var currentRow=$(this).closest("tr"); 							
			var cd_pcnt = currentRow.find("td:eq(0)").text();
			var nm_pcnt = currentRow.find("td:eq(1)").text();
			
			event.preventDefault();			
			$.ajax({
				type: "POST",
				url:"../tratamento/altera_status.php",
				data:{cd_pcnt:cd_pcnt, nm_pcnt:nm_pcnt},					
				success : function(completeHtmlPage) {									
					$("html").empty();					
					$("html").append(completeHtmlPage);										
				}
			});			
		});	
	});
	
	$(document).ready(function(){
		$(document).on('click', '.excluistatus', function(){
			
			var currentRow=$(this).closest("tr"); 							
			var cd_pcnt = currentRow.find("td:eq(0)").text();
			var nm_pcnt = currentRow.find("td:eq(1)").text();
			
			event.preventDefault();			
			$.ajax({
				type: "POST",
				url:"../tratamento/exclui_status.php",
				data:{cd_pcnt:cd_pcnt, nm_pcnt:nm_pcnt},					
				success : function(completeHtmlPage) {									
					$("html").empty();					
					$("html").append(completeHtmlPage);										
				}
			});			
		});	
	});
	

	$('#exportarpaineltratamento').click(function(){			
		
		$.ajax({
			type : 'POST',
			url : '../tratamento/tratamentoexcel.php', // give complete url here								
			success : function(completeHtmlPage) {	
				alert("Faça o download do arquivo de impressão. Abra no Excel e solicite para Salvar Como com o nome desejado.");
				$("html").empty();
				$("html").append(completeHtmlPage);
			}
		});
	});	
	
	
	
	$("#tabela").on('click', '.imprimirpdf', function(){
		
		var currentRow=$(this).closest("tr"); 							
		var cd_pcnt = currentRow.find("td:eq(0)").text();
		var nm_pcnt = currentRow.find("td:eq(1)").text();
							
		$.ajax({
			url:"impressao_por_acompanhamentopedidotratamento.php",
			method:"POST",			
			data:{cd_pcnt:cd_pcnt, nm_pcnt:nm_pcnt},
			success:function(data){
				$('#impressao').html(data);
				$('#imprimir').modal('show');
			}
		});
	});
	
</script>
<?php ?>