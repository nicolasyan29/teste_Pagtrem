<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - PagTrem</title>
    <link rel="stylesheet" href="../style/combined.css">
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <form method="post" action="autenticar.php">
            <label for="usuario">Usuário:</label>
            <input type="text" id="usuario" name="usuario" placeholder="Digite aqui..." required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Digite aqui..." required>

            <button type="submit">Fazer login</button>
        </form>
    </div>
</body>
</html>
