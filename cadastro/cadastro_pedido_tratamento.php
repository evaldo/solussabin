<?php
		
	session_start();		
	
    include '../database.php';
	
	error_reporting(0); 
	
    global $pdo;	
	
	$pdo = database::connect();
	
	$optconsulta = "";
	$textoconsulta = "";	
	$sql = '';
	
	if(isset($_POST['botaoconsultar'])&& $_POST['textoconsulta']<>""){
		
		$textoconsulta = strtoupper($_POST['textoconsulta']);
		
		$sql ="SELECT id_pddo_trtmto, nm_pcnt, to_char(dt_incs, 'dd/mm/yyyy hh24:mi') as dt_incs
				from tratamento.tb_pddo_trtmto 
				where upper(nm_pcnt) like upper('%" . $textoconsulta . "%') order by nm_pcnt asc, id_pddo_trtmto desc ";
		
	} else{
		
			$sql ="SELECT id_pddo_trtmto, nm_pcnt, to_char(dt_incs, 'dd/mm/yyyy hh24:mi') as dt_rlzd
				from tratamento.tb_pddo_trtmto order by nm_pcnt asc, id_pddo_trtmto desc";	
	}
	
	if ($pdo==null){
			header(Config::$webLogin);
	}	
    $ret = pg_query($pdo, $sql);
    if(!$ret) {
        echo pg_last_error($pdo);
        exit;
    }
	
	if(isset($_POST['insere'])){					
		
		if ($pdo==null){
			header(Config::$webLogin);
		}
		
		try
		{	
		
			if ($_POST['ds_exame_enviado']=='' || $_POST['ds_exame_enviado']==null){
				echo "<div class=\"alert alert-warning alert-dismissible\">
						<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
						<strong>Atenção!</strong> ATENÇÃO. Campo Exames Enviados não pode estar em branco. Clique em <input type='submit' class='btn btn-primary' onclick='history.go()' value='Voltar'> caso necessite repetir a operação.</div>";
			}
		
			$inserenovotratamento=0;
		
			if ($_POST['id_hstr_pnel_solic_trtmto']=='null' || $_POST['id_hstr_pnel_solic_trtmto']==null || $_POST['id_hstr_pnel_solic_trtmto']=='') {
				$_POST['id_hstr_pnel_solic_trtmto']='null';
			}
			
			if ($_POST['dt_rlzd'] == null){
				$dt_rlzd = 'null';
			} else {
				$dt_rlzd = "'".$_POST['dt_rlzd']."'";
			}
			
			if ($_POST['dt_aplc'] == null){
				$dt_aplc = 'null';
			} else {
				$dt_aplc = "'".$_POST['dt_aplc']."'";
			}
			
			if ($_POST['dt_diagn'] == null){
				$dt_diagn = 'null';
			} else {
				$dt_diagn = "'".$_POST['dt_diagn']."'";
			}
			
			$id_hstr_pnel_solic_trtmto = "null";
			
			$sql = "SELECT count(id_hstr_pnel_solic_trtmto) FROM tratamento.tb_hstr_pnel_solic_trtmto WHERE cd_pcnt = '".$_POST['cd_pcnt']."' and id_equipe = 13 and fl_trtmto_fchd = 0  ";
					
			$retcountpanelsolictrtmto = pg_query($pdo, $sql);
				
			if(!$retcountpanelsolictrtmto) {
				echo pg_last_error($pdo);		
				exit;
			}
				
			$rowcountpanelsolictrtmto = pg_fetch_row($retcountpanelsolictrtmto);
			
			if ($rowcountpanelsolictrtmto[0] > 0) {
			
				$sql = "SELECT MAX(id_hstr_obs_pnel_solic_trtmto) FROM tratamento.tb_hstr_obs_pnel_solic_trtmto WHERE cd_pcnt = '".$_POST['cd_pcnt']."' and id_status_equipe = 13 ";
					
				$retmaxstatusequipe = pg_query($pdo, $sql);
					
				if(!$retmaxstatusequipe) {
					echo pg_last_error($pdo);		
					exit;
				}
					
				$rowmaxstatusequipe = pg_fetch_row($retmaxstatusequipe);

				$sql = "SELECT MAX(id_hstr_pnel_solic_trtmto) FROM tratamento.tb_hstr_pnel_solic_trtmto WHERE cd_pcnt = '".$_POST['cd_pcnt']."' and id_equipe = 13 and fl_trtmto_fchd = 0 ";
					
				$retmaxpanelsolictrtmto = pg_query($pdo, $sql);
					
				if(!$retmaxpanelsolictrtmto) {
					echo pg_last_error($pdo);		
					exit;
				}
					
				$rowmaxpanelsolictrtmto = pg_fetch_row($retmaxpanelsolictrtmto);
							
				$sql = "SELECT id_hstr_pnel_solic_trtmto, dt_inicial_trtmto 
						  FROM tratamento.tb_hstr_pnel_solic_trtmto 
						WHERE cd_pcnt = '".$_POST['cd_pcnt']."' and id_equipe = 13 and fl_trtmto_fchd = 0 and id_hstr_pnel_solic_trtmto = ".$rowmaxpanelsolictrtmto[0]." ";

				//echo $sql;

				$rethstrtratamento = pg_query($pdo, $sql);

				if(!$rethstrtratamento) {
					echo pg_last_error($pdo);		
					exit;
				}

				$rowhstrtratamento = pg_fetch_row($rethstrtratamento);

				$id_hstr_pnel_solic_trtmto = $rowhstrtratamento[0];
				$dt_inicial_trtmto = $rowhstrtratamento[1];
						
				$sql = "update tratamento.tb_hstr_pnel_solic_trtmto set id_status_trtmto = ".$_POST['id_status_trtmto'].", ds_status_trtmto = (select ds_status_trtmto from tratamento.tb_c_status_trtmto where id_status_trtmto = ".$_POST['id_status_trtmto']."), cd_cor_status_trtmto = (select cd_cor_status_trtmto from tratamento.tb_c_status_trtmto where id_status_trtmto = ".$_POST['id_status_trtmto']."), cd_usua_altr = '".$_SESSION['usuario']."', dt_altr = current_timestamp where id_hstr_pnel_solic_trtmto = ".$id_hstr_pnel_solic_trtmto."";
						
				//echo $sql;

				$result = pg_query($pdo, $sql);

				if($result){
					echo "";
				}
				
				$sql = "select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '". $_POST['cd_pcnt']."'  ";
					
				$retnmpcnt = pg_query($pdo, $sql);
					
				if(!$retnmpcnt) {
					echo pg_last_error($pdo);		
					exit;
				}
					
				$rowpcnt = pg_fetch_row($retnmpcnt);
						
				$sql = "insert into tratamento.tb_log_alrt (id_log_alrt, cd_alrt, ds_alrt, cd_usua_incs_alrt, dt_incs_alrt, nm_pcnt) values ((select NEXTVAL('tratamento.sq_log_alrt')),'INSERCAO DE STATUS DE TRATAMENTO', (select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."')||' - '||(select ds_equipe from tratamento.tb_c_equipe where id_equipe = 13)||' - '||(select ds_status_trtmto from tratamento.tb_c_status_trtmto where id_status_trtmto = ".$_POST['id_status_trtmto']."), '".$_SESSION['usuario']."', current_timestamp, '".$rowpcnt[0]."')";

				$result = pg_query($pdo, $sql);

				if($result){
					echo "";
				}


				$sql = "INSERT INTO tratamento.tb_hstr_obs_pnel_solic_trtmto(id_hstr_obs_pnel_solic_trtmto, id_hstr_pnel_solic_trtmto, id_status_equipe, ds_status_equipe, dt_inic_status_equipe_trtmto, dt_final_status_equipe_trtmto, ds_obs_pcnt, tp_minuto_status_equipe_trtmto, cd_usua_incs, dt_incs, dt_inicial_trtmto, cd_pcnt, nm_pcnt, id_status_trtmto, ds_status_trtmto)
				VALUES ((select NEXTVAL('tratamento.sq_hstr_obs_pnel_solic_trtmto')), ".$id_hstr_pnel_solic_trtmto.", 13, (select ds_equipe from tratamento.tb_c_equipe where id_equipe = 13), current_timestamp, null, null, 0, '".$_SESSION['usuario']."', current_timestamp, '".$dt_inicial_trtmto."', '".$_POST['cd_pcnt']."', (select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."'),".$_POST['id_status_trtmto'].", (select ds_status_trtmto from tratamento.tb_c_status_trtmto where id_status_trtmto = ".$_POST['id_status_trtmto']."));";

				//echo $sql;

				$result = pg_query($pdo, $sql);

				if($result){
					echo "";
				} 
						
				$sql = "UPDATE tratamento.tb_hstr_obs_pnel_solic_trtmto set dt_final_status_equipe_trtmto=current_timestamp, tp_minuto_status_equipe_trtmto = round((SELECT date_part( 'day', age(current_timestamp::timestamp WITHOUT TIME ZONE , dt_inic_status_equipe_trtmto))*24*60 + date_part( 'hour', age(current_timestamp::timestamp WITHOUT TIME ZONE , dt_inic_status_equipe_trtmto))*60 + date_part( 'minute', age(current_timestamp::timestamp WITHOUT TIME ZONE , dt_inic_status_equipe_trtmto)))), cd_usua_altr = '".$_SESSION['usuario']."', dt_altr = current_timestamp where id_hstr_obs_pnel_solic_trtmto = ".$rowmaxstatusequipe[0]."";

				//echo $sql;

				$result = pg_query($pdo, $sql);

				if($result){
					echo "";
				} 
			
			} else {

				$inserenovotratamento=1;
				//Insere novo tratamento

				

				$sqldataatual = "SELECT to_char(current_timestamp, 'dd/mm/yyyy hh24:mi') ";										  

				$retdataatual = pg_query($pdo, $sqldataatual);					

				if(!$retdataatual) {

					echo pg_last_error($pdo);		

					exit;

				}					

				$rowdataatual = pg_fetch_row($retdataatual);

				

				

				$sqlpcnt = "SELECT nm_pcnt, dt_nasc_pcnt, ds_mncp_pcnt FROM tratamento.tb_c_pcnt WHERE cd_pcnt = '".$_POST['cd_pcnt']."' ";					

				$retpcnt = pg_query($pdo, $sqlpcnt);									

				if(!$retpcnt) {

					echo pg_last_error($pdo);		

					exit;

				}					

				$rowpcnt = pg_fetch_row($retpcnt);

				

				$sqlequipetratamento = "SELECT 

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

				

				$retequipetratamento = pg_query($pdo, $sqlequipetratamento);

									

				if(!$retequipetratamento) {

					echo pg_last_error($pdo);		

					exit;

				}

									

				while($rowretequipetratamento = pg_fetch_row($retequipetratamento)) {

				

					$sql = "INSERT INTO tratamento.tb_hstr_pnel_solic_trtmto(

		id_hstr_pnel_solic_trtmto, cd_pcnt, nm_pcnt, dt_nasc_pcnt, ds_mncp_pcnt, id_equipe, ds_equipe, nu_seq_equipe_pnel, id_status_trtmto, ds_status_trtmto, fl_trtmto_fchd, dt_inicial_trtmto, dt_final_trtmto, ds_utlma_obs_pcnt, tp_dia_trtmto, tp_hora_trtmto, tp_minuto_trtmto, cd_usua_incs, dt_incs, cd_usua_altr, dt_altr, cd_cor_status_trtmto, cd_cnvo)

		VALUES ((select NEXTVAL('tratamento.sq_hstr_pnel_solic_trtmto')), '". $_POST['cd_pcnt'] ."', '". $rowpcnt[0] ."', '". $rowpcnt[1] ."', '". $rowpcnt[2] ."', ".$rowretequipetratamento[0].", '".$rowretequipetratamento[1]."', ".$rowretequipetratamento[2].", ".$rowretequipetratamento[3].", '".$rowretequipetratamento[4]."', 0, '".$rowdataatual[0]."', null, 'INICIO DO TRATAMENTO', 0, 0, 0, '".$_SESSION['usuario']."', current_timestamp, null, null, '".$rowretequipetratamento[5]."', '". $_POST['cd_cnvo'] ."');";		

					//echo $sql;		

					$result = pg_query($pdo, $sql);					

					if($result){

						echo "";

					}
					

					$sql = "INSERT INTO tratamento.tb_hstr_obs_pnel_solic_trtmto(id_hstr_obs_pnel_solic_trtmto, id_hstr_pnel_solic_trtmto, id_status_equipe, ds_status_equipe, dt_inic_status_equipe_trtmto, dt_final_status_equipe_trtmto, ds_obs_pcnt, tp_minuto_status_equipe_trtmto, cd_usua_incs, dt_incs, dt_inicial_trtmto, cd_pcnt, nm_pcnt, id_status_trtmto, ds_status_trtmto)

		VALUES ((select NEXTVAL('tratamento.sq_hstr_obs_pnel_solic_trtmto')), (SELECT currval('tratamento.sq_hstr_pnel_solic_trtmto')), ".$rowretequipetratamento[0].", '".$rowretequipetratamento[1]."', '".$rowdataatual[0]."', null, 'INICIO DO TRATAMENTO', 0, '".$_SESSION['usuario']."', current_timestamp, '".$rowdataatual[0]."', '".$_POST['cd_pcnt']."', '". $rowpcnt[0] ."',".$rowretequipetratamento[3].", '".$rowretequipetratamento[4]."') ";

					//echo $sql;

					$result = pg_query($pdo, $sql);			

					if($result){

						echo "";

					}

					
					$sql = "insert into tratamento.tb_log_alrt (id_log_alrt, cd_alrt, ds_alrt, cd_usua_incs_alrt, dt_incs_alrt, nm_pcnt) values ((select NEXTVAL('tratamento.sq_log_alrt')),'INSERCAO DE TRATAMENTO', (select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."')||' - INICIO DE TRATAMENTO - ".$rowretequipetratamento[2]."', '".$_SESSION['usuario']."', current_timestamp, (select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."'))";						

					$result = pg_query($pdo, $sql);

					if($result){

						echo "";

					}			

					

				

				

				}

				



			}
			
			$sql = "select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '". $_POST['cd_pcnt']."'  ";
					
			$retnmpcnt = pg_query($pdo, $sql);
				
			if(!$retnmpcnt) {
				echo pg_last_error($pdo);		
				exit;
			}
				
			$rowpcnt = pg_fetch_row($retnmpcnt);
		
			$sql = "INSERT INTO tratamento.tb_pddo_trtmto(id_pddo_trtmto, id_hstr_pnel_solic_trtmto, cd_pcnt, nm_pcnt, dt_nasc_pcnt, vl_idade_pcnt, nu_peso_pcnt, vl_altura_pcnt, vl_sup_corp, ds_indic_clnic, dt_diagn, cd_cid, ds_plano_trptco, ds_info_rlvnte, ds_diagn_cito_hstpagico, ds_tp_cirurgia, ds_area_irrda, dt_rlzd, dt_aplc, ds_obs_jfta, nu_qtde_ciclo_prta, ds_ciclo_atual, ds_dia_ciclo_atual, ds_intrv_entre_ciclo_dia, ds_estmt, ds_tipo_linha_trtmto, ds_fnlde, ic_tipo_tumor, ic_tipo_nodulo, ic_tipo_metastase, cd_usua_incs, dt_incs, cd_cnvo, nm_mdco_encaminhador, ic_crioterapia, ds_exame_enviado)
	VALUES ((select NEXTVAL('tratamento.sq_pddo_trtmto')), ". $id_hstr_pnel_solic_trtmto.", '". $_POST['cd_pcnt']."', (select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '". $_POST['cd_pcnt']."'), (select dt_nasc_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '". $_POST['cd_pcnt']."'), (select date_part('year', age(now(), (select dt_nasc_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '". $_POST['cd_pcnt']."')))), ". str_replace(",", ".", $_POST['nu_peso_pcnt']).", ". str_replace(",", ".", $_POST['vl_altura_pcnt']).", ". str_replace(",", ".", $_POST['vl_sup_corp']).", UPPER('".str_replace("'", " ",$_POST['ds_indic_clnic'])."'), ".$dt_diagn.", '". $_POST['cd_cid']."', UPPER('". str_replace("'", " ",$_POST['ds_plano_trptco'])."'), UPPER('". str_replace("'", " ",$_POST['ds_info_rlvnte'])."'), UPPER('". str_replace("'", " ",$_POST['ds_diagn_cito_hstpagico'])."'), UPPER('". str_replace("'", " ",$_POST['ds_tp_cirurgia'])."'), UPPER('". str_replace("'", " ",$_POST['ds_area_irrda'])."'), ".$dt_rlzd.", ".$dt_aplc.", UPPER('". str_replace("'", " ",$_POST['ds_obs_jfta'])."'), '". $_POST['nu_qtde_ciclo_prta']."', '". $_POST['ds_ciclo_atual']."', '". $_POST['ds_dia_ciclo_atual']."', '". $_POST['ds_intrv_entre_ciclo_dia']."', '". $_POST['ds_estmt']."' ,'". $_POST['ds_tipo_linha_trtmto']."', '".$_POST['ds_fnlde']."', '". $_POST['ic_tipo_tumor']."', '". $_POST['ic_tipo_nodulo']."', '". $_POST['ic_tipo_metastase']."', '".$_SESSION['usuario']."', current_timestamp, '". $_POST['cd_cnvo']."', '". $_POST['nm_mdco_encaminhador']."', '". $_POST['ic_crioterapia']."', '". $_POST['ds_exame_enviado']."');";
	
			//echo $sql;
			
			$_SESSION['cd_pcnt'] = $_POST['cd_pcnt'];
			$_SESSION['cd_cnvo'] = $_POST['cd_cnvo'];
			$_SESSION['nu_peso_pcnt'] = $_POST['nu_peso_pcnt'];
			$_SESSION['vl_altura_pcnt'] = $_POST['vl_altura_pcnt'];
			$_SESSION['vl_sup_corp'] = $_POST['vl_sup_corp'];
			$_SESSION['ds_indic_clnic'] = $_POST['ds_indic_clnic'];
			$_SESSION['dt_diagn'] = $dt_diagn;
			$_SESSION['cd_cid'] = $_POST['cd_cid'];
			$_SESSION['ds_estmt'] = $_POST['ds_estmt'];
			$_SESSION['ds_tipo_linha_trtmto'] = $_POST['ds_tipo_linha_trtmto'];
			$_SESSION['ds_fnlde'] = $_POST['ds_fnlde'];
			$_SESSION['ic_tipo_tumor'] = $_POST['ic_tipo_tumor'];
			$_SESSION['ic_tipo_nodulo'] = $_POST['ic_tipo_nodulo'];
			$_SESSION['ic_tipo_metastase'] = $_POST['ic_tipo_metastase'];
			$_SESSION['ds_plano_trptco'] = $_POST['ds_plano_trptco'];
			$_SESSION['ds_info_rlvnte'] = $_POST['ds_info_rlvnte'];
			$_SESSION['ds_diagn_cito_hstpagico'] = $_POST['ds_diagn_cito_hstpagico'];
			$_SESSION['ds_tp_cirurgia'] = $_POST['ds_tp_cirurgia'];
			$_SESSION['ds_area_irrda'] = $_POST['ds_area_irrda'];
			$_SESSION['dt_rlzd'] = $dt_rlzd;
			$_SESSION['dt_aplc'] = $dt_aplc;
			$_SESSION['ds_obs_jfta'] = $_POST['ds_obs_jfta'];
			$_SESSION['nu_qtde_ciclo_prta'] = $_POST['nu_qtde_ciclo_prta'];
			$_SESSION['ds_ciclo_atual'] = $_POST['ds_ciclo_atual'];
			$_SESSION['ds_dia_ciclo_atual'] = $_POST['ds_dia_ciclo_atual'];			
			$_SESSION['ds_intrv_entre_ciclo_dia'] = $_POST['ds_intrv_entre_ciclo_dia'];
			$_SESSION['nm_mdco_encaminhador'] = $_POST['nm_mdco_encaminhador'];
			$_SESSION['ic_crioterapia'] = $_POST['ic_crioterapia'];			
			$_SESSION['ds_exame_enviado'] = $_POST['ds_exame_enviado'];
			
			$fp = fopen("log_pedido.txt", "a");
			
			// Escreve a mensagem passada através da variável $msg
			$msg = "---------------------Log de Inclusao do Pedido de Tratamento------------------------\n";
			$msg .= "Mensagem gerada pelo usuario	: '".$_SESSION['usuario']."' em ".date('d/m/Y')."\n";
			$msg .= "-----------------------------------------------------------------------------------\n";
			$msg .= "Codigo Paciente				: '".$_POST['cd_pcnt']."'\n";
			$msg .= "Paciente						: '".$rowpcnt[0]."'\n";
			$msg .= "Convênio						: '".$_POST['cd_cnvo']."'\n";
			$msg .= "Peso							: '".$_POST['nu_peso_pcnt']."'\n";
			$msg .= "Altura							: '".$_POST['vl_altura_pcnt']."'\n";
			$msg .= "Sup Corp						: '".$_POST['vl_sup_corp']."'\n";
			$msg .= "Indicacao Clinica				: '".$_POST['ds_indic_clnic']."'\n";
			$msg .= "Data do Diagnostico			: '".$dt_diagn."'\n";
			$msg .= "CID							: '".$_POST['cd_cid']."'\n";
			$msg .= "Estadiamento					: '".$_POST['ds_estmt']."'\n";
			$msg .= "Tipo Quimio (Linha)			: '".$_POST['ds_tipo_linha_trtmto']."'\n";
			$msg .= "Finalidade						: '".$_POST['ds_fnlde']."'\n";
			$msg .= "Tipo de Tumor					: '".$_POST['ic_tipo_tumor']."'\n";
			$msg .= "Tipo de Nodulo					: '".$_POST['ic_tipo_nodulo']."'\n";
			$msg .= "Tipo de Metastase				: '".$_POST['ic_tipo_metastase']."'\n";
			$msg .= "Plano Terapêutio				: '".$_POST['ds_plano_trptco']."'\n";
			$msg .= "Informações Relevantes			: '".$_POST['ds_info_rlvnte']."'\n";
			$msg .= "Diagnóstico Histopatologico	: '".$_POST['ds_diagn_cito_hstpagico']."'\n";
			$msg .= "Tipo de Cirurgia				: '".$_POST['ds_tp_cirurgia']."'\n";
			$msg .= "Área Irradiada					: '".$_POST['ds_area_irrda']."'\n";
			$msg .= "Data de Realização				: '".$dt_rlzd."'\n";
			$msg .= "Data da Aplicação				: '".$dt_aplc."'\n";
			$msg .= "Observação Justificativa		: '".$_POST['ds_obs_jfta']."'\n";
			$msg .= "Quantidade de Ciclos Prevsitos	: '".$_POST['nu_qtde_ciclo_prta']."'\n";
			$msg .= "Ciclo Atual					: '".$_POST['ds_ciclo_atual']."'\n";
			$msg .= "Dias do ciclo atual			: '".$_POST['ds_dia_ciclo_atual']."'\n";			
			$msg .= "Intervalo de Ciclos			: '".$_POST['ds_intrv_entre_ciclo_dia']."'\n";			
			$msg .= "Nome do medico encaminhador	: '".$_POST['nm_mdco_encaminhador']."'\n";
			$msg .= "Exames Enviados				: '".$_POST['ds_exame_enviado']."'\n";
			$msg .= "Crioterapia					: '".$_POST['ic_crioterapia']."'\n";
			$msg .= "\n";			
			$msg .= "\n";			
			$msg .= "-----------------------------------------------------------------------------------\n";
			
			$escreve = fwrite($fp, $msg);

			// Fecha o arquivo
			fclose($fp);

			$result = pg_query($pdo, $sql);
			if($result){
				echo "";
			} 
			
			
			$sqlcurrval_pddo_trtmto = "select max(id_pddo_trtmto) from tratamento.tb_pddo_trtmto where cd_pcnt = '".$_POST['cd_pcnt']."' ";

			$retcurrval_pddo_trtmto = pg_query($pdo, $sqlcurrval_pddo_trtmto);

			if(!$retcurrval_pddo_trtmto) {

				echo pg_last_error($pdo);		

				exit;

			}

			$rowcurrval_pddo_trtmto = pg_fetch_row($retcurrval_pddo_trtmto);

			$sql = "insert into tratamento.tb_log_alrt (id_log_alrt, cd_alrt, ds_alrt, cd_usua_incs_alrt, dt_incs_alrt, nm_pcnt) values ((select NEXTVAL('tratamento.sq_log_alrt')),'INSERCAO DE PEDIDO DE TRATAMENTO', '".str_replace("'"," ", $msg)."', '".$_SESSION['usuario']."', current_timestamp, '".$rowpcnt[0]."')";			

			$result = pg_query($pdo, $sql);

			if($result){

				echo "";

			} 		

			//echo $sql;			

			$sql = "SELECT MAX(id_hstr_pnel_solic_trtmto) FROM tratamento.tb_hstr_pnel_solic_trtmto WHERE cd_pcnt = '".$_POST['cd_pcnt']."' and id_equipe = 13 and fl_trtmto_fchd = 0 ";
					

			$retmaxpanelsolictrtmto = pg_query($pdo, $sql);


			if(!$retmaxpanelsolictrtmto) {

				echo pg_last_error($pdo);		
				exit;
			}
			
			$rowmaxpanelsolictrtmto = pg_fetch_row($retmaxpanelsolictrtmto);
			
			$sql = "update tratamento.tb_pddo_trtmto set id_hstr_pnel_solic_trtmto = ".$rowmaxpanelsolictrtmto[0]." where id_pddo_trtmto = ".$rowcurrval_pddo_trtmto[0]."";			
			$result = pg_query($pdo, $sql);
			if($result){
				echo "";
			} 
			
			//echo $sql;
			
			$secondsWait = 0;
			header("Refresh:$secondsWait");
			
		} catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
	
	if(isset($_POST['altera'])){					
		
		if ($pdo==null){
			header(Config::$webLogin);
		}
		
		try
		{	
		
			if ($_POST['id_hstr_pnel_solic_trtmto']=='null' || $_POST['id_hstr_pnel_solic_trtmto']==null || $_POST['id_hstr_pnel_solic_trtmto']=='') {
				$_POST['id_hstr_pnel_solic_trtmto']='null';
			}
			
			if ($_POST['dt_rlzd'] == null){
				$dt_rlzd = 'null';
			} else {
				$dt_rlzd = "'".$_POST['dt_rlzd']."'";
			}
			
			if ($_POST['dt_aplc'] == null){
				$dt_aplc = 'null';
			} else {
				$dt_aplc = "'".$_POST['dt_aplc']."'";
			}
			
			if ($_POST['dt_diagn'] == null){
				$dt_diagn = 'null';
			} else {
				$dt_diagn = "'".$_POST['dt_diagn']."'";
			}
			
			
			$id_hstr_pnel_solic_trtmto = "null";
			
			$sql = "SELECT count(id_hstr_pnel_solic_trtmto) FROM tratamento.tb_hstr_pnel_solic_trtmto WHERE cd_pcnt = '".$_POST['cd_pcnt']."' and id_equipe = 13 and fl_trtmto_fchd = 0  ";
					
			$retcountpanelsolictrtmto = pg_query($pdo, $sql);
				
			if(!$retcountpanelsolictrtmto) {
				echo pg_last_error($pdo);		
				exit;
			}
				
			$rowcountpanelsolictrtmto = pg_fetch_row($retcountpanelsolictrtmto);
			
			if ($rowcountpanelsolictrtmto[0] > 0) {
				
				$sql = "SELECT MAX(id_hstr_pnel_solic_trtmto) FROM tratamento.tb_hstr_pnel_solic_trtmto WHERE cd_pcnt = '".$_POST['cd_pcnt']."' and id_equipe = 13 and fl_trtmto_fchd = 0 ";
					
				$retmaxpanelsolictrtmto = pg_query($pdo, $sql);
					
				if(!$retmaxpanelsolictrtmto) {
					echo pg_last_error($pdo);		
					exit;
				}
					
				$rowmaxpanelsolictrtmto = pg_fetch_row($retmaxpanelsolictrtmto);
							
				$sql = "SELECT id_hstr_pnel_solic_trtmto, dt_inicial_trtmto 
						  FROM tratamento.tb_hstr_pnel_solic_trtmto 
						WHERE cd_pcnt = '".$_POST['cd_pcnt']."' and id_equipe = 13 and fl_trtmto_fchd = 0 and id_hstr_pnel_solic_trtmto = ".$rowmaxpanelsolictrtmto[0]." ";

				//echo $sql;

				$rethstrtratamento = pg_query($pdo, $sql);

				if(!$rethstrtratamento) {
					echo pg_last_error($pdo);		
					exit;
				}

				$rowhstrtratamento = pg_fetch_row($rethstrtratamento);
				$id_hstr_pnel_solic_trtmto = $rowhstrtratamento[0];				
			
			}
			
			if ($_POST['id_status_trtmto'] == '0'){ $id_hstr_pnel_solic_trtmto="null";}
			
			$sql = "UPDATE tratamento.tb_pddo_trtmto
	SET id_hstr_pnel_solic_trtmto = ". $id_hstr_pnel_solic_trtmto." ,nu_peso_pcnt=". str_replace(",", ".", $_POST['nu_peso_pcnt']).", vl_altura_pcnt=". str_replace(",", ".", $_POST['vl_altura_pcnt']).", vl_sup_corp=". str_replace(",", ".", $_POST['vl_sup_corp']).", ds_indic_clnic=UPPER('". str_replace("'", " ",$_POST['ds_indic_clnic'])."'), dt_diagn=". $dt_diagn.", cd_cid='". $_POST['cd_cid']."', ds_plano_trptco=UPPER('". str_replace("'", " ",$_POST['ds_plano_trptco'])."'), ds_info_rlvnte=UPPER('". str_replace("'", " ",$_POST['ds_info_rlvnte'])."'), ds_diagn_cito_hstpagico=UPPER('". str_replace("'", " ",$_POST['ds_diagn_cito_hstpagico'])."'), ds_tp_cirurgia=UPPER('". str_replace("'", " ",$_POST['ds_tp_cirurgia'])."'), ds_area_irrda=UPPER('". str_replace("'", " ",$_POST['ds_area_irrda'])."'), dt_rlzd=".$dt_rlzd.", dt_aplc=". $dt_aplc.", ds_obs_jfta=UPPER('". str_replace("'", " ",$_POST['ds_obs_jfta'])."'), nu_qtde_ciclo_prta='". $_POST['nu_qtde_ciclo_prta']."', ds_ciclo_atual='". $_POST['ds_ciclo_atual']."', ds_dia_ciclo_atual='". $_POST['ds_dia_ciclo_atual']."', ds_intrv_entre_ciclo_dia='". $_POST['ds_intrv_entre_ciclo_dia']."', ds_estmt='". $_POST['ds_estmt']."', ds_tipo_linha_trtmto='". $_POST['ds_tipo_linha_trtmto']."', ds_fnlde='". $_POST['ds_fnlde']."', ic_tipo_tumor='". $_POST['ic_tipo_tumor']."', ic_tipo_nodulo='". $_POST['ic_tipo_nodulo']."', ic_tipo_metastase='". $_POST['ic_tipo_metastase']."', cd_usua_altr = '".$_SESSION['usuario']."', dt_altr = current_timestamp, cd_cnvo='". $_POST['cd_cnvo']."', nm_mdco_encaminhador='". $_POST['nm_mdco_encaminhador']."', ic_crioterapia='". $_POST['ic_crioterapia']."', ds_exame_enviado='". $_POST['ds_exame_enviado']."' where id_pddo_trtmto = ". $_SESSION['id_pddo_trtmto']."";	
			
			//echo $sql;
			
			$result = pg_query($pdo, $sql);

			if($result){
				echo "";
			}  
			
			$sql = "select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '". $_POST['cd_pcnt']."'  ";
					
			$retnmpcnt = pg_query($pdo, $sql);
					
			if(!$retnmpcnt) {
				echo pg_last_error($pdo);		
				exit;
			}
					
			$rowpcnt = pg_fetch_row($retnmpcnt);
			
			// Escreve a mensagem passada através da variável $msg
			$msg = "---------------------Log de Alteração do Pedido de Tratamento------------------------\n";
			$msg .= "Mensagem gerada pelo usuario: '".$_SESSION['usuario']."' em ".date('d/m/Y')."\n";
			$msg .= "-----------------------------------------------------------------------------------\n";
			$msg .= "Codigo Paciente			: '".$_POST['cd_pcnt']."'\n";
			$msg .= "Paciente					: '".$rowpcnt[0]."'\n";
			$msg .= "Convênio					: '".$_POST['cd_cnvo']."'\n";
			$msg .= "Peso						: '".$_POST['nu_peso_pcnt']."'\n";
			$msg .= "Altura						: '".$_POST['vl_altura_pcnt']."'\n";
			$msg .= "Sup Corp					: '".$_POST['vl_sup_corp']."'\n";
			$msg .= "Indicacao Clinica			: '".$_POST['ds_indic_clnic']."'\n";
			$msg .= "Data do Diagnostico		: '".$dt_diagn."'\n";
			$msg .= "CID						: '".$_POST['cd_cid']."'\n";
			$msg .= "Estadiamento				: '".$_POST['ds_estmt']."'\n";
			$msg .= "Tipo Quimio (Linha)		: '".$_POST['ds_tipo_linha_trtmto']."'\n";
			$msg .= "Finalidade					: '".$_POST['ds_fnlde']."'\n";
			$msg .= "Tipo de Tumor				: '".$_POST['ic_tipo_tumor']."'\n";
			$msg .= "Tipo de Nodulo				: '".$_POST['ic_tipo_nodulo']."'\n";
			$msg .= "Tipo de Metastase			: '".$_POST['ic_tipo_metastase']."'\n";
			$msg .= "Plano Terapêutio			: '".$_POST['ds_plano_trptco']."'\n";
			$msg .= "Informações Relevantes		: '".$_POST['ds_info_rlvnte']."'\n";
			$msg .= "Diagnóstico Histopatologico: '".$_POST['ds_diagn_cito_hstpagico']."'\n";
			$msg .= "Tipo de Cirurgia			: '".$_POST['ds_tp_cirurgia']."'\n";
			$msg .= "Área Irradiada				: '".$_POST['ds_area_irrda']."'\n";
			$msg .= "Data de Realização			: '".$dt_rlzd."'\n";
			$msg .= "Data da Aplicação			: '".$dt_aplc."'\n";
			$msg .= "Observação Justificativa	: '".$_POST['ds_obs_jfta']."'\n";
			$msg .= "Quantidade de Ciclos Prevsitos: '".$_POST['nu_qtde_ciclo_prta']."'\n";
			$msg .= "Ciclo Atual				: '".$_POST['ds_ciclo_atual']."'\n";
			$msg .= "Dias do ciclo atual		: '".$_POST['ds_dia_ciclo_atual']."'\n";			
			$msg .= "Intervalo de Ciclos		: '".$_POST['ds_intrv_entre_ciclo_dia']."'\n";
			$msg .= "Nome do medico encaminhador: '".$_POST['nm_mdco_encaminhador']."'\n";
			$msg .= "Exames Enviados			: '".$_POST['ds_exame_enviado']."'\n";
			$msg .= "Crioterapia				: '".$_POST['ic_crioterapia']."'\n";			
			$msg .= "\n";			
			$msg .= "\n";			
			$msg .= "-----------------------------------------------------------------------------------\n";

			
			$sql = "insert into tratamento.tb_log_alrt (id_log_alrt, cd_alrt, ds_alrt, cd_usua_incs_alrt, dt_incs_alrt, nm_pcnt) values ((select NEXTVAL('tratamento.sq_log_alrt')),'ALTERACAO DE PEDIDO DE TRATAMENTO', '".str_replace("'"," ", $msg)."', '".$_SESSION['usuario']."', current_timestamp, '".$rowpcnt[0]."')";
			
			//echo $sql;
			
			$result = pg_query($pdo, $sql);
			if($result){
				echo "";
			}
			
			if ($_POST['ds_exame_enviado']=='' || $_POST['ds_exame_enviado']==null){
					echo "<div class=\"alert alert-warning alert-dismissible\">
							<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
							<strong>Atenção!</strong> ATENÇÃO. Campo Exames Enviados não pode estar em branco. Clique em <input type='submit' class='btn btn-primary' onclick='history.go()' value='Voltar'> caso necessite repetir a operação.</div>";
				} else {
				
					$secondsWait = 0;
					header("Refresh:$secondsWait");
				}
				
			} catch(PDOException $e)
			{
				die($e->getMessage());
			}
	}
	
	if(isset($_POST['deleta'])){					
		
		if ($pdo==null){
			header(Config::$webLogin);
		}
		
		try
		{
			
			$sql ="SELECT id_hstr_pnel_solic_trtmto from tratamento.tb_pddo_trtmto  WHERE id_pddo_trtmto = ".$_SESSION['id_pddo_trtmto']." ";				
			
			if ($pdo==null){
					header(Config::$webLogin);
			}	
			$ret = pg_query($pdo, $sql);
			if(!$ret) {
				echo pg_last_error($pdo);
				exit;
			}
			
			$row = pg_fetch_row($ret);
			if ($row[0]!=null){
				echo "<div class=\"alert alert-warning alert-dismissible\">
					<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
					<strong>Atenção!</strong> Pedido de tratamento está associado a um tratamento em realização. Exclua o tratamento para ecluir o pedido.</div>";
					
				$secondsWait = 5;
				header("Refresh:$secondsWait");
				
			} else {
			
				$sql = "SELECT id_pddo_trtmto 
	            , id_hstr_pnel_solic_trtmto
				, cd_pcnt
				, nm_pcnt
				, dt_nasc_pcnt
				, vl_idade_pcnt
				, nu_peso_pcnt
				, vl_altura_pcnt
				, vl_sup_corp
				, ds_indic_clnic
				, to_char(dt_diagn,'yyyy-mm-dd') as dt_diagn
				, cd_cid
				, ds_plano_trptco
				, ds_info_rlvnte
				, ds_diagn_cito_hstpagico
				, ds_tp_cirurgia
				, ds_area_irrda
				, to_char(dt_rlzd,'yyyy-mm-dd') as dt_rlzd
				, to_char(dt_aplc,'yyyy-mm-dd') as dt_aplc
				, ds_obs_jfta
				, nu_qtde_ciclo_prta
				, ds_ciclo_atual
				, ds_dia_ciclo_atual
				, ds_intrv_entre_ciclo_dia
				, ds_estmt
				, ds_tipo_linha_trtmto
				, ds_fnlde
				, ic_tipo_tumor
				, ic_tipo_nodulo
				, ic_tipo_metastase
				, cd_usua_incs
				, dt_incs
				, cd_usua_altr
				, dt_altr 
				, cd_cnvo
				, nm_mdco_encaminhador
				, ic_crioterapia
				, ds_exame_enviado
				from tratamento.tb_pddo_trtmto
				where id_pddo_trtmto = ".$_SESSION['id_pddo_trtmto']." ";

				if ($pdo==null){
						header(Config::$webLogin);
				}	
				$retpddotrtmto = pg_query($pdo, $sql);
				if(!$retpddotrtmto) {
					echo pg_last_error($pdo);
					exit;
				}
				
				$rowpddotrtmto = pg_fetch_row($retpddotrtmto);
				
				
				// Escreve a mensagem passada através da variável $msg
				$msg = "---------------------Log de Deleção do Pedido de Tratamento------------------------\n";
				$msg .= "Mensagem gerada pelo usuario: '".$_SESSION['usuario']."' em ".date('d/m/Y')."\n";
				$msg .= "-----------------------------------------------------------------------------------\n";
				$msg .= "Codigo Paciente				: '".$rowpddotrtmto[2]."'\n";
				$msg .= "Paciente						: '".$rowpddotrtmto[3]."'\n";
				$msg .= "Convênio						: '".$rowpddotrtmto[34]."'\n";
				$msg .= "Peso							: '".$rowpddotrtmto[6]."'\n";
				$msg .= "Altura							: '".$rowpddotrtmto[7]."'\n";
				$msg .= "Sup Corp						: '".$rowpddotrtmto[8]."'\n";
				$msg .= "Indicacao Clinica				: '".$rowpddotrtmto[9]."'\n";
				$msg .= "Data do Diagnostico			: '".$rowpddotrtmto[10]."'\n";
				$msg .= "CID							: '".$rowpddotrtmto[11]."'\n";
				$msg .= "Estadiamento					: '".$rowpddotrtmto[24]."'\n";
				$msg .= "Tipo Quimio (Linha)			: '".$rowpddotrtmto[25]."'\n";
				$msg .= "Finalidade						: '".$rowpddotrtmto[26]."'\n";
				$msg .= "Tipo de Tumor					: '".$rowpddotrtmto[27]."'\n";
				$msg .= "Tipo de Nodulo					: '".$rowpddotrtmto[28]."'\n";
				$msg .= "Tipo de Metastase				: '".$rowpddotrtmto[29]."'\n";
				$msg .= "Plano Terapêutio				: '".$rowpddotrtmto[12]."'\n";
				$msg .= "Informações Relevantes			: '".$rowpddotrtmto[13]."'\n";
				$msg .= "Diagnóstico Histopatologico	: '".$rowpddotrtmto[14]."'\n";
				$msg .= "Tipo de Cirurgia				: '".$rowpddotrtmto[15]."'\n";
				$msg .= "Área Irradiada					: '".$rowpddotrtmto[16]."'\n";
				$msg .= "Data de Realização				: '".$rowpddotrtmto[17]."'\n";
				$msg .= "Data da Aplicação				: '".$rowpddotrtmto[18]."'\n";
				$msg .= "Observação Justificativa		: '".$rowpddotrtmto[19]."'\n";
				$msg .= "Quantidade de Ciclos Prevsitos	: '".$rowpddotrtmto[20]."'\n";
				$msg .= "Ciclo Atual					: '".$rowpddotrtmto[21]."'\n";
				$msg .= "Dias do ciclo atual			: '".$rowpddotrtmto[22]."'\n";			
				$msg .= "Intervalo de Ciclos			: '".$rowpddotrtmto[23]."'\n";			
				$msg .= "Nome do médico encaminhador	: '".$rowpddotrtmto[35]."'\n";
				$msg .= "Crioterapia					: '".$rowpddotrtmto[36]."'\n";
				$msg .= "Exames enviados				: '".$rowpddotrtmto[37]."'\n";				
				$msg .= "\n";			
				$msg .= "\n";			
				$msg .= "-----------------------------------------------------------------------------------\n";
				
				$sql = "insert into tratamento.tb_log_alrt (id_log_alrt, cd_alrt, ds_alrt, cd_usua_incs_alrt, dt_incs_alrt, nm_pcnt) values ((select NEXTVAL('tratamento.sq_log_alrt')),'DELEÇÃO DE PEDIDO DE TRATAMENTO', '".str_replace("'"," ", $msg)."', '".$_SESSION['usuario']."', current_timestamp, '".$rowpddotrtmto[3]."')";
			
				$result = pg_query($pdo, $sql);
				if($result){
					echo "";
				}
							
				
				// remove do banco			
				$sql = "DELETE FROM tratamento.tb_pddo_trtmto WHERE id_pddo_trtmto = ".$_SESSION['id_pddo_trtmto']."";			
				$result = pg_query($pdo, $sql);

				if($result){
					echo "";
				}  
				
				$secondsWait = 0;
				header("Refresh:$secondsWait");
				
			}
			
		} catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
    	
?>	

	<!DOCTYPE html>
	<html lang="pt-br">
	<head>
	 <meta charset="utf-8">
	 <meta http-equiv="X-UA-Compatible" content="IE=edge">
	 <meta name="viewport" content="width=device-width, initial-scale=1">
	 <title>Cadastro de Pedido de Tratamento</title>

	 <link href="../css/bootstrap.min.css" rel="stylesheet">
	 <link href="../css/style.css" rel="stylesheet">
	</head>
	<body>

	 <div id="main" class="container-fluid" style="margin-top: 50px"> 
		<div class="container" style="margin-left: 0px">
			<form class="form-inline" action="#" method="post" >				
				<b>Consultar Pacientes:</b>:&nbsp;&nbsp													
				<input class="form-control" name="textoconsulta" type="text" placeholder="Pesquisar">&nbsp;&nbsp;&nbsp;&nbsp;
				<input class="btn btn-primary" style="font-size: 11px;"  type="submit" value="Consultar" name="botaoconsultar">&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="button" style="font-size: 11px;"  value="Novo Registro" class="btn btn-primary btn-xs insere"/>&nbsp;&nbsp;&nbsp;&nbsp;
				<input class="btn btn-primary" style="font-size: 11px;"  type="button" value="Exportar Última Digitação" id="exportarultimopedido">&nbsp;&nbsp;&nbsp;&nbsp;
				<input class="btn btn-primary" style="font-size: 11px;"  type="button" value="Recuperar Última Digitação" id="recuperaulitmo">&nbsp;&nbsp;&nbsp;&nbsp;
			</form>
		</div> <!-- /#top -->
	 	
		<br>

		<div id="list" class="row">
		
		<div class="table-responsive col-md-12">
			<table class="table table-striped" cellspacing="0" cellpadding="0" id="tabela">
				<thead>
					<tr>
						<th>Id do Pedido</th>
						<th>Paciente</th>
						<th>Data/Hora de Inclusão</th>	
						<th class="actions">Ações</th>
					</tr>
				</thead>				
				<tbody>
				<?php

					$cont=1;										
					while($row = pg_fetch_row($ret)) {
					?>						
						<tr>
							<td id="id_local_trtmto" value="<?php echo $row[0];?>"><?php echo $row[0];?></td>
							<td id="ds_local_trtmto" value="<?php echo $row[1];?>"><?php echo $row[1];?></td>
							<td id="nu_seq_local_pnel" value="<?php echo $row[2];?>"><?php echo $row[2];?></td>
														
							<td class="actions">								
								<input type="button" style="font-size: 11px;" value="Visualizar" class="btn btn-success btn-xs visualiza"/>								
								<input type="button" style="font-size: 11px;" value="Alterar" class="btn btn-warning btn-xs altera"/>								
								<input type="button" style="font-size: 11px;" value="Excluir" class="btn btn-danger btn-xs delecao"/>
								<input type="button" style="font-size: 11px;" value="Reutilizar" class="btn btn-primary btn-xs reutiliza"/>
								<input type="button" style="font-size: 11px;" value="PDF" class="btn btn-info btn-xs imprimirpdf"/>
							</td>
						</tr>
					<?php $cont=$cont+1;} ?>	
				</tbody>
			</table>
		</div>
		
		</div> <!-- /#list -->
		
	 </div> <!-- /#main -->

	 <script src="../js/jquery.min.js"></script>
	 <script src="../js/bootstrap.min.js"></script>
	</body>
	</html>	
	<div id="visualiza" class="modal fade">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Visualização dos Dados</h4>
				</div>
				<div class="modal-body" id="visualizacao">
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
	<script>
	$(document).ready(function(){
    
		$("#tabela").on('click','.delecao',function(){			
		
			var currentRow=$(this).closest("tr"); 
			
			var id_pddo_trtmto = currentRow.find("td:eq(0)").text();
			var nm_pcnt = currentRow.find("td:eq(1)").text();	
			var dt_rlzd = currentRow.find("td:eq(2)").text();	
			
			// AJAX code to submit form.
			$.ajax({
				 type: "POST",
				 url: "../delecao/delecao_pedido_tratamento.php", //
				 data: {id_pddo_trtmto:id_pddo_trtmto, nm_pcnt:nm_pcnt, dt_rlzd:dt_rlzd},
				 dataType : "text",			 
				 success : function(completeHtmlPage) {				
					$("html").empty();
					$("html").append(completeHtmlPage);
				 }
			});
		});
	
		$(document).on('click', '.insere', function(){
			event.preventDefault();			
			$.ajax({
				type: "POST",
				url:"../insercao/insercao_pedido_tratamento.php",															
				success : function(completeHtmlPage) {				
					$("html").empty();
					$("html").append(completeHtmlPage);
				}
			});			
		});	
		
		$(document).on('click', '.reutiliza', function(){
			var currentRow=$(this).closest("tr"); 
			
			var id_pddo_trtmto = currentRow.find("td:eq(0)").text();
			var nm_pcnt = currentRow.find("td:eq(1)").text();	
			var dt_rlzd = currentRow.find("td:eq(2)").text();	
			
			// AJAX code to submit form.
			$.ajax({
				 type: "POST",
				 url: "reutiliza_pedido_tratamento.php", //
				 data: {id_pddo_trtmto:id_pddo_trtmto, nm_pcnt:nm_pcnt, dt_rlzd:dt_rlzd},
				 dataType : "text",			 
				 success : function(completeHtmlPage) {				
					$("html").empty();
					$("html").append(completeHtmlPage);
				 }
			});	
		});	

		$("#tabela").on('click','.altera',function(){			
		
			var currentRow=$(this).closest("tr"); 
			
			var id_pddo_trtmto = currentRow.find("td:eq(0)").text();
			var nm_pcnt = currentRow.find("td:eq(1)").text();	
			var dt_rlzd = currentRow.find("td:eq(2)").text();	
			
			// AJAX code to submit form.
			$.ajax({
				 type: "POST",
				 url: "../alteracao/alteracao_pedido_tratamento.php", //
				 data: {id_pddo_trtmto:id_pddo_trtmto, nm_pcnt:nm_pcnt, dt_rlzd:dt_rlzd},
				 dataType : "text",			 
				 success : function(completeHtmlPage) {				
					$("html").empty();
					$("html").append(completeHtmlPage);
				 }
			});
		});		
				
		$('#recuperaulitmo').click(function(){	
			$.ajax({
			type : 'POST',
				 url: '../alteracao/alteracao_ulitmo_pedido.php',
				 success : function(completeHtmlPage) {				
					$("html").empty();
					$("html").append(completeHtmlPage);
				}
			});
		});	

		$('#exportarultimopedido').click(function(){			
		
			$.ajax({
				type : 'POST',
				url : 'excelultimopedido.php', // give complete url here								
				success : function(completeHtmlPage) {	
					alert("Faça o download do arquivo de impressão. Abra no Excel e solicite para Salvar Como com o nome desejado.");
					$("html").empty();
					$("html").append(completeHtmlPage);
				}
			});
		});			
		
		
		$("#tabela").on('click', '.visualiza', function(){
			
			var currentRow=$(this).closest("tr");
			
			var id_pddo_trtmto = currentRow.find("td:eq(0)").text();
			var nm_pcnt = currentRow.find("td:eq(1)").text();	
			var dt_rlzd = currentRow.find("td:eq(2)").text();								
						
			$.ajax({
				url:"../visualizacao/visualizacao_pedido_tratamento.php",
				method:"POST",
				data:{id_pddo_trtmto:id_pddo_trtmto, nm_pcnt:nm_pcnt, dt_rlzd:dt_rlzd},
				success:function(data){
					$('#visualizacao').html(data);
					$('#visualiza').modal('show');
				}
			});
        });
		
		$('#exportarultimopedido').click(function(){			
		
		$.ajax({
			type : 'POST',
			url : 'excelultimopedido.php', // give complete url here								
			success : function(completeHtmlPage) {	
				alert("Faça o download do arquivo de impressão. Abra no Excel e solicite para Salvar Como com o nome desejado.");
				$("html").empty();
				$("html").append(completeHtmlPage);
			}
		});
	});	
		
		$("#tabela").on('click', '.imprimirpdf', function(){
			
			var currentRow=$(this).closest("tr");
			
			var id_pddo_trtmto = currentRow.find("td:eq(0)").text();
			var nm_pcnt = currentRow.find("td:eq(1)").text();	
			var dt_rlzd = currentRow.find("td:eq(2)").text();								
						
			$.ajax({
				url:"impressao_por_pedidotratamento.php",
				method:"POST",
				data:{id_pddo_trtmto:id_pddo_trtmto, nm_pcnt:nm_pcnt, dt_rlzd:dt_rlzd},
				success:function(data){
					$('#impressao').html(data);
					$('#imprimir').modal('show');
				}
			});
        });
		
	});		
	
	</script>
<?php ?>