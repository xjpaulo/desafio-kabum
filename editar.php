<?php
include "config/verificar_sessao.php";

require 'config/conn.php';

$id = (isset($_GET['id'])) ? numericoFormat($_GET['id']) : '';

function numericoFormat($string)
{
    return preg_replace('/[^0-9]/', '', $string);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gerenciamento de Clientes :: Editar</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="config/style.css">
</head>
<body>   
<div id="myDiv" class="myDiv">    
	<div class="headerDiv"><h2>Editar</h2></div>
		<div id="msg-alert">
			<span id="mensagem"></span>
		</div>
	<p></p>
<?php
$sql = "SELECT id, nome, data_nascimento, cpf, rg, telefone FROM clientes WHERE id = ?";
$stm = $conn->prepare($sql);
$stm->bind_param("i", $id);
$stm->execute();
$res = $stm->get_result();
$row = $res->fetch_assoc();

$sql2 = "SELECT ce.id, ce.clientes_id, ce.cep, ce.logradouro, ce.bairro, ce.numero, ce.complemento, ce.cidade, ce.estado FROM clientes c, clientes_enderecos ce WHERE c.id = ce.clientes_id and ce.clientes_id = ?";
$stm2 = $conn->prepare($sql2);
$stm2->bind_param("i", $id);
$stm2->execute();
$res2 = $stm2->get_result();

if (empty($row['id']))
{ ?>
		Cliente não encontrado.
<?php
}
else
{
?>
<form id="editar-form" action="editar_banco.php" method="post">
	<input id="id" name="id" type="text" value="<?php echo $row['id'] ?>" hidden/>
	<input id="botao" name="botao" type="text" value="" hidden/>
	<table width="100%" class="tableIn">
				<tr>
			<th align=left colspan=4><b> Dados Pessoais </b></th>			
		</tr>
		<tr>
			<td width="40%">Nome</td><td align=left><input id="nome" name="nome" type="text" value="<?php echo $row['nome'] ?>" required/></td>
		</tr>
		<tr>
			<td>Data de Nascimento</td><td align=left><input class="onlyNumbers" id="data_nascimento" name="data_nascimento" type="text" value="<?php echo $row['data_nascimento'] ?>" onkeyup="mascara_data(this, this.value)" maxlength="10" required/></td>
		</tr>
		<tr>
			<td>CPF</td><td align=left><input class="onlyNumbers" id="cpf" name="cpf" type="text" value="<?php echo $row['cpf'] ?>" maxlength="11" required/></td>
		</tr>
		<tr>
			<td>RG</td><td align=left><input class="onlyNumbers" id="rg" name="rg" type="text" value="<?php echo $row['rg'] ?>" required/></td>
		</tr>
		<tr>
			<td>Telefone</td><td align=left><input class="onlyNumbers" id="telefone" name="telefone" type="text" value="<?php echo $row['telefone'] ?>" maxlength="15" required/></td>
		</tr>
		<tr>
			<td colspan=4 align=center><button type="button" class="myButton" name="salvar" id="salvar" value="salvar">Salvar</button></td>
		</tr>
	<?php
    $x = 0;
    while ($row2 = $res2->fetch_assoc())
    {
        $x++;
?>
		<tr>
			<th align=left colspan=3><b> Endereço <?php echo $x ?></b></th><th><a href="#" id="<?php echo $row2['id'] ?>" class="apagar_end" title="Excluir Endereço"><img src="imgs/delete.png" width="20px" height="20px"></a></th>		
		</tr>
		<tr>
			<td align=left colspan=4><?php echo $row2['logradouro'] . ', ' . $row2['numero'] . ' - ' . $row2['bairro'] . ', ' . $row2['cidade'] . ' - ' . $row2['estado'] . ', ' . $row2['cep'] . ' / Complemento: ' . $row2['complemento'] ?></td>
		</tr>
	<?php
    } ?>
		<tr>
			<th align=left colspan=4><b> Adicionar Novo Endereço </b></th>			
		</tr>
		<tr>
			<td width="40%">
		<label for="cep">CEP</label>
			</td>
			<td align=left>
		<input class="onlyNumbers" id="cep" name="cep" type="text" maxlength="8" required/>
			</td>
		</tr>
		<tr>
			<td>
<label for="logradouro">Logradouro</label>
			</td>
			<td align=left>
		<input id="logradouro" name="logradouro" type="text" required/>
			</td>
		</tr>
		<tr>
			<td>
<label for="numero">Número</label>
			</td>
			<td align=left>
		<input class="onlyNumbers" id="numero" name="numero" type="text" required/>
			</td>
		</tr>
		<tr>
			<td>
<label for="complemento">Complemento</label>
			</td>
			<td align=left>
		<input id="complemento" name="complemento" type="text"/>
			</td>
		</tr>
		<tr>
			<td>
<label for="bairro">Bairro</label>
			</td>
			<td align=left>
		<input id="bairro" name="bairro" type="text" required/>
			</td>
		</tr>
		<tr>
		<tr>
			<td>
<label for="cidade">Cidade</label>
			</td>
			<td align=left>
		<input id="cidade" name="cidade" type="text" required/>
			</td>
		</tr>
		<tr>
			<td>
<label for="uf">Estado</label>
			</td>
			<td align=left>
		<select id="uf" name="uf">
			<option value="">--</option>
			<option value="AC">Acre</option>
			<option value="AL">Alagoas</option>
			<option value="AP">Amapá</option>
			<option value="AM">Amazonas</option>
			<option value="BA">Bahia</option>
			<option value="CE">Ceará</option>
			<option value="DF">Distrito Federal</option>
			<option value="ES">Espírito Santo</option>
			<option value="GO">Goiás</option>
			<option value="MA">Maranhão</option>
			<option value="MT">Mato Grosso</option>
			<option value="MS">Mato Grosso do Sul</option>
			<option value="MG">Minas Gerais</option>
			<option value="PA">Pará</option>
			<option value="PB">Paraíba</option>
			<option value="PR">Paraná</option>
			<option value="PE">Pernambuco</option>
			<option value="PI">Piauí</option>
			<option value="RJ">Rio de Janeiro</option>
			<option value="RN">Rio Grande do Norte</option>
			<option value="RS">Rio Grande do Sul</option>
			<option value="RO">Rondônia</option>
			<option value="RR">Roraima</option>
			<option value="SC">Santa Catarina</option>
			<option value="SP">São Paulo</option>
			<option value="SE">Sergipe</option>
			<option value="TO">Tocantins</option>
		</select>
			</td>
		</tr>
		<tr>
			<td colspan=4 align=center><button type="button" class="myButton" name="add_endereco" id="add_endereco" value="add_endereco">Adicionar</button></td>
		</tr>
				</table>
	</form>
	<?php
} ?>
	<br><br><br>
</div>  
</body>
</html>

<script type="text/javascript">
	$("#cep").focusout(function(){
		$.ajax({
			url: 'https://viacep.com.br/ws/'+$(this).val()+'/json/unicode/',
			dataType: 'json',
			success: function(resposta){
				$("#logradouro").val(resposta.logradouro);
				$("#complemento").val(resposta.complemento);
				$("#bairro").val(resposta.bairro);
				$("#cidade").val(resposta.localidade);
				$("#uf").val(resposta.uf);
				$("#numero").focus();
			}
		});
	});
	
	function mascara_data(campo, valor){
  var mydata = '';
  mydata = mydata + valor;
  if (mydata.length == 2){
    mydata = mydata + '/';
    campo.value = mydata;
  }
  if (mydata.length == 5){
    mydata = mydata + '/';
    campo.value = mydata;
  }
}
	
$('document').ready(function(){

	$("#salvar").click(function(){
		document.getElementsByName("botao")[0].value = this.value;
		var data = $("#editar-form").serialize();
			
		$.ajax({
			type : 'POST',
			url  : 'editar_banco.php',
			data : data,
			dataType: 'json',
			beforeSend: function()
			{	
				$("#salvar").html('Validando ...');
			},
			success :  function(response){						
				if(response.codigo == "1"){	
					$("#salvar").html('Salvar');
					$("#msg-alert").css('display', 'block');
					$("#msg-alert").css('color', '#000000')
					$("#mensagem").html('<strong>Feito! </strong>' + response.mensagem);
				}
				else{			
					$("#salvar").html('Salvar');
					$("#msg-alert").css('display', 'block')
					$("#msg-alert").css('color', '#cc3300')
					$("#mensagem").html('<strong>Erro! </strong>' + response.mensagem);
				}
		    }
		});
	});
	
		$("#add_endereco").click(function(){
		document.getElementsByName("botao")[0].value = this.value;
		var data = $("#editar-form").serialize();
			
		$.ajax({
			type : 'POST',
			url  : 'editar_banco.php',
			data : data,
			dataType: 'json',
			beforeSend: function()
			{	
				$("#add_endereco").html('Validando ...');
			},
			success :  function(response){						
				if(response.codigo == "1"){	
					$("#add_endereco").html('Adicionar');
					$("#msg-alert").css('display', 'block');
					$("#msg-alert").css('color', '#000000')
					$("#mensagem").html('<strong>Feito! </strong>' + response.mensagem);
					var x = document.getElementById("id").value;
					window.location.href = "editar.php?id=" + x;
				}
				else{			
					$("#add_endereco").html('Adicionar');
					$("#msg-alert").css('display', 'block')
					$("#msg-alert").css('color', '#cc3300')
					$("#mensagem").html('<strong>Erro! </strong>' + response.mensagem);
				}
		    }
		});
	});
	
		$(".apagar_end").click(function(){
		var id = this.id;
		var x = document.getElementById("id").value;
			
		$.ajax({
			type : 'POST',
			url  : 'apagar_end.php',
			data : 'id=' + id,
			dataType: 'json',
			success :  function(response){						
				if(response.codigo == "1"){	
					$("#msg-alert").css('display', 'block');
					$("#msg-alert").css('color', '#000000')
					$("#mensagem").html('<strong>Feito! </strong>' + response.mensagem);
					window.location.href = "editar.php?id=" + x;
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
	
$(document).ready(function () {
  $(".onlyNumbers").keypress(function (e) {
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
               return false;
    }
   });
	
	   $("#add_more").on('click', function(e){
        e.preventDefault();
        $(".endereco:first").clone().appendTo(".div-endereco");
		$("#myDIV").classList.add("myDiv");
   });
});
</script>