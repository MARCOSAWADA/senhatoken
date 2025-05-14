<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .msg { margin-top: 10px; }
    </style>
</head>
<body>

<h2>Cadastro</h2>

<form id="formCadastro">
    <label for="email">E-mail:</label><br>
    <input type="email" name="email" id="email" required><br><br>

    <label for="senha">Senha:</label><br>
    <input type="password" name="senha" id="senha" required><br><br>

    <button type="submit">Cadastrar</button>
</form>

<div class="msg" id="mensagem"></div>

<script>
document.getElementById('formCadastro').addEventListener('submit', async function(event) {
    event.preventDefault();

    const email = document.getElementById('email').value.trim();
    const senha = document.getElementById('senha').value.trim();
    const mensagem = document.getElementById('mensagem');

    if (!email || !senha) {
        mensagem.innerText = 'Preencha todos os campos.';
        mensagem.style.color = 'red';
        return;
    }

    const formData = new FormData();
    formData.append('email', email);
    formData.append('senha', senha);

    const response = await fetch('processar_cadastro.php', {
        method: 'POST',
        body: formData
    });

    const resultado = await response.text();

    mensagem.innerText = resultado;
    mensagem.style.color = resultado.includes('sucesso') ? 'green' : 'red';
});
</script>

</body>
</html>
