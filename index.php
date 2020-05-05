<?php session_start();?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./styles/style.css" />
    <link rel="icon" type="image/png" href="./imagens/icon.png">
    <script src="https://kit.fontawesome.com/83506e1289.js" crossorigin="anonymous"></script>

    <title>Login em PHP</title>
</head>

<body>
    <!-- <h2>Acesso ao Registro de usuários</h2> -->

<?php
date_default_timezone_set("America/Sao_Paulo");
echo "<div id='form'>";
$nome = "";
if(!isset($_SESSION['email'])){
?>

    <form name="form-usuario" id="form-aluno" method="POST">

    <h1 id="titulo"> LOGIN </h1>
        <div class="campos">
            <input required name="email" autocomplete="off" type="email" placeholder="Email" ><br>
            <i class="fas fa-envelope"></i>
        </div>
        <div class="campos">
            <input required name="senha" autocomplete="off" type="password" placeholder="Senha" minlength="7"><br>
            <i class="fas fa-unlock-alt"></i>
        </div>

        <div class="botao">
            <input type="submit" name="enviar" value="Enviar">
        </div>

        

    </form>
    <p id="registro"> Não tem conta ainda? <a href="cadastro.php">Cadastre-se</a></p>
    </div>

    

    <?php 
    $usuario = "Indefinido";

    if(isset($_POST['enviar'])){

    // VALIDAÇÃO DE EMAIL //
    if(!$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)){
    }
    // VALIDAÇÃO DE SENHA //
    $senha = md5($_POST['senha']);

    $arquivo = fopen('dados.txt', 'r');
    $login = 0;
    while(!feof($arquivo)){
        $linha = fgets($arquivo, 1024);
        if ($linha==null)break;

        $dado = explode("|", $linha);

        $nomeJaExistente  = $dado['0'];
        $emailJaExistente = $dado['1'];
        $senhaJaExistente = $dado['2'];
        if($senhaJaExistente == $senha && $emailJaExistente == $email){
            $login = 1;
            $_SESSION["email"]=$_POST['email'];
            echo "<meta HTTP-EQUIV='refresh' CONTENT='0';URL=index.php'>";
        }
    }
    if($login == 0){
        echo "<div id='erro'><h1> LOGIN INCORRETO! </h1></div>";
    }
    }
    
}else{
    if(isset($_SESSION['email'])){
    $email = $_SESSION['email'];
    }else{
        $email = "Indefinido";
    }

    $arquivo = fopen('dados.txt', 'r');
    
    while(!feof($arquivo)){
        $linha = fgets($arquivo, 1024);
        if ($linha==null)break;

        $dado = explode("|", $linha);

        $nomeJaExistente  = $dado['0'];
        $emailJaExistente = $dado['1'];
        if( $emailJaExistente == $email){
            $nome = $nomeJaExistente;
        }
    }
    fclose($arquivo);

    echo "<h1 id='titulo2'>Olá ". $nome. "! </h1>";
    echo "<div id='deslogar'><a href='logout.php' >Logout</a>"."</div><br>";
}
?>
    <?php
    $data=date("d/m/Y");
    if(isset($_SESSION['email'])){
        $email = $_SESSION['email'];
    }else{
            $email = "Indefinido";
    }

    $hora=date("h:i:s");

    $str=$data."|".$hora."|". $email ."\n";

    if($file=fopen("usuario.log", 'a')){

        fwrite($file, $str);

        fclose($file);
    }

    if(isset($_SESSION['email'])){
        if($file=fopen("usuario.log", 'r')){
            while($linha=fgets($file)){
                echo "<a class='textos'>".$linha."</a>";
            }
        }
    }

?>
</body>

</html>