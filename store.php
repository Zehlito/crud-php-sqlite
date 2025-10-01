<?php
require 'connection.php';
$connection = new Connection();

// Pega dados do formulário
$name  = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;

if (!$name || !$email) {
    die("Preencha todos os campos.");
}

// Insere no banco
$stmt = $connection->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
$stmt->execute([$name, $email]);

// Volta para a lista
header("Location: index.php");
exit;
