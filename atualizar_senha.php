<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE token_redefinicao = ? AND token_expira > NOW()");
    $stmt->execute([$token]);

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch();
        $stmt = $pdo->prepare("UPDATE usuarios SET senha = ?, token_redefinicao = NULL, token_expira = NULL WHERE id = ?");
        $stmt->execute([$senha, $user['id']]);
        echo "Senha atualizada com sucesso!";
    } else {
        echo "Token inválido ou expirado.";
    }
}
