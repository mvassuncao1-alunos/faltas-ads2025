<?php
// Configurações de conexão
$host = 'localhost';
$dbname = 'bigcellc_ads2025';
$user = 'bigcellc_ads2025';
$pass = 'Ads*2025_';

// Estabelece a conexão usando mysqli
$conn = new mysqli($host, $user, $pass, $dbname);

// Verifica se houve algum erro na conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Define o charset para evitar problemas com acentuação
$conn->set_charset("utf8");

// Consulta no information_schema para obter as tabelas, colunas e tipos
$sql = "SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, COLUMN_TYPE
        FROM information_schema.COLUMNS
        WHERE TABLE_SCHEMA = '" . $conn->real_escape_string($dbname) . "'
        ORDER BY TABLE_NAME, ORDINAL_POSITION";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $current_table = "";
    
    echo "<h1>Estrutura do Banco de Dados: $dbname</h1>";

    // Percorre os resultados e formata a saída em HTML
    while ($row = $result->fetch_assoc()) {
        // Sempre que o nome da tabela mudar, cria um novo bloco
        if ($current_table != $row['TABLE_NAME']) {
            if ($current_table != "") {
                echo "</ul><hr>";
            }
            $current_table = $row['TABLE_NAME'];
            echo "<h3>Tabela: $current_table</h3>";
            echo "<ul>";
        }
        
        // Exibe o campo e o tipo de dado (COLUMN_TYPE traz detalhes como tamanho, ex: varchar(255))
        echo "<li><strong>" . htmlspecialchars($row['COLUMN_NAME']) . "</strong> - " . htmlspecialchars($row['COLUMN_TYPE']) . "</li>";
    }
    echo "</ul><hr>"; // Fecha a última lista

} else {
    echo "<p>Nenhuma tabela encontrada no banco de dados ou o usuário não tem permissão de leitura no information_schema.</p>";
}

// Fecha a conexão
$conn->close();
?>