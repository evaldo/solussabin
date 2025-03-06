<?php
//altera_cores.php
	session_start();
	$_SESSION['id_pddo_trtmto']=$_POST['id_pddo_trtmto'];
	
    include '../database.php';	
	
	$pdo = database::connect();

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
	where id_pddo_trtmto = ".$_POST['id_pddo_trtmto']." ";

	if ($pdo==null){
			header(Config::$webLogin);
	}	
	$retpddotrtmto = pg_query($pdo, $sql);
	if(!$retpddotrtmto) {
		echo pg_last_error($pdo);
		exit;
	}
	
	$rowpddotrtmto = pg_fetch_row($retpddotrtmto);	
	
?>
	<!DOCTYPE html>
	<html lang="pt-br">
	<head>
	 <meta charset="utf-8">
	 <link href="../css/bootstrap.min.css" rel="stylesheet">
	 <link href="../css/style.css" rel="stylesheet">
	</head>
	<body style="margin-right: 0; margin-left: 0">	
		<div class="container" style="width: 100%;  margin-right: 0; margin-left: 0; position: relative;">
		  <div class="modal-dialog">
				<div class="modal-content" style="width:800px">
					<div class="container">						
						<h4 class="modal-title">Alteração do Pedido de Tratamento</h4>
					</div>								
					<form class="form-inline" method="post" id="formAltera">
						<div class="modal-body">
							<div class="table-responsive">  							
								<table class="table table-bordered">
									
									<tr>  
										<td style="width:150px"><label>Paciente:</label></td>  
										<?php
										
										$sql = "SELECT cd_pcnt, substring(nm_pcnt, 1, 30) as nm_pcnt from tratamento.tb_c_pcnt order by 2";
										
										if ($pdo==null){
												header(Config::$webLogin);
										}	
										$ret = pg_query($pdo, $sql);
										if(!$ret) {
											echo pg_last_error($pdo);
											exit;
										}
										?>
										<td style="width:150px">
											<select  id="pcnt" class="form-control" onchange=" 
														var selObj = document.getElementById('pcnt');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('cd_pcnt').value = selValue;">
														<option value="null"></option>
																									
											<?php
												$cont=1;																	
											
												while($row = pg_fetch_row($ret)) {
													if($row[0]==$rowpddotrtmto[2]){														
												?>												
													<option value="<?php echo $row[0]; ?>" selected><?php echo $row[1]; ?></option>
												<?php																		
													} else {
												?>
													<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>												
													<?php } 
												$cont=$cont+1;} ?>	
											</select>
										
										</td>	
									   </tr>
									   
									   <tr>  
										<td style="width:150px"><label>Convênio:</label></td>  
										<?php
										
										$sql = "SELECT id_cnvo, cd_cnvo from tratamento.tb_c_cnvo order by 2";
										
										if ($pdo==null){
												header(Config::$webLogin);
										}	
										$ret = pg_query($pdo, $sql);
										if(!$ret) {
											echo pg_last_error($pdo);
											exit;
										}
										?>
										<td style="width:150px">
											<select  id="cnvo" class="form-control" onchange=" 
														var selObj = document.getElementById('cnvo');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('cd_cnvo').value = selValue;">
														<option value="null"></option>
																									
											<?php
												$cont=1;																	
											
												while($row = pg_fetch_row($ret)) {
													if($row[1]==$rowpddotrtmto[34]){														
												?>												
													<option value="<?php echo $row[1]; ?>" selected><?php echo $row[1]; ?></option>
												<?php																		
													} else {
												?>
													<option value="<?php echo $row[1]; ?>"><?php echo $row[1]; ?></option>												
													<?php } 
												$cont=$cont+1;} ?>		
											</select>
										
										</td>	
									   </tr>
									   
									   <tr>  
										<td style="width:150px"><label>Tratamento:</label></td>  
										<?php
										
										$statustratamentoatual = '';
										
										$sql = "SELECT count(id_hstr_pnel_solic_trtmto) FROM tratamento.tb_hstr_pnel_solic_trtmto WHERE cd_pcnt = '".$rowpddotrtmto[2]."' and id_equipe = 13 and fl_trtmto_fchd = 0  ";
					
										$retcountpanelsolictrtmto = pg_query($pdo, $sql);
											
										if(!$retcountpanelsolictrtmto) {
											echo pg_last_error($pdo);		
											exit;
										}
											
										$rowcountpanelsolictrtmto = pg_fetch_row($retcountpanelsolictrtmto);
										
										if ($rowcountpanelsolictrtmto[0] > 0) {
										
										
											$sql = "SELECT MAX(id_hstr_pnel_solic_trtmto) FROM tratamento.tb_hstr_pnel_solic_trtmto WHERE cd_pcnt = '".$rowpddotrtmto[2]."' and id_equipe = 13 and fl_trtmto_fchd = 0 ";
						
											$retmaxpanelsolictrtmto = pg_query($pdo, $sql);
												
											if(!$retmaxpanelsolictrtmto) {
												echo pg_last_error($pdo);		
												exit;
											}
												
											$rowmaxpanelsolictrtmto = pg_fetch_row($retmaxpanelsolictrtmto);
														
											$sql = "SELECT id_status_trtmto, ds_status_trtmto 
													  FROM tratamento.tb_hstr_pnel_solic_trtmto 
													WHERE cd_pcnt = '".$rowpddotrtmto[2]."' and id_equipe = 13 and fl_trtmto_fchd = 0 and id_hstr_pnel_solic_trtmto = ".$rowmaxpanelsolictrtmto[0]." ";

											//echo $sql;

											$rethstrtratamento = pg_query($pdo, $sql);

											if(!$rethstrtratamento) {
												echo pg_last_error($pdo);		
												exit;
											}

											$rowhstrtratamento = pg_fetch_row($rethstrtratamento);
											$idstatustratamentoatual = $rowhstrtratamento[0];
											$statustratamentoatual = $rowhstrtratamento[1];
										}
										
										$sql = "SELECT trtmto.id_status_trtmto, trtmto.ds_status_trtmto 
												FROM tratamento.tb_c_status_trtmto trtmto
												  WHERE trtmto.id_equipe = 13 
												order by 2 asc";
										
										if ($pdo==null){
												header(Config::$webLogin);
										}	
										$ret = pg_query($pdo, $sql);
										if(!$ret) {
											echo pg_last_error($pdo);
											exit;
										}
										
										?>
										<td style="width:150px">
											<select  id="sel_id_status_trtmto" class="form-control" onchange=" 
														var selObj = document.getElementById('sel_id_status_trtmto');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('id_status_trtmto').value = selValue;">
														<option value="0"></option>
																									
											<?php
											
												$cont=1;																	
											
												while($row = pg_fetch_row($ret)) {
													if($row[1]==$statustratamentoatual){														
												?>												
													<option value="<?php echo $row[0]; ?>" selected><?php echo $row[1]; ?></option>
												<?php																		
													} else {
												?>
													<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>												
													<?php } 
												$cont=$cont+1;} ?>	
										
										</td>	
									   </tr>
									   
									   <tr>
											<td style="width:50px"><label>Nome do médico encaminhador:</label></td> 
											<td style="width:10px"><input type="text" class="form-control" name="nm_mdco_encaminhador" value="<?php echo $rowpddotrtmto[35]; ?>"></td>
									   </tr>
									   
									   <tr>
											<td style="width:50px"><label>Peso(Kg):</label></td> 
											<td style="width:10px"><input type="text" class="form-control" name="nu_peso_pcnt" value="<?php echo $rowpddotrtmto[6]; ?>"></td>
									   </tr>
									   
									   <tr>
											<td style="width:50px"><label>Altura(Cm):</label></td> 
											<td style="width:10px"><input type="text" class="form-control" name="vl_altura_pcnt" value="<?php echo $rowpddotrtmto[7]; ?>"></td>
									   </tr>
									   
									   <tr>
											<td style="width:50px"><label>Sup. Corp(m2):</label></td> 
											<td style="width:10px"><input type="text" class="form-control" name="vl_sup_corp" value="<?php echo $rowpddotrtmto[8]; ?>"></td>
									   </tr>
										
									   <tr>
									 
										<td style="width:150px"><label>Indicação Clínica:</label></td>  
										<td style="width:200px"><textarea rows="6" cols="50" id="ds_utlma_obs_mapa_risco" class="form-control" name="ds_indic_clnic"><?php echo $rowpddotrtmto[9]; ?></textarea></td> 
									 
									   </tr>
									   
									   <tr>
											<td ><label>Data do Diagnóstico:</label></td>
											<td ><input type="date" class="form-control" id="dt_diagn" name="dt_diagn" value="<?php echo $rowpddotrtmto[10]; ?>"></td>
									   </tr>
									   
									   <tr>
										<td ><label>CID 10 Principal:</label></td>  
										<?php
										
										$sql = "SELECT cd_cid, ds_rsmo_cid from tratamento.tb_c_cid order by 2";
										
										if ($pdo==null){
												header(Config::$webLogin);
										}	
										$ret = pg_query($pdo, $sql);
										if(!$ret) {
											echo pg_last_error($pdo);
											exit;
										}
										?>
										<td>
											<select  id="cid" class="form-control" onchange=" 
														var selObj = document.getElementById('cid');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('cd_cid').value = selValue;">
														<option value="null"></option>
																									
											<?php
												$cont=1;																	
											
												while($row = pg_fetch_row($ret)) {
													if($row[0]==$rowpddotrtmto[11]){														
												?>												
													<option value="<?php echo $row[0]; ?>" selected><?php echo $row[1]; ?></option>
												<?php																		
													} else {
												?>
													<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>												
													<?php } 
												$cont=$cont+1;} ?>	
											</select>
										</td>
										
									 </tr>
									 
									 <tr>  
										<td style="width:150px"><label>Estadiamento:</label></td>  										
										<td style="width:150px">
											<select  id="sl_estmt" class="form-control" onchange=" 
														var selObj = document.getElementById('sl_estmt');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('ds_estmt').value = selValue;">
												<option value="">Escolha uma opção</option>
												<?php if($rowpddotrtmto[24]=='I') { ?>
													<option value="I" selected>I</option>											
													<option value="II">II</option>
													<option value="III">III</option>
													<option value="IV">IV</option>												
												<?php } ?>
												<?php if($rowpddotrtmto[24]=='II') { ?>
													<option value="I" >I</option>											
													<option value="II" selected>II</option>
													<option value="III">III</option>
													<option value="IV">IV</option>												
												<?php } ?>
												<?php if($rowpddotrtmto[24]=='III') { ?>
													<option value="I" >I</option>											
													<option value="II" >II</option>
													<option value="III" selected>III</option>
													<option value="IV">IV</option>												
												<?php } ?>
												<?php if($rowpddotrtmto[24]=='IV') { ?>
													<option value="I" >I</option>											
													<option value="II" >II</option>
													<option value="III">III</option>
													<option value="IV" selected>IV</option>												
												<?php } else { ?>													
													<option value="I">I</option>											
													<option value="II">II</option>
													<option value="III">III</option>
													<option value="IV">IV</option>
												<?php }  ?>
											</select>
										</td>	
									 </tr>
									 
									  <tr>  
										<td style="width:150px"><label>Tipo Quimio. (Linha):</label></td>  										
										<td style="width:150px">
											<select  id="sl_tipo_linha_trtmto" class="form-control" onchange=" 
														var selObj = document.getElementById('sl_tipo_linha_trtmto');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('ds_tipo_linha_trtmto').value = selValue;">
												<option value="">Escolha uma opção</option>
												<?php if($rowpddotrtmto[25]=='1 Linha') { ?>
													<option value="1 Linha" selected>1 Linha</option>													
													<option value="2 Linha">2 Linha</option>
													<option value="3 Linha">3 Linha</option>
													<option value="Outras">Outras</option>													
												<?php } ?>
												<?php if($rowpddotrtmto[25]=='2 Linha') { ?>
													<option value="1 Linha">1 Linha</option>											
													<option value="1 Linha" selected>2 Linha</option>
													<option value="3 Linha">3 Linha</option>
													<option value="Outras">Outras</option>													
												<?php } ?>
												<?php if($rowpddotrtmto[25]=='3 Linha') { ?>
													<option value="1 Linha">1 Linha</option>											
													<option value="1 Linha">2 Linha</option>
													<option value="3 Linha" selected>3 Linha</option>
													<option value="Outras">Outras</option>													
												<?php } ?>								
												<?php if($rowpddotrtmto[25]=='Outras') { ?>
													<option value="1 Linha">1 Linha</option>											
													<option value="1 Linha">2 Linha</option>
													<option value="3 Linha">3 Linha</option>
													<option value="Outras" selected>Outras</option>													
												<?php } else { ?>													
													<option value="1 Linha">1 Linha</option>											
													<option value="1 Linha">2 Linha</option>
													<option value="3 Linha">3 Linha</option>
													<option value="Outras">Outras</option>
												<?php }  ?>
											</select>
										</td>	
									 </tr>
									 
									 <tr>  
										<td style="width:150px"><label>Finalidade:</label></td>  										
										<td style="width:150px">
											<select  id="sl_fnlde" class="form-control" onchange=" 
														var selObj = document.getElementById('sl_fnlde');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('ds_fnlde').value = selValue;">
												<option value="">Escolha uma opção</option>
												<?php if($rowpddotrtmto[26]=='Paliativo') { ?>
													<option value="Paliativo" selected>Paliativo</option>											
													<option value="Adjuvante">Adjuvante</option>
													<option value="Neo-Adjuvante">Neo-Adjuvante</option>
													<option value="Curativo">Curativo</option>															
												<?php } ?>
												<?php if($rowpddotrtmto[26]=='Adjuvante') { ?>
													<option value="Paliativo" >Paliativo</option>											
													<option value="Adjuvante" selected>Adjuvante</option>
													<option value="Neo-Adjuvante">Neo-Adjuvante</option>
													<option value="Curativo">Curativo</option>															
												<?php } ?>							
												<?php if($rowpddotrtmto[26]=='Neo-Adjuvante') { ?>
													<option value="Paliativo" >Paliativo</option>											
													<option value="Adjuvante" >Adjuvante</option>
													<option value="Neo-Adjuvante" selected>Neo-Adjuvante</option>
													<option value="Curativo">Curativo</option>															
												<?php } ?>
												<?php if($rowpddotrtmto[26]=='Curativo') { ?>
													<option value="Paliativo" >Paliativo</option>											
													<option value="Adjuvante" >Adjuvante</option>
													<option value="Neo-Adjuvante" >Neo-Adjuvante</option>
													<option value="Curativo" selected>Curativo</option>	
												<?php } else { ?>													
													<option value="Paliativo" >Paliativo</option>											
													<option value="Adjuvante" >Adjuvante</option>
													<option value="Neo-Adjuvante" >Neo-Adjuvante</option>
													<option value="Curativo">Curativo</option>	
												<?php }  ?>
											</select>
										</td>	
									 </tr>
									 
									 <tr>  
										<td style="width:150px"><label>Tumor:</label></td>  										
										<td style="width:150px">
											<select  id="sl_tipo_tumor" class="form-control" onchange=" 
														var selObj = document.getElementById('sl_tipo_tumor');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('ic_tipo_tumor').value = selValue;">
												<option value="">Escolha uma opção</option>
												<?php if($rowpddotrtmto[27]=='T1') { ?>
													<option value="T1" selected>T1</option>											
													<option value="T2">T2</option>
													<option value="T3">T3</option>
													<option value="T0">T0</option>												
													<option value="TIS">TIS</option>												
													<option value="TX">TX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>	
												<?php if($rowpddotrtmto[27]=='T2') { ?>
													<option value="T1" >T1</option>											
													<option value="T2" selected>T2</option>
													<option value="T3">T3</option>
													<option value="T0">T0</option>												
													<option value="TIS">TIS</option>												
													<option value="TX">TX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>	
												<?php if($rowpddotrtmto[27]=='T3') { ?>
													<option value="T1" >T1</option>											
													<option value="T2" >T2</option>
													<option value="T3" selected>T3</option>
													<option value="T0">T0</option>												
													<option value="TIS">TIS</option>												
													<option value="TX">TX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>
												<?php if($rowpddotrtmto[27]=='T0') { ?>
													<option value="T1" >T1</option>											
													<option value="T2" >T2</option>
													<option value="T3" >T3</option>
													<option value="T0" selected>T0</option>												
													<option value="TIS">TIS</option>												
													<option value="TX">TX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>
												<?php if($rowpddotrtmto[27]=='TIS') { ?>
													<option value="T1" >T1</option>											
													<option value="T2" >T2</option>
													<option value="T3" >T3</option>
													<option value="T0" >T0</option>												
													<option value="TIS" selected>TIS</option>												
													<option value="TX">TX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>
												<?php if($rowpddotrtmto[27]=='TX') { ?>
													<option value="T1" >T1</option>											
													<option value="T2" >T2</option>
													<option value="T3" >T3</option>
													<option value="T0" >T0</option>												
													<option value="TIS" >TIS</option>												
													<option value="TX" selected>TX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>
												<?php if($rowpddotrtmto[27]=='Nao Se Aplica') { ?>
													<option value="T1" >T1</option>											
													<option value="T2" >T2</option>
													<option value="T3" >T3</option>
													<option value="T0" >T0</option>												
													<option value="TIS" >TIS</option>												
													<option value="TX" >TX</option>												
													<option value="Nao Se Aplica" selected>Nao Se Aplica</option>
												<?php } else { ?>													
													<option value="T1" >T1</option>											
													<option value="T2" >T2</option>
													<option value="T3" >T3</option>
													<option value="T0" >T0</option>												
													<option value="TIS" >TIS</option>												
													<option value="TX" >TX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php }  ?>
											</select>
										</td>	
									 </tr>

									  <tr>  
										<td style="width:150px"><label>Nódulo:</label></td>  										
										<td style="width:150px">
											<select  id="sl_tipo_nodulo" class="form-control" onchange=" 
														var selObj = document.getElementById('sl_tipo_nodulo');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('ic_tipo_nodulo').value = selValue;">
												<option value="">Escolha uma opção</option>
												<?php if($rowpddotrtmto[28]=='N1') { ?>
													<option value="N1" selected>N1</option>											
													<option value="N2">N2</option>
													<option value="N3">N3</option>
													<option value="N0">N0</option>														
													<option value="NX">NX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>
												<?php if($rowpddotrtmto[28]=='N2') { ?>
													<option value="N1" >N1</option>											
													<option value="N2" selected>N2</option>
													<option value="N3">N3</option>
													<option value="N0">N0</option>														
													<option value="NX">NX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>												
												<?php if($rowpddotrtmto[28]=='N3') { ?>
													<option value="N1" >N1</option>											
													<option value="N2" >N2</option>
													<option value="N3" selected>N3</option>
													<option value="N0">N0</option>														
													<option value="NX">NX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>	
												<?php if($rowpddotrtmto[28]=='N0') { ?>
													<option value="N1" >N1</option>											
													<option value="N2" >N2</option>
													<option value="N3" >N3</option>
													<option value="N0" selected>N0</option>														
													<option value="NX">NX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>
												<?php if($rowpddotrtmto[28]=='NX') { ?>
													<option value="N1" >N1</option>											
													<option value="N2" >N2</option>
													<option value="N3" >N3</option>
													<option value="N0" >N0</option>														
													<option value="NX" selected>NX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>
												<?php if($rowpddotrtmto[28]=='Nao Se Aplica') { ?>
													<option value="N1" >N1</option>											
													<option value="N2" >N2</option>
													<option value="N3" >N3</option>
													<option value="N0" >N0</option>														
													<option value="NX" >NX</option>												
													<option value="Nao Se Aplica" selected>Nao Se Aplica</option>
												<?php } else { ?>													
													<option value="N1" >N1</option>											
													<option value="N2" >N2</option>
													<option value="N3" >N3</option>
													<option value="N0" >N0</option>														
													<option value="NX" >NX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php }  ?>
											</select>
										</td>	
									 </tr>
									 
									 <tr>  
										<td style="width:150px"><label>Metástase:</label></td>  										
										<td style="width:150px">
											<select  id="sl_tipo_metastase" class="form-control" onchange=" 
														var selObj = document.getElementById('sl_tipo_metastase');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('ic_tipo_metastase').value = selValue;">
												<option value="">Escolha uma opção</option>
												<?php if($rowpddotrtmto[29]=='M1') { ?>
													<option value="M1" selected>M1</option>											
													<option value="M0">M0</option>														
													<option value="MX">MX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>
												<?php if($rowpddotrtmto[29]=='M0') { ?>
													<option value="M1" >M1</option>											
													<option value="M0" selected>M0</option>														
													<option value="MX">MX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>									
												<?php if($rowpddotrtmto[29]=='MX') { ?>
													<option value="M1" >M1</option>											
													<option value="M0" >M0</option>														
													<option value="MX" selected>MX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>
												<?php if($rowpddotrtmto[29]=='Nao Se Aplica') { ?>
													<option value="M1" >M1</option>											
													<option value="M0" >M0</option>														
													<option value="MX" >MX</option>												
													<option value="Nao Se Aplica" selected>Nao Se Aplica</option>
												<?php } else { ?>													
													<option value="M1" >M1</option>											
													<option value="M0" >M0</option>														
													<option value="MX" >MX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php }  ?>
											</select>
										</td>	
									 </tr>
									 
									 <tr>
									 
											<td style="width:150px"><label>Plano Terapêutico:</label></td>  
											<td style="width:200px"><textarea rows="6" cols="50" id="ds_plano_trptco" class="form-control" name="ds_plano_trptco" ><?php echo $rowpddotrtmto[12]; ?></textarea></td> 
									 
									 </tr>
									 
									 <tr>
									 
											<td style="width:150px"><label>Informações Relevantes:</label></td>  
											<td style="width:200px"><textarea rows="6" cols="50" id="ds_info_rlvnte" class="form-control" name="ds_info_rlvnte" ><?php echo $rowpddotrtmto[13]; ?></textarea></td> 
									 
									 </tr>
									 
									 <tr>
									 
											<td style="width:150px"><label>Diagnóstico Cito/Histopatológico:</label></td>  
											<td style="width:200px"><textarea rows="6" cols="50" id="ds_diagn_cito_hstpagico" class="form-control" name="ds_diagn_cito_hstpagico" ><?php echo $rowpddotrtmto[14]; ?></textarea></td> 
									 
									 </tr>
									 
									 <tr>
									 
											<td style="width:150px"><label>Cirurgia:</label></td>  
											<td style="width:200px"><textarea rows="5" cols="50" id="ds_tp_cirurgia" class="form-control" name="ds_tp_cirurgia" ><?php echo $rowpddotrtmto[15]; ?></textarea></td> 
									 
									 </tr>
									 
									 <tr>
									 
											<td style="width:150px"><label>Área Irradiada:</label></td>  
											<td style="width:200px"><textarea rows="5" cols="50" id="ds_area_irrda" class="form-control" name="ds_area_irrda"><?php echo $rowpddotrtmto[16]; ?></textarea></td> 
									 
									 </tr>
									 
									 <tr>
											<td ><label>Data de Realização:</label></td>
											<td ><input type="date" class="form-control" id="dt_rlzd" name="dt_rlzd" value="<?php echo $rowpddotrtmto[17]; ?>"></td>
									 </tr>
									 
									 <tr>
											<td ><label>Data da Aplicação:</label></td>
											<td ><input type="date" class="form-control" id="dt_aplc" name="dt_aplc" value="<?php echo $rowpddotrtmto[18]; ?>"></td>
									 </tr>
									 
									 <tr>  
										<td style="width:150px"><label>Crioterapia:</label></td>  										
										<td style="width:150px">
											<select  id="sl_ic_crioterapia" class="form-control" onchange=" 
														var selObj = document.getElementById('sl_ic_crioterapia');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('ic_crioterapia').value = selValue;">
												<option value="">Escolha uma opção</option>
												<?php if($rowpddotrtmto[36]=='Sim') { ?>
													<option value="Sim" selected>Sim</option>													
													<option value="Não">Não</option>
													<option value="Em análise">Em análise</option>																								
												<?php } ?>
												<?php if($rowpddotrtmto[36]=='Não') { ?>
													<option value="Sim">Sim</option>													
													<option value="Não" selected>Não</option>
													<option value="Em análise">Em análise</option>																								
												<?php } ?>
												<?php if($rowpddotrtmto[36]=='Em análise') { ?>
													<option value="Sim">Sim</option>													
													<option value="Não">Não</option>
													<option value="Em análise" selected>Em análise</option>												
												<?php } ?>																				
												<?php if($rowpddotrtmto[36]=='') { ?>														
													<option value="Sim">Sim</option>													
													<option value="Não">Não</option>
													<option value="Em análise">Em análise</option>		
												<?php }  ?>
											</select>
										</td>	
									 </tr>
									 
									  <tr>
									 
											<td style="width:150px"><label>Observação/Justificativa:</label></td>  
											<td style="width:200px"><textarea rows="6" cols="50" id="ds_obs_jfta" class="form-control" name="ds_obs_jfta"><?php echo $rowpddotrtmto[19]; ?></textarea></td> 
									 
									 </tr>
									 
									 <tr>
											<td style="width:50px"><label>Quantidade de Ciclos Previstos:</label></td> 
											<td style="width:10px"><input type="text" class="form-control" name="nu_qtde_ciclo_prta" value="<?php echo $rowpddotrtmto[20]; ?>" id="nu_qtde_ciclo_prta"></td>
									 </tr>
									 
									 <tr>
											<td style="width:50px"><label>Ciclo Atual:</label></td> 
											<td style="width:50px"><input type="text" class="form-control" name="ds_ciclo_atual" value="<?php echo $rowpddotrtmto[21]; ?>" id="ds_ciclo_atual"></td>
									 </tr>
									 
									  <tr>
											<td style="width:50px"><label>Número de Dias do Ciclo Atual:</label></td> 
											<td style="width:50px"><input type="text" class="form-control" name="ds_dia_ciclo_atual" value="<?php echo $rowpddotrtmto[22]; ?>" id="ds_dia_ciclo_atual"></td>
									 </tr>
									 
									 <tr>
											<td style="width:50px"><label>Intervalo entre Ciclos (em dias):</label></td> 
											<td style="width:50px"><input type="text" class="form-control" value="<?php echo $rowpddotrtmto[23]; ?>" name="ds_intrv_entre_ciclo_dia" id="ds_intrv_entre_ciclo_dia"></td>
									 </tr>
									 
									 <tr>
									 
										<td style="width:150px"><label>Exames enviados:</label></td>  
											<td style="width:200px"><textarea rows="6" cols="50" id="ds_exame_enviado" class="form-control" name="ds_exame_enviado"><?php echo $rowpddotrtmto[37]; ?></textarea></td> 
									 
									   </tr>
									 
									 <input type="text" id="cd_pcnt" name="cd_pcnt" value="<?php echo $rowpddotrtmto[2]; ?>" style="display:none"> 
									 <input type="text" id="cd_cnvo" name="cd_cnvo" value="<?php echo $rowpddotrtmto[34]; ?>" style="display:none"> 
									 <input type="text" id="cd_cid" name="cd_cid" value="<?php echo $rowpddotrtmto[11]; ?>" style="display:none"> 
									 
									 <input type="text" id="id_status_trtmto" name="id_status_trtmto" value="<?php echo $idstatustratamentoatual; ?>" style="display:none"> 
									 
									 <input type="text" id="ds_estmt" name="ds_estmt" value="<?php echo $rowpddotrtmto[24]; ?>" style="display:none"> 
									 <input type="text" id="ds_tipo_linha_trtmto" name="ds_tipo_linha_trtmto" value="<?php echo $rowpddotrtmto[25]; ?>" style="display:none"> 
									 <input type="text" id="ds_fnlde" name="ds_fnlde" value="<?php echo $rowpddotrtmto[26]; ?>" style="display:none"> 
									 <input type="text" id="ic_tipo_tumor" name="ic_tipo_tumor" value="<?php echo $rowpddotrtmto[27]; ?>" style="display:none"> 
									 <input type="text" id="ic_tipo_nodulo" name="ic_tipo_nodulo" value="<?php echo $rowpddotrtmto[28]; ?>" style="display:none"> 
									 <input type="text" id="ic_tipo_metastase" name="ic_tipo_metastase" value="<?php echo $rowpddotrtmto[29]; ?>" style="display:none"> 
									 <input type="text" id="ic_crioterapia" name="ic_crioterapia" value="<?php echo $rowpddotrtmto[36]; ?>" style="display:none">
									  
								</table>																
							</div>								
							<div class="modal-footer">	
								<input type="submit" class="btn btn-danger" name="altera" value="Alterar" onclick="if (document.getElementById('ds_exame_enviado').value=='') {alert('ATENÇÃO: Campo Exames Enviados, não preenchido!!'); return false;} else {document.getElementById('formAltera').submit();} " >&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="submit" class="btn btn-primary" onclick="history.go()" value="Voltar">						
							</div>								
						</div>
					</form>
				</div>
			</div>
		</div>		
		<script src="../js/jquery.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
	</body>
	</html>
		
<?php 
    
	
?>
