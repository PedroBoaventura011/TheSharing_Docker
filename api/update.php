<?php
// Inclui o arquivo de conexão com o banco de dados
require __DIR__ . '/../crud/crud/src/infraestrutura/basededados/criar-conexao.php';

// Define o cabeçalho para JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    echo json_encode(["erro" => "Método inválido. Utilize o método PUT para atualizar um utilizador."]);
    exit;
}

// Obtém os dados enviados no corpo da requisição
$input = json_decode(file_get_contents("php://input"), true);

// Verifica se o ID e os outros campos foram fornecidos
if (!isset($input['id'], $input['nome'], $input['apelido'], $input['nif'], $input['telemovel'], $input['email'])) {
    echo json_encode(["erro" => "Todos os campos (id, nome, apelido, nif, telemovel, email) são obrigatórios."]);
    exit;
}

// Executa a lógica diretamente no arquivo
try {
    // SQL para atualizar os dados
    $sql = "UPDATE utilizadores SET nome = :nome, apelido = :apelido, nif = :nif, telemovel = :telemovel, email = :email WHERE id = :id";
    $stmt = $conn->prepare($sql);

    // Liga os parâmetros aos valores recebidos
    $stmt->bindParam(':id', $input['id'], PDO::PARAM_INT);
    $stmt->bindParam(':nome', $input['nome']);
    $stmt->bindParam(':apelido', $input['apelido']);
    $stmt->bindParam(':nif', $input['nif']);
    $stmt->bindParam(':telemovel', $input['telemovel']);
    $stmt->bindParam(':email', $input['email']);
    
    // Executa a query
    $stmt->execute();

    // Verifica se a atualização afetou alguma linha
    if ($stmt->rowCount() > 0) {
        echo json_encode(["mensagem" => "Registro atualizado com sucesso"]);
    } else {
        echo json_encode(["mensagem" => "Nenhum registro foi atualizado. Verifique se o ID existe."]);
    }
} catch (PDOException $e) {
    // Retorna mensagem de erro, se houver
    echo json_encode(["erro" => $e->getMessage()]);
}

// exemplo
// http://localhost:8080/api/update.php
// {
//     "id": 8,
//     "nome": "João",
//     "apelido": "Miguel",
//     "nif": 222222222,
//     "telemovel": 911111111,
//     "email": "carlosmiguel@gmail.com"
//  }
