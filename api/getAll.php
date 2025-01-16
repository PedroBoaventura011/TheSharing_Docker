<?php
require __DIR__ . '/../crud/crud/src/infraestrutura/basededados/criar-conexao.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(["erro" => "Método inválido. Utilize o método GET para buscar todos os utilizadores."]);
    exit;
}

try {
    $sql = "SELECT * FROM utilizadores";
    $stmt = $conn->query($sql);
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($dados);
} catch (PDOException $e) {
    echo json_encode(["erro" => $e->getMessage()]);
}

//exemplo
// http://localhost:8080/api/getall.php
