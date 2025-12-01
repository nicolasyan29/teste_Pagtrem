
<?php
require_once __DIR__ . '/../public/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user = trim($_POST["username"]);
    $pass = $_POST["senha"];

    $sql = "SELECT * FROM usuarios WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) === 1) {
        $u = mysqli_fetch_assoc($result);

        // login com senha pura
        if ($u["senha"] === $pass) {

            session_regenerate_id(true);
            $_SESSION["user_id"] = $u["id"];
            $_SESSION["username"] = $u["username"];
            $_SESSION["cargo"] = $u["cargo"];

            header("Location: index.php");
            exit;
        }
    }

    $err = "Usuário ou senha inválidos.";
}
?>
