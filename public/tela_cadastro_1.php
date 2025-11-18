<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - PagTrem</title>
    <link rel="stylesheet" href="../style/combined.css">
</head>
<body>
    <div class="cadastro-container">
        <h1>Cadastro</h1>
        <form method="post" action="salvar_cadastro.php">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" placeholder="Digite aqui..." required>

            <label for="nascimento">Data de nascimento:</label>
            <input type="date" id="nascimento" name="nascimento" required>

            <button type="submit" class="arrow-button">➔</button>
        </form>
    </div>
</body>
</html>
