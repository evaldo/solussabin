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
							break;
						}											
					}
					if ($achoupacientenalista == 1) {
						$id_reg = $data[0];
						$nm_pcnt=strtoupper($data[1]);
						$cd_cnvo=strtoupper($data[2]);
						$nu_peso_pcnt=$data[3];
						$vl_altura_pcnt=$data[4];
						$vl_sup_corp=$data[5];
						$ds_indic_clnic=$data[6];
						$dt_diagn=$data[7];
						$cd_cid=$data[8];
						$ds_estmt=$data[9];
						$ds_tipo_linha_trtmto=$data[10];
						$ds_fnlde=$data[11];
						$ic_tipo_tumor=$data[12];
						$ic_tipo_nodulo=$data[13];
						$ic_tipo_metastase=$data[14];
						$ds_plano_trptco=$data[15];
						$ds_info_rlvnte=$data[16];
						$ds_diagn_cito_hstpagico=$data[17];
						$ds_tp_cirurgia=$data[18];
						$ds_area_irrda=$data[19];
						$dt_rlzd=$data[20];
						$dt_aplc=$data[21];
						$ds_obs_jfta=$data[22];
						$nu_qtde_ciclo_prta=$data[23];
						$ds_ciclo_atual=$data[24];
						$ds_dia_ciclo_atual=$data[25];
						$ds_intrv_entre_ciclo_dia=$data[26];
						$nm_mdco_encaminhador=$data[27];

						$sql = "INSERT INTO tratamento.tb_pddo_trtmto(id_pddo_trtmto, id_hstr_pnel_solic_trtmto, cd_pcnt, nm_pcnt, dt_nasc_pcnt, vl_idade_pcnt, nu_peso_pcnt, vl_altura_pcnt, vl_sup_corp, ds_indic_clnic, dt_diagn, cd_cid, ds_plano_trptco, ds_info_rlvnte, ds_diagn_cito_hstpagico, ds_tp_cirurgia, ds_area_irrda, dt_rlzd, dt_aplc, ds_obs_jfta, nu_qtde_ciclo_prta, ds_ciclo_atual, ds_dia_ciclo_atual, ds_intrv_entre_ciclo_dia, ds_estmt, ds_tipo_linha_trtmto, ds_fnlde, ic_tipo_tumor, ic_tipo_nodulo, ic_tipo_metastase, cd_usua_incs, dt_incs, cd_cnvo, nm_mdco_encaminhador)
	VALUES ((select NEXTVAL('tratamento.sq_pddo_trtmto')), null, (select cd_pcnt from tratamento.tb_c_pcnt where trim(nm_pcnt) = trim('".$nm_pcnt."')), '". trim($nm_pcnt)."', (select dt_nasc_pcnt from tratamento.tb_c_pcnt where trim(nm_pcnt) = trim('". $nm_pcnt."')), (select date_part('year', age(now(), (select dt_nasc_pcnt from tratamento.tb_c_pcnt where nm_pcnt = '". $nm_pcnt."')))), ". str_replace(",", ".", $nu_peso_pcnt).", ". str_replace(",", ".", $vl_altura_pcnt).", ". str_replace(",", ".", $vl_sup_corp).", UPPER('".str_replace("'", " ",$ds_indic_clnic)."'), '".$dt_diagn."', '". $cd_cid."', UPPER('". str_replace("'", " ",$ds_plano_trptco)."'), UPPER('". str_replace("'", " ",$ds_info_rlvnte)."'), UPPER('". str_replace("'", " ",$ds_diagn_cito_hstpagico)."'), UPPER('". str_replace("'", " ",$ds_tp_cirurgia)."'), UPPER('". str_replace("'", " ",$ds_area_irrda)."'), '".$dt_rlzd."', '".$dt_aplc."', UPPER('". str_replace("'", " ",$ds_obs_jfta)."'), '". $nu_qtde_ciclo_prta."', '". $ds_ciclo_atual."', '". $ds_dia_ciclo_atual."', '". $ds_intrv_entre_ciclo_dia."', '". $ds_estmt."' ,'". $ds_tipo_linha_trtmto."', '".$ds_fnlde."', '". $ic_tipo_tumor."', '". $ic_tipo_nodulo."', '". $ic_tipo_metastase."', '".$_SESSION['usuario']."', current_timestamp, '". $cd_cnvo."', '". $nm_mdco_encaminhador."');";
					    
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
									</tr>
								</thead>
						<?php
							$data = fgetcsv($CSVvar, 1000, ";");
							
							$sql = "SELECT cd_pcnt, substring(nm_pcnt, 1, 30) as nm_pcnt from tratamento.tb_c_pcnt order by 2";

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
									$sql = "select count(1) from tratamento.tb_log_importa_csv where nm_arquivo_csv='".$_SESSION['fileUploaded']."' and id_reg_arquivo_csv=".$data[0]." ";									
								
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
