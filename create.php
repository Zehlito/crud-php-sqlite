<?php
// Apenas exibe o formulário para inserir um novo usuário
?>

<h1>Cadastrar Novo Usuário</h1>

<form action="store.php" method="POST">
    <label>Nome:</label>
    <input type="text" name="name" required><br><br>

    <label>Email:</label>
    <input type="email" name="email" required><br><br>

    <button type="submit">Cadastrar</button>
</form>

<br>
<a href="index.php">← Voltar para a lista</a>


