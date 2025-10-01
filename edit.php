<?php
require 'connection.php';
$connection = new Connection();

// Pega o ID da URL
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID inválido.");
}

// Busca o usuário
$stmt = $connection->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$stmt->setFetchMode(PDO::FETCH_OBJ);
$user = $stmt->fetch();

if (!$user) {
    die("Usuário não encontrado.");
}

// Buscar todas as cores disponíveis
$stmt = $connection->prepare("SELECT * FROM colors");
$stmt->execute();
$colors = $stmt->fetchAll(PDO::FETCH_OBJ);

// Buscar cores já vinculadas ao usuário
$stmt = $connection->prepare("SELECT color_id FROM user_colors WHERE user_id = ?");
$stmt->execute([$user->id]);
$user_colors = $stmt->fetchAll(PDO::FETCH_COLUMN);

?>


<h1>Editar Usuário</h1>
<form action="update.php" method="POST">
    <input type="hidden" name="id" value="<?= $user->id ?>">

    <label>Nome:</label>
    <input type="text" name="name" value="<?= $user->name ?>" required><br><br>

    <label>Email:</label>
    <input type="email" name="email" value="<?= $user->email ?>" required><br><br>

    <label>Cores:</label><br>
    <?php foreach ($colors as $color): ?>
        <input type="checkbox" name="colors[]" value="<?= $color->id ?>"
            <?= in_array($color->id, $user_colors) ? 'checked' : '' ?>>
        <?= $color->name ?><br>
    <?php endforeach; ?>
    <br>

    <button type="submit">Salvar Alterações</button>
</form>
