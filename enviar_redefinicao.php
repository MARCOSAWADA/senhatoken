<?php
require 'conexao.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = strtolower(trim($_POST['email']));
    

    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        $token = bin2hex(random_bytes(32));
        $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $stmt = $pdo->prepare("UPDATE usuarios SET token_redefinicao = ?, token_expira = ? WHERE email = ?");
        $stmt->execute([$token, $expira, $email]);

        $link = "http://localhost/senhatoken/redefinir_senha.php?token=$token";

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.seuservidor.com'; // configure com seu SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'seu@email.com';
        $mail->Password = 'sua_senha';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('no-reply@seusite.com', 'Sistema');
        $mail->addAddress($email);
        $mail->Subject = 'Redefinição de Senha';
        $mail->Body = "Clique para redefinir sua senha: $link";

        if ($mail->send()) {
            echo "Instruções enviadas para seu e-mail.";
        } else {
            echo "Erro ao enviar e-mail.";
        }
    } else {
        echo "E-mail não cadastrado.";
    }
}
