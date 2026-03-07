<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BigCell Celulares - Login</title>
    <link rel="stylesheet" href="Source/login.css">
</head>
<body>

    <div class="login-container">
        <h1>BigCell Celulares</h1>

        <form action="login.php" method="POST">

            <div>
                <label for="usuario">Usuário:</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>

            <br>

            <div>
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>

            <br>

            <div>
                <label for="loja">Loja:</label>
                <select id="loja" name="loja">
                    <option value="BigCell">BigCell</option>
                    <option value="Loja1">Loja 1</option>
                    <option value="Loja2">Loja 2</option>
                </select>
            </div>

            <br>

    <div>
    <label for="computador">Computador:</label>
    <input 
        type="text"
        id="computador"
        name="computador"
        inputmode="numeric"
        maxlength="14"
        required
        oninput="this.value = this.value
            .replace(/\D/g,'')
            .replace(/(\d{3})(\d)/,'$1.$2')
            .replace(/(\d{3})\.(\d{3})(\d)/,'$1.$2.$3')
            .replace(/(\d{3})\.(\d{3})\.(\d{3})(\d{1,2})/,'$1.$2.$3-$4')
            .replace(/(-\d{2})\d+?$/,'$1');">
            </div>
            <br>

            <div>
                <input type="checkbox" id="lembrar" name="lembrar">
                <label for="lembrar">Lembrar-me</label>
            </div>

            <br>

            <div>
                <button type="submit">LOGIN</button>
            </div>

        </form>
    </div>

</body>
</html>