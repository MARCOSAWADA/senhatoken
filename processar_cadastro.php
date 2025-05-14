<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email']));
    $senha = trim($_POST['senha']);

    if (!$email || !$senha) {
        exit('Preencha todos os campos.');
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Verifica se o e-mail já existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        exit('E-mail já cadastrado.');
    }

    // Insere usuário
    $stmt = $pdo->prepare("INSERT INTO usuarios (email, senha) VALUES (?, ?)");
    if ($stmt->execute([$email, $senhaHash])) {
        exit('Cadastro realizado com sucesso!');
    } else {
        exit('Erro ao cadastrar.');
    }
}
