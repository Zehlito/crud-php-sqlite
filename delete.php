<?php
require 'connection.php';
$connection = new Connection();

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID inválido.");
}

$stmt = $connection->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php"); // volta para listagem
exit;
