<?php
include "config/verificar_sessao.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Desafio Kabum :: Menu</title>
    <link rel="stylesheet" type="text/css" href="config/style.css">
	<style>
td {
  vertical-align: middle;
}

td:hover {
  background-color: #768d87;
  color: #000000;
}

.box-decoration:hover img{
filter: brightness(0) invert(1);  
}
		
a:link {
  font-family: "Arial Black", "Arial Bold", Gadget, sans-serif;
  font-size: 20px; font-style: normal; font-variant: normal; font-weight: 700;
  color: black;
  text-decoration: none;	
	
}

a:visited {
  color: black;
}

a:hover {
  color: white;
}

a:active {
  color: white;
}

</style>
</head>
<body>
	<div class=myDiv>
<table align=center width=70% height=100%>
	<tr><td align=center class="box-decoration"><a href=cadastro.php><img src="imgs/add.png" height=150px width=150px>Cadastrar</a></td>
	<td align=center class="box-decoration"><a href=listar.php><img src="imgs/list.png" height=150px width=150px>Listar</a></td>
	<td align=center class="box-decoration"><a href=logout.php><img src="imgs/logout.png" height=150px width=150px>Logout</a></td></tr>
	</table>
	</div>
 
</body>
</html>