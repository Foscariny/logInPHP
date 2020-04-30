<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./styles/style.css" />
    <title>Registro de Conta</title>
</head>

<body>

    <?php
    date_default_timezone_set("America/Sao_Paulo");
    // Validando os Campos
if(isset($_POST['enviar-formulario'])):

    $erro = 0;

    // Nome

    $nome = $_POST['nome_completo'];

    if(!is_string($nome)){ 
        $erro += 1;         
    }

    // Email

    if(!$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)){
        $erro += 2;
    }


    // Senha

    $senha = $_POST['senha'];
    $senhaConfirmacao = $_POST['senhaConfirmacao'];

    if(strcmp($senha, $senhaConfirmacao)){
        $erro += 4;
    }
    
    // TODOS OS ERROS POSSÍVEIS //

    switch ($erro){

        case 1 : $mensagem = "Nome Inválido!"; 
        break;
        case 2 : $mensagem = "Email Inválido!"; 
        break;
        case 3 : $mensagem = "Nome e Email Inválidos!"; 
        break;
        case 4 : $mensagem = "Senha Incorreta!"; 
        break;
        case 5 : $mensagem = "Nome Inválido e Senha Incorreta!"; 
        break;
        case 6 : $mensagem = "Senha Incorreta e Email Inválido!"; 
        break;
        case 7 : $mensagem = "Senha Incorreta, Nome e Email Inválidos!"; 
        break;
        default: 
            // ENVIO ARQUIVO
                $criaArq = fopen("dados.txt", "a+");
                $login = 0;
                $dados = "$nome|";
                $dados .= "$email|";
                $dados .= md5($senha)."|\n";


    while(!feof($criaArq)){
        $linha = fgets($criaArq, 1024);
        if ($linha==null)break;

        $dado = explode("|", $linha); 
        $nomeJaExistente  = $dado['0'];
        $emailJaExistente = $dado['1'];
        $senhaJaExistente = $dado['2'];
        if( $emailJaExistente == $email){
            $login = 1;
            echo "Email já cadastrado! Favor repetir"; 
            }
    }
        if($login == 0){
            if(fwrite($criaArq,$dados)){
                $mensagem = "Enviado com Sucesso!";
                header('Location:index.php');
                }
                
                else{
                $mensagem = "Erro no Envio!";
                } 
        }

     fclose($criaArq);
}

endif;
?>

    <div id="alertas">

        <h1 id="confirmacao"></h1>
        <h1 id="titulo">Registro de Conta</h1>

    </div>

    <form id="formulario" method="POST" enctype="multipart/form-data">
        <!-- Nome -->
        <label class="labels" for="nomeCompleto">Nome Completo:</label><br>
        <input class="campos" type="text" required="required" name="nome_completo" pattern="^[^-\s][a-zA-ZÀ-ú ]*"
            Placeholder="João Dias"><br>
        <!-- Email -->
        <label class="labels" for="email">Email:</label><br>
        <input class="campos" type="email" required="required" name="email" Placeholder="exemplo@exemplo.com.br"><br>
        <!-- Senha -->
        <div>
            <label class="labels" for="senha">Senha:</label><br>
            <input class="campos" type="password" required="required" name="senha"  minlength="8"><br>
            <label class="labels" for="senha">Repita a Senha:</label><br>
            <input class="campos" type="password" required="required" name="senhaConfirmacao"  minlength="8"><br>
        </div>
        <!-- Botões -->
        <div id="botoes">
            <input class="bot" type="submit" name="enviar-formulario">
            <input class="bot" name="Reset" type="reset" class="formobjects" value="Redefinir">
        </div>
    </form>


    <script type="text/javascript">
        var mensagem = "<?php echo $mensagem;?>";
        document.querySelector("#confirmacao").innerText = mensagem;
    </script>


</body>

</html>