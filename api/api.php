<?php
require __DIR__ . '/../crud/crud/src/infraestrutura/basededados/criar-conexao.php';

// Função para buscar todos os utilizadores
function getAllUtilizadores($conn) {
    $sql = "SELECT * FROM utilizadores";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Criar novo utilizador
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nome']) && !isset($_POST['id'])) {
    $nome = $_POST['nome'];
    $apelido = $_POST['apelido'];
    $nif = $_POST['nif'];
    $telemovel = $_POST['telemovel'];
    $email = $_POST['email'];

    try {
        $sql = "INSERT INTO utilizadores (nome, apelido, nif, telemovel, email) 
                VALUES (:nome, :apelido, :nif, :telemovel, :email)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':apelido', $apelido);
        $stmt->bindParam(':nif', $nif);
        $stmt->bindParam(':telemovel', $telemovel);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        echo "Utilizador criado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

// Atualizar utilizador
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $apelido = $_POST['apelido'];
    $nif = $_POST['nif'];
    $telemovel = $_POST['telemovel'];
    $email = $_POST['email'];

    try {
        $sql = "UPDATE utilizadores 
                SET nome = :nome, apelido = :apelido, nif = :nif, telemovel = :telemovel, email = :email
                WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':apelido', $apelido);
        $stmt->bindParam(':nif', $nif);
        $stmt->bindParam(':telemovel', $telemovel);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        echo "Utilizador atualizado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

// Apagar utilizador
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_to_delete'])) {
    $id_to_delete = $_POST['id_to_delete'];

    try {
        $sql = "DELETE FROM utilizadores WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id_to_delete);
        $stmt->execute();
        echo "Utilizador apagado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

// Exibir todos os utilizadores
$utilizadores = getAllUtilizadores($conn);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Utilizadores</title>
</head>
<body>

    <h1>Lista de Utilizadores</h1>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Apelido</th>
            <th>NIF</th>
            <th>Telemóvel</th>
            <th>Email</th>
        </tr>

        <?php foreach ($utilizadores as $utilizador): ?>
            <tr>
                <td><?php echo $utilizador['id']; ?></td>
                <td><?php echo $utilizador['nome']; ?></td>
                <td><?php echo $utilizador['apelido']; ?></td>
                <td><?php echo $utilizador['nif']; ?></td>
                <td><?php echo $utilizador['telemovel']; ?></td>
                <td><?php echo $utilizador['email']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Ações</h2>
    <form method="POST" action="">
        <label for="id_to_delete">ID do Utilizador a Apagar:</label>
        <input type="text" id="id_to_delete" name="id_to_delete" required><br><br>
        <button type="submit" onclick="return confirm('Tem certeza que deseja excluir?')">Deletar</button>
    </form>

    <h2>Atualizar Utilizador</h2>
    <form method="POST" action="">
        <label for="id">ID:</label>
        <input type="text" id="id" name="id" required><br><br>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>
        <label for="apelido">Apelido:</label>
        <input type="text" id="apelido" name="apelido" required><br><br>
        <label for="nif">NIF:</label>
        <input type="text" id="nif" name="nif" required><br><br>
        <label for="telemovel">Telemóvel:</label>
        <input type="text" id="telemovel" name="telemovel" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <button type="submit">Atualizar</button>
    </form>

    <h2>Criar Utilizador</h2>
    <form method="POST" action="">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>
        <label for="apelido">Apelido:</label>
        <input type="text" id="apelido" name="apelido" required><br><br>
        <label for="nif">NIF:</label>
        <input type="text" id="nif" name="nif" required><br><br>
        <label for="telemovel">Telemóvel:</label>
        <input type="text" id="telemovel" name="telemovel" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <button type="submit">Criar</button>
    </form>

</body>
</html>
