<?php
		
	session_start();		
	
    include '../database.php';
	
	error_reporting(0); 
	
	$itens_por_pagina=10;
	$pagina=intval($_GET['pagina']);
	
    global $pdo;	
	
	$pdo = database::connect();
	$optconsulta = "";
	$textoconsulta = "";
	
	$sql = '';
	
	$textoconsulta = "";
	
	if(isset($_POST['botaoconsultar'])&& $_POST['textoconsulta']<>""){
		
		$textoconsulta = strtoupper($_POST['textoconsulta']);
		
		$sql = "SELECT count(id_status_pcnt)
				from tratamento.tb_c_status_pcnt 
				where upper(ds_status_pcnt) like '%" . $textoconsulta . "%'";
			
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
		
		$sql ="SELECT id_status_pcnt, ds_status_pcnt, case when fl_ativo=1 then 'Sim' else 'Não' end fl_ativo, cd_cor_status_pcnt 
				from tratamento.tb_c_status_pcnt 
				where upper(ds_status_pcnt) like '%" . $textoconsulta . "%' order by cd_cor_status_pcnt LIMIT $itens_por_pagina OFFSET $pagina*$itens_por_pagina";
		
	} else{
		
			$sql = "SELECT count(id_status_pcnt)
				from tratamento.tb_c_status_pcnt";
			
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
		
			$sql ="SELECT id_status_pcnt, ds_status_pcnt, case when fl_ativo=1 then 'Sim' else 'Não' end fl_ativo, cd_cor_status_pcnt from tratamento.tb_c_status_pcnt order by cd_cor_status_pcnt LIMIT $itens_por_pagina OFFSET $pagina*$itens_por_pagina";	
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
		
			$sql = "insert into tratamento.tb_c_status_pcnt (id_status_pcnt, ds_status_pcnt, fl_ativo, cd_cor_status_pcnt, cd_usua_incs, dt_incs) values ((select NEXTVAL('tratamento.sq_status_pcnt')), '". $_POST['ds_status_pcnt']."', ". $_POST['fl_ativo'].", '". $_POST['cd_cor_status_pcnt']."', '".$_SESSION['usuario']."', current_timestamp);";

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
	
	if(isset($_POST['altera'])){					
		
		if ($pdo==null){
			header(Config::$webLogin);
		}
		
		try
		{	
			
			$sql = "update tratamento.tb_c_status_pcnt set ds_status_pcnt = '". $_POST['ds_status_pcnt']."', fl_ativo = ". $_POST['fl_ativo'].", cd_usua_altr = '".$_SESSION['usuario']."', cd_cor_status_pcnt = '". $_POST['cd_cor_status_pcnt']."',  dt_altr = current_timestamp where id_status_pcnt = ". $_SESSION['id_status_pcnt']."";	
			
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

			/*$sql = "SELECT count(id_status_pcnt)
				from tratamento.tb_c_status_equipe
				where id_status_pcnt = ".$_SESSION['id_status_pcnt']." ";
			
			if ($pdo==null){
					header(Config::$webLogin);
			}	
			$ret = pg_query($pdo, $sql);
			if(!$ret) {
				echo pg_last_error($pdo);
				exit;
			}	
			$row = pg_fetch_row($ret);
			
			if ($row[0]>0){
				
				
				echo "<div class=\"alert alert-warning alert-dismissible\">
					<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
					<strong>Atenção!</strong> Exclusão recusada! Esta equipe está cadastrada em status por Equipe.
				</div>";
				
				$secondsWait = 5;
				header("Refresh:$secondsWait");
				
			} else {*/
		
				// remove do banco			
				$sql = "DELETE FROM tratamento.tb_c_status_pcnt WHERE id_status_pcnt = ".$_SESSION['id_status_pcnt']."";			
				$result = pg_query($pdo, $sql);

				if($result){
					echo "";
				}  
				
				$secondsWait = 0;
				header("Refresh:$secondsWait");
				
			//}

			
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
	 <title>Cadastro dos Status do Paciente</title>

	 <link href="../css/bootstrap.min.css" rel="stylesheet">
	 <link href="../css/style.css" rel="stylesheet">
	</head>
	<body>

	 <div id="main" class="container-fluid" style="margin-top: 50px"> 
		<div class="container" style="margin-left: 0px">
			<form class="form-inline" action="#" method="post" >				
				<b>Consultar Status dos Pacientes:</b>:&nbsp;&nbsp													
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
					<tr>
						<th>Identificador do Status do Paciente</th>
						<th>Descrição do Status do Paciente</th>
						<th>Flag Ativo?</th>	
						<th>Cor no Painel</th>	
						<th class="actions">Ações</th>
					</tr>
				</thead>				
				<tbody>
				<?php

					$cont=1;										
					while($row = pg_fetch_row($ret)) {
					?>						
						<tr>
							<td id="id_status_pcnt" value="<?php echo $row[0];?>"><?php echo $row[0];?></td>
							<td id="ds_status_pcnt" value="<?php echo $row[1];?>"><?php echo $row[1];?></td>
							<td id="fl_ativo" value="<?php echo $row[2];?>"><?php echo $row[2];?></td>
							<td id="cd_cor_status_pcnt" value="<?php echo $row[3];?>"><?php echo $row[3];?></td>
														
							<td class="actions">								
								<input type="button" value="Visualizar" class="btn btn-success btn-xs visualiza"/>
								<input type="button" value="Alterar" class="btn btn-warning btn-xs altera"/>								
								<input type="button" value="Excluir" class="btn btn-danger btn-xs delecao"/>								
							</td>
						</tr>
					<?php $cont=$cont+1;} ?>	
				</tbody>
			</table>
		</div>
		
		</div> <!-- /#list -->
		
		<div>			
			<ul class="pagination">
				<li class="page-item"><a class="page-link" href="cadastro_status_paciente.php?pagina=0">Primeiro</a></li>
				<?php 				
				for ($i=0; $i<$num_paginas;$i++){										
				?>
					<li class="page-item" ><a class="page-link" href="cadastro_status_paciente.php?pagina=<?php echo $i;?>">
						<?php echo $i+1;?></a></li>
				<?php } ?>
				<li class="page-item"><a class="page-link" href="cadastro_status_paciente.php?pagina=<?php echo $num_paginas-1; ?>">Último</a></li>
			</ul>		
		</div> <!-- /#bottom -->
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
			
			var id_status_pcnt = currentRow.find("td:eq(0)").text();
			var ds_status_pcnt = currentRow.find("td:eq(1)").text();	
			var fl_ativo = currentRow.find("td:eq(2)").text();
			var cd_cor_status_pcnt = currentRow.find("td:eq(3)").text();	
			
			// AJAX code to submit form.
			$.ajax({
				 type: "POST",
				 url: "../delecao/delecao_status_paciente.php", //
				 data: {id_status_pcnt:id_status_pcnt, ds_status_pcnt:ds_status_pcnt, fl_ativo:fl_ativo, cd_cor_status_pcnt:cd_cor_status_pcnt},
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
				url:"../insercao/insercao_status_paciente.php",															
				success : function(completeHtmlPage) {				
					$("html").empty();
					$("html").append(completeHtmlPage);
				}
			});			
		});	

		$("#tabela").on('click','.altera',function(){			
		
			var currentRow=$(this).closest("tr"); 
			
			var id_status_pcnt = currentRow.find("td:eq(0)").text();
			var ds_status_pcnt = currentRow.find("td:eq(1)").text();
			var fl_ativo = currentRow.find("td:eq(2)").text();
			var cd_cor_status_pcnt = currentRow.find("td:eq(3)").text();
			
			// AJAX code to submit form.
			$.ajax({
				 type: "POST",
				 url: "../alteracao/alteracao_status_paciente.php", //
				 data: {id_status_pcnt:id_status_pcnt, ds_status_pcnt:ds_status_pcnt, fl_ativo:fl_ativo, cd_cor_status_pcnt:cd_cor_status_pcnt},
				 dataType : "text",			 
				 success : function(completeHtmlPage) {				
					$("html").empty();
					$("html").append(completeHtmlPage);
				 }
			});
		});		
		
		
		$("#tabela").on('click', '.visualiza', function(){
			
			var currentRow=$(this).closest("tr"); 			
			var id_status_pcnt = currentRow.find("td:eq(0)").text();							
						
			$.ajax({
				url:"../visualizacao/visualizacao_status_paciente.php",
				method:"POST",
				data:{id_status_pcnt:id_status_pcnt},
				success:function(data){
					$('#visualizacao').html(data);
					$('#visualiza').modal('show');
				}
			});
        });
		
	});		
	
	</script>
<?php ?>