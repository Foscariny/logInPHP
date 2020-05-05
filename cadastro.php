<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./styles/style.css" />
    <link rel="icon" type="image/png" href="./imagens/icon.png">
    <script src="https://kit.fontawesome.com/83506e1289.js" crossorigin="anonymous"></script>
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
            echo "<div id='erro'><h1 id='mensagemerro'>Email já cadastrado! Favor repetir</h1></div>"; 
            }
    }
        if($login == 0){
            if(fwrite($criaArq,$dados)){
                $mensagem = "Enviado com Sucesso!";
                echo "<script> window.location.replace('index.php') </script>";
                }
                
                else{
                $mensagem = "Erro no Envio!";
                } 
        }

     fclose($criaArq);
}

endif;
?>

     <div id='erro'><h1 id='mensagemerro'></h1></div>

    <form id="form" method="POST" enctype="multipart/form-data">
    
        <h1 id="titulo"> CADASTRO </h1>

        <!-- Nome -->
        <div class="campos">
        <input class="campos" type="text" required="required" name="nome_completo" pattern="^[^-\s][a-zA-ZÀ-ú ]*" Placeholder="Nome"><br>
        <i class="fas fa-envelope"></i>
        </div> 
        <!-- Email -->
        <div class="campos">
        <input class="campos" type="email" required="required" name="email" placeholder="Email"><br>
        <i class="fas fa-envelope"></i>
        </div> 
        <!-- Senha -->
        <div class="campos">
            <input class="campos" type="password" required="required" name="senha"  minlength="8" placeholder="Senha"><br>
            <i class="fas fa-lock"></i>
        </div> 
        <!-- Senha Confirmar -->
        <div class="campos">
            <input class="campos" type="password" required="required" name="senhaConfirmacao"  minlength="8" placeholder="Confirme a senha"><br>
            <i class="fas fa-unlock"></i>
        </div>
        <!-- Botões -->
        <div class="botao">
            <input class="bot" type="submit" name="enviar-formulario">
        </div>
        <p id="registro"> Já possui uma conta? <a href="index.php">Logue-se</a></p>
    </form>


    <script type="text/javascript">
        var mensagem = "<?php echo $mensagem;?>";
        document.querySelector("#mensagemerro").innerText = mensagem;
    </script>


</body>

</html>