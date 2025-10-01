<?php
require 'connection.php';
$connection = new Connection();

// Pega dados do formulário
$id = $_POST['id'] ?? null;
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$colors = $_POST['colors'] ?? []; // array de cores selecionadas

if (!$id || !$name || !$email) {
    die("Dados incompletos.");
}

// Atualiza usuário
$stmt = $connection->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
$stmt->execute([$name, $email, $id]);

// Remove vínculos antigos de cores
$stmt = $connection->prepare("DELETE FROM user_colors WHERE user_id = ?");
$stmt->execute([$id]);

// Insere novos vínculos de cores
$stmt = $connection->prepare("INSERT INTO user_colors (user_id, color_id) VALUES (?, ?)");
foreach ($colors as $color_id) {
    $stmt->execute([$id, $color_id]);
}

// Redireciona de volta para a lista
header("Location: index.php");
exit;
?>
