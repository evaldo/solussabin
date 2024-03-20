<?php
		
	session_start();
	
    include '../database.php';
	
	error_reporting(0); 	
	
    $pdo = database::connect();
	$optconsulta = "";
	$textoconsulta = "";
	$sql="";

	$sql = "SELECT cd_pcnt	   
			 , ds_status_pcnt
			 , ds_local_trtmto 
			 , nm_pcnt
			 , cd_cor_status_pcnt
			 , case when fl_acesso_vnso_pefrco = 1 then 'Acesso Venoso Periférico' else '' end fl_acesso_vnso_pefrco
			 , case when fl_cttr_vnso_central = 1 then 'Cateter Venoso Central' else '' end fl_cttr_vnso_central
			 , case when fl_via_aplc_edvnso = 1 then 'Endovenoso' else '' end fl_via_aplc_edvnso 
			 , case when fl_via_aplc_sctnea = 1 then 'Subcutânea' else '' end fl_via_aplc_sctnea 
			 , case when fl_via_aplc_intramusc = 1 then 'Intramuscular' else '' end fl_via_aplc_intramusc 
			 , case when fl_via_aplc_vscal = 1 then 'Via Vesical' else '' end fl_via_aplc_vscal
			FROM tratamento.tb_hstr_pnel_mapa_risco
		WHERE dt_final_mapa_risco is null
		ORDER BY nu_seq_local_pnel asc";		
	
	if ($pdo==null){
			header(Config::$webLogin);
	}	
    $ret = pg_query($pdo, $sql);
    if(!$ret) {
        echo pg_last_error($pdo);
        exit;
    }
    $row = pg_fetch_row($ret);
	
	if(isset($_POST['inserestatus'])){					
		
		if ($pdo==null){
			header(Config::$webLogin);
		}
		
		try
		{		
			
			$sql = "SELECT MAX(id_hstr_obs_pnel_mapa_risco) FROM tratamento.tb_hstr_obs_pnel_mapa_risco WHERE cd_pcnt = '".$_POST['cd_pcnt']."' ";
				
			//echo $sql;

			$retmaxstatuspcnt = pg_query($pdo, $sql);
			
			if(!$retmaxstatuspcnt) {
				echo pg_last_error($pdo);		
				exit;
			}
			
			$rowmaxstatuspcnt = pg_fetch_row($retmaxstatuspcnt);
			
			$sql = "SELECT count(1) FROM tratamento.tb_hstr_pnel_mapa_risco WHERE cd_pcnt = '".$_POST['cd_pcnt']."'  and id_status_pcnt = ".$_POST['id_status_pcnt']." and dt_final_mapa_risco is null ";
			
			//echo $sql;

			$rethstrobs = pg_query($pdo, $sql);
			
			if(!$rethstrobs) {
				echo pg_last_error($pdo);		
				exit;
			}
			
			$rowhstrobs = pg_fetch_row($rethstrobs);
			
			if ($rowhstrobs[0]==0){
					
				$sql = "SELECT id_hstr_pnel_mapa_risco, dt_inic_mapa_risco 
						  FROM tratamento.tb_hstr_pnel_mapa_risco 
						WHERE cd_pcnt = '".$_POST['cd_pcnt']."' and dt_final_mapa_risco is null ";
				
				//echo $sql;

				$rethstrpcnt = pg_query($pdo, $sql);
				
				if(!$rethstrpcnt) {
					echo pg_last_error($pdo);		
					exit;
				}
				
				$rowhstrpcnt = pg_fetch_row($rethstrpcnt);
				
				$id_hstr_pnel_mapa_risco = $rowhstrpcnt[0];
				$dt_inic_mapa_risco = $rowhstrpcnt[1];
				
				$sqlupdatepainel = "update tratamento.tb_hstr_pnel_mapa_risco set ds_utlma_obs_mapa_risco = '".$_POST['ds_obs_mapa_risco']."', id_status_pcnt = ".$_POST['id_status_pcnt'].", ds_status_pcnt = (select ds_status_pcnt from tratamento.tb_c_status_pcnt where id_status_pcnt = ".$_POST['id_status_pcnt']."), cd_cor_status_pcnt = (select cd_cor_status_pcnt from tratamento.tb_c_status_pcnt where id_status_pcnt = ".$_POST['id_status_pcnt']."), cd_usua_altr = '".$_SESSION['usuario']."', dt_altr = current_timestamp where id_hstr_pnel_mapa_risco = ".$id_hstr_pnel_mapa_risco."";
				
				//echo $sqlupdatepainel;

				$resultupdatepainel = pg_query($pdo, $sqlupdatepainel);

				if($resultupdatepainel){
					echo "";
				}
				
				$sqlstatus = "select ds_status_pcnt from tratamento.tb_c_status_pcnt where id_status_pcnt = ".$_POST['id_status_pcnt'].";";
				$retstatus = pg_query($pdo, $sqlstatus);
				if(!$retstatus) {
					echo pg_last_error($pdo);		
					exit;
				}				
				$rowstatus = pg_fetch_row($retstatus);				
				$ds_status_pcnt = $rowstatus[0];
				
				$sqlpcnt = "SELECT nm_pcnt FROM tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."' ";
				$retpcnt = pg_query($pdo, $sqlpcnt);
				if(!$retpcnt) {
					echo pg_last_error($pdo);		
					exit;
				}				
				$rowpcnt = pg_fetch_row($retpcnt);				
				$nm_pcnt = $rowpcnt[0];

				$sqlinsertobs = "INSERT INTO tratamento.tb_hstr_obs_pnel_mapa_risco(id_hstr_obs_pnel_mapa_risco, id_hstr_pnel_mapa_risco, ds_status_pcnt, dt_inic_status_pcnt, dt_final_status_pcnt, ds_obs_mapa_risco, tp_min_status_pcnt, cd_usua_incs, dt_incs, cd_pcnt, nm_pcnt, id_status_pcnt)
		VALUES ((select NEXTVAL('tratamento.sq_hstr_obs_pnel_mapa_risco')), ".$id_hstr_pnel_mapa_risco.", '".$ds_status_pcnt."', current_timestamp, null, '".$_POST['ds_obs_mapa_risco']."', 0, '".$_SESSION['usuario']."', current_timestamp, '".$_POST['cd_pcnt']."', '".$nm_pcnt."',".$_POST['id_status_pcnt'].") ";

				//echo $sqlinsertobs;

				$resultinsertobs = pg_query($pdo, $sqlinsertobs);

				if($resultinsertobs){
					echo "";
				} 
				
				$sqlupdateobs = "UPDATE tratamento.tb_hstr_obs_pnel_mapa_risco set dt_final_status_pcnt= current_timestamp, tp_min_status_pcnt = round((SELECT date_part( 'day', age(current_timestamp::timestamp WITHOUT TIME ZONE , dt_inic_status_pcnt))*24*60 + date_part( 'hour', age(current_timestamp::timestamp WITHOUT TIME ZONE , dt_inic_status_pcnt))*60 + date_part( 'minute', age(current_timestamp::timestamp WITHOUT TIME ZONE , dt_inic_status_pcnt)))), cd_usua_altr = '".$_SESSION['usuario']."', dt_altr = current_timestamp where id_hstr_obs_pnel_mapa_risco = ".$rowmaxstatuspcnt[0]."";

				//echo $sql;

				$resultupdateobs = pg_query($pdo, $sqlupdateobs);

				if($resultupdateobs){
					echo "";
				} 

				$secondsWait = 0;
				header("Refresh:$secondsWait");
			
			} else {
				
				echo "<div class=\"alert alert-warning alert-dismissible\">
					<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
					<strong>Atenção!</strong> Status já existe para o paciente. Tente novamente com outro stauts.	</div>";
					
					$secondsWait = 2;
					header("Refresh:$secondsWait");

			}
			
		
		} catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
	
	if(isset($_POST['inseremapa'])){					
		
		if ($pdo==null){
			header(Config::$webLogin);
		}
		
		try
		{	
			
			$sqldataatual = "SELECT to_char(current_timestamp, 'dd/mm/yyyy hh24:mi') ";
											  
			$retdataatual = pg_query($pdo, $sqldataatual);
			
			if(!$retdataatual) {
				echo pg_last_error($pdo);		
				exit;
			}
			
			$rowdataatual = pg_fetch_row($retdataatual);			
			
			$sqlmaparisco = "SELECT count(1)			 
							FROM tratamento.tb_hstr_pnel_mapa_risco 
							WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."' and dt_final_mapa_risco is not null ";
										  
			$retmaparisco = pg_query($pdo, $sqlmaparisco);
			
			//echo $sqlmaparisco;
			
			if(!$retmaparisco) {
				echo pg_last_error($pdo);		
				exit;
			}
			
			$rowmaparisco = pg_fetch_row($retmaparisco);
			
			if($rowmaparisco[0]>=1){				
				
				if ($_POST['id_local_trtmto']=='0' || $_POST['id_local_trtmto']=='' || $_POST['id_status_pcnt']=='0' || $_POST['id_status_pcnt']==''){
					echo "<div class=\"alert alert-warning alert-dismissible\">
						<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
						<strong>Atenção!</strong>Local ou stauts não selecionados para o novo mapa. Execute novamente a inserção e selecione estes campos.</div>";
						
						$secondsWait = 3;
						header("Refresh:$secondsWait");
				} else {
					
					
					$sqlstatus = "select ds_status_pcnt from tratamento.tb_c_status_pcnt where id_status_pcnt = ".$_POST['id_status_pcnt'].";";
					$retstatus = pg_query($pdo, $sqlstatus);
					if(!$retstatus) {
						echo pg_last_error($pdo);		
						exit;
					}				
					$rowstatus = pg_fetch_row($retstatus);				
					$ds_status_pcnt = $rowstatus[0];
				
					$sqlinseremaparisco = "SELECT id_hstr_pnel_mapa_risco, cd_pcnt, nm_pcnt, ds_utlma_obs_mapa_risco, fl_acesso_vnso_pefrco, fl_cttr_vnso_central, fl_via_aplc_edvnso, fl_via_aplc_sctnea, fl_via_aplc_intramusc, fl_via_aplc_vscal, id_local_trtmto  FROM tratamento.tb_hstr_pnel_mapa_risco WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."' and id_hstr_pnel_mapa_risco = (select max(id_hstr_pnel_mapa_risco) FROM tratamento.tb_hstr_pnel_mapa_risco WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."' and dt_final_mapa_risco is not null) and dt_final_mapa_risco is not null";
										  
					$retinseremaparisco = pg_query($pdo, $sqlinseremaparisco);
					
					//echo $sqlinseremaparisco;
					
					if(!$retinseremaparisco) {
						echo pg_last_error($pdo);		
						exit;
					}
					
					$rowinseremaparisco = pg_fetch_row($retinseremaparisco);
					
					$sqlinsertpanelrisco = "INSERT INTO tratamento.tb_hstr_pnel_mapa_risco(id_hstr_pnel_mapa_risco, cd_pcnt, nm_pcnt, ds_utlma_obs_mapa_risco, fl_acesso_vnso_pefrco, fl_cttr_vnso_central, fl_via_aplc_edvnso, fl_via_aplc_sctnea, fl_via_aplc_intramusc, fl_via_aplc_vscal, cd_usua_incs, dt_incs, dt_inic_mapa_risco, dt_final_mapa_risco, id_local_trtmto, ds_local_trtmto, id_status_pcnt, ds_status_pcnt, cd_cor_status_pcnt, cd_cnvo) VALUES ((select NEXTVAL('tratamento.sq_hstr_pnel_mapa_risco')), '".$rowinseremaparisco[1]."', '".$rowinseremaparisco[2]."', '".$_POST['ds_obs_mapa_risco']."', ".$rowinseremaparisco[4].", ".$rowinseremaparisco[5]." , ".$rowinseremaparisco[6].", ".$rowinseremaparisco[7]." , ".$rowinseremaparisco[8]." , ".$rowinseremaparisco[9]." ,'".$_SESSION['usuario']."', '".$rowdataatual[0]."', '".$rowdataatual[0]."', null, ".$_POST['id_local_trtmto'].", (select ds_local_trtmto from tratamento.tb_c_local_trtmto where id_local_trtmto = ".$_POST['id_local_trtmto']."), ".$_POST['id_status_pcnt'].", '".$ds_status_pcnt."', (select cd_cor_status_pcnt from tratamento.tb_c_status_pcnt where id_status_pcnt = ".$_POST['id_status_pcnt']."), (SELECT cd_cnvo FROM tratamento.tb_c_pcnt where cd_pcnt = '".$rowinseremaparisco[1]."') ) ";
			
					//echo $sqlinsertpanelrisco;
		
					$resultinsertpanelrisco = pg_query($pdo, $sqlinsertpanelrisco);

					if($resultinsertpanelrisco){
						echo "";
					}
					
					$sqlpcnt = "SELECT nm_pcnt FROM tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."' ";
					$retpcnt = pg_query($pdo, $sqlpcnt);
					if(!$retpcnt) {
						echo pg_last_error($pdo);		
						exit;
					}				
					$rowpcnt = pg_fetch_row($retpcnt);				
					$nm_pcnt = $rowpcnt[0];
					
					$sqlobs = "INSERT INTO tratamento.tb_hstr_obs_pnel_mapa_risco(id_hstr_obs_pnel_mapa_risco, id_hstr_pnel_mapa_risco, dt_inic_status_pcnt, tp_min_status_pcnt, cd_usua_incs, dt_incs, cd_pcnt, nm_pcnt, id_status_pcnt, ds_status_pcnt, ds_obs_mapa_risco)
	VALUES ((select NEXTVAL('tratamento.sq_hstr_obs_pnel_mapa_risco')), (SELECT currval('tratamento.sq_hstr_pnel_mapa_risco')), '".$rowdataatual[0]."', 0, '".$_SESSION['usuario']."', current_timestamp, '".$_POST['cd_pcnt']."', '".$nm_pcnt."', ".$_POST['id_status_pcnt'].", '".$ds_status_pcnt."', '".$_POST['ds_obs_mapa_risco']."') ";

					//echo $sql;

					$resultobs = pg_query($pdo, $sqlobs);

					if($resultobs){
						echo "";
					}
						
						
						$sqlinsereriscomaparisco = "SELECT id_risco_rnado_pcnt, id_risco_pcnt, id_hstr_pnel_mapa_risco, nm_pcnt, ds_risco_pacnt, cd_usua_incs, cd_pcnt, dt_incs FROM tratamento.tb_risco_rnado_pcnt where id_hstr_pnel_mapa_risco = ".$rowinseremaparisco[0]."";
										  
					$retinsereriscomaparisco = pg_query($pdo, $sqlinsereriscomaparisco);
					
					//echo $sqlinsereriscomaparisco;
					
					if(!$retinsereriscomaparisco) {
						echo pg_last_error($pdo);		
						exit;
					}
					
					while($rowinsereriscomaparisco = pg_fetch_row($retinsereriscomaparisco)) {	
					
						$sqlinsertrisco = " INSERT INTO tratamento.tb_risco_rnado_pcnt(id_risco_rnado_pcnt, id_risco_pcnt, id_hstr_pnel_mapa_risco, nm_pcnt, ds_risco_pacnt, cd_usua_incs, dt_incs, cd_pcnt) VALUES ((select NEXTVAL('tratamento.sq_risco_rnado_pcnt')), ".$rowinsereriscomaparisco[1].", (select CURRVAL('tratamento.sq_hstr_pnel_mapa_risco')), '".$rowinseremaparisco[2]."', (SELECT ds_risco_pcnt FROM tratamento.tb_c_risco_pcnt where id_risco_pcnt = '".$rowinsereriscomaparisco[1]."'), '".$_SESSION['usuario']."', current_timestamp, '". $_POST['cd_pcnt'] ."'); ";
				
						//echo $sqlinsertrisco;
			
						$resultinsertriscomaparisco = pg_query($pdo, $sqlinsertrisco);

						if($resultinsertriscomaparisco){
							echo "";
						}
						
					}	
					
					$secondsWait = 0;
					header("Refresh:$secondsWait");	
				}
				
			} else {
			
				$sqldataatual = "SELECT to_char(current_timestamp, 'dd/mm/yyyy hh24:mi') ";
											  
				$retdataatual = pg_query($pdo, $sqldataatual);
				
				if(!$retdataatual) {
					echo pg_last_error($pdo);		
					exit;
				}
				
				$rowdataatual = pg_fetch_row($retdataatual);
				
				if ($_POST['id_local_trtmto']=='0' || $_POST['id_local_trtmto']=='' || $_POST['id_status_pcnt']=='0' || $_POST['id_status_pcnt']==''){
					echo "<div class=\"alert alert-warning alert-dismissible\">
						<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
						<strong>Atenção!</strong>Local ou stauts não selecionados para o novo mapa. Execute novamente a inserção e selecione estes campos.</div>";
						
						$secondsWait = 3;
						header("Refresh:$secondsWait");
						
				} else {
				
					$sqlqtdemaparisco = "SELECT count(1)			 
												FROM tratamento.tb_hstr_pnel_mapa_risco 
												WHERE (cd_pcnt = '". $_POST['cd_pcnt'] ."' or id_local_trtmto = ".$_POST['id_local_trtmto'].") and dt_final_mapa_risco is null ";
												  
					$retqtdemaparisco = pg_query($pdo, $sqlqtdemaparisco);
					
					//echo $sqlqtdemaparisco;
					
					if(!$retqtdemaparisco) {
						echo pg_last_error($pdo);		
						exit;
					}
					
					$rowretmaparisco = pg_fetch_row($retqtdemaparisco);
					
					if($rowretmaparisco[0]==0){
						
							$sqlinsertpanelrisco = "INSERT INTO tratamento.tb_hstr_pnel_mapa_risco(
					id_hstr_pnel_mapa_risco, cd_pcnt, nm_pcnt, nu_seq_local_pnel, id_status_pcnt, ds_status_pcnt, dt_inic_mapa_risco, dt_final_mapa_risco, tp_pcnt_mapa_risco, cd_usua_incs, dt_incs, id_local_trtmto, ds_local_trtmto, ds_utlma_obs_mapa_risco, cd_cor_status_pcnt, cd_cnvo) VALUES ((select NEXTVAL('tratamento.sq_hstr_pnel_mapa_risco')), '". $_POST['cd_pcnt'] ."', (SELECT nm_pcnt FROM tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."'), (select nu_seq_local_pnel from tratamento.tb_c_local_trtmto where id_local_trtmto = ".$_POST['id_local_trtmto']."), ".$_POST['id_status_pcnt'].",  (select ds_status_pcnt from tratamento.tb_c_status_pcnt where id_status_pcnt = ".$_POST['id_status_pcnt']."), '".$rowdataatual[0]."', null, 0, '".$_SESSION['usuario']."', current_timestamp, ".$_POST['id_local_trtmto'].", (select ds_local_trtmto from tratamento.tb_c_local_trtmto where id_local_trtmto = ".$_POST['id_local_trtmto']."), '".$_POST['ds_obs_mapa_risco']."', (select cd_cor_status_pcnt from tratamento.tb_c_status_pcnt where id_status_pcnt = ".$_POST['id_status_pcnt']."), (SELECT cd_cnvo FROM tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."'));";
					
								//echo $sqlinsertpanelrisco;
					
								$resultinsertpanelrisco = pg_query($pdo, $sqlinsertpanelrisco);

								if($resultinsertpanelrisco){
									echo "";
								}
								
								$sqlstatus = "select ds_status_pcnt from tratamento.tb_c_status_pcnt where id_status_pcnt = ".$_POST['id_status_pcnt'].";";
								$retstatus = pg_query($pdo, $sqlstatus);
								if(!$retstatus) {
									echo pg_last_error($pdo);		
									exit;
								}				
								$rowstatus = pg_fetch_row($retstatus);				
								$ds_status_pcnt = $rowstatus[0];
								
								$sqlpcnt = "SELECT nm_pcnt FROM tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."' ";
								$retpcnt = pg_query($pdo, $sqlpcnt);
								if(!$retpcnt) {
									echo pg_last_error($pdo);		
									exit;
								}				
								$rowpcnt = pg_fetch_row($retpcnt);				
								$nm_pcnt = $rowpcnt[0];
								
								$sqlobs = "INSERT INTO tratamento.tb_hstr_obs_pnel_mapa_risco(id_hstr_obs_pnel_mapa_risco, id_hstr_pnel_mapa_risco, dt_inic_status_pcnt, tp_min_status_pcnt, cd_usua_incs, dt_incs, cd_pcnt, nm_pcnt, id_status_pcnt, ds_status_pcnt, ds_obs_mapa_risco)
				VALUES ((select NEXTVAL('tratamento.sq_hstr_obs_pnel_mapa_risco')), (SELECT currval('tratamento.sq_hstr_pnel_mapa_risco')), '".$rowdataatual[0]."', 0, '".$_SESSION['usuario']."', current_timestamp, '".$_POST['cd_pcnt']."', '".$nm_pcnt."', ".$_POST['id_status_pcnt'].", '".$ds_status_pcnt."', '".$_POST['ds_obs_mapa_risco']."') ";

							//echo $sql;

							$resultobs = pg_query($pdo, $sqlobs);

							if($resultobs){
								echo "";
							}
							
							$secondsWait = 0;
							header("Refresh:$secondsWait");	
					}else {
					echo "<div class=\"alert alert-warning alert-dismissible\">
						<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
						<strong>Atenção!</strong>Paciente ou Local cadastrado no mapa. Exclua o paciente do mapa para este paciente para incluí-lo novamente.	</div>";
						
						$secondsWait = 3;
						header("Refresh:$secondsWait");
					
					}
					
				} 
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
			
			if ($_POST['fl_mapa_risco_fchd'] == 1){
							
				$sql = "UPDATE tratamento.tb_hstr_pnel_mapa_risco SET tp_pcnt_mapa_risco = round((SELECT date_part( 'day', age(current_timestamp::timestamp WITHOUT TIME ZONE , dt_inic_mapa_risco))*24*60 + date_part( 'hour', age(current_timestamp::timestamp WITHOUT TIME ZONE , dt_inic_mapa_risco))*60 + date_part( 'minute', age(current_timestamp::timestamp WITHOUT TIME ZONE , dt_inic_mapa_risco)))), dt_final_mapa_risco = current_timestamp, cd_usua_altr = '".$_SESSION['usuario']."', dt_altr = current_timestamp WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."' and dt_final_mapa_risco is null ";
				
				//echo $sql;
				
				$result = pg_query($pdo, $sql);
				
				if($result){
					echo "";
				} 
				
			} else {
			
				$sql = "SELECT id_hstr_pnel_mapa_risco
						  FROM tratamento.tb_hstr_pnel_mapa_risco 
						WHERE cd_pcnt = '".$_POST['cd_pcnt']."' and dt_final_mapa_risco is null ";
				
				//echo $sql;

				$rethstrpcnt = pg_query($pdo, $sql);
				
				if(!$rethstrpcnt) {
					echo pg_last_error($pdo);		
					exit;
				}
				
				$rowhstrmaparisco = pg_fetch_row($rethstrpcnt);
								
				$id_hstr_pnel_mapa_risco = $rowhstrmaparisco[0];
			
				$sql = "DELETE FROM tratamento.tb_hstr_obs_pnel_mapa_risco WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."' and id_hstr_pnel_mapa_risco = ".$id_hstr_pnel_mapa_risco." ";
				
				//echo $sql;
				
				$result = pg_query($pdo, $sql);

				if($result){
					echo "";
				} 
				
				$sql = "DELETE FROM tratamento.tb_risco_rnado_pcnt WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."' and id_hstr_pnel_mapa_risco = ".$id_hstr_pnel_mapa_risco." ";
				
				//echo $sql;
				
				$result = pg_query($pdo, $sql);

				if($result){
					echo "";
				} 
				
				$sql = "DELETE FROM tratamento.tb_hstr_pnel_mapa_risco WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."' and id_hstr_pnel_mapa_risco = ".$id_hstr_pnel_mapa_risco." ";
				
				//echo $sql;
				
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
			
			$sql = "SELECT id_hstr_pnel_mapa_risco
						  FROM tratamento.tb_hstr_pnel_mapa_risco 
						WHERE cd_pcnt = '".$_POST['cd_pcnt']."' and dt_final_mapa_risco is null ";
				
			//echo $sql;

			$rethstrpcnt = pg_query($pdo, $sql);
			
			if(!$rethstrpcnt) {
				echo pg_last_error($pdo);		
				exit;
			}
			
			$rowhstrmaparisco = pg_fetch_row($rethstrpcnt);
							
			$id_hstr_pnel_mapa_risco = $rowhstrmaparisco[0];
			
			$sql = "UPDATE tratamento.tb_hstr_pnel_mapa_risco SET ds_utlma_obs_mapa_risco = '". $_POST['ds_utlma_obs_mapa_risco'] ."', cd_usua_altr = '".$_SESSION['usuario']."', dt_altr = current_timestamp WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."' and id_status_pcnt = ". $_POST['id_status_pcnt'] ." and id_hstr_pnel_mapa_risco = ".$id_hstr_pnel_mapa_risco." ";
			
			//echo $sql;
			
			$result = pg_query($pdo, $sql);
			
			if($result){
				echo "";
			} 
			
			$sql = "UPDATE tratamento.tb_hstr_obs_pnel_mapa_risco SET ds_obs_mapa_risco = '". $_POST['ds_utlma_obs_mapa_risco'] ."', cd_usua_altr = '".$_SESSION['usuario']."', dt_altr = current_timestamp WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."' and id_status_pcnt = ". $_POST['id_status_pcnt'] ." and id_hstr_pnel_mapa_risco = ".$id_hstr_pnel_mapa_risco." ";
			
			//echo $sql;
			
			$result = pg_query($pdo, $sql);
			
			if($result){
				echo "";
			} 
				
			//voltar aqui
			$secondsWait = 0;
			header("Refresh:$secondsWait");

				
		} catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
	
	if(isset($_POST['insererisco'])){					
		
		if ($pdo==null){
			header(Config::$webLogin);
		}
		
		try
		{	
		
			$sql = "SELECT count(1)
					FROM tratamento.tb_risco_rnado_pcnt mapa_risco
					   , tratamento.tb_hstr_pnel_mapa_risco mapa_risco_pcnt
					WHERE mapa_risco_pcnt.id_hstr_pnel_mapa_risco = mapa_risco.id_hstr_pnel_mapa_risco
					  and mapa_risco_pcnt.dt_final_mapa_risco  is null
					  and mapa_risco.id_risco_pcnt = ".$_POST['id_risco_pcnt']."
					  and mapa_risco_pcnt.cd_pcnt = '".$_POST['cd_pcnt']."' ";
			
			if ($pdo==null){
					header(Config::$webLogin);
			}	
			$retqtderiscopcnt = pg_query($pdo, $sql);
			if(!$retqtderiscopcnt) {
				echo pg_last_error($pdo);
				exit;
			}
		
			$rowqtderiscopcnt = pg_fetch_row($retqtderiscopcnt);
			
			if($rowqtderiscopcnt[0]==0){
		
				$sql = "SELECT id_hstr_pnel_mapa_risco
							  FROM tratamento.tb_hstr_pnel_mapa_risco 
							WHERE cd_pcnt = '".$_POST['cd_pcnt']."' and dt_final_mapa_risco is null ";
					
				//echo $sql;

				$rethstrpcnt = pg_query($pdo, $sql);
				
				if(!$rethstrpcnt) {
					echo pg_last_error($pdo);		
					exit;
				}
				
				$rowhstrmaparisco = pg_fetch_row($rethstrpcnt);
								
				$id_hstr_pnel_mapa_risco = $rowhstrmaparisco[0];
				
				$sqlriscornado = "INSERT INTO tratamento.tb_risco_rnado_pcnt(id_risco_rnado_pcnt, id_risco_pcnt, id_hstr_pnel_mapa_risco, nm_pcnt, ds_risco_pacnt, cd_usua_incs, dt_incs, cd_pcnt) VALUES ((select NEXTVAL('tratamento.sq_risco_rnado_pcnt')), ".$_POST['id_risco_pcnt'].", ".$id_hstr_pnel_mapa_risco.", (SELECT nm_pcnt FROM tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."'), (SELECT ds_risco_pcnt FROM tratamento.tb_c_risco_pcnt where id_risco_pcnt = '".$_POST['id_risco_pcnt']."'), '".$_SESSION['usuario']."', current_timestamp, '".$_POST['cd_pcnt']."'); ";
				
				//echo $sql;
				
				$resultriscornado = pg_query($pdo, $sqlriscornado);
				
				if($resultriscornado){
					echo "";
				} 
						
				$secondsWait = 0;
				header("Refresh:$secondsWait");
				
			} else { 
			
				echo "<div class=\"alert alert-warning alert-dismissible\">
					<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
					<strong>Atenção!</strong> Risco já existe para o paciente. Tente novamente com outro risco.	</div>";
				
				$secondsWait = 3;
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
			
			
			$sql = "DELETE FROM tratamento.tb_hstr_obs_pnel_mapa_risco WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."' and id_status_pcnt = ". $_POST['id_status_pcnt'] ." and id_hstr_obs_pnel_mapa_risco = ".$_POST['id_hstr_obs_pnel_mapa_risco']." ";
			
			//echo $sql;
			
			$result = pg_query($pdo, $sql);

			if($result){
				echo "";
			} 
						
			$sql = "SELECT mapa_hstr.id_status_pcnt
			             , mapa_hstr.ds_status_pcnt
						 , status.cd_cor_status_pcnt
						 , mapa_hstr.ds_obs_mapa_risco
					FROM tratamento.tb_hstr_obs_pnel_mapa_risco mapa_hstr
					   , tratamento.tb_c_status_pcnt status 
					WHERE mapa_hstr.id_status_pcnt = status.id_status_pcnt
					  AND mapa_hstr.id_hstr_obs_pnel_mapa_risco = (
														SELECT max(id_hstr_obs_pnel_mapa_risco)
															FROM tratamento.tb_hstr_obs_pnel_mapa_risco mapa
														WHERE mapa.cd_pcnt =  '". $_POST['cd_pcnt'] ."'													  
														)
					";
			
			//echo $sql;

			$retultimostatus = pg_query($pdo, $sql);
			
			if(!$retultimostatus) {
				echo pg_last_error($pdo);		
				exit;
			}
			
			$rowretultimostatus = pg_fetch_row($retultimostatus);
			
			$id_status_pcnt = $rowretultimostatus[0];
			$ds_status_pcnt = $rowretultimostatus[1];
			$cd_cor_status_pcnt = $rowretultimostatus[2];
			$ds_utlma_obs_mapa_risco = $rowretultimostatus[3];
			
			If($ds_status_pcnt==''){
				$sql = "UPDATE tratamento.tb_hstr_pnel_mapa_risco set id_status_pcnt = null, ds_status_pcnt = null, cd_cor_status_pcnt = null WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."' and id_hstr_pnel_mapa_risco = ".$_POST['id_hstr_pnel_mapa_risco']." ";
			} else {					
				$sql = "UPDATE tratamento.tb_hstr_pnel_mapa_risco set ds_utlma_obs_mapa_risco = '".$ds_utlma_obs_mapa_risco ."' , id_status_pcnt = ".$id_status_pcnt.", ds_status_pcnt = '".$ds_status_pcnt."', cd_cor_status_pcnt = '".$cd_cor_status_pcnt."' WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."' and dt_final_mapa_risco is null ";
			}
			
			//echo $sql;
			
			$result = pg_query($pdo, $sql);

			if($result){
				echo "";
			} 
		
			//voltar aqui
			$secondsWait = 0;
			header("Refresh:$secondsWait");
				
		} catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
	
	
	if(isset($_POST['excluirisco'])){					
		
		if ($pdo==null){
			header(Config::$webLogin);
		}
		
		try
		{				
		
			$sql = "DELETE FROM tratamento.tb_risco_rnado_pcnt WHERE id_risco_rnado_pcnt = ". $_POST['id_risco_rnado_pcnt'] ." ";
			
			//echo $sql;
			
			$result = pg_query($pdo, $sql);

			if($result){
				echo "";
			} 
			
			//voltar aqui
			$secondsWait = 0;
			header("Refresh:$secondsWait");
				
		} catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
	
	
	if(isset($_POST['forminsereacessovenoso'])){					
		
		if ($pdo==null){
			header(Config::$webLogin);
		}
		
		try
		{				
			
			if ($_POST['acessovenoso']=='avp'){
				$selacessovenoso = 1;
			} else {
				$selacessovenoso = 0;
			}
			
			if ($_POST['acessovenoso']=='cvc'){
				$catetervenosocentral = 1;
			} else {
				$catetervenosocentral = 0;
			}
			
			if ($_POST['ev_text']=='true'){
				$ev = 1;
			} else {
				$ev = 0;
			}	
			
			if ($_POST['sc_text']=='true'){
				$sc = 1;
			} else {
				$sc = 0;
			}	
			
			if ($_POST['im_text']=='true'){
				$im = 1;
			} else {
				$im = 0;
			}
			
			if ($_POST['vv_text']=='true'){
				$vv = 1;
			} else {
				$vv = 0;
			}
			
			$sql = "update tratamento.tb_hstr_pnel_mapa_risco set fl_acesso_vnso_pefrco = ".$selacessovenoso.", fl_cttr_vnso_central = ".$catetervenosocentral." , fl_via_aplc_edvnso = ".$ev.", fl_via_aplc_sctnea = ".$sc.", fl_via_aplc_intramusc = ".$im.", fl_via_aplc_vscal = ".$vv.", cd_usua_altr = '".$_SESSION['usuario']."', dt_altr = current_timestamp  WHERE dt_final_mapa_risco is null and cd_pcnt = '". $_POST['cd_pcnt'] ."' ";
			
			//echo $sql;
			
			$result = pg_query($pdo, $sql);

			if($result){
				echo "";
			} 
			
			//voltar aqui
			$secondsWait = 0;
			header("Refresh:$secondsWait");
				
		} catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
	
	if(isset($_POST['insercaopacientemapa'])){					
		
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
		VALUES ('". $_POST['cd_pcnt'] ."', '". $_POST['nm_pcnt'] ."', '". $_POST['dt_nasc_pcnt'] ."', '". $_POST['ds_mncp'] ."', '".$_SESSION['usuario']."', current_timestamp, (select id_cnvo from tratamento.tb_c_cnvo where cd_cnvo = '". $_POST['cd_cnvo'] ."'), '". $_POST['cd_cnvo'] ."')";
		
				//echo $sqlinsertpcnt;
		
				$result = pg_query($pdo, $sqlinsertpcnt);

				if($result){
					echo "";
				}  
				
			} else {
				$sqlupdatepcnt = "UPDATE tratamento.tb_c_pcnt SET nm_pcnt='". $_POST['nm_pcnt'] ."', dt_nasc_pcnt = '". $_POST['dt_nasc_pcnt'] ."', ds_mncp_pcnt= '". $_POST['ds_mncp'] ."', id_cnvo = (select id_cnvo from tratamento.tb_c_cnvo where cd_cnvo = '". $_POST['cd_cnvo'] ."'), cd_cnvo = '". $_POST['cd_cnvo'] ."', cd_usua_altr = '".$_SESSION['usuario']."', dt_altr = current_timestamp WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."'";
				
				//echo $sqlupdatepcnt;
				
				$result = pg_query($pdo, $sqlupdatepcnt);

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
	
	
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Mapa de Tratamento</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script type="text/javascript">
	var auto_refresh = setInterval(
	function ()
	{
		$('#qtderegmapa').load('aviso_quatidade_reg_mapa.php').fadeIn("slow");}, 10000); // refresh every 10000 milliseconds
   </script>
  <style>
    .grid {
      display: grid;
      grid-template-columns: auto auto auto;
      grid-template-rows: auto auto auto;
      grid-gap: 5px;
      position: relative;
      font-size: 12px;
      height: 70px;
    }

    .grid > * {
      border: 1px solid;
    }
  </style>
</head>
<body> 
	<br>
	<div class="container">		
		<h2 id="qtderegmapa"></h2>
	</div>
	<br>
	<hr>
	<div class="container">  
	  <form class="form-inline" action="#" method="post" >
			<input type="button" style="font-size: 11px;" value="Novo Paciente" class="btn btn-primary btn-xs inserepaciente" />&nbsp;
			<input type="button" style="font-size: 11px;" value="Novo Mapa" class="btn btn-primary btn-xs insere" />&nbsp;
			<input type="button" style="font-size: 11px;" value="Novo Risco" class="btn btn-primary btn-xs novorisco"/>&nbsp;
			<input type="button" style="font-size: 11px;" value="Exclui Risco" class="btn btn-primary btn-xs excluirisco"/>&nbsp;	
			<input type="button" style="font-size: 11px;" value="Novo Status" class="btn btn-primary btn-xs novostatus"/>&nbsp;
			<input type="button" style="font-size: 11px;" value="Exclui Status" class="btn btn-primary btn-xs excluistatus"/>&nbsp;
			<input type="button" style="font-size: 11px;" value="Altera Observação" class="btn btn-primary btn-xs alteraobs"/>&nbsp;
			<input type="button" style="font-size: 11px;" value="Acesso Venoso" class="btn btn-primary btn-xs insereacessovenoso"/>&nbsp;
			<input type="button" style="font-size: 11px;" value="Finaliza Mapa" class="btn btn-primary btn-xs finalizamapa"/>&nbsp;
	  </form>		  
	</div>
	
	<hr>
			
		<br>		
		
        <div class="container"> 
		<div class="card-columns">		
		
		<?php

        $cont=1;
		$ret = pg_query($pdo, $sql);		
		
        while($row = pg_fetch_row($ret)) {	
			
		?>
			<div class="card bg-light">
         <?php		
            ?>				
				<div class="card-body text-center">
                <p class="card-text"><input type="button" name="view" value="<?php echo trim($row[2]); ?>" id="<?php echo trim($row[2]); ?>" class="btn btn-info btn-xs view_data" /></p>
				
				<?php
			
					echo "<p style='font-weight: bold'>". substr($row[3], 0, 20) . "</p>";			
					echo "<p>".$row[5]."".$row[6]."</p>"; 
					echo "<p>".$row[7]." ".$row[8]." ".$row[9]." ".$row[10]."</p>"; 
					echo "<p style='background-color:".$row[4]."'>". $row[1]. "</p>";	
				
					$pdo = database::connect();
					
					$sql="SELECT distinct risco.ds_risco_pcnt
								 , risco.cd_cor_risco_pcnt
							FROM tratamento.tb_hstr_pnel_mapa_risco mapa_risco
							   , tratamento.tb_risco_rnado_pcnt	risco_rnado   
							   , tratamento.tb_c_risco_pcnt risco
							WHERE mapa_risco.id_hstr_pnel_mapa_risco = risco_rnado.id_hstr_pnel_mapa_risco
							  AND risco.id_risco_pcnt = risco_rnado.id_risco_pcnt
							  AND mapa_risco.cd_pcnt = '".$row[0]."'
							  AND mapa_risco.dt_final_mapa_risco is null";		
					
					$ret_risco = pg_query($pdo, $sql);
					if(!$ret_risco) {
						pg_last_error($pdo);
						exit;
					}    
				
					?><div class="grid"><?php
				
					while($row_risco = pg_fetch_row($ret_risco)) 
					{																		 
						echo "<div style='background-color:".$row_risco[1]."; color:black;'>" . trim($row_risco[0]). "</div>";						
					}	
				?>				
				</div>								
				</div>
				</div>
				<?php
        }		
        //database::disconnect();
        ?>                
		</div>  
		</div>			
		<!-- Modal -->				
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
	<script>
		
		$(document).ready(function(){
			$(document).on('click', '.insere', function(){
				
				event.preventDefault();			
				$.ajax({
					type: "POST",
					url:"../mapa/insercao_mapa.php",				
					success : function(completeHtmlPage) {									
						$("html").empty();					
						$("html").append(completeHtmlPage);										
					}
				});			
			});	
		});
		
		$(document).ready(function(){
			$(document).on('click', '.novorisco', function(){
				
				event.preventDefault();			
				$.ajax({
					type: "POST",
					url:"../mapa/insercao_risco_paciente.php",				
					success : function(completeHtmlPage) {									
						$("html").empty();					
						$("html").append(completeHtmlPage);										
					}
				});			
			});	
		});
		
		$(document).ready(function(){
			$(document).on('click', '.excluirisco', function(){
				
				event.preventDefault();			
				$.ajax({
					type: "POST",
					url:"../mapa/exclui_risco_paciente.php",				
					success : function(completeHtmlPage) {									
						$("html").empty();					
						$("html").append(completeHtmlPage);										
					}
				});			
			});	
		});
		
		$(document).ready(function(){
			$(document).on('click', '.novostatus', function(){
				
				event.preventDefault();			
				$.ajax({
					type: "POST",
					url:"../mapa/insere_status_paciente_mapa.php",				
					success : function(completeHtmlPage) {									
						$("html").empty();					
						$("html").append(completeHtmlPage);										
					}
				});			
			});	
		});
		
		$(document).ready(function(){
			$(document).on('click', '.excluistatus', function(){
				
				event.preventDefault();			
				$.ajax({
					type: "POST",
					url:"../mapa/exclui_status_paciente_mapa.php",				
					success : function(completeHtmlPage) {									
						$("html").empty();					
						$("html").append(completeHtmlPage);										
					}
				});			
			});	
		});
		
		$(document).ready(function(){
			$(document).on('click', '.insereacessovenoso', function(){
				
				event.preventDefault();			
				$.ajax({
					type: "POST",
					url:"../mapa/insere_acesso_venoso.php",				
					success : function(completeHtmlPage) {									
						$("html").empty();					
						$("html").append(completeHtmlPage);										
					}
				});			
			});	
		});
		
		$(document).ready(function(){
			$(document).on('click', '.excluirisco', function(){
				
				event.preventDefault();			
				$.ajax({
					type: "POST",
					url:"../mapa/exclui_risco_paciente.php",				
					success : function(completeHtmlPage) {									
						$("html").empty();					
						$("html").append(completeHtmlPage);										
					}
				});			
			});	
		});		
		
		$(document).ready(function(){
			$(document).on('click', '.alteraobs', function(){
				
				event.preventDefault();			
				$.ajax({
					type: "POST",
					url:"../mapa/altera_status_paciente_mapa.php",				
					success : function(completeHtmlPage) {									
						$("html").empty();					
						$("html").append(completeHtmlPage);										
					}
				});			
			});	
		});
		
		$(document).ready(function(){
			$(document).on('click', '.finalizamapa', function(){
				
				event.preventDefault();			
				$.ajax({
					type: "POST",
					url:"../mapa/finaliza_paciente_mapa.php",				
					success : function(completeHtmlPage) {									
						$("html").empty();					
						$("html").append(completeHtmlPage);										
					}
				});			
			});	
		});
		
		$(document).ready(function(){
			$(document).on('click', '.inserepaciente', function(){
				
				event.preventDefault();			
				$.ajax({
					type: "POST",
					url:"../mapa/insercao_paciente_mapa.php",				
					success : function(completeHtmlPage) {									
						$("html").empty();					
						$("html").append(completeHtmlPage);										
					}
				});			
			});	
		});
		
		$(document).on('click', '.view_data', function(){
			//$('#dataModal').modal();
			var local = $(this).attr("id");
			$.ajax({
				url:"../mapa/selecao_detalhe_paciente_mapa.php",
				method:"POST",
				data:{local:local},
				success:function(data){
					$('#detalhe_paciente').html(data);
					$('#dataModal').modal('show');
				}
			});
		});
		
	</script>
</html>
<?php ?>