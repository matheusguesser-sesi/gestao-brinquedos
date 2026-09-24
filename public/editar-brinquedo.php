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

$sql = "SELECT nome, categoria, faixa_etaria, preco, quantidade_estoque FROM brinquedos WHERE id = ?";
$stmt = mysqli_prepare($conexao, $sql);

if ($stmt === false) {
    die("Erro ao preparar consulta: " . mysqli_error($conexao));
}

mysqli_stmt_bind_param($stmt, 'i', $id);

if (!mysqli_stmt_execute($stmt)) {
    die("Erro ao buscar brinquedo: " . mysqli_stmt_error($stmt));
}

$resultado = mysqli_stmt_get_result($stmt);
$brinquedo = mysqli_fetch_assoc($resultado);
mysqli_stmt_close($stmt);

if ($brinquedo === null) {
    die("Brinquedo não encontrado. <a href='../index.php'>Voltar</a>");
}

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $categoria = trim($_POST['categoria']);
    $faixa_etaria = trim($_POST['faixa_etaria']);
    $preco = trim($_POST['preco']);
    $quantidade_estoque = trim($_POST['quantidade_estoque']);

    $brinquedo['nome'] = $nome;
    $brinquedo['categoria'] = $categoria;
    $brinquedo['faixa_etaria'] = $faixa_etaria;
    $brinquedo['preco'] = $preco;
    $brinquedo['quantidade_estoque'] = $quantidade_estoque;

    if ($nome == "" || $categoria == "" || $faixa_etaria == "" || $preco == "" || $quantidade_estoque == "") {
        $erro = "Preencha todos os campos.";
    } elseif (mb_strlen($nome) > 100 || mb_strlen($categoria) > 100 || mb_strlen($faixa_etaria) > 50) {
        $erro = "Nome e categoria aceitam até 100 caracteres e a faixa etária até 50.";
    } elseif (!is_numeric($preco) || $preco < 0 || $preco > 9999.99) {
        $erro = "O preço deve ser um número entre 0 e 9999.99.";
    } elseif (!ctype_digit($quantidade_estoque) || $quantidade_estoque > 2147483647) {
        $erro = "A quantidade em estoque deve ser um número inteiro maior ou igual a zero.";
    } else {
        $sql = "UPDATE brinquedos SET nome = ?, categoria = ?, faixa_etaria = ?, preco = ?, quantidade_estoque = ? WHERE id = ?";
        $stmt = mysqli_prepare($conexao, $sql);

        if ($stmt === false) {
            die("Erro ao preparar consulta: " . mysqli_error($conexao));
        }

        mysqli_stmt_bind_param($stmt, 'sssdii', $nome, $categoria, $faixa_etaria, $preco, $quantidade_estoque, $id);

        if (mysqli_stmt_execute($stmt)) {
            echo "Brinquedo atualizado!";
            echo "<br><a href='../index.php'>Voltar</a>";
            exit();
        } else {
            $erro = "Erro ao atualizar brinquedo: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Brinquedo</title>
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>

    <main>

        <h1>Editar Brinquedo</h1>

        <a href="../index.php">Voltar para a lista</a>

        <h2>Altere os dados do brinquedo</h2>

        <?php if ($erro != "") { ?>
            <p class="mensagem erro"><?php echo htmlspecialchars($erro); ?></p>
        <?php } ?>

        <form action="editar-brinquedo.php?id=<?php echo $id; ?>" method="POST">

            <div>
                <label for="nome">Nome do brinquedo:</label>
                <input type="text" id="nome" name="nome" maxlength="100"
                       placeholder="Ex.: Carrinho de controle remoto"
                       value="<?php echo htmlspecialchars($brinquedo['nome']); ?>" required>
            </div>

            <div>
                <label for="categoria">Categoria:</label>
                <input type="text" id="categoria" name="categoria" maxlength="100"
                       placeholder="Ex.: Veículos"
                       value="<?php echo htmlspecialchars($brinquedo['categoria']); ?>" required>
            </div>

            <div>
                <label for="faixa_etaria">Faixa etária:</label>
                <input type="text" id="faixa_etaria" name="faixa_etaria" maxlength="50"
                       placeholder="Ex.: 3 a 5 anos"
                       value="<?php echo htmlspecialchars($brinquedo['faixa_etaria']); ?>" required>
            </div>

            <div>
                <label for="preco">Preço (R$):</label>
                <input type="number" id="preco" name="preco" step="0.01" min="0"
                       placeholder="Ex.: 49.90"
                       value="<?php echo htmlspecialchars($brinquedo['preco']); ?>" required>
            </div>

            <div>
                <label for="quantidade_estoque">Quantidade em estoque:</label>
                <input type="number" id="quantidade_estoque" name="quantidade_estoque" step="1" min="0"
                       placeholder="Ex.: 25"
                       value="<?php echo htmlspecialchars($brinquedo['quantidade_estoque']); ?>" required>
            </div>

            <button type="submit">Salvar Alterações</button>

        </form>

    </main>

</body>

</html>