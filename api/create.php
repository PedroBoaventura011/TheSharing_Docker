<?php
// Inclui o arquivo de conexão com o banco de dados
require __DIR__ . '/../crud/crud/src/infraestrutura/basededados/criar-conexao.php';

// Define o cabeçalho para JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["erro" => "Método inválido. Utilize o método POST para criar um utilizador."]);
    exit;
}

// Obtém os dados enviados no corpo da requisição
$input = json_decode(file_get_contents("php://input"), true);

// Verifica se os dados necessários foram fornecidos
if (!isset($input['nome'], $input['apelido'], $input['nif'], $input['telemovel'], $input['email'])) {
    echo json_encode(["erro" => "Todos os campos (nome, apelido, nif, telemovel, email) são obrigatórios."]);
    exit;
}

// Executa a lógica diretamente no arquivo
try {
    // SQL para inserir os dados
    $sql = "INSERT INTO utilizadores (nome, apelido, nif, telemovel, email) VALUES (:nome, :apelido, :nif, :telemovel, :email)";
    $stmt = $conn->prepare($sql);

    // Liga os parâmetros aos valores recebidos
    $stmt->bindParam(':nome', $input['nome']);
    $stmt->bindParam(':apelido', $input['apelido']);
    $stmt->bindParam(':nif', $input['nif']);
    $stmt->bindParam(':telemovel', $input['telemovel']);
    $stmt->bindParam(':email', $input['email']);
    
    // Executa a query
    $stmt->execute();

    // Retorna mensagem de sucesso
    echo json_encode(["mensagem" => "Registro criado com sucesso"]);
} catch (PDOException $e) {
    // Retorna mensagem de erro, se houver
    echo json_encode(["erro" => $e->getMessage()]);
}

// exemplo:
// http://localhost:8080/api/create.php
// {
//     "id": 8,
//     "nome": "Carlos",
//     "apelido": "Miguel",
//     "nif": 222222222,
//     "telemovel": 911111111,
//     "email": "carlosmiguel@gmail.com"
// }
