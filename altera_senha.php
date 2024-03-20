<?php	

	function alterasenha($usuario, $senhanova) {
		
		include './database.php';			
		
		$pdo = database::connect();
		
		if ($pdo==null){
			header(Config::$webLogin);
		}
		
		try
		{	
		
			$usuario = substr_replace($usuario, '"', 0, 0);
			$usuario = substr_replace($usuario, '"', strlen($usuario), strlen($usuario));

			$sql="ALTER USER ".$usuario." WITH PASSWORD '".$senhanova."'";			
			pg_query($sql);
			
			//echo $sql;
			
			session_destroy();
			unset( $_SESSION['usuario'] );

			header(Config::$webServer);			
			
			
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
			<h4>Alterar Senha</h4>
			<form  class="was-validated" method="post">
			  <div class="form-group">
				<label for="usuariolabel">Usuário:</label>
				<input type="text" class="form-control" id="usuario" placeholder="<?php session_start(); echo $_SESSION['usuario'] ;?>" name="usuario" readonly>	
			  </div>
			  <div class="form-group">
				<label for="senhalabel">Nova Senha:</label>
				<input type="password" class="form-control" id="senha" placeholder="Entre com a senha" name="senha" required>
				<div class="valid-feedback">Validação.</div>
				<div class="invalid-feedback"><font color="black">Preencha totalmente este campo.</a></div>
			  </div>	
			  <hr>
			  <button type="submit" onclick="" name="acessar" class="btn btn-primary">Alterar</button>
			  <br>
			  <br>
			</form>	
		</div>
	</body>	
</html>
<?php 

	if (isset($_POST['senha'])) {
		alterasenha($_SESSION['usuario'], $_POST['senha']);
	}
?>