<?php
require('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verifica se os campos estão preenchidos
    if (empty($username) || empty($password)) {
        die("Nome de usuário e senha são obrigatórios.");
    }

    // Hash da senha
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Prepara a consulta SQL
    $sql = "INSERT INTO usuarios (username, password) VALUES (?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            echo "Registro bem-sucedido!";
            header("Location: login.php");
            exit();
        } else {
            echo "Erro ao inserir usuário: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Erro na preparação da consulta: " . $conn->error;
    }

    $conn->close();
} else {
    die("Método de solicitação inválido.");
}
?>
