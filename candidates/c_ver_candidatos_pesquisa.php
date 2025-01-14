<?php
// Conexão com o banco de dados
$conn = mysqli_connect("localhost", "root", "12345", "emprega_mais");
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

// Verifica se o id da vaga foi enviado via GET
$id_vaga = isset($_GET['id']) ? $_GET['id'] : '';

if (!empty($id_vaga)) {
    // Busca as informações da vaga com base no ID
    $sql_vaga = "SELECT id, nome, empresa FROM vagas WHERE id = ?";
    $stmt = $conn->prepare($sql_vaga);
    $stmt->bind_param("i", $id_vaga);
    $stmt->execute();
    $result_vaga = $stmt->get_result();

    if ($result_vaga->num_rows > 0) {
        $vaga = $result_vaga->fetch_assoc();
        echo "<div class='infos'>";
            echo "<p class='vaga-id'>ID da vaga: " . htmlspecialchars($vaga['id']) . "</p>";
            echo "<p class='nome-id'>Vaga: " . htmlspecialchars($vaga['nome']) . "</p>";  
            echo "<p class='empresa-id'>Empresa: " . htmlspecialchars($vaga['empresa']) . "</p>";
        echo "</div>";
    } else {
        echo "<p>Vaga não encontrada.</p>"; // Mensagem clara se a vaga não for encontrada
    }
    $stmt->close();
}
?>