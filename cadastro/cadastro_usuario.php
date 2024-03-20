<?php
		
	session_start();		
	
    include '../database.php';
	
	error_reporting(0); 
	
	$itens_por_pagina=5;
	$pagina=intval($_GET['pagina']);
	
    global $pdo;	
	
	$pdo = database::connect();
	$optconsulta = "";
	$textoconsulta = "";
	
	$sql = '';
	
	$textoconsulta = "";
	
	if(isset($_POST['botaoconsultar'])&& $_POST['textoconsulta']<>""){
		
		$textoconsulta = strtoupper($_POST['textoconsulta']);
		
		$sql = "SELECT count(cd_usua_acesso)
				from tratamento.tb_c_usua_acesso 
				where upper(nm_usua_acesso) like '%" . $textoconsulta . "%'";
			
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
		
		$sql ="SELECT cd_usua_acesso, nm_usua_acesso 
				from tratamento.tb_c_usua_acesso 
				where upper(nm_usua_acesso) like '%" . $textoconsulta . "%' order by nm_usua_acesso LIMIT $itens_por_pagina OFFSET $pagina*$itens_por_pagina";
		
	} else{
		
			$sql = "SELECT count(cd_usua_acesso)
				from tratamento.tb_c_usua_acesso";
			
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
		
			$sql ="SELECT cd_usua_acesso, nm_usua_acesso from tratamento.tb_c_usua_acesso order by nm_usua_acesso LIMIT $itens_por_pagina OFFSET $pagina*$itens_por_pagina";	
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
		
			if ($_POST['fl_sist_admn']=='on'){
				$fl_sist_admn = 'S';
			} else {
				$fl_sist_admn = 'N';
			}
			
			if ($_POST['fl_acesso_ip']=='on'){
				$fl_acesso_ip = 'S';
			} else {
				$fl_acesso_ip = 'N';
			}
		
			$sql = "insert into tratamento.tb_c_usua_acesso (cd_usua_acesso, nm_usua_acesso, ds_usua_acesso, fl_sist_admn, cd_faixa_ip_1, cd_faixa_ip_2, fl_acesso_ip, cd_usua_incs, dt_incs) values ((select NEXTVAL('tratamento.sq_usua_acesso')), '". $_POST['nm_usua_acesso']."', '". $_POST['ds_usua_acesso']."' ,'". $fl_sist_admn ."','". $_POST['cd_faixa_ip_1']."', '". $_POST['cd_faixa_ip_2']."','". $fl_acesso_ip ."', '".$_SESSION['usuario']."', current_timestamp);";

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
			
			if ($_POST['fl_sist_admn_text']=='true' or $_POST['fl_sist_admn']=='on'){					
				$fl_sist_admn = 'S';
			} else {
				$fl_sist_admn = 'N';
			}
			
			if ($_POST['fl_acesso_ip_text']=='true' or $_POST['fl_acesso_ip']=='on'){
				$fl_acesso_ip = 'S';
			} else {
				$fl_acesso_ip = 'N';
			}
			
			$sql = "update tratamento.tb_c_usua_acesso set nm_usua_acesso = '". $_POST['nm_usua_acesso']."',ds_usua_acesso = '". $_POST['ds_usua_acesso']."',  cd_faixa_ip_1 = '". $_POST['cd_faixa_ip_1']."',  cd_faixa_ip_2 = '". $_POST['cd_faixa_ip_2']."', fl_sist_admn = '" .$fl_sist_admn."' , fl_acesso_ip = '" .$fl_acesso_ip."', cd_usua_altr = '".$_SESSION['usuario']."', dt_altr = current_timestamp where cd_usua_acesso = ". $_SESSION['cd_usua_acesso']."";	
			
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

			$sql = "SELECT count(cd_usua_acesso)
				from tratamento.tb_c_grupo_usua_acesso
				where cd_usua_acesso = ".$_SESSION['cd_usua_acesso']." ";
			
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
					<strong>Atenção!</strong> Exclusão recusada! Este usuário está cadastrado para grupos de acesso.
				</div>";
				
				$secondsWait = 5;
				header("Refresh:$secondsWait");
				
			} else {
		
				// remove do banco			
				$sql = "DELETE FROM tratamento.tb_c_usua_acesso WHERE cd_usua_acesso = ".$_SESSION['cd_usua_acesso']."";			
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
	 <title>tratamento de Usuários</title>

	 <link href="../css/bootstrap.min.css" rel="stylesheet">
	 <link href="../css/style.css" rel="stylesheet">
	</head>
	<body>

	 <div id="main" class="container-fluid" style="margin-top: 50px"> 
		<div class="container" style="margin-left: 0px">
			<form class="form-inline" action="#" method="post" >				
				<b>Consultar usuários:</b>:&nbsp;&nbsp													
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
						<th>Identificador do usuário</th>
						<th>Nome do Usuário</th>												
						<th class="actions">Ações</th>
					</tr>
				</thead>				
				<tbody>
				<?php

					$cont=1;										
					while($row = pg_fetch_row($ret)) {
					?>						
						<tr>
							<td id="cd_usua_acesso" value="<?php echo $row[0];?>"><?php echo $row[0];?></td>
							<td id="nm_usua_acesso" value="<?php echo $row[1];?>"><?php echo $row[1];?></td>
														
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
				<li class="page-item"><a class="page-link" href="cadastro_usuario.php?pagina=0">Primeiro</a></li>
				<?php 				
				for ($i=0; $i<$num_paginas;$i++){										
				?>
					<li class="page-item" ><a class="page-link" href="cadastro_usuario.php?pagina=<?php echo $i;?>">
						<?php echo $i+1;?></a></li>
				<?php } ?>
				<li class="page-item"><a class="page-link" href="cadastro_usuario.php?pagina=<?php echo $num_paginas-1; ?>">Último</a></li>
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
			
			var cd_usua_acesso = currentRow.find("td:eq(0)").text();
			var nm_usua_acesso = currentRow.find("td:eq(1)").text();	
			
			// AJAX code to submit form.
			$.ajax({
				 type: "POST",
				 url: "../delecao/delecao_usuario.php", //
				 data: {cd_usua_acesso:cd_usua_acesso, nm_usua_acesso:nm_usua_acesso},
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
				url:"../insercao/insercao_usuario.php",															
				success : function(completeHtmlPage) {				
					$("html").empty();
					$("html").append(completeHtmlPage);
				}
			});			
		});	

		$("#tabela").on('click','.altera',function(){			
		
			var currentRow=$(this).closest("tr"); 
			
			var cd_usua_acesso = currentRow.find("td:eq(0)").text();
			var nm_usua_acesso = currentRow.find("td:eq(1)").text();			
			
			// AJAX code to submit form.
			$.ajax({
				 type: "POST",
				 url: "../alteracao/alteracao_usuario.php", //
				 data: {cd_usua_acesso:cd_usua_acesso, nm_usua_acesso:nm_usua_acesso},
				 dataType : "text",			 
				 success : function(completeHtmlPage) {				
					$("html").empty();
					$("html").append(completeHtmlPage);
				 }
			});
		});		
		
		
		$("#tabela").on('click', '.visualiza', function(){
			
			var currentRow=$(this).closest("tr"); 			
			var codigo_usua = currentRow.find("td:eq(0)").text();							
						
			$.ajax({
				url:"../visualizacao/visualizacao_usuario.php",
				method:"POST",
				data:{codigo_usua:codigo_usua},
				success:function(data){
					$('#visualizacao').html(data);
					$('#visualiza').modal('show');
				}
			});
        });
		
	});		
	
	</script>
<?php ?>