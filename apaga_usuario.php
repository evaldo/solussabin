<?php	

	function apagausuario($apagarusuario) {
		
		session_start();
		
		include './database.php';			
		
		$pdo = database::connect();
		
		if ($pdo==null){
			header(Config::$webLogin);
		}
		
		try
		{	
		
			$apagarusuario = substr_replace($apagarusuario, '"', 0, 0);
			$apagarusuario = substr_replace($apagarusuario, '"', strlen($apagarusuario), strlen($apagarusuario));
			
			$sql="REVOKE USAGE ON SCHEMA tratamento from ".$apagarusuario.";";
			$sql.="REVOKE USAGE ON SCHEMA glosa from ".$apagarusuario.";";
			$sql.="REVOKE ALL PRIVILEGES ON ALL TABLES IN SCHEMA tratamento FROM ".$apagarusuario.";";
			$sql.="REVOKE ALL PRIVILEGES ON ALL TABLES IN SCHEMA glosa FROM ".$apagarusuario.";";
			$sql.="REVOKE ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA tratamento FROM ".$apagarusuario.";";
			$sql.="REVOKE ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA glosa FROM ".$apagarusuario.";";
			
			pg_query($sql);	

			$sql="DROP USER ".$apagarusuario."";
			
			pg_query($sql);					
			
			
		} catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
	
?>
	<!DOCTYPE html>
	<html>
	<head>	
		<meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>							
	</head>
	<body style="background-color:MediumSeaGreen">						
		<br><br>
		<div class="container" style="width:50%; border:2px solid black;  border-radius:5px">						
			<h4>Apagar usuário</h4>
			<form  class="was-validated" method="post">
			  <div class="form-group">
				<label for="usuariolabel">Usuário:</label>
				<input type="text" class="form-control" id="apagarusuario" name="apagarusuario">	
			  </div>			  	
			  <hr>
			  <button type="submit" onclick="" name="acessar" id="acessar" class="btn btn-primary">Apagar Usuário</button>
			  <br>
			  <br>
			</form>	
		</div>
	</body>	
</html>
<?php 

	if (isset($_POST['acessar'])) {
		apagausuario($_POST['apagarusuario']);
	}
?>