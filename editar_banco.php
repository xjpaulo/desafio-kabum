<?php
include "config/verificar_sessao.php";

require 'config/conn.php';

$nome = (isset($_POST['nome'])) ? alfaFormat($_POST['nome']) : '';
$data_nascimento = (isset($_POST['data_nascimento'])) ? dataFormat($_POST['data_nascimento']) : '';
$cpf = (isset($_POST['cpf'])) ? numericoFormat($_POST['cpf']) : '';
$rg = (isset($_POST['rg'])) ? numericoFormat($_POST['rg']) : '';
$telefone = (isset($_POST['telefone'])) ? numericoFormat($_POST['telefone']) : '';
$cep = (isset($_POST['cep'])) ? numericoFormat($_POST['cep']) : '';
$logradouro = (isset($_POST['logradouro'])) ? alfaNumericoFormat($_POST['logradouro']) : '';
$numero = (isset($_POST['numero'])) ? numericoFormat($_POST['numero']) : '';
$complemento = (isset($_POST['complemento'])) ? alfaNumericoFormat($_POST['complemento']) : '';
$bairro = (isset($_POST['bairro'])) ? alfaNumericoFormat($_POST['bairro']) : '';
$cidade = (isset($_POST['cidade'])) ? alfaFormat($_POST['cidade']) : '';
$uf = (isset($_POST['uf'])) ? alfaFormat($_POST['uf']) : '';
$id = (isset($_POST['id'])) ? numericoFormat($_POST['id']) : '';

if ($_POST['botao'] == "salvar")
{
    if (empty($nome)):
        $retorno = array(
            'codigo' => 0,
            'mensagem' => 'O nome é obrigatório!'
        );
        echo json_encode($retorno);
        exit();
    endif;

    if (empty($data_nascimento)):
        $retorno = array(
            'codigo' => 0,
            'mensagem' => 'A data de nascimento é obrigatória!'
        );
        echo json_encode($retorno);
        exit();
    endif;

    if (empty($cpf)):
        $retorno = array(
            'codigo' => 0,
            'mensagem' => 'O CPF é obrigatório!'
        );
        echo json_encode($retorno);
        exit();
    endif;

    if (empty($rg)):
        $retorno = array(
            'codigo' => 0,
            'mensagem' => 'O RG é obrigatório!'
        );
        echo json_encode($retorno);
        exit();
    endif;

    if (empty($telefone)):
        $retorno = array(
            'codigo' => 0,
            'mensagem' => 'O telefone é obrigatório!'
        );
        echo json_encode($retorno);
        exit();
    endif;

    $sql = "UPDATE clientes SET `nome` = ?, `data_nascimento` = ?, `cpf` = ?, `rg` = ?, `telefone` = ? WHERE id = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param("sssssi", $nome, $data_nascimento, $cpf, $rg, $telefone, $id);
    $stm->execute();

    if ($stm->affected_rows)
    {
        $retorno = array(
            'codigo' => 1,
            'mensagem' => 'Cliente <b>' . $nome . '</b> atualizado(a) com sucesso!'
        );
        echo json_encode($retorno);
    }
    else
    {
        $retorno = array(
            'codigo' => 0,
            'mensagem' => 'Não foi possível atualizar.'
        );
        echo json_encode($retorno);
    }
}

if ($_POST['botao'] == "add_endereco")
{
    if (empty($cep)):
        $retorno = array(
            'codigo' => 0,
            'mensagem' => 'O CEP é obrigatório!'
        );
        echo json_encode($retorno);
        exit();
    endif;

    if (empty($logradouro)):
        $retorno = array(
            'codigo' => 0,
            'mensagem' => 'O logradouro é obrigatório!'
        );
        echo json_encode($retorno);
        exit();
    endif;

    if (empty($numero)):
        $retorno = array(
            'codigo' => 0,
            'mensagem' => 'O número é obrigatório!'
        );
        echo json_encode($retorno);
        exit();
    endif;

    if (empty($bairro)):
        $retorno = array(
            'codigo' => 0,
            'mensagem' => 'O bairro é obrigatório!'
        );
        echo json_encode($retorno);
        exit();
    endif;

    if (empty($complemento)):
        $complemento = '-';
    endif;

    if (empty($cidade)):
        $retorno = array(
            'codigo' => 0,
            'mensagem' => 'A cidade é obrigatória!'
        );
        echo json_encode($retorno);
        exit();
    endif;

    if (empty($uf)):
        $retorno = array(
            'codigo' => 0,
            'mensagem' => 'O Estado é obrigatório!'
        );
        echo json_encode($retorno);
        exit();
    endif;

    $sql = "INSERT INTO `clientes_enderecos` (`cep`, `logradouro`, `numero`, `bairro`, `complemento`, `cidade`, `estado`, `clientes_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stm = $conn->prepare($sql);
    $stm->bind_param("sssssssi", $cep, $logradouro, $numero, $bairro, $complemento, $cidade, $uf, $id);
    $stm->execute();

    if ($stm->affected_rows)
    {
        $retorno = array(
            'codigo' => 1,
            'mensagem' => 'Endereço adicionado com sucesso!'
        );
        echo json_encode($retorno);
    }
    else
    {
        $retorno = array(
            'codigo' => 0,
            'mensagem' => 'Não foi possível adicionar.'
        );
        echo json_encode($retorno);
    }
}

function alfaFormat($string)
{
    return preg_replace('/[^A-Za-zÃãÁáÉéÍíÓóôÔÚúÇç ]/', '', $string);
}

function dataFormat($string)
{
    return preg_replace('/[^0-9\/]/', '', $string);
}

function alfaNumericoFormat($string)
{
    return preg_replace('/[^A-Za-z0-9ÃãÁáÉéÍíÓóôÔÚúÇç ]/', '', $string);
}

function numericoFormat($string)
{
    return preg_replace('/[^0-9]/', '', $string);
}

$stm->close();