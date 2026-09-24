<?php

include "infra/conexao.php";

$sql = "SELECT id, nome, categoria, faixa_etaria, preco, quantidade_estoque
        FROM brinquedos
        ORDER BY id DESC";

$brinquedos = mysqli_query($conexao, $sql);

if (!$brinquedos) {
    die("Erro ao listar os brinquedos: " . mysqli_error($conexao));
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Brinquedos</title>
    <link rel="stylesheet" href="style/style.css">
</head>

<body>

    <main>

        <h1>Gerenciar Brinquedos</h1>

        <a href="public/cadastrar-brinquedo.php">Cadastrar Brinquedo</a>
        <br><br>

        <div>

            <h2>Brinquedos Cadastrados</h2>

            <table>

                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Faixa Etária</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Ações</th>
                </tr>

                <?php if (mysqli_num_rows($brinquedos) === 0) { ?>



                <?php } ?>

                <?php while ($brinquedo = mysqli_fetch_assoc($brinquedos)) { ?>

                    <tr>

                        <td>
                            <?php echo $brinquedo["id"]; ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($brinquedo["nome"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($brinquedo["categoria"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($brinquedo["faixa_etaria"]); ?>
                        </td>

                        <td>
                            R$ <?php echo number_format($brinquedo["preco"], 2, ',', '.'); ?>
                        </td>

                        <td>
                            <?php echo $brinquedo["quantidade_estoque"]; ?>
                        </td>

                        <td>
                            <a href="public/editar-brinquedo.php?id=<?php echo $brinquedo["id"]; ?>">
                                Editar
                            </a>

                            <a href="public/excluir-brinquedo.php?id=<?php echo $brinquedo["id"]; ?>"
                               onclick="return confirm('Tem certeza que deseja excluir este brinquedo?');">
                                Excluir
                            </a>
                        </td>

                    </tr>

                <?php } ?>

            </table>

        </div>

    </main>

    <footer>

    </footer>

</body>

</html>