<?php
require('src/conexao_bd_login.php');

// Verificação adicional para garantir que a conexão foi estabelecida corretamente
if (!isset($conn)) {
    die("Falha ao conectar ao banco de dados.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepara a consulta SQL para inserir o novo usuário
    $sql = "INSERT INTO usuario (username, password) VALUES (:username, :password)";
    $stmt = $conn->prepare($sql);

    // Verificação de depuração para a preparação da consulta
    if (!$stmt) {
        die("Falha na preparação da consulta: " . implode(" ", $conn->errorInfo()));
    }

    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);

    // Executa a consulta
    if ($stmt->execute()) {
        echo "Usuário cadastrado com sucesso!";
        header("Location: cadastroBemSucedido.php?username=" . urlencode($username));
        exit();
    } else {
        // Mensagem de erro se a consulta falhar
        echo "Erro ao cadastrar o usuário: " . implode(" ", $stmt->errorInfo());
    }
}
