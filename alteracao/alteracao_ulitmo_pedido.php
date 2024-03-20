<?php
//altera_cores.php
	session_start();
	
	include '../database.php';
	
	error_reporting(0); 
	
    global $pdo;	
	
	$pdo = database::connect();
	
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
						<h4 class="modal-title">Recuperação/Inclusão dos Dados do Último Pedido de Tratamento</h4>
					</div>								
					<form class="form-inline" method="post" >
						<div class="modal-body">
							<div class="table-responsive">  							
								<table class="table table-bordered">
									
									<tr>  
										<td style="width:150px"><label>Paciente:</label></td>  
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
										<td style="width:150px">
											<select  id="pcnt" class="form-control" onchange=" 
														var selObj = document.getElementById('pcnt');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('cd_pcnt').value = selValue;">
														<option value="null"></option>
																									
											<?php
												$cont=1;																	
											
												while($row = pg_fetch_row($ret)) {
													if($row[0]==$_SESSION['cd_pcnt']){														
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
													if($row[1]==$_SESSION['cd_cnvo']){														
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
										
										$sql = "SELECT id_hstr_pnel_solic_trtmto
													 , nm_pcnt||'-'||ds_status_trtmto
												FROM tratamento.tb_hstr_pnel_solic_trtmto trtmto
												  WHERE trtmto.fl_trtmto_fchd = 0
													and trtmto.ds_equipe = 'Oncologistas';";
										
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
											<select  id="sel_hstr_pnel_solic_trtmto" class="form-control" onchange=" 
														var selObj = document.getElementById('sel_hstr_pnel_solic_trtmto');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('id_hstr_pnel_solic_trtmto').value = selValue;">
														<option value="null"></option>
																									
											<?php
												$cont=1;																	
											
												while($row = pg_fetch_row($ret)) {
												?>
													<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>												
													<?php  
												$cont=$cont+1;} ?>	
											</select>
										
										</td>	
									   </tr>
									   
									   <tr>
											<td style="width:50px"><label>Peso(Kg):</label></td> 
											<td style="width:10px"><input type="text" class="form-control" name="nu_peso_pcnt" value="<?php echo $_SESSION['nu_peso_pcnt']; ?>"></td>
									   </tr>
									   
									   <tr>
											<td style="width:50px"><label>Altura(Cm):</label></td> 
											<td style="width:10px"><input type="text" class="form-control" name="vl_altura_pcnt" value="<?php echo $_SESSION['vl_altura_pcnt']; ?>"></td>
									   </tr>
									   
									   <tr>
											<td style="width:50px"><label>Sup. Corp(m2):</label></td> 
											<td style="width:10px"><input type="text" class="form-control" name="vl_sup_corp" value="<?php echo $_SESSION['vl_sup_corp']; ?>"></td>
									   </tr>
										
									   <tr>
									 
										<td style="width:150px"><label>Indicação Clínica:</label></td>  
										<td style="width:200px"><textarea rows="6" cols="50" id="ds_utlma_obs_mapa_risco" class="form-control" name="ds_indic_clnic"><?php echo $_SESSION['ds_indic_clnic']; ?></textarea></td> 
									 
									   </tr>
									   
									   <tr>
											<td ><label>Data do Diagnóstico:</label></td>
											<td ><input type="date" class="form-control" id="dt_diagn" name="dt_diagn" value="<?php echo $_SESSION['dt_diagn']; ?>"></td>
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
													if($row[0]==$_SESSION['cd_cid']){														
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
												<?php if($_SESSION['ds_estmt']=='I') { ?>
													<option value="I" selected>I</option>											
													<option value="II">II</option>
													<option value="III">III</option>
													<option value="IV">IV</option>												
												<?php } ?>
												<?php if($_SESSION['ds_estmt']=='II') { ?>
													<option value="I" >I</option>											
													<option value="II" selected>II</option>
													<option value="III">III</option>
													<option value="IV">IV</option>												
												<?php } ?>
												<?php if($_SESSION['ds_estmt']=='III') { ?>
													<option value="I" >I</option>											
													<option value="II" >II</option>
													<option value="III" selected>III</option>
													<option value="IV">IV</option>												
												<?php } ?>
												<?php if($_SESSION['ds_estmt']=='IV') { ?>
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
												<?php if($_SESSION['ds_tipo_linha_trtmto']=='1 Linha') { ?>
													<option value="1 Linha" selected>1 Linha</option>													
													<option value="2 Linha">2 Linha</option>
													<option value="3 Linha">3 Linha</option>
													<option value="Outras">Outras</option>													
												<?php } ?>
												<?php if($_SESSION['ds_tipo_linha_trtmto']=='2 Linha') { ?>
													<option value="1 Linha">1 Linha</option>											
													<option value="1 Linha" selected>2 Linha</option>
													<option value="3 Linha">3 Linha</option>
													<option value="Outras">Outras</option>													
												<?php } ?>
												<?php if($_SESSION['ds_tipo_linha_trtmto']=='3 Linha') { ?>
													<option value="1 Linha">1 Linha</option>											
													<option value="1 Linha">2 Linha</option>
													<option value="3 Linha" selected>3 Linha</option>
													<option value="Outras">Outras</option>													
												<?php } ?>								
												<?php if($_SESSION['ds_tipo_linha_trtmto']=='Outras') { ?>
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
												<?php if($_SESSION['ds_fnlde']=='Paliativo') { ?>
													<option value="Paliativo" selected>Paliativo</option>											
													<option value="Adjuvante">Adjuvante</option>
													<option value="Neo-Adjuvante">Neo-Adjuvante</option>
													<option value="Curativo">Curativo</option>															
												<?php } ?>
												<?php if($_SESSION['ds_fnlde']=='Adjuvante') { ?>
													<option value="Paliativo" >Paliativo</option>											
													<option value="Adjuvante" selected>Adjuvante</option>
													<option value="Neo-Adjuvante">Neo-Adjuvante</option>
													<option value="Curativo">Curativo</option>															
												<?php } ?>							
												<?php if($_SESSION['ds_fnlde']=='Neo-Adjuvante') { ?>
													<option value="Paliativo" >Paliativo</option>											
													<option value="Adjuvante" >Adjuvante</option>
													<option value="Neo-Adjuvante" selected>Neo-Adjuvante</option>
													<option value="Curativo">Curativo</option>															
												<?php } ?>
												<?php if($_SESSION['ds_fnlde']=='Curativo') { ?>
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
												<?php if($_SESSION['ic_tipo_tumor']=='T1') { ?>
													<option value="T1" selected>T1</option>											
													<option value="T2">T2</option>
													<option value="T3">T3</option>
													<option value="T0">T0</option>												
													<option value="TIS">TIS</option>												
													<option value="TX">TX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>	
												<?php if($_SESSION['ic_tipo_tumor']=='T2') { ?>
													<option value="T1" >T1</option>											
													<option value="T2" selected>T2</option>
													<option value="T3">T3</option>
													<option value="T0">T0</option>												
													<option value="TIS">TIS</option>												
													<option value="TX">TX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>	
												<?php if($_SESSION['ic_tipo_tumor']=='T3') { ?>
													<option value="T1" >T1</option>											
													<option value="T2" >T2</option>
													<option value="T3" selected>T3</option>
													<option value="T0">T0</option>												
													<option value="TIS">TIS</option>												
													<option value="TX">TX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>
												<?php if($_SESSION['ic_tipo_tumor']=='T0') { ?>
													<option value="T1" >T1</option>											
													<option value="T2" >T2</option>
													<option value="T3" >T3</option>
													<option value="T0" selected>T0</option>												
													<option value="TIS">TIS</option>												
													<option value="TX">TX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>
												<?php if($_SESSION['ic_tipo_tumor']=='TIS') { ?>
													<option value="T1" >T1</option>											
													<option value="T2" >T2</option>
													<option value="T3" >T3</option>
													<option value="T0" >T0</option>												
													<option value="TIS" selected>TIS</option>												
													<option value="TX">TX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>
												<?php if($_SESSION['ic_tipo_tumor']=='TX') { ?>
													<option value="T1" >T1</option>											
													<option value="T2" >T2</option>
													<option value="T3" >T3</option>
													<option value="T0" >T0</option>												
													<option value="TIS" >TIS</option>												
													<option value="TX" selected>TX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>
												<?php if($_SESSION['ic_tipo_tumor']=='Nao Se Aplica') { ?>
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
												<?php if($_SESSION['ic_tipo_nodulo']=='N1') { ?>
													<option value="N1" selected>N1</option>											
													<option value="N2">N2</option>
													<option value="N3">N3</option>
													<option value="N0">N0</option>														
													<option value="NX">NX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>
												<?php if($_SESSION['ic_tipo_nodulo']=='N2') { ?>
													<option value="N1" >N1</option>											
													<option value="N2" selected>N2</option>
													<option value="N3">N3</option>
													<option value="N0">N0</option>														
													<option value="NX">NX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>												
												<?php if($_SESSION['ic_tipo_nodulo']=='N3') { ?>
													<option value="N1" >N1</option>											
													<option value="N2" >N2</option>
													<option value="N3" selected>N3</option>
													<option value="N0">N0</option>														
													<option value="NX">NX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>	
												<?php if($_SESSION['ic_tipo_nodulo']=='N0') { ?>
													<option value="N1" >N1</option>											
													<option value="N2" >N2</option>
													<option value="N3" >N3</option>
													<option value="N0" selected>N0</option>														
													<option value="NX">NX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>
												<?php if($_SESSION['ic_tipo_nodulo']=='NX') { ?>
													<option value="N1" >N1</option>											
													<option value="N2" >N2</option>
													<option value="N3" >N3</option>
													<option value="N0" >N0</option>														
													<option value="NX" selected>NX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>
												<?php if($_SESSION['ic_tipo_nodulo']=='Nao Se Aplica') { ?>
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
												<?php if($_SESSION['ic_tipo_metastase']=='M1') { ?>
													<option value="M1" selected>M1</option>											
													<option value="M0">M0</option>														
													<option value="MX">MX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>
												<?php if($_SESSION['ic_tipo_metastase']=='M0') { ?>
													<option value="M1" >M1</option>											
													<option value="M0" selected>M0</option>														
													<option value="MX">MX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>									
												<?php if($_SESSION['ic_tipo_metastase']=='MX') { ?>
													<option value="M1" >M1</option>											
													<option value="M0" >M0</option>														
													<option value="MX" selected>MX</option>												
													<option value="Nao Se Aplica">Nao Se Aplica</option>
												<?php } ?>
												<?php if($_SESSION['ic_tipo_metastase']=='Nao Se Aplica') { ?>
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
											<td style="width:200px"><textarea rows="6" cols="50" id="ds_plano_trptco" class="form-control" name="ds_plano_trptco" ><?php echo $_SESSION['ds_plano_trptco']; ?></textarea></td> 
									 
									 </tr>
									 
									 <tr>
									 
											<td style="width:150px"><label>Informações Relevantes:</label></td>  
											<td style="width:200px"><textarea rows="6" cols="50" id="ds_info_rlvnte" class="form-control" name="ds_info_rlvnte" ><?php echo $_SESSION['ds_info_rlvnte']; ?></textarea></td> 
									 
									 </tr>
									 
									 <tr>
									 
											<td style="width:150px"><label>Diagnóstico Cito/Histopatológico:</label></td>  
											<td style="width:200px"><textarea rows="6" cols="50" id="ds_diagn_cito_hstpagico" class="form-control" name="ds_diagn_cito_hstpagico" ><?php echo $_SESSION['ds_diagn_cito_hstpagico']; ?></textarea></td> 
									 
									 </tr>
									 
									 <tr>
									 
											<td style="width:150px"><label>Cirurgia:</label></td>  
											<td style="width:200px"><textarea rows="5" cols="50" id="ds_tp_cirurgia" class="form-control" name="ds_tp_cirurgia" ><?php echo $_SESSION['ds_tp_cirurgia']; ?></textarea></td> 
									 
									 </tr>
									 
									 <tr>
									 
											<td style="width:150px"><label>Área Irradiada:</label></td>  
											<td style="width:200px"><textarea rows="5" cols="50" id="ds_area_irrda" class="form-control" name="ds_area_irrda"><?php echo $_SESSION['ds_area_irrda']; ?></textarea></td> 
									 
									 </tr>
									 
									 <tr>
											<td ><label>Data de Realização:</label></td>
											<td ><input type="date" class="form-control" id="dt_rlzd" name="dt_rlzd" value="<?php echo $_SESSION['dt_rlzd']; ?>"></td>
									 </tr>
									 
									 <tr>
											<td ><label>Data da Aplicação:</label></td>
											<td ><input type="date" class="form-control" id="dt_aplc" name="dt_aplc" value="<?php echo $_SESSION['dt_aplc']; ?>"></td>
									 </tr>
									 
									  <tr>
									 
											<td style="width:150px"><label>Observação/Justificativa:</label></td>  
											<td style="width:200px"><textarea rows="6" cols="50" id="ds_obs_jfta" class="form-control" name="ds_obs_jfta"><?php echo $_SESSION['ds_obs_jfta']; ?></textarea></td> 
									 
									 </tr>
									 
									 <tr>
											<td style="width:50px"><label>Quantidade de Ciclos Previstos:</label></td> 
											<td style="width:10px"><input type="text" class="form-control" name="nu_qtde_ciclo_prta" value="<?php echo $_SESSION['nu_qtde_ciclo_prta']; ?>" id="nu_qtde_ciclo_prta"></td>
									 </tr>
									 
									 <tr>
											<td style="width:50px"><label>Ciclo Atual:</label></td> 
											<td style="width:50px"><input type="text" class="form-control" name="ds_ciclo_atual" value="<?php echo $_SESSION['ds_ciclo_atual']; ?>" id="ds_ciclo_atual"></td>
									 </tr>
									 
									  <tr>
											<td style="width:50px"><label>Número de Dias do Ciclo Atual:</label></td> 
											<td style="width:50px"><input type="text" class="form-control" name="ds_dia_ciclo_atual" value="<?php echo $_SESSION['ds_dia_ciclo_atual']; ?>" id="ds_dia_ciclo_atual"></td>
									 </tr>
									 
									 <tr>
											<td style="width:50px"><label>Intervalo entre Ciclos (em dias):</label></td> 
											<td style="width:50px"><input type="text" class="form-control" value="<?php echo $_SESSION['ds_intrv_entre_ciclo_dia']; ?>" name="ds_intrv_entre_ciclo_dia" id="ds_intrv_entre_ciclo_dia"></td>
									 </tr>
									 
									 <input type="text" id="cd_pcnt" name="cd_pcnt" value="<?php echo $_SESSION['cd_pcnt']; ?>" style="display:none"> 
									 <input type="text" id="cd_cnvo" name="cd_cnvo" value="<?php echo $_SESSION['cd_cnvo']; ?>" style="display:none"> 
									 <input type="text" id="cd_cid" name="cd_cid" value="<?php echo $_SESSION['cd_cid']; ?>" style="display:none"> 
									 
									 <input type="text" id="id_hstr_pnel_solic_trtmto" name="id_hstr_pnel_solic_trtmto" style="display:none"> 
									 
									 <input type="text" id="ds_estmt" name="ds_estmt" value="<?php echo $_SESSION['ds_estmt']; ?>" style="display:none"> 
									 <input type="text" id="ds_tipo_linha_trtmto" name="ds_tipo_linha_trtmto" value="<?php echo $_SESSION['ds_tipo_linha_trtmto']; ?>" style="display:none"> 
									 <input type="text" id="ds_fnlde" name="ds_fnlde" value="<?php echo $_SESSION['ds_fnlde']; ?>" style="display:none"> 
									 <input type="text" id="ic_tipo_tumor" name="ic_tipo_tumor" value="<?php echo $_SESSION['ic_tipo_tumor']; ?>" style="display:none"> 
									 <input type="text" id="ic_tipo_nodulo" name="ic_tipo_nodulo" value="<?php echo $_SESSION['ic_tipo_nodulo']; ?>" style="display:none"> 
									 <input type="text" id="ic_tipo_metastase" name="ic_tipo_metastase" value="<?php echo $_SESSION['ic_tipo_metastase']; ?>" style="display:none"> 
									  
								</table>																
							</div>								
							<div class="modal-footer">	
								<input type="submit" class="btn btn-danger" name="insere" value="Inserir">&nbsp;&nbsp;&nbsp;&nbsp;
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
