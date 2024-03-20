<?php
		
	session_start();		
	
    include '../database.php';
	
	error_reporting(0); 
	
    global $pdo;	
	
	$pdo = database::connect();
	$optconsulta = "";
	$textoconsulta = "";
	
	$sql = '';
	
	$textoconsulta = "";
	
	if(isset($_POST['botaoconsultar'])&& $_POST['textoconsulta']<>""){
		
		$textoconsulta = strtoupper($_POST['textoconsulta']);
		
		$sql = "SELECT count(id_status_trtmto)
				from tratamento.tb_c_status_trtmto 
				where upper(ds_status_trtmto) like '%" . $textoconsulta . "%'";
			
		if ($pdo==null){
				header(Config::$webLogin);
		}	
		$ret = pg_query($pdo, $sql);
		if(!$ret) {
			echo pg_last_error($pdo);
			exit;
		}	
		$row = pg_fetch_row($ret);
		$num_total = $row[0];	
		$num_paginas = ceil($num_total/$itens_por_pagina);
		
		$sql ="SELECT status.id_status_trtmto, equipe.ds_equipe, status.ds_status_trtmto, case when status.fl_ativo = 1 then 'Sim' else 'Não' End Status_Ativo, case when status.fl_status_intrpe_trtmto_equipe = 1 then 'Sim' else 'Não' End Status_intrpe_trtmeto_equipe, case when status.fl_status_finaliza_trtmto_equipe = 1 then 'Sim' else 'Não' End status_finaliza_trtmto_equipe, status.cd_cor_status_trtmto, case when status.fl_status_inicial_trtmto = 1 then 'Sim' else 'Não' End fl_status_inicial_trtmto from tratamento.tb_c_status_trtmto status, tratamento.tb_c_equipe equipe 
				where status.id_equipe = equipe.id_equipe and upper(status.ds_status_trtmto) like '%" . $textoconsulta . "%' order by equipe.nu_seq_equipe_pnel ";
		
	} else{
		
			$sql = "SELECT count(id_equipe)
				from tratamento.tb_c_equipe";
			
			if ($pdo==null){
					header(Config::$webLogin);
			}	
			$ret = pg_query($pdo, $sql);
			if(!$ret) {
				echo pg_last_error($pdo);
				exit;
			}	
			$row = pg_fetch_row($ret);
			$num_total = $row[0];	
			$num_paginas = ceil($num_total/$itens_por_pagina);
		
			$sql ="SELECT status.id_status_trtmto, equipe.ds_equipe, status.ds_status_trtmto, case when status.fl_ativo = 1 then 'Sim' else 'Não' End Status_Ativo, case when status.fl_status_intrpe_trtmto_equipe = 1 then 'Sim' else 'Não' End Status_intrpe_trtmto_equipe, case when status.fl_status_finaliza_trtmto_equipe = 1 then 'Sim' else 'Não' End status_finaliza_trtmto_equipe, status.cd_cor_status_trtmto, case when status.fl_status_inicial_trtmto = 1 then 'Sim' else 'Não' End fl_status_inicial_trtmto	from tratamento.tb_c_status_trtmto status, tratamento.tb_c_equipe equipe 
				where status.id_equipe = equipe.id_equipe order by equipe.nu_seq_equipe_pnel ";	
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
		
			$sql = "INSERT INTO tratamento.tb_c_status_trtmto(id_status_trtmto, id_equipe, ds_status_trtmto, fl_ativo, fl_status_intrpe_trtmto_equipe, fl_status_finaliza_trtmto_equipe, cd_cor_status_trtmto, cd_usua_incs, dt_incs, fl_status_inicial_trtmto) values ((select NEXTVAL('tratamento.sq_status_trtmto')), ". $_POST['id_equipe'].", upper('". $_POST['ds_status_trtmto']."'), ". $_POST['fl_ativo'].", ". $_POST['fl_status_intrpe_trtmto_equipe'].",  ". $_POST['fl_status_finaliza_trtmto_equipe'].", '".$_POST['cd_cor_status_trtmto']."','".$_SESSION['usuario']."', current_timestamp,  ". $_POST['fl_status_inicial_trtmto'].");";

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
			
			$sql = "UPDATE tratamento.tb_c_status_trtmto
	SET id_equipe=". $_POST['id_equipe'].", ds_status_trtmto=upper('". $_POST['ds_status_trtmto']."'), fl_ativo=". $_POST['fl_ativo'].", fl_status_intrpe_trtmto_equipe=". $_POST['fl_status_intrpe_trtmto_equipe'].", fl_status_finaliza_trtmto_equipe=". $_POST['fl_status_finaliza_trtmto_equipe'].", cd_cor_status_trtmto='".$_POST['cd_cor_status_trtmto']."', cd_usua_altr='".$_SESSION['usuario']."', fl_status_inicial_trtmto = ". $_POST['fl_status_inicial_trtmto'].", dt_altr=current_timestamp
	WHERE id_status_trtmto = ". $_SESSION['id_status_trtmto']."";
			
			//echo $sql;
			
			$result = pg_query($pdo, $sql);

			if($result){
				echo "";
			}  
			
			$secondsWait = 0;
			header("Refresh:$secondsWait");

			
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
	
			// remove do banco			
			$sql = "DELETE FROM tratamento.tb_c_status_trtmto WHERE id_status_trtmto = ".$_SESSION['id_status_trtmto']."";		
			
			$result = pg_query($pdo, $sql);

			if($result){
				echo "";
			}  
			
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
	 <meta charset="utf-8">
	 <meta http-equiv="X-UA-Compatible" content="IE=edge">
	 <meta name="viewport" content="width=device-width, initial-scale=1">
	 <title>Cadastro dos Status do Tratamento</title>

	 <link href="../css/bootstrap.min.css" rel="stylesheet">
	 <link href="../css/style.css" rel="stylesheet">
	</head>
	<body>

	 <div id="main" class="container-fluid" style="margin-top: 50px"> 
		<div class="container" style="margin-left: 0px">
			<form class="form-inline" action="#" method="post" >				
				<b>Consultar os Status do Tratamento:</b>:&nbsp;&nbsp													
				<input class="form-control" name="textoconsulta" type="text" placeholder="Pesquisar">&nbsp;&nbsp;&nbsp;&nbsp;
				<input class="btn btn-primary" type="submit" value="Consultar" name="botaoconsultar">&nbsp;&nbsp;											
				<input type="button" value="Novo Registro" class="btn btn-primary btn-xs insere"/>				
			</form>
		</div> <!-- /#top -->
	 	
		<br>

		<div id="list" class="row">
		
		<div class="table-responsive col-md-12">
			<table class="table table-striped" cellspacing="0" cellpadding="0" id="tabela">
				<thead>
					<tr style="font-size: 11px">
						<th>Id Status Tratamento</th>						
						<th>Descrição da Equipe</th>
						<th>Descrição do Status</th>						
						<th>Flag Ativo?</th>
						<th>Flag Interrompe o Tratamento?</th>
						<th>Flag Finaliza o Tratamento?</th>
						<th>Cor no Painel</th>
						<th>Flag para o Status Inicial do Tratamento?</th>
						<th class="actions">Ações</th>
					</tr>
				</thead>				
				<tbody>
				<?php

					$cont=1;										
					while($row = pg_fetch_row($ret)) {
					?>						
						<tr style="font-size: 11px">
						
							<td id="id_status_trtmto" value="<?php echo $row[0];?>"><?php echo $row[0];?></td>
							<td id="ds_equipe" value="<?php echo $row[1];?>"><?php echo $row[1];?></td>
							<td id="ds_status_trtmto" value="<?php echo $row[2];?>"><?php echo $row[2];?></td>
							<td id="fl_ativo" value="<?php echo $row[3];?>"><?php echo $row[3];?></td>
							<td id="fl_status_intrpe_trtmto_equipe" value="<?php echo $row[4];?>"><?php echo $row[4];?></td>
							<td id="fl_status_finaliza_trtmto_equipe" value="<?php echo $row[5];?>"><?php echo $row[5];?></td>
							<td id="cd_cor_status_trtmto" value="<?php echo $row[6];?>"><?php echo $row[6];?></td>
							<td id="fl_status_inicial_trtmto" value="<?php echo $row[6];?>"><?php echo $row[7];?></td>
														
							<td class="actions">								
								<input style="font-size: 11px" type="button" value="Visualizar" class="btn btn-success btn-xs visualiza"/>
								<input style="font-size: 11px" type="button" value="Alterar" class="btn btn-warning btn-xs altera"/>								
								<input style="font-size: 11px" type="button" value="Excluir" class="btn btn-danger btn-xs delecao"/>								
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
		<div class="modal-dialog">
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
	<script>
	$(document).ready(function(){
    
		$("#tabela").on('click','.delecao',function(){			
		
			var currentRow=$(this).closest("tr"); 
						
			var id_status_trtmto = currentRow.find("td:eq(0)").text();
			var ds_equipe = currentRow.find("td:eq(1)").text();	
			var ds_status_trtmto = currentRow.find("td:eq(2)").text();	
			var fl_ativo = currentRow.find("td:eq(3)").text();
			var fl_status_intrpe_trtmto_equipe = currentRow.find("td:eq(4)").text();	
			var fl_status_finaliza_trtmto_equipe = currentRow.find("td:eq(5)").text();
			var cd_cor_status_trtmto = currentRow.find("td:eq(6)").text();
			var fl_status_inicial_trtmto = currentRow.find("td:eq(7)").text();
			
			// AJAX code to submit form.
			$.ajax({
				 type: "POST",
				 url: "../delecao/delecao_status_tratamento.php", //
				 data: {id_status_trtmto:id_status_trtmto, ds_equipe:ds_equipe, ds_status_trtmto:ds_status_trtmto,fl_ativo:fl_ativo, fl_status_intrpe_trtmto_equipe:fl_status_intrpe_trtmto_equipe, fl_status_finaliza_trtmto_equipe:fl_status_finaliza_trtmto_equipe, cd_cor_status_trtmto:cd_cor_status_trtmto, fl_status_inicial_trtmto:fl_status_inicial_trtmto},
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
				url:"../insercao/insercao_status_tratamento.php",															
				success : function(completeHtmlPage) {				
					$("html").empty();
					$("html").append(completeHtmlPage);
				}
			});			
		});	

		$("#tabela").on('click','.altera',function(){			
		
			var currentRow=$(this).closest("tr"); 
			
			var id_status_trtmto = currentRow.find("td:eq(0)").text();
			var ds_equipe = currentRow.find("td:eq(1)").text();	
			var ds_status_trtmto = currentRow.find("td:eq(2)").text();	
			var fl_ativo = currentRow.find("td:eq(3)").text();
			var fl_status_intrpe_trtmto_equipe = currentRow.find("td:eq(4)").text();	
			var fl_status_finaliza_trtmto_equipe = currentRow.find("td:eq(5)").text();
			var cd_cor_status_trtmto = currentRow.find("td:eq(6)").text();
			var fl_status_inicial_trtmto = currentRow.find("td:eq(7)").text();
			
			// AJAX code to submit form.
			$.ajax({
				 type: "POST",
				 url: "../alteracao/alteracao_status_tratamento.php", //
				 data: {id_status_trtmto:id_status_trtmto, ds_equipe:ds_equipe, ds_status_trtmto:ds_status_trtmto,fl_ativo:fl_ativo, fl_status_intrpe_trtmto_equipe:fl_status_intrpe_trtmto_equipe, fl_status_finaliza_trtmto_equipe:fl_status_finaliza_trtmto_equipe, cd_cor_status_trtmto:cd_cor_status_trtmto, fl_status_inicial_trtmto:fl_status_inicial_trtmto},
				 dataType : "text",			 
				 success : function(completeHtmlPage) {				
					$("html").empty();
					$("html").append(completeHtmlPage);
				 }
			});
		});		
		
		
		$("#tabela").on('click', '.visualiza', function(){
			
			var currentRow=$(this).closest("tr"); 			
			var id_status_trtmto = currentRow.find("td:eq(0)").text();						
						
			$.ajax({
				url:"../visualizacao/visualizacao_status_tratamento.php",
				method:"POST",
				data:{id_status_trtmto:id_status_trtmto},
				success:function(data){
					$('#visualizacao').html(data);
					$('#visualiza').modal('show');
				}
			});
        });
		
	});		
	
	</script>
<?php ?>