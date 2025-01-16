<?php
require __DIR__ . '/../crud/crud/src/infraestrutura/basededados/criar-conexao.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(["erro" => "Método inválido. Utilize o método GET para buscar todos os utilizadores."]);
    exit;
}

if (!isset($_GET['id'])) {
    echo json_encode(["erro" => "ID não especificado"]);
    exit;
}

$id = $_GET['id'];

try {
    $sql = "SELECT * FROM utilizadores WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($dados) {
        echo json_encode($dados);
    } else {
        echo json_encode(["erro" => "Registro não encontrado"]);
    }
} catch (PDOException $e) {
    echo json_encode(["erro" => $e->getMessage()]);
}

// exemplo
// http://localhost:8080/api/getbyid.php?id=2