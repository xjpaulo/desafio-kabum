<?php
include "config/verificar_sessao.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gerenciamento de Clientes :: Cadastrar</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="config/style.css">
</head>
<body>   
<div id="myDiv" class="myDiv">    
	<div class="headerDiv"><h2>Cadastro</h2></div>
		<div id="msg-alert">
			<span id="mensagem"></span>
		</div>
	<p></p>
<form id="cadastro-form" action="cadastrar.php" method="post">
	<table width="100%" class="tableIn">
		<tr><th align=left colspan=4><b> Dados Pessoais </b></th></tr>
		<tr>
			<td width="40%">Nome</td><td align=left><input id="nome" name="nome" type="text" required/></td>
		</tr>
		<tr>
			<td>Data de Nascimento</td><td align=left><input class="onlyNumbers" id="data_nascimento" name="data_nascimento" type="text" onkeyup="mascara_data(this, this.value)" maxlength="10" required/></td>
		</tr>
		<tr>
			<td>CPF</td><td align=left><input class="onlyNumbers" id="cpf" name="cpf" type="text" maxlength="11" required/></td>
		</tr>
		<tr>
			<td>RG</td><td align=left><input class="onlyNumbers" id="rg" name="rg" type="text" maxlength="14" required/></td>
		</tr>
		<tr>
			<td>Telefone</td><td align=left><input class="onlyNumbers" id="telefone" name="telefone" type="text" maxlength="14" required/></td>
		</tr>
		<tr><th align=left colspan=4><b> Endereço </b></th></tr>
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
				</table><table align="center">
		<tr><td align=center><p></p><button type="button" class="myButton" name="cadastrar" id="cadastrar">Cadastrar</button></td></tr>
	</table>
				
</form><br><br><br>
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

	$("#cadastrar").click(function(){
		var data = $("#cadastro-form").serialize();
			
		$.ajax({
			type : 'POST',
			url  : 'cadastrar.php',
			data : data,
			dataType: 'json',
			beforeSend: function()
			{	
				$("#cadastrar").html('Validando ...');
			},
			success :  function(response){						
				if(response.codigo == "1"){	
					$("#cadastrar").html('Cadastrar');
					$("#msg-alert").css('display', 'block');
					$("#msg-alert").css('color', '#000000')
					$("#mensagem").html('<strong>Feito! </strong>' + response.mensagem);
				}
				else{			
					$("#cadastrar").html('Cadastrar');
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
});
</script>