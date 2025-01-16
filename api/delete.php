<?php
require __DIR__ . '/../crud/crud/src/infraestrutura/basededados/criar-conexao.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    echo json_encode(["erro" => "Método inválido. Utilize o método DELETE para apagar um utilizador."]);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['id'])) {
    echo json_encode(["erro" => "ID não especificado"]);
    exit;
}

$id = $input['id'];

try {
    $sql = "DELETE FROM utilizadores WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(["mensagem" => "Registro excluído com sucesso"]);
    } else {
        echo json_encode(["erro" => "Registro não encontrado para exclusão"]);
    }
} catch (PDOException $e) {
    echo json_encode(["erro" => $e->getMessage()]);
}


//exemplo
//http://localhost:8080/api/delete.php
// {
//     "id": 1
// }