<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./styles/style.css" />
    <title>LOGIN em PHP</title>
</head>

<body>
    <h2>Logue para acessar os Registros de usuários</h2>

    <?php
session_start();
date_default_timezone_set("America/Sao_Paulo");
echo "<div id='form'>";
$nome = "";
if(!isset($_SESSION['email'])){
?>

    <form name="form-usuario" id="form-aluno" method="POST">


        <div class="input">
            <label class="labels" for="email">Email:</label><br>
            <input required name="email" autocomplete="off" type="email"><br>
        </div>
        <div class="input">
            <label class="labels" for="email">Senha:</label><br>
            <input required name="senha" autocomplete="off" type="password"><br>
        </div>

        <div class="input">
            <input type="submit" name="enviar" value="enviar">
        </div>

    </form>
    </div>

    <p> Não tem conta ainda? <a href="cadastro.php">Cadastre-se</a></p>

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
        if( $emailJaExistente == $email && $senha == $senha){
            $login = 1;
            
            $_SESSION["email"]=$_POST['email'];
            /*Recarrega a Página*/
            header("location:index:php");
        }
    }
    if($login == 0){
        echo "<h1> Login incorreto! </h1>";
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

    echo "Bem Vindo ". $nome. " ";
    echo "<a href='index.php?acao=logout' >Logout</a>";

    if(isset($_GET['acao'])){
        if($_GET['acao']=="logout"){
            /*Exclui sessão*/
            unset($_SESSION["email"]);
            header("location:index.php");
        }
    }
}
?>
    <hr />
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
                echo $linha. "<br/>";
            }
        }
    }

?>
</body>

</html>