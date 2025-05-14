<?php
$host = 'localhost';
$db = 'security';
$user = 'root'; // ou o usuário do seu MySQL
$pass = '';     // ou a senha, se tiver

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
