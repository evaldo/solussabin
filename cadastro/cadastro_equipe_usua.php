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
		
		$sql = "select count(1)
				  from tratamento.tb_c_equipe_usua equipe_usua
					 , tratamento.tb_c_equipe equipe
					 , tratamento.tb_c_usua_acesso usua
				where equipe_usua.id_equipe = equipe.id_equipe
				  and equipe_usua.cd_usua_acesso = usua.cd_usua_acesso
				  and upper(usua.nm_usua_acesso) like '%" . $textoconsulta . "%' 
				  order by equipe.nu_seq_equipe_pnel";
			
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
		
		$sql ="select equipe.ds_equipe
					 , usua.nm_usua_acesso
					 , id_equipe_usua					 
				  from tratamento.tb_c_equipe_usua equipe_usua
					 , tratamento.tb_c_equipe equipe
					 , tratamento.tb_c_usua_acesso usua
				where equipe_usua.id_equipe = equipe.id_equipe
				  and equipe_usua.cd_usua_acesso = usua.cd_usua_acesso
				  and upper(usua.nm_usua_acesso) like '%" . $textoconsulta . "%'
				order by equipe.nu_seq_equipe_pnel LIMIT $itens_por_pagina OFFSET $pagina*$itens_por_pagina";
		
	} else{
		
			$sql = "select count(1)
				  from tratamento.tb_c_equipe_usua equipe_usua
					 , tratamento.tb_c_equipe equipe
					 , tratamento.tb_c_usua_acesso usua
				where equipe_usua.id_equipe = equipe.id_equipe
				  and equipe_usua.cd_usua_acesso = usua.cd_usua_acesso ";
			
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
		
			$sql ="select equipe.ds_equipe
					 , usua.nm_usua_acesso
					 , id_equipe_usua					 
				  from tratamento.tb_c_equipe_usua equipe_usua
					 , tratamento.tb_c_equipe equipe
					 , tratamento.tb_c_usua_acesso usua
				where equipe_usua.id_equipe = equipe.id_equipe
				  and equipe_usua.cd_usua_acesso = usua.cd_usua_acesso				  
				order by equipe.nu_seq_equipe_pnel LIMIT $itens_por_pagina OFFSET $pagina*$itens_por_pagina";		
	}
	
	if ($pdo==null){
			header(Config::$webLogin);
	}	
    $ret = pg_query($pdo, $sql);
    if(!$ret) {
        echo pg_last_error($pdo);
        exit;
    }
	
	if(isset($_POST['deleta'])){					
		
		if ($pdo==null){
			header(Config::$webLogin);
		}
		
		try
		{	
			// remove do banco			
			$sql = "DELETE FROM tratamento.tb_c_equipe_usua WHERE id_equipe_usua = ".$_SESSION['id_equipe_usua']."";	
			
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
	
	if(isset($_POST['insere'])){					
		
		if ($pdo==null){
			header(Config::$webLogin);
		}
		
		try
		{	
				
			$sql="select count(1) from tratamento.tb_c_equipe_usua where id_equipe = ".$_POST['id_equipe']." and cd_usua_acesso = ".$_POST['cd_usua_acesso']."";
			
			if ($pdo==null){
			header(Config::$webLogin);
			}	
			$ret = pg_query($pdo, $sql);
			if(!$ret) {
				echo pg_last_error($pdo);
				exit;
			}
			
			$row = pg_fetch_row($ret);
			
			if($row[0]>0){
				echo "<div class=\"alert alert-warning alert-dismissible\">
					<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
					<strong>Atenção!</strong>  Tentativa de inclusão em duplicidade.</div>";
			} else {
		
				$sql = "insert into tratamento.tb_c_equipe_usua values ((select NEXTVAL('tratamento.sq_equipe_usua')),".$_POST['id_equipe'].", ". $_POST['cd_usua_acesso'].", '".$_SESSION['usuario']."', current_timestamp)";	
								
				$result = pg_query($pdo, $sql);
				
				//echo $sql;

				if($result){
					echo "";
				}  				
				
			}

			$secondsWait = 0;
			header("Refresh:$secondsWait");			
			
		} catch(PDOException $e)
		{
			echo "<div class=\"alert alert-warning alert-dismissible\">
					<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
					<strong>Atenção!</strong> ".$e->getMessage()."	</div>";			
		}
	}
    	
?>	

	<!DOCTYPE html>
	<html lang="pt-br">
	<head>
	 <meta charset="utf-8">
	 <meta http-equiv="X-UA-Compatible" content="IE=edge">
	 <meta name="viewport" content="width=device-width, initial-scale=1">
	 <title>Usuários Por Equipe</title>

	 <link href="../css/bootstrap.min.css" rel="stylesheet">
	 <link href="../css/style.css" rel="stylesheet">
	</head>
	<body>

	 <div id="main" class="container-fluid" style="margin-top: 50px"> 
		<div class="container" style="margin-left: 0px">
			<form class="form-inline" action="#" method="post" >				
				<b>Consultar por usuários:</b>:&nbsp;&nbsp													
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
						<th>Equipe</th>
						<th>Usuário</th>												
						<th>Id da Relação Usuário Por Equipe</th>
						<th class="actions">Ações</th>
					</tr>
				</thead>				
				<tbody>
				<?php

					$cont=1;										
					while($row = pg_fetch_row($ret)) {
					?>						
						<tr>
							<td id="ds_equipe" value="<?php echo $row[0];?>"><?php echo $row[0];?></td>
							<td id="nm_usua" value="<?php echo $row[1];?>"><?php echo $row[1];?></td>
							<td id="id_equipe_usua" value="<?php echo $row[2];?>"><?php echo $row[2];?></td>														
							<td class="actions">								
								<input type="button" value="Visualizar" class="btn btn-success btn-xs visualiza"/>																
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
				<li class="page-item"><a class="page-link" href="cadastro_equipe_usua.php?pagina=0">Primeiro</a></li>
				<?php 				
				for ($i=0; $i<$num_paginas;$i++){										
				?>
					<li class="page-item" ><a class="page-link" href="cadastro_equipe_usua.php?pagina=<?php echo $i;?>">
						<?php echo $i+1;?></a></li>
				<?php } ?>
				<li class="page-item"><a class="page-link" href="cadastro_equipe_usua.php?pagina=<?php echo $num_paginas-1; ?>">Último</a></li>
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
			
			var ds_equipe = currentRow.find("td:eq(0)").text();				
			var nm_usua_acesso = currentRow.find("td:eq(1)").text();
			var id_equipe_usua = currentRow.find("td:eq(2)").text();	
			
			// AJAX code to submit form.
			$.ajax({
				 type: "POST",
				 url: "../delecao/delecao_equipe_usua.php", //
				 data: {ds_equipe:ds_equipe, nm_usua_acesso:nm_usua_acesso, id_equipe_usua:id_equipe_usua},
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
				url:"../insercao/insercao_equipe_usua.php",															
				success : function(completeHtmlPage) {				
					$("html").empty();
					$("html").append(completeHtmlPage);
				}
			});			
		});		
		
		$("#tabela").on('click', '.visualiza', function(){
			
			var currentRow=$(this).closest("tr"); 			
			var id_equipe_usua = currentRow.find("td:eq(2)").text();						
						
			$.ajax({
				url:"../visualizacao/visualizacao_equipe_usua.php",
				method:"POST",
				data:{id_equipe_usua:id_equipe_usua},
				success:function(data){
					$('#visualizacao').html(data);
					$('#visualiza').modal('show');
				}
			});
        });
		
	});		
	
	</script>
<?php ?>