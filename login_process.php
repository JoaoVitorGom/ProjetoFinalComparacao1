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

    // Adiciona mensagens de depuração
    echo "Username recebido: " . htmlspecialchars($username) . "<br>";
    echo "Password recebido: " . htmlspecialchars($password) . "<br>";

    // Prepara a consulta SQL
    $sql = "SELECT id, username, password FROM usuario WHERE username = :username";
    $stmt = $conn->prepare($sql);

    // Verificação de depuração para a preparação da consulta
    if (!$stmt) {
        die("Falha na preparação da consulta: " . implode(" ", $conn->errorInfo()));
    }

    $stmt->bindParam(':username', $username);

    // Verifique se a consulta foi preparada corretamente
    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $stored_password = $user['password'];

            // Verifica a senha sem hash
            if ($password === $stored_password) {
                // Adiciona uma mensagem de depuração
                echo "Login bem-sucedido! Redirecionando para welcome.php...";
                // Redireciona o usuário para a página de boas-vindas com o nome de usuário na URL
                header("Location: loginBemSucedido.php?username=" . urlencode($username));
                exit();
            } else {
                echo "Senha incorreta.";
            }
        } else {
            echo "Nome de usuário não encontrado.";
        }
    } else {
        // Mensagem de erro se a consulta falhar
        echo "Erro na execução da consulta: " . implode(" ", $stmt->errorInfo());
    }
} else {
    echo "Método de requisição inválido.";
}