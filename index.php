<?php
require 'connection.php';

$connection = new Connection();

// Busca usuários com cores vinculadas
$stmt = $connection->prepare("
    SELECT u.id, u.name, u.email, GROUP_CONCAT(c.name) AS colors
    FROM users u
    LEFT JOIN user_colors uc ON u.id = uc.user_id
    LEFT JOIN colors c ON uc.color_id = c.id
    GROUP BY u.id
");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuários</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">

    <h1 class="mb-4">Usuários</h1>

    <a href="create.php" class="btn btn-success mb-3">+ Novo Usuário</a>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>    
                <th>Nome</th>    
                <th>Email</th>
                <th>Cores</th>
                <th style="width:160px;">Ações</th>    
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user->id) ?></td>
                    <td><?= htmlspecialchars($user->name) ?></td>
                    <td><?= htmlspecialchars($user->email) ?></td>
                    <td><?= htmlspecialchars($user->colors ?: '-') ?></td>
                    <td>
                        <a href="edit.php?id=<?= $user->id ?>"
                           class="btn btn-warning btn-sm">Editar</a>
                        <a href="delete.php?id=<?= $user->id ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Deseja excluir este usuário?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
