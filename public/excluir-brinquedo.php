<?php

include '../infra/conexao.php';
if (!isset($conexao) || $conexao === false) {
    die("Erro: Conexão com o banco de dados não estabelecida.");
}

mysqli_report(MYSQLI_REPORT_OFF);

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Brinquedo inválido. <a href='../index.php'>Voltar</a>");
}

$id = (int) $_GET['id'];

$sql = "DELETE FROM brinquedos WHERE id = ?";
$stmt = mysqli_prepare($conexao, $sql);

if ($stmt === false) {
    die("Erro ao preparar consulta: " . mysqli_error($conexao));
}

mysqli_stmt_bind_param($stmt, 'i', $id);

if (mysqli_stmt_execute($stmt)) {
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Brinquedo excluído!";
    } else {
        echo "Brinquedo não encontrado.";
    }
    echo "<br><a href='../index.php'>Voltar</a>";
} else {
    echo "Erro ao excluir brinquedo: " . mysqli_stmt_error($stmt);
    echo "<br><a href='../index.php'>Voltar</a>";
}

mysqli_stmt_close($stmt);