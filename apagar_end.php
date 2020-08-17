<?php
include "config/verificar_sessao.php";

require 'config/conn.php';

$id = (isset($_POST['id'])) ? numericoFormat($_POST['id']) : '';

if (empty($id)):
	$retorno = array('codigo' => 0, 'mensagem' => 'O id é obrigatório!');
	echo json_encode($retorno);
	exit();
endif;

$sql_verificar = "select clientes_id from clientes_enderecos where clientes_id = (select clientes_id from clientes_enderecos where id = ?)";
$stm = $conn->prepare($sql_verificar);
$stm->bind_param("i", $id);
$stm->execute();
$stm->store_result();
if ($stm->num_rows == 1) {
	$retorno = array('codigo' => 0, 'mensagem' => 'Ao menos um endereço é obrigatório!');
	echo json_encode($retorno);
	exit();
}
$stm->close();
	
$sql = "DELETE FROM clientes_enderecos WHERE id = ?";
$stm = $conn->prepare($sql);
$stm->bind_param("i", $id);
$stm->execute();

if ($stm->affected_rows) {
    	$retorno = array('codigo' => 1, 'mensagem' => 'Endereço removido com sucesso!');
	echo json_encode($retorno);
} else {
    	$retorno = array('codigo' => 0, 'mensagem' => 'Não foi possível remover.');
	echo json_encode($retorno);
}

function numericoFormat($string) {
   return preg_replace('/[^0-9]/', '', $string);
}

$stm->close();
