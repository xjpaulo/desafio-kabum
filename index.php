<!DOCTYPE html>
<html>
<head>
    <title>Desafio Kabum :: Login</title>
    <link rel="stylesheet" type="text/css" href="config/style.css">
</head>
<body>
<div class="loginDiv">    
	<div class="headerDiv"><h2>Login</h2></div>
		<div id="login-alert">
			<span id="mensagem"></span>
		</div>
	<p></p>
		<form id="login-form" action="login.php" method="post">             
			<div>
				<input type="text" class="css-input" id="usuario" name="usuario" required placeholder="Usuario">                                        
			</div>
			<p></p>                           
			<div>
				<input type="password" class="css-input" id="senha" name="senha" required placeholder="Senha">
			</div>
			<p></p>  
			<div>
				<button type="button" class="myButton" name="entrar" id="entrar">
					Entrar
				</button>
			</div> 
		</form>     
</div>  
 
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script>
    $('document').ready(function(){

	$("#entrar").click(function(){
		var data = $("#login-form").serialize();
			
		$.ajax({
			type : 'POST',
			url  : 'login.php',
			data : data,
			dataType: 'json',
			beforeSend: function()
			{	
				$("#entrar").html('Validando ...');
			},
			success :  function(response){						
				if(response.codigo == "1"){	
					$("#entrar").html('Entrar');
					$("#login-alert").css('display', 'none')
					window.location.href = "home.php";
				}
				else{			
					$("#entrar").html('Entrar');
					$("#login-alert").css('display', 'block')
					$("#mensagem").html('<strong>Erro! </strong>' + response.mensagem);
				}
		    }
		});
	});

}); 
</script>
</body>
</html>