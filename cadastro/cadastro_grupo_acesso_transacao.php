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
				  from tratamento.tb_c_grupo_acesso grupo
					 , tratamento.tb_c_grupo_usua_transac_acesso grupo_transac
					 , tratamento.tb_c_acesso_transac_tratamento transac
				where grupo_transac.id_grupo_acesso = grupo.id_grupo_acesso
				  and transac.id_acesso_transac_tratamento = grupo_transac.id_acesso_transac_nm_grupo_acessocao
				  and upper(transac.nm_acesso_transac_tratamento) like '%" . $textoconsulta . "%' ";
			
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
		
		$sql ="select grupo_transac.id_grupo_usua_transac_acesso
		            , transac.nm_acesso_transac_tratamento
					, grupo.nm_grupo_acesso					
		          from tratamento.tb_c_grupo_acesso grupo
					 , tratamento.tb_c_grupo_usua_transac_acesso grupo_transac
					 , tratamento.tb_c_acesso_transac_tratamento transac
				where grupo_transac.id_grupo_acesso = grupo.id_grupo_acesso
				  and transac.id_acesso_transac_tratamento = grupo_transac.id_acesso_transac_tratamento
				  and upper(transac.nm_acesso_transac_tratamento) like '%" . $textoconsulta . "%'
				order by 1, 2 LIMIT $itens_por_pagina OFFSET $pagina*$itens_por_pagina";
		
	} else{
		
			$sql = "select count(1)
				  from tratamento.tb_c_grupo_acesso grupo
					 , tratamento.tb_c_grupo_usua_transac_acesso grupo_transac
					 , tratamento.tb_c_acesso_transac_tratamento transac
				where grupo_transac.id_grupo_acesso = grupo.id_grupo_acesso
				  and transac.id_acesso_transac_tratamento = grupo_transac.id_acesso_transac_tratamento ";
			
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
		
			$sql ="select grupo_transac.id_grupo_usua_transac_acesso
		            , transac.nm_acesso_transac_tratamento
					, grupo.nm_grupo_acesso					
		          from tratamento.tb_c_grupo_acesso grupo
					 , tratamento.tb_c_grupo_usua_transac_acesso grupo_transac
					 , tratamento.tb_c_acesso_transac_tratamento transac
				where grupo_transac.id_grupo_acesso = grupo.id_grupo_acesso
				  and transac.id_acesso_transac_tratamento = grupo_transac.id_acesso_transac_tratamento			  
				order by 1, 2 LIMIT $itens_por_pagina OFFSET $pagina*$itens_por_pagina";		
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
			$sql = "DELETE FROM tratamento.tb_c_grupo_usua_transac_acesso WHERE id_grupo_usua_transac_acesso = ".$_SESSION['id_grupo_usua_transac_acesso']."";	
			
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
				
			$sql="select count(1) from tratamento.tb_c_grupo_usua_transac_acesso where id_grupo_acesso = ".$_POST['id_grupo_acesso']." and id_acesso_transac_tratamento = ".$_POST['id_acesso_transac_tratamento']."";
			
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
		
				$sql = "insert into tratamento.tb_c_grupo_usua_transac_acesso values ((select NEXTVAL('tratamento.sq_grupo_usua_transac_acesso')),".$_POST['id_acesso_transac_tratamento'].", ".$_POST['id_grupo_acesso'].", '".$_SESSION['usuario']."', current_timestamp, null,null)";	
				
				//echo $sql;
				
				$result = pg_query($pdo, $sql);

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
	 <title>Grupo de Acesso por Transação</title>

	 <link href="../css/bootstrap.min.css" rel="stylesheet">
	 <link href="../css/style.css" rel="stylesheet">
	</head>
	<body>

	 <div id="main" class="container-fluid" style="margin-top: 50px"> 
		<div class="container" style="margin-left: 0px">
			<form class="form-inline" action="#" method="post" >				
				<b>Consultar por transação:</b>:&nbsp;&nbsp													
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
						<th>Grp Acesso Transac</th>
						<th>Transação</th>												
						<th>Grupo de Acesso</th>
						<th class="actions">Ações</th>
					</tr>
				</thead>				
				<tbody>
				<?php

					$cont=1;										
					while($row = pg_fetch_row($ret)) {
					?>						
						<tr>
							<td id="id_grupo_usua_transac_acesso" value="<?php echo $row[0];?>"><?php echo $row[0];?></td>
							<td id="nm_acesso_transac_tratamento" value="<?php echo $row[1];?>"><?php echo $row[1];?></td>
							<td id="nm_grupo_acesso" value="<?php echo $row[2];?>"><?php echo $row[2];?></td>														
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
				<li class="page-item"><a class="page-link" href="cadastro_grupo_acesso_transacao.php?pagina=0">Primeiro</a></li>
				<?php 				
				for ($i=0; $i<$num_paginas;$i++){										
				?>
					<li class="page-item" ><a class="page-link" href="cadastro_grupo_acesso_transacao.php?pagina=<?php echo $i;?>">
						<?php echo $i+1;?></a></li>
				<?php } ?>
				<li class="page-item"><a class="page-link" href="cadastro_grupo_acesso_transacao.php?pagina=<?php echo $num_paginas-1; ?>">Último</a></li>
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
			
			var id_grupo_usua_transac_acesso = currentRow.find("td:eq(0)").text();				
			var nm_acesso_transac_tratamento = currentRow.find("td:eq(1)").text();
			var nm_grupo_acesso = currentRow.find("td:eq(2)").text();	
			
			// AJAX code to submit form.
			$.ajax({
				 type: "POST",
				 url: "../delecao/delecao_grupo_acesso_transacao.php", //
				 data: {id_grupo_usua_transac_acesso:id_grupo_usua_transac_acesso, nm_acesso_transac_tratamento:nm_acesso_transac_tratamento, nm_grupo_acesso:nm_grupo_acesso},
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
				url:"../insercao/insercao_grupo_acesso_transacao.php",															
				success : function(completeHtmlPage) {				
					$("html").empty();
					$("html").append(completeHtmlPage);
				}
			});			
		});		
		
		$("#tabela").on('click', '.visualiza', function(){
			
			var currentRow=$(this).closest("tr"); 			
			var id_grupo_usua_transac_acesso = currentRow.find("td:eq(0)").text();	
			var nm_acesso_transac_tratamento = currentRow.find("td:eq(1)").text();
			var nm_grupo_acesso = currentRow.find("td:eq(2)").text();				
						
			$.ajax({
				url:"../visualizacao/visualizacao_grupo_acesso_transacao.php",
				method:"POST",
				data: {id_grupo_usua_transac_acesso:id_grupo_usua_transac_acesso, nm_acesso_transac_tratamento:nm_acesso_transac_tratamento, nm_grupo_acesso:nm_grupo_acesso},
				success:function(data){
					$('#visualizacao').html(data);
					$('#visualiza').modal('show');
				}
			});
        });
		
	});		
	
	</script>
<?php ?>