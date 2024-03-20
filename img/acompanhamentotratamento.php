<?php
	
	session_start();		
	
    include '../database.php';
    $pdo = database::connect();
	
	error_reporting(0); 	
		
	$textoconsulta = "";
	$retSqlServer = "";
	$sql = '';
	
		
	$sql ="select * from tratamento.vw_painel_trtmto order by nm_pcnt";
			
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
			
			$sqlpaciente = "SELECT count(1)			 
							FROM tratamento.tb_c_pcnt pcnt 
							WHERE pcnt.cd_pcnt = '". $_POST['cd_pcnt'] ."'" ;
										  
			$retpaciente = pg_query($pdo, $sqlpaciente);
								
			if(!$retpaciente) {
				echo pg_last_error($pdo);		
				exit;
			}
			
			$rowpaciente = pg_fetch_row($retpaciente);
			
			if(!$retpaciente) {
				echo pg_last_error($pdo);		
				exit;
			}
			
			if($rowpaciente[0]==0){
				$sqlinsertpcnt = "INSERT INTO tratamento.tb_c_pcnt(cd_pcnt, nm_pcnt, dt_nasc_pcnt, ds_mncp_pcnt)
		VALUES ('". $_POST['cd_pcnt'] ."', '". $_POST['nm_pcnt'] ."', '". $_POST['dt_nasc_pcnt'] ."', '". $_POST['ds_mncp'] ."')";
				$result = pg_query($pdo, $sqlinsertpcnt);

				if($result){
					echo "";
				}  
				
			} else {
				$sqlupdatepcnt = "UPDATE tratamento.tb_c_pcnt SET nm_pcnt='". $_POST['nm_pcnt'] ."', dt_nasc_pcnt = '". $_POST['dt_nasc_pcnt'] ."', ds_mncp_pcnt= '". $_POST['ds_mncp'] ."' WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."'";
				
				$result = pg_query($pdo, $sqlupdatepcnt);

				if($result){
					echo "";
				}  
			
			}				
			
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
		id_hstr_pnel_solic_trtmto, cd_pcnt, nm_pcnt, dt_nasc_pcnt, ds_mncp_pcnt, id_equipe, ds_equipe, nu_seq_equipe_pnel, id_status_trtmto, ds_status_trtmto, fl_trtmto_fchd, dt_inicial_trtmto, dt_final_trtmto, ds_utlma_obs_pcnt, tp_dia_trtmto, tp_hora_trtmto, tp_minuto_trtmto, cd_usua_incs, dt_incs, cd_usua_altr, dt_altr)
		VALUES ((select NEXTVAL('tratamento.sq_hstr_pnel_solic_trtmto')), '". $_POST['cd_pcnt'] ."', '". $_POST['nm_pcnt'] ."', '". $_POST['dt_nasc_pcnt'] ."', '". $_POST['ds_mncp'] ."',".$rowretequipetratamento[0].", '".$rowretequipetratamento[1]."', ".$rowretequipetratamento[2].", ".$rowretequipetratamento[3].", '".$rowretequipetratamento[4]."', 0, current_timestamp, null, null, 0, 0, 0, '".$_SESSION['usuario']."', current_timestamp, null, null);";
		
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
	
	if(isset($_POST['altera'])){					
		
		if ($pdo==null){
			header(Config::$webLogin);
		}
		
		try
		{	
		
			$sql = "UPDATE integracao.tb_ctrl_leito SET WHERE trim(ds_leito) = '". $_POST['nm_loc_nome'] ."'";
						
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
		
?>	

	<!DOCTYPE html>
	<html lang="pt-br">
		<head>
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
		
				
			</style>
			 <meta charset="utf-8">
			 <meta http-equiv="X-UA-Compatible" content="IE=edge">
			 <meta name="viewport" content="width=device-width, initial-scale=1">
			 <title>Processo de Solicitação e Agendamento de Quimioterapia</title>			 
			 <link href="../css/bootstrap.min.css" rel="stylesheet">
			 <link href="../css/style.css" rel="stylesheet">	 			 		 			 
	  
		</head>
		<body id="aplicacao" onload="removeDivsEtapasCarga();">			
			<div class="container" style="margin-left: 0px; margin-right: 0px; position:fixed; margin-top: 0px; background-color:white; max-width: 5000px; height: 80px; border: 1px solid #E6E6E6;">
				
				<br>
				<input type="button" value="Novo Paciente" class="btn btn-primary btn-xs insere"/>
			
				<input class="btn btn-primary" type="submit" value="Exportar para Excel" id="exportarplanejamento">&nbsp;
				
				<input class="btn btn-primary" type="submit" value="PDF" id="exportarplanejamento">&nbsp;
				
			</div>
			
			<div id="list" class="row">
				
				<div class="table-responsive" style="margin-top: 80px;">				
					<table id="tabela" class="table table-striped table-bordered">
						<thead class="thead-dark">
							<tr style="font-size: 15px;">
								<?php
									$sqlequipe ="select ds_equipe from tratamento.tb_c_equipe order by nu_seq_equipe_pnel asc";
					
									$retequipe = pg_query($pdo, $sqlequipe);
									
									if(!$retequipe) {
										echo pg_last_error($pdo);		
										exit;
									}
								?>
									<th style="text-align:center">Id Pac</th>
									<th style="text-align:center">Paciente</th>
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
									<td data-toggle="tooltip" data-placement="top" title="<?php echo $row[0];?>" style="text-align:center; " id="<?php echo $row[0];?>" value="<?php echo $row[0];?>" ><?php echo $row[0];?></td>
									
									<td data-toggle="tooltip" data-placement="top" title="<?php echo $row[1];?>" style=" " id="<?php echo $row[1];?>" value="<?php echo $row[1];?>" ><?php echo $row[1];?></td>
									
									<td data-toggle="tooltip" data-placement="top" title="<?php echo $row[2];?>" style="text-align:center;" id="<?php echo $row[2];?>" value="<?php echo $row[2];?>" ><?php echo $row[2];?></td>
									
									<td data-toggle="tooltip" data-placement="top" title="<?php echo $row[3];?>" style=" text-align:center;" id="<?php echo $row[3];?>" value="<?php echo $row[3];?>" ><?php echo $row[3];?></td>
									
									<td data-toggle="tooltip" data-placement="top" title="<?php echo $row[4];?>" style="text-align:center; " id="<?php echo $row[4];?>" value="<?php echo $row[4];?>" ><?php echo $row[4];?></td>
									
									<td data-toggle="tooltip" data-placement="top" title="<?php echo $row[5];?>" style="text-align:center; " id="<?php echo $row[5];?>" value="<?php echo $row[5];?>" ><?php echo $row[5];?></td>				
									
									<td data-toggle="tooltip" data-placement="top" title="<?php echo $row[6];?>" style=" text-align:center;" id="<?php echo $row[6];?>" value="<?php echo $row[6];?>" ><?php echo $row[6];?></td>
									
									<td data-toggle="tooltip" data-placement="top" title="<?php echo $row[7];?>" style=" text-align:center;" id="<?php echo $row[7];?>" value="<?php echo $row[7];?>" ><?php echo $row[7];?></td>

									
									<td class="actions">
										<input type="image" title="Insere Status" src="../img/insertstatus.png"  height="23" width="23" name="inserestatus" data-toggle="modal" data-target="#inserestatus" class="btn-xs inserestatus"/>
									</td>
									<td class="actions">
										<input type="image" src="../img/delete.png"  height="23" width="23" class="btn-xs deletestatus"/>
									</td>
									<td class="actions">
										<input type="image" src="../img/imprimileito.png"  height="23" width="23"  class="btn-xs imprimileito"/>
									</td>
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

<script>
	
	
	$(document).ready(function(){
		$("#tabela").on('click', '.loader', function(){
			
			var currentRow=$(this).closest("tr"); 							
			var nm_loc_nome_inteiro = currentRow.find("td:eq(0)").text();
			var nm_loc_nome_trim = nm_loc_nome_inteiro.trim();			
			var nm_loc_nome_replace = nm_loc_nome_trim.replace('LEITO ', '');			
			var nm_loc_nome = nm_loc_nome_replace.trim();			
												
			$.ajax({
				url:"../gestaoleitos/selecao_detalhe_paciente.php",
				method:"POST",
				data:{nm_loc_nome:nm_loc_nome},
				success:function(data){
					$('#detalhe_paciente').html(data);
					$('#dataModal').modal('show');
				}
			});
        });
	});
	
	$(document).on('click', '.insere', function(){
			event.preventDefault();			
			$.ajax({
				type: "POST",
				url:"../tratamento/insercao_paciente.php",															
				success : function(completeHtmlPage) {				
					$("html").empty();
					$("html").append(completeHtmlPage);
				}
			});			
		});	
	
	$(document).ready(function(){
		$("#tabela").on('click', '.visualiza', function(){
			
			var currentRow=$(this).closest("tr"); 							
			var nm_loc_nome_inteiro = currentRow.find("td:eq(0)").text();
			var nm_loc_nome_trim = nm_loc_nome_inteiro.trim();			
			var nm_loc_nome_replace = nm_loc_nome_trim.replace('LEITO ', '');			
			var nm_loc_nome = nm_loc_nome_replace.trim();			
			
			$.ajax({
				url:"../gestaoleitos/selecao_detalhe_paciente.php",
				method:"POST",
				data:{nm_loc_nome:nm_loc_nome},
				success:function(data){
					$('#detalhe_paciente').html(data);
					$('#dataModal').modal('show');
				}
			});
        });
	});
	
</script>
<?php ?>