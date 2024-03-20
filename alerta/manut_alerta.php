<?php
		
	session_start();		
	
    include '../database.php';
	
	error_reporting(0); 	
	global $pdo;	
	
	$pdo = database::connect();	
	$sql = '';
		
	$sql = "select id_log_alrt as id_alerta
			 , cd_alrt as assunto
			 , ds_alrt as corpo_mensagem
			 , cd_usua_incs_alrt as usuario_que_gerou_alerta
			 , to_char(dt_incs_alrt, 'dd/mm/yyyy hh24:mi') as data_geracao_alerta
			 , nm_pcnt
		from tratamento.tb_log_alrt ";
	if ($_GET["tipoconsultaalerta"] == 'consultaregsnaolidos'){
		$sql.="
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
									 )";
	} else {
		$sql.="
			where id_log_alrt in (
										select id_log_alrt
										  from tratamento.tb_usua_alrt_manut manut
											 , tratamento.tb_c_usua_acesso acesso
										where manut.cd_usua_acesso = acesso.cd_usua_acesso
										  and acesso.nm_usua_acesso = '".$_SESSION['usuario']."'										  
									 )";
	}
	$sql.="	order by dt_incs_alrt desc";
			
			
	if ($pdo==null){
		header(Config::$webLogin);
	}			
		
    $ret = pg_query($pdo, $sql);
    if(!$ret) {
        echo pg_last_error($pdo);
        exit;
    }
	
		
?>	

	<!DOCTYPE html>
	<html lang="pt-br">
	<head>
	 <meta charset="utf-8">
	 <meta http-equiv="X-UA-Compatible" content="IE=edge">
	 <meta name="viewport" content="width=device-width, initial-scale=1">
	 <title>Alertas</title>

	 <link href="../css/bootstrap.min.css" rel="stylesheet">
	 <link href="../css/style.css" rel="stylesheet">
	</head>
	<body>

	 <div id="main" class="container-fluid" style="margin-top: 50px"> 
		
		<div id="list" class="row">
		
		<div class="table-responsive col-md-12">
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
					
						$sql = "INSERT INTO tratamento.tb_usua_alrt_manut(id_usua_alrt_manut, cd_usua_acesso, id_log_alrt, fl_alrt_leitura, fl_alrt_excluido, cd_usua_altr, dt_altr) VALUES ((select NEXTVAL('tratamento.sq_usua_alrt_manut')), (select cd_usua_acesso from tratamento.tb_c_usua_acesso where nm_usua_acesso = '".$_SESSION['usuario']."'), ".$row[0].", 1, 0, '".$_SESSION['usuario']."', current_timestamp) ";

						$result = pg_query($pdo, $sql);

						if($result){
							echo "";
						}  
						
						$cont=$cont+1;
					} ?>	
				</tbody>
			</table>
		</div>
		
		</div> <!-- /#list -->
		
	 </div> <!-- /#main -->

	 <script src="../js/jquery.min.js"></script>
	 <script src="../js/bootstrap.min.js"></script>
	</body>
	</html>		
<?php ?>