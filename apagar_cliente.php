<?php
include "config/verificar_sessao.php";

require 'config/conn.php';

$id = (isset($_POST['id'])) ? numericoFormat($_POST['id']) : '';

if (empty($id)):
	$retorno = array('codigo' => 0, 'mensagem' => 'O id é obrigatório!');
	echo json_encode($retorno);
	exit();
endif;
	
$sql = "DELETE FROM clientes WHERE id = ?";
$stm = $conn->prepare($sql);
$stm->bind_param("i", $id);
$stm->execute();

$sql2 = "DELETE FROM clientes_enderecos WHERE clientes_id = ?";
$stm = $conn->prepare($sql2);
$stm->bind_param("i", $id);
$stm->execute();

if ($stm->affected_rows) {
    	$retorno = array('codigo' => 1, 'mensagem' => 'Cliente removido com sucesso!');
	echo json_encode($retorno);
} else {
    	$retorno = array('codigo' => 0, 'mensagem' => 'Não foi possível remover.');
	echo json_encode($retorno);
}

function numericoFormat($string) {
   return preg_replace('/[^0-9]/', '', $string);
}

$stm->close();