<?php
include "config/verificar_sessao.php";

require 'config/conn.php';

$query = mysqli_query($conn, "SELECT id, nome, data_nascimento, cpf, rg, telefone FROM clientes");
$query2 = mysqli_query($conn, "SELECT ce.id, ce.clientes_id, ce.cep, ce.logradouro, ce.bairro, ce.numero, ce.complemento, ce.cidade, ce.estado FROM clientes c, clientes_enderecos ce WHERE c.id = ce.clientes_id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gerenciamento de Clientes :: Listar</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="config/style.css">
</head>
<body>   
<div id="myDiv" class="myDiv">    
	<div class="headerDiv"><h2>Clientes</h2></div>
		<div id="msg-alert">
			<span id="mensagem"></span>
		</div>
	<p></p>
<table width="100%" class="tableIn">
<?php
if (mysqli_num_rows($query) == 0)
{ ?>
		<tr><td>Não há clientes cadastrados.</td></tr>
<?php
}
else
{
    while ($endereco = mysqli_fetch_array($query2))
    {
        $endereco_array[$endereco['clientes_id']][$endereco['id']]['cep'] = $endereco['cep'];
        $endereco_array[$endereco['clientes_id']][$endereco['id']]['logradouro'] = $endereco['logradouro'];
        $endereco_array[$endereco['clientes_id']][$endereco['id']]['numero'] = $endereco['numero'];
        $endereco_array[$endereco['clientes_id']][$endereco['id']]['bairro'] = $endereco['bairro'];
        $endereco_array[$endereco['clientes_id']][$endereco['id']]['cidade'] = $endereco['cidade'];
        $endereco_array[$endereco['clientes_id']][$endereco['id']]['estado'] = $endereco['estado'];
        $endereco_array[$endereco['clientes_id']][$endereco['id']]['complemento'] = $endereco['complemento'];
    }
    while ($cliente = mysqli_fetch_array($query))
    { ?>
		<tr><th align=left colspan=6><?php echo $cliente['nome'] ?></th><th>
			<a href="editar.php?id=<?php echo $cliente['id'] ?>" id="<?php echo $cliente['id'] ?>" class="editar_cliente" title="Editar Cliente"><img src="imgs/edit.png" width="20px" height="20px"></a>
			<a href="#" id="<?php echo $cliente['id'] ?>" class="apagar_cliente" title="Apagar Cliente"><img src="imgs/delete.png" width="20px" height="20px"></a>
			</th></tr>
	<tr><td align=left width="50%" colspan=7><b>CPF:</b> <?php echo $cliente['cpf'] ?></td></tr>
		<tr><td align=left colspan=7><b>RG:</b> <?php echo $cliente['rg'] ?></td></tr>
	<tr><td align=left colspan=7><b>Data de Nascimento:</b> <?php echo $cliente['data_nascimento'] ?></td></tr>
		<tr><td align=left colspan=7><b>Telefone:</b> <?php echo $cliente['telefone'] ?></td></tr>
		<?php
        foreach ($endereco_array[$cliente['id']] as $k => $v)
        {
?>
	<tr><td colspan=7 align=left><b>Endereço:</b> <?php echo $v['logradouro'] . ', ' . $v['numero'] . ' - ' . $v['bairro'] . ', ' . $v['cidade'] . ' - ' . $v['estado'] . ', ' . $v['cep'] . ' / Complemento: ' . $v['complemento'] ?></td></tr>
 <?php
        }
    }
} ?>
	</table>
	<br><br>
</div>  
</body>
</html>

<script type="text/javascript">
	$('document').ready(function(){
				$(".apagar_cliente").click(function(){
		var id = this.id;
			
		$.ajax({
			type : 'POST',
			url  : 'apagar_cliente.php',
			data : 'id=' + id,
			dataType: 'json',
			success :  function(response){						
				if(response.codigo == "1"){	
					$("#msg-alert").css('display', 'block');
					$("#msg-alert").css('color', '#000000')
					$("#mensagem").html('<strong>Feito! </strong>' + response.mensagem);
					window.location.href = "listar.php";
				}
				else{			
					$("#msg-alert").css('display', 'block')
					$("#msg-alert").css('color', '#cc3300')
					$("#mensagem").html('<strong>Erro! </strong>' + response.mensagem);
				}
		    }
		});
	});

}); 
</script>