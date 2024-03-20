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
		
		$sql = "SELECT count(transac.id_acesso_transac_tratamento)
				FROM tratamento.tb_c_acesso_transac_tratamento transac where upper(transac.nm_acesso_transac_tratamento) like '%" . $textoconsulta . "%'";
			
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
		
		$sql ="SELECT transac.id_acesso_transac_tratamento, menu.nm_menu_sist_tratamento, transac.nm_acesso_transac_tratamento, transac.cd_transac_tratamento, transac.cd_form_transac_tratamento FROM tratamento.tb_c_acesso_transac_tratamento transac, tratamento.tb_c_menu_sist_tratamento menu where transac.id_menu_sist_tratamento = menu.id_menu_sist_tratamento and   upper(transac.nm_acesso_transac_tratamento) like '%" . $textoconsulta . "%' order by transac.nm_acesso_transac_tratamento LIMIT $itens_por_pagina OFFSET $pagina*$itens_por_pagina";
		
	} else{
		
			$sql = "SELECT count(transac.id_acesso_transac_tratamento)
				FROM tratamento.tb_c_acesso_transac_tratamento transac";
			
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
		
			$sql ="SELECT transac.id_acesso_transac_tratamento, menu.nm_menu_sist_tratamento, transac.nm_acesso_transac_tratamento, transac.cd_transac_tratamento, transac.cd_form_transac_tratamento FROM tratamento.tb_c_acesso_transac_tratamento transac, tratamento.tb_c_menu_sist_tratamento menu where transac.id_menu_sist_tratamento = menu.id_menu_sist_tratamento order by transac.nm_acesso_transac_tratamento LIMIT $itens_por_pagina OFFSET $pagina*$itens_por_pagina";	
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
		
			$sql = "insert into tratamento.tb_c_acesso_transac_tratamento values ((select NEXTVAL('tratamento.sq_acesso_transac_tratamento')), ".$_POST['id_menu_sist_tratamento'].", '". $_POST['nm_acesso_transac_tratamento']."', '". $_POST['cd_transac_tratamento'] ."', '". $_POST['cd_form_transac_tratamento'] ."', '". $_SESSION['usuario'] ."', current_timestamp, null,null);";

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
						
			$sql = "update tratamento.tb_c_acesso_transac_tratamento set nm_acesso_transac_tratamento = '". $_POST['nm_acesso_transac_tratamento']."', id_menu_sist_tratamento = ".$_POST['id_menu_sist_tratamento'].", cd_transac_tratamento = '". $_POST['cd_transac_tratamento'] ."', cd_form_transac_tratamento = '". $_POST['cd_form_transac_tratamento'] ."', cd_usua_altr = '".$_SESSION['usuario']."', dt_altr = current_timestamp where id_acesso_transac_tratamento = ". $_SESSION['id_acesso_transac_tratamento']."";	
			
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
			$sql = "DELETE FROM tratamento.tb_c_acesso_transac_tratamento WHERE id_acesso_transac_tratamento = ".$_SESSION['id_acesso_transac_tratamento']."";			

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
	 <title>Cadastro das Transações das Funcionalidades/Menus</title>

	 <link href="../css/bootstrap.min.css" rel="stylesheet">
	 <link href="../css/style.css" rel="stylesheet">
	</head>
	<body>

	 <div id="main" class="container-fluid" style="margin-top: 50px"> 
		<div class="container" style="margin-left: 0px">
			<form class="form-inline" action="#" method="post" >				
				<b>Consultar de transações:</b>:&nbsp;&nbsp													
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
						<th>Identificador</th>
						<th>Funcionalidade/Menu</th>												
						<th>Transação</th>												
						<th>Cód Transação</th>
						<th>Cod Func/Menu</th>						
						
						<th class="actions">Ações</th>			
					</tr>
				</thead>				
				<tbody>
				<?php
				
					$cont=1;										
					while($row = pg_fetch_row($ret)) {
					?>						
						<tr>
							<td id="id_acesso_transac_tratamento" value="<?php echo $row[0];?>"><?php echo $row[0];?></td>
							<td id="nm_menu_sist_tratamento" value="<?php echo $row[1];?>"><?php echo $row[1];?></td>
							<td id="nm_acesso_transac_tratamento" value="<?php echo $row[2];?>"><?php echo $row[2];?></td>				
							<td id="cd_transac_tratamento" value="<?php echo $row[3];?>"><?php echo $row[3];?></td>							
							<td id="cd_form_transac_tratamento" value="<?php echo $row[4];?>"><?php echo $row[3];?></td>
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
				<li class="page-item"><a class="page-link" href="cadastro_transacao.php?pagina=0">Primeiro</a></li>
				<?php 				
				for ($i=0; $i<$num_paginas;$i++){										
				?>
					<li class="page-item" ><a class="page-link" href="cadastro_transacao.php?pagina=<?php echo $i;?>">
						<?php echo $i+1;?></a></li>
				<?php } ?>
				<li class="page-item"><a class="page-link" href="cadastro_transacao.php?pagina=<?php echo $num_paginas-1; ?>">Último</a></li>
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
			
			var id_acesso_transac_tratamento = currentRow.find("td:eq(0)").text();
			var nm_menu_sist_tratamento = currentRow.find("td:eq(1)").text();	
			var nm_acesso_transac_tratamento = currentRow.find("td:eq(2)").text();
			var cd_transac_tratamento = currentRow.find("td:eq(3)").text();	
			var cd_form_transac_tratamento = currentRow.find("td:eq(4)").text();				
			
			// AJAX code to submit form.
			$.ajax({
				 type: "POST",
				 url: "../delecao/delecao_transacao.php", //
				 data: {id_acesso_transac_tratamento:id_acesso_transac_tratamento, nm_menu_sist_tratamento:nm_menu_sist_tratamento,
				 nm_acesso_transac_tratamento:nm_acesso_transac_tratamento, cd_transac_tratamento:cd_transac_tratamento, cd_form_transac_tratamento:cd_form_transac_tratamento},
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
				url:"../insercao/insercao_transacao.php",															
				success : function(completeHtmlPage) {				
					$("html").empty();
					$("html").append(completeHtmlPage);
				}
			});			
		});	

		$("#tabela").on('click','.altera',function(){			
		
			var currentRow=$(this).closest("tr"); 
			
			var id_acesso_transac_tratamento = currentRow.find("td:eq(0)").text();
			var nm_menu_sist_tratamento = currentRow.find("td:eq(1)").text();	
			var nm_acesso_transac_tratamento = currentRow.find("td:eq(2)").text();
			var cd_transac_tratamento = currentRow.find("td:eq(3)").text();	
			var cd_form_transac_tratamento = currentRow.find("td:eq(4)").text();		
			
			// AJAX code to submit form.
			$.ajax({
				 type: "POST",
				 url: "../alteracao/alteracao_transacao.php", //
				 data: {id_acesso_transac_tratamento:id_acesso_transac_tratamento, nm_menu_sist_tratamento:nm_menu_sist_tratamento,
				 nm_acesso_transac_tratamento:nm_acesso_transac_tratamento, cd_transac_tratamento:cd_transac_tratamento, cd_form_transac_tratamento:cd_form_transac_tratamento},
				 dataType : "text",			 
				 success : function(completeHtmlPage) {				
					$("html").empty();
					$("html").append(completeHtmlPage);
				 }
			});
		});		
		
		
		$("#tabela").on('click', '.visualiza', function(){
			
			var currentRow=$(this).closest("tr"); 			
			var id_acesso_transac_tratamento = currentRow.find("td:eq(0)").text();							
						
			$.ajax({
				url:"../visualizacao/visualizacao_transacao.php",
				method:"POST",
				data:{id_acesso_transac_tratamento:id_acesso_transac_tratamento},
				success:function(data){
					$('#visualizacao').html(data);
					$('#visualiza').modal('show');
				}
			});
        });
		
	});		
	
	</script>
<?php ?>

