<?php
	
	session_start();
    
	include '../database.php';
	
	error_reporting(0);

	$CSVvar = false;
	
	global $pdo;		
	
	$pdo = database::connect();	
	
	if(isset($_POST['btprocessar'])&& $_POST['fileUploaded']<>""){		
		
		$CSVvar = fopen('c:/pedidotratamento/'.$_POST['fileUploaded'], "r");		
		$_SESSION['fileUploaded'] = $_POST['fileUploaded'];
		
	}	
	if(isset($_POST['btsalvar'])){
		
		$CSVvar = fopen('c:/pedidotratamento/'.$_SESSION['fileUploaded'], "r");
		
		$id_reg = 0;
		
		if ($CSVvar !== FALSE) {
			
			$sql = "SELECT cd_pcnt, nm_pcnt as nm_pcnt from tratamento.tb_c_pcnt order by 2";

			if ($pdo==null){
				header(Config::$webLogin);
			}	
			$ret = pg_query($pdo, $sql);
			if(!$ret) {
				echo pg_last_error($pdo);
				exit;
			}

			$paciente = array();
			$cont_paciente = 0;
			

			while($row = pg_fetch_row($ret)) {
				
				$paciente[$cont_paciente][0] = $row[0];
				$paciente[$cont_paciente][1] = $row[1];
				
				$cont_paciente=$cont_paciente+1;
			} 
			
			$data = fgetcsv($CSVvar, 1000, ";");
			while (! feof($CSVvar)) {
				$data = fgetcsv($CSVvar, 1000, ";");
				
				$achoupacientenalista=0;								
				
				if (! empty($data) && $data[1] <> '') {					
					for ($linhalista = 0; $linhalista < $cont_paciente; $linhalista++) {
						if (trim($paciente[$linhalista][1])==trim($data[1])){
							$achoupacientenalista = 1;
							$cd_pcnt = $paciente[$linhalista][0];
							break;
						}											
					}
					if ($achoupacientenalista == 1) {
						$id_reg = $data[0];
						$nm_pcnt=strtoupper($data[1]);
						$cd_cnvo=strtoupper($data[2]);
						$nu_peso_pcnt=is_numeric($data[3]) ? $data[3] : 0;
						$vl_altura_pcnt=is_numeric($data[4]) ? $data[4] : 0;
						$vl_sup_corp=is_numeric($data[5]) ? $data[5] : 0;
						$ds_indic_clnic = str_replace("'", "", $data[6]);
						$dt_diagn=$data[7];
						$cd_cid=$data[8];
						$ds_estmt=str_replace("'", "", trim($data[9]));
						$ds_tipo_linha_trtmto=str_replace("'", "", trim($data[10]));
						$ds_fnlde=str_replace("'", "", trim($data[11]));
						$ic_tipo_tumor=$data[12];
						$ic_tipo_nodulo=$data[13];
						$ic_tipo_metastase=$data[14];
						$ds_plano_trptco=str_replace("'", "", trim($data[15]));
						$ds_info_rlvnte=str_replace("'", "", trim($data[16]));
						$ds_diagn_cito_hstpagico=str_replace("'", "", trim($data[17]));
						$ds_tp_cirurgia=str_replace("'", "", trim($data[18]));
						$ds_area_irrda = str_replace("'", "", trim($data[19]));
						$dt_rlzd=$data[20];
						$dt_aplc=$data[21];
						$ds_obs_jfta=str_replace("'", "", trim($data[22]));
						$nu_qtde_ciclo_prta=$data[23];
						$ds_ciclo_atual=str_replace("'", "", trim($data[24]));
						$ds_dia_ciclo_atual=str_replace("'", "", trim($data[25]));
						$ds_intrv_entre_ciclo_dia=str_replace("'", "", trim($data[26]));
						$nm_mdco_encaminhador=str_replace("'", "", trim($data[27]));
						$ds_exame_enviado=str_replace("'", "", trim($data[28]));
						$ic_crioterapia=$data[29];
						
						if ($dt_rlzd == null || $dt_rlzd == ''){
							$dt_rlzd = 'null';
						}
						
						if ($dt_aplc == null || $dt_aplc == ''){
							$dt_aplc = 'null';
						} 
						
						if ($dt_diagn == null || $dt_diagn == ''){
							$dt_diagn = 'null';
						}
						
						$id_hstr_pnel_solic_trtmto = "null";
			
						$sql = "SELECT count(id_hstr_pnel_solic_trtmto) FROM tratamento.tb_hstr_pnel_solic_trtmto WHERE cd_pcnt = '".$cd_pcnt."' and id_equipe = 13 and fl_trtmto_fchd = 0  ";
								
						$retcountpanelsolictrtmto = pg_query($pdo, $sql);
							
						if(!$retcountpanelsolictrtmto) {
							echo pg_last_error($pdo);		
							exit;
						}
							
						$rowcountpanelsolictrtmto = pg_fetch_row($retcountpanelsolictrtmto);
						
						if ($rowcountpanelsolictrtmto[0] > 0) {
						
							$sql = "SELECT MAX(id_hstr_obs_pnel_solic_trtmto) FROM tratamento.tb_hstr_obs_pnel_solic_trtmto WHERE cd_pcnt = '".$cd_pcnt."' and id_status_equipe = 13 ";
								
							$retmaxstatusequipe = pg_query($pdo, $sql);
								
							if(!$retmaxstatusequipe) {
								echo pg_last_error($pdo);		
								exit;
							}
								
							$rowmaxstatusequipe = pg_fetch_row($retmaxstatusequipe);

							$sql = "SELECT MAX(id_hstr_pnel_solic_trtmto) FROM tratamento.tb_hstr_pnel_solic_trtmto WHERE cd_pcnt = '".$cd_pcnt."' and id_equipe = 13 and fl_trtmto_fchd = 0 ";
								
							$retmaxpanelsolictrtmto = pg_query($pdo, $sql);
								
							if(!$retmaxpanelsolictrtmto) {
								echo pg_last_error($pdo);		
								exit;
							}
								
							$rowmaxpanelsolictrtmto = pg_fetch_row($retmaxpanelsolictrtmto);
										
							$sql = "SELECT id_hstr_pnel_solic_trtmto, dt_inicial_trtmto 
									  FROM tratamento.tb_hstr_pnel_solic_trtmto 
									WHERE cd_pcnt = '".$cd_pcnt."' and id_equipe = 13 and fl_trtmto_fchd = 0 and id_hstr_pnel_solic_trtmto = ".$rowmaxpanelsolictrtmto[0]." ";

							//echo $sql;

							$rethstrtratamento = pg_query($pdo, $sql);

							if(!$rethstrtratamento) {
								echo pg_last_error($pdo);		
								exit;
							}

							$rowhstrtratamento = pg_fetch_row($rethstrtratamento);

							$id_hstr_pnel_solic_trtmto = $rowhstrtratamento[0];
							$dt_inicial_trtmto = $rowhstrtratamento[1];
									
							$sql = "update tratamento.tb_hstr_pnel_solic_trtmto set id_status_trtmto = 130, ds_status_trtmto = (select ds_status_trtmto from tratamento.tb_c_status_trtmto where id_status_trtmto = 130), cd_cor_status_trtmto = (select cd_cor_status_trtmto from tratamento.tb_c_status_trtmto where id_status_trtmto = 130), cd_usua_altr = '".$_SESSION['usuario']."', dt_altr = current_timestamp where id_hstr_pnel_solic_trtmto = ".$id_hstr_pnel_solic_trtmto."";
									
							//echo $sql;
							$result = pg_query($pdo, $sql);
							if($result){
								echo "";
							}
							
							$sql = "select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '". $cd_pcnt."'  ";
								
							$retnmpcnt = pg_query($pdo, $sql);
								
							if(!$retnmpcnt) {
								echo pg_last_error($pdo);		
								exit;
							}
								
							$rowpcnt = pg_fetch_row($retnmpcnt);
									
							$sql = "insert into tratamento.tb_log_alrt (id_log_alrt, cd_alrt, ds_alrt, cd_usua_incs_alrt, dt_incs_alrt, nm_pcnt) values ((select NEXTVAL('tratamento.sq_log_alrt')),'INSERCAO DE STATUS DE TRATAMENTO', (select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '".$cd_pcnt."')||' - '||(select ds_equipe from tratamento.tb_c_equipe where id_equipe = 13)||' - '||(select ds_status_trtmto from tratamento.tb_c_status_trtmto where id_status_trtmto = 130), '".$_SESSION['usuario']."', current_timestamp, '".$rowpcnt[0]."')";

							$result = pg_query($pdo, $sql);
							if($result){
								echo "";
							}


				$sql = "INSERT INTO tratamento.tb_hstr_obs_pnel_solic_trtmto(id_hstr_obs_pnel_solic_trtmto, id_hstr_pnel_solic_trtmto, id_status_equipe, ds_status_equipe, dt_inic_status_equipe_trtmto, dt_final_status_equipe_trtmto, ds_obs_pcnt, tp_minuto_status_equipe_trtmto, cd_usua_incs, dt_incs, dt_inicial_trtmto, cd_pcnt, nm_pcnt, id_status_trtmto, ds_status_trtmto)
				VALUES ((select NEXTVAL('tratamento.sq_hstr_obs_pnel_solic_trtmto')), ".$id_hstr_pnel_solic_trtmto.", 13, (select ds_equipe from tratamento.tb_c_equipe where id_equipe = 13), current_timestamp, null, null, 0, '".$_SESSION['usuario']."', current_timestamp, '".$dt_inicial_trtmto."', '".$cd_pcnt."', (select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '".$cd_pcnt."'),130, (select ds_status_trtmto from tratamento.tb_c_status_trtmto where id_status_trtmto = 130));";

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
				
				$sqlpcnt = "SELECT nm_pcnt, dt_nasc_pcnt, ds_mncp_pcnt FROM tratamento.tb_c_pcnt WHERE cd_pcnt = '".$cd_pcnt."' ";					
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
		VALUES ((select NEXTVAL('tratamento.sq_hstr_pnel_solic_trtmto')), '". $cd_pcnt ."', '". $rowpcnt[0] ."', '". $rowpcnt[1] ."', '". $rowpcnt[2] ."', ".$rowretequipetratamento[0].", '".$rowretequipetratamento[1]."', ".$rowretequipetratamento[2].", ".$rowretequipetratamento[3].", '".$rowretequipetratamento[4]."', 0, '".$rowdataatual[0]."', null, 'INICIO DO TRATAMENTO', 0, 0, 0, '".$_SESSION['usuario']."', current_timestamp, null, null, '".$rowretequipetratamento[5]."', '". $cd_cnvo ."');";		
					//echo $sql;		
					$result = pg_query($pdo, $sql);					
					if($result){
						echo "";
					}
					
					
					$sql = "INSERT INTO tratamento.tb_hstr_obs_pnel_solic_trtmto(id_hstr_obs_pnel_solic_trtmto, id_hstr_pnel_solic_trtmto, id_status_equipe, ds_status_equipe, dt_inic_status_equipe_trtmto, dt_final_status_equipe_trtmto, ds_obs_pcnt, tp_minuto_status_equipe_trtmto, cd_usua_incs, dt_incs, dt_inicial_trtmto, cd_pcnt, nm_pcnt, id_status_trtmto, ds_status_trtmto)
		VALUES ((select NEXTVAL('tratamento.sq_hstr_obs_pnel_solic_trtmto')), (SELECT currval('tratamento.sq_hstr_pnel_solic_trtmto')), ".$rowretequipetratamento[0].", '".$rowretequipetratamento[1]."', '".$rowdataatual[0]."', null, 'INICIO DO TRATAMENTO', 0, '".$_SESSION['usuario']."', current_timestamp, '".$rowdataatual[0]."', '".$cd_pcnt."', '". $rowpcnt[0] ."',".$rowretequipetratamento[3].", '".$rowretequipetratamento[4]."') ";
					//echo $sql;
					$result = pg_query($pdo, $sql);			
					if($result){
						echo "";
					}
					
					
					$sql = "insert into tratamento.tb_log_alrt (id_log_alrt, cd_alrt, ds_alrt, cd_usua_incs_alrt, dt_incs_alrt, nm_pcnt) values ((select NEXTVAL('tratamento.sq_log_alrt')),'INSERCAO DE TRATAMENTO', (select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '".$cd_pcnt."')||' - INICIO DE TRATAMENTO - ".$rowretequipetratamento[2]."', '".$_SESSION['usuario']."', current_timestamp, (select nm_pcnt from tratamento.tb_c_pcnt where cd_pcnt = '".$cd_pcnt."'))";						
					$result = pg_query($pdo, $sql);
					if($result){
						echo "";
					}			
					
				
				
				}
				
				$sql = "SELECT MAX(id_hstr_pnel_solic_trtmto) FROM tratamento.tb_hstr_pnel_solic_trtmto WHERE cd_pcnt = '".$cd_pcnt."' and id_equipe = 13 and fl_trtmto_fchd = 0 ";
								
				$retmaxpanelsolictrtmto = pg_query($pdo, $sql);
					
				if(!$retmaxpanelsolictrtmto) {
					echo pg_last_error($pdo);		
					exit;
				}
					
				$rowmaxpanelsolictrtmto = pg_fetch_row($retmaxpanelsolictrtmto);
							
				$sql = "SELECT id_hstr_pnel_solic_trtmto, dt_inicial_trtmto 
						  FROM tratamento.tb_hstr_pnel_solic_trtmto 
						WHERE cd_pcnt = '".$cd_pcnt."' and id_equipe = 13 and fl_trtmto_fchd = 0 and id_hstr_pnel_solic_trtmto = ".$rowmaxpanelsolictrtmto[0]." ";

				//echo $sql;

				$rethstrtratamento = pg_query($pdo, $sql);

				if(!$rethstrtratamento) {
					echo pg_last_error($pdo);		
					exit;
				}

				$rowhstrtratamento = pg_fetch_row($rethstrtratamento);

				$id_hstr_pnel_solic_trtmto = $rowhstrtratamento[0];
				$dt_inicial_trtmto = $rowhstrtratamento[1];

			}

						$sql = "INSERT INTO tratamento.tb_pddo_trtmto(id_pddo_trtmto, id_hstr_pnel_solic_trtmto, cd_pcnt, nm_pcnt, dt_nasc_pcnt, vl_idade_pcnt, nu_peso_pcnt, vl_altura_pcnt, vl_sup_corp, ds_indic_clnic, dt_diagn, cd_cid, ds_plano_trptco, ds_info_rlvnte, ds_diagn_cito_hstpagico, ds_tp_cirurgia, ds_area_irrda, dt_rlzd, dt_aplc, ds_obs_jfta, nu_qtde_ciclo_prta, ds_ciclo_atual, ds_dia_ciclo_atual, ds_intrv_entre_ciclo_dia, ds_estmt, ds_tipo_linha_trtmto, ds_fnlde, ic_tipo_tumor, ic_tipo_nodulo, ic_tipo_metastase, cd_usua_incs, dt_incs, cd_cnvo, nm_mdco_encaminhador, ds_exame_enviado, ic_crioterapia)
	VALUES ((select NEXTVAL('tratamento.sq_pddo_trtmto')), ". $id_hstr_pnel_solic_trtmto.", (select cd_pcnt from tratamento.tb_c_pcnt where trim(nm_pcnt) = trim('".$nm_pcnt."')), '". trim($nm_pcnt)."', (select dt_nasc_pcnt from tratamento.tb_c_pcnt where trim(nm_pcnt) = trim('". $nm_pcnt."')), (select date_part('year', age(now(), (select dt_nasc_pcnt from tratamento.tb_c_pcnt where trim(nm_pcnt) = trim('". $nm_pcnt."'))))), ". str_replace(",", ".", $nu_peso_pcnt).", ". str_replace(",", ".", $vl_altura_pcnt).", ". str_replace(",", ".", $vl_sup_corp).", UPPER('".str_replace("'", " ",$ds_indic_clnic)."'), '".$dt_diagn."', UPPER('". $cd_cid."'), UPPER('". str_replace("'", " ",$ds_plano_trptco)."'), UPPER('". str_replace("'", " ",$ds_info_rlvnte)."'), UPPER('". str_replace("'", " ",$ds_diagn_cito_hstpagico)."'), UPPER('". str_replace("'", " ",$ds_tp_cirurgia)."'), UPPER('". str_replace("'", " ",$ds_area_irrda)."'), '".$dt_rlzd."', '".$dt_aplc."', UPPER('". str_replace("'", " ",$ds_obs_jfta)."'), '". $nu_qtde_ciclo_prta."', '". $ds_ciclo_atual."', '". $ds_dia_ciclo_atual."', '". $ds_intrv_entre_ciclo_dia."', '". $ds_estmt."' ,'". $ds_tipo_linha_trtmto."', '".$ds_fnlde."', '". $ic_tipo_tumor."', '". $ic_tipo_nodulo."', '". $ic_tipo_metastase."', '".$_SESSION['usuario']."', current_timestamp, '". $cd_cnvo."', '". $nm_mdco_encaminhador."', '". $ds_exame_enviado."', '". $ic_crioterapia."');";
					    
						//echo $sql;
						
						$result = pg_query($pdo, $sql);			
						if($result){
							//tratar erro
							echo "";	
						}
						
						$sql = "insert into tratamento.tb_log_importa_csv (nm_arquivo_csv, id_reg_arquivo_csv) values ('".$_SESSION['fileUploaded']."', ".$id_reg.");"; 		
						$result = pg_query($pdo, $sql);			
						if($result){
							//tratar erro
							echo "";	
						}
					}
				}
			}
		}		
	}
		
?>  
	<!DOCTYPE html>
	<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="../css/prism.css">
		<link rel="stylesheet" href="../css/chosen.css">	 
		
		<script >
		function ShowLoading(e) {
			var div = document.createElement('div');
			var img = document.createElement('img');
			img.src = '../img/Update_2.ico';
			div.innerHTML = "<br><br><br><br>Aguarde...<br />";
			div.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height:100%; text-align: center; background: #f0f0f0; filter: alpha(opacity = 65); -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=65)"; opacity: 0.65; z-index: 9998;';
			div.appendChild(img);
			document.body.appendChild(div);
			return true;
		}
		
		</script>
		
		<style>	
			#importtable {
			  font-family: Arial, Helvetica, sans-serif;;	  
			  font-size: 0.7em; 
			  border-collapse: collapse;
			  width: 100%;
			}
			
			#importtable td, #importtable th {
			  border: 1px solid #ddd;
			  padding: 5px;
			}

			#importtable tr:nth-child(even){background-color: #f2f2f2;}

			#importtable tr:hover {background-color: #ddd;}

			#importtable th {
			  padding-top: 12px;
			  padding-bottom: 12px;
			  text-align: left;
			  background-color: #04AA6D;
			  color: white;
			}
			
			.table {
			  border-collapse: collapse;
			  border-spacing: 0px;
			}
			
			.td {
			  border: 2px solid black;
			  padding: 0;
			  margin: 0px;
			  overflow: auto;
			}

			.divtable {
			  resize: both;
			  overflow: auto;
			  width: auto;
			  height: auto;
			  margin: 0px;
			  padding: 0px;
			  border: 1px solid black;
			  display:block;

			}

			.td divtable {
			  border: 0;
			  width: auto;
			  height: auto;
			  min-height: auto;
			  min-width: auto;
			}
			
	</style>
	 </head>	
	 <body>
	 	<h2>Importação da planilha de pedidos de tratamentos</h2>
		<br>				
		<div id="main" class="container-fluid">            	
			<div class="container" style="margin-left: 0px">			    	
				<form class="form-inline" action="#" method="post" onsubmit="ShowLoading()">	
					<input type="file" id="fileUploaded" name="fileUploaded" value="" class="inputfile"  />&nbsp;&nbsp;					
					<input class="btn btn-primary" style="font-size: 11px;" type="submit" value="Carregar arquivo" name="btprocessar">&nbsp;
					<input class="btn btn-primary" style="font-size: 11px;" type="submit" value="Salvar dados processados" name="btsalvar">&nbsp;
					<input class="btn btn-primary" style="font-size: 11px;" type="submit" value="Limpar seleção de arquivo" name="btlimpar">&nbsp;										
				</form>	
			</div>
			
			<br>

			<div id="list" class="row">	                									    
				<div class="table-responsive col-md-12">					
				<?php
				
					if ($CSVvar !== FALSE) {
					?>
						<div id="divtable">								
							<table id="importtable" name="tabelaprincipal">
							
								<thead>
									<tr>				
										<th><b>Ação</b></th>
										<th><b>ID Reg</b></th>
										<th><b>Paciente</b></th>
										<th><b>Convênio</b></th>
										<th><b>Peso</b></th>				 
										<th><b>Altura</b></th>
										<th><b>Sup Corp</b></th>
										<th><b>Indicacao Clinica</b></th>	
										<th><b>Data do Diagnostico</b></th>
										<th><b>CID</b></th>
										<th><b>Estadiamento</b></th>	
										<th><b>Tipo Quimio (Linha)</b></th>
										<th><b>Finalidade</b></th>
										<th><b>Tipo de Tumor</b></th>	
										<th><b>Tipo de Nodulo</b></th>
										<th><b>Tipo de Metastase</b></th>
										<th><b>Plano Terapêutico</b></th>	
										<th><b>Informações Relevantes</b></th>
										<th><b>Diagnóstico Histopatologico</b></th>
										<th><b>Tipo de Cirurgia</b></th>	
										<th><b>Área Irradiada</b></th>
										<th><b>Data de Realização</b></th>
										<th><b>Data da Aplicação</b></th>	
										<th><b>Observação Justificativa</b></th>
										<th><b>Quantidade de Ciclos Prevsitos</b></th>
										<th><b>Ciclo Atual</b></th>	
										<th><b>Dias do ciclo atual</b></th>
										<th><b>Intervalo de Ciclos</b></th>
										<th><b>Nome do médico encaminhador</b></th>	
										<th><b>Exames enviados</b></th>
										<th><b>Crioterapia</b></th>
									</tr>
								</thead>
						<?php
							$data = fgetcsv($CSVvar, 1000, ";");
							
							$sql = "SELECT cd_pcnt, nm_pcnt as nm_pcnt from tratamento.tb_c_pcnt order by 2";

							if ($pdo==null){
								header(Config::$webLogin);
							}	
							$ret = pg_query($pdo, $sql);
							if(!$ret) {
								echo pg_last_error($pdo);
								exit;
							}

							$paciente = array();
							$cont_paciente = 0;
							

							while($row = pg_fetch_row($ret)) {
								
								$paciente[$cont_paciente][0] = $row[0];
								$paciente[$cont_paciente][1] = $row[1];
								
								$cont_paciente=$cont_paciente+1;
							} 

							while (! feof($CSVvar)) {
								$data = fgetcsv($CSVvar, 1000, ";");
								$achoupacientenalista=0;
								
								$pacienteimportado=false;								
								
								if (!empty($data)){
									$sql = "select count(1) from tratamento.tb_log_importa_csv where nm_arquivo_csv='".$_SESSION['fileUploaded']."'  ";									
								
									if ($pdo==null){
										header(Config::$webLogin);
									}	
									$ret = pg_query($pdo, $sql);
									if(!$ret) {
										echo pg_last_error($pdo);
										exit;
									}
									
									$row = pg_fetch_row($ret);
									
									if($row[0] > 0) {
										$pacienteimportado=true;	
									}
								}
								
								if (!empty($data) && $data[1] <> '' && $pacienteimportado==false) {
									?>									
									<tr>
										
										<?php
										for ($linhalista = 0; $linhalista < $cont_paciente; $linhalista++) {
											if (trim($paciente[$linhalista][1])==trim($data[1])){
												$achoupacientenalista = 1;
												break;
											}											
										} 														
										?>
										
										<td class="actions"><!--Ações-->
											<?php
												if ($achoupacientenalista==1){												
													echo 'Dados processados.';												
												}else{
													echo 'Pac. não cadastrado.';
												}													
												?>	
										</td>
										
										<td><div><?php echo $data[0];?></div></td><!--ID Reg-->
										
										<td><div style="resize: both; overflow: auto;width:200px"><?php echo $data[1];?></div></td><!--Paciente-->
										<td value="<?php echo $data[2];?>"><div><?php echo $data[2];?></div></td><!--Convênio-->	
										
										<td><?php echo $data[3];?></td><!--Peso-->
										<td><?php echo $data[4];?></td><!--Altura-->	
										<td><div style="resize: both; overflow: auto;width:80px"><?php echo $data[5];?></div></td><!--Sup Corp-->	
										
										<td><div style="resize: both; overflow: auto;width:250px"><?php echo $data[6];?></div></td><!--Indicacao Clinica-->
										
										<td><?php echo $data[7];?></td><!--Data do Diagnostico-->
										<td><?php echo $data[8];?></td><!--CID	-->
										<td><?php echo $data[9];?></td><!--Estadiamento-->	
										<td><?php echo $data[10];?></td><!--Tipo Quimio (Linha)-->	
										
										<td><div style="resize: both; overflow: auto;width:100px"><?php echo $data[11];?></div></td><!--Finalidade-->	
										
										<td><?php echo $data[12];?></td><!--Tipo de Tumor-->
										<td><?php echo $data[13];?></td><!--Tipo de Nodulo-->
										<td><?php echo $data[14];?></td><!--Tipo de Metastase-->	
										
										<td><div style="resize: both; overflow: auto;width:400px"><?php echo $data[15];?></div></td><!--Plano Terapêutico-->
										<td><div style="resize: both; overflow: auto;width:400px"><?php echo $data[16];?></div></td><!--Informações Relevantes-->
										<td><div style="resize: both; overflow: auto;width:300px"><?php echo $data[17];?></div></td><!--Diagnóstico Histopatologico-->
										<td><div style="resize: both; overflow: auto;width:150px"><?php echo $data[18];?></div></td><!--Tipo de Cirurgia-->
										<td><div style="resize: both; overflow: auto;width:150px"><?php echo $data[19];?></div></td><!--Área Irradiada-->	
										
										<td><?php echo $data[20];?></td><!--Data de Realização-->
										<td><?php echo $data[21];?></td><!--Data da Aplicação-->
										
										<td><div style="resize: both; overflow: auto;width:300px"><?php echo $data[22];?></div></td><!--Observação Justificativa-->	
										
										<td><?php echo $data[23];?></td><!--Quantidade de Ciclos Prevsitos-->
										<td><?php echo $data[24];?></td><!--Ciclo Atual-->
										<td><?php echo $data[25];?></td><!--Dias do ciclo atual-->	
										<td><?php echo $data[26];?></td><!--Intervalo de Ciclos-->
										
										<td><div><?php echo $data[27];?></div></td><!--Nome do médico encaminhador-->				
										<td><div><?php echo $data[28];?></div></td><!--Exames Enviados-->
										<td><div><?php echo $data[29];?></div></td><!--Crioterapia-->
										
									</tr>
						<?php }?>
					<?php }?>
						</table>
					</div>
				<?php }?>
				</div>
			</div>
		</div>
		
		<script src="../js/bootstrap.min.js"></script>			
		<script src="../js/jquery-3.2.1.min.js" type="text/javascript"></script>
		<script src="../js/chosen.jquery.js" type="text/javascript"></script>		
		<script src="../js/prism.js" type="text/javascript" charset="utf-8"></script>
		<script src="../js/init.js" type="text/javascript" charset="utf-8"></script>

	</body>
	</html>
	
	
<?php
?>
