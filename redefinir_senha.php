<?php
require 'conexao.php';

$token = $_GET['token'] ?? '';

$stmt = $pdo->prepare("SELECT id FROM usuarios WHERE token_redefinicao = ? AND token_expira > NOW()");
$stmt->execute([$token]);

if ($stmt->rowCount() === 0) {
    die("Link inválido ou expirado.");
}

?>

<form action="atualizar_senha.php" method="POST">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
    <label>Nova senha:</label>
    <input type="password" name="senha" required>
    <button type="submit">Atualizar senha</button>
</form>
