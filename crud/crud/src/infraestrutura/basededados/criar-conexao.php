<?php

// # CRIA CONEXÃO COM O PDO UTILIZANDO A BASE DE DADOS SQLITE
// try {
//     $caminhoBD = __DIR__ . '/database.sqlite';
//     $pdo = new PDO('sqlite:' . $caminhoBD);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
// } catch (PDOException $e) {
//     echo "Ocorreu um erro na ligação à base de dados";
//     echo $e->getMessage();
//     file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
//     exit();
// }

try {
    // Caminho para o banco de dados SQLite
    $databasePath = __DIR__ . '/database.sqlite'; // Ajuste o caminho conforme necessário
    $conn = new PDO("sqlite:" . $databasePath);

    // Configura o PDO para lançar exceções em caso de erro
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>

