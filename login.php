<?php
session_start();

require 'config/conn.php';

if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != "http://localhost/desafio/index.php"):
    $retorno = array(
        'codigo' => 0,
        'mensagem' => 'Origem da requisição não autorizada!'
    );
    echo json_encode($retorno);
    exit();
endif;

$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$senha = (isset($_POST['senha'])) ? $_POST['senha'] : '';

if (empty($usuario)):
    $retorno = array(
        'codigo' => 0,
        'mensagem' => 'Preencha um usuário!'
    );
    echo json_encode($retorno);
    exit();
endif;

if (empty($senha)):
    $retorno = array(
        'codigo' => 0,
        'mensagem' => 'Preencha sua senha!'
    );
    echo json_encode($retorno);
    exit();
endif;

$senha = md5($senha);

$sql = 'SELECT id, login, senha FROM usuarios WHERE login = ? AND senha = ?';
$stm = $conn->prepare($sql);
$stm->bind_param('ss', $usuario, $senha);
$stm->execute();
$res = $stm->get_result();
$row = $res->fetch_assoc();

$stm->close();
$conn->close();

if (!empty($res)):
    $_SESSION['user_login'] = $row['login'];
endif;

if (isset($_SESSION['user_login'])):
    $retorno = array(
        'codigo' => 1,
        'mensagem' => 'Logado com sucesso!'
    );
    echo json_encode($retorno);
    exit();
else:
    $retorno = array(
        'codigo' => '0',
        'mensagem' => 'Usuário/Senha incorreto(s)'
    );
    echo json_encode($retorno);
    exit();
endif;

