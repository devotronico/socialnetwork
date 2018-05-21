<?php
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']))
{
    $email = $mysqli->escape_string($_GET['email']); 
    $hash = $mysqli->escape_string($_GET['hash']); 
    
    $result = $mysqli->query("SELECT * FROM Users WHERE email='$email' AND hash='$hash' AND active='1'");

    if ( $result->num_rows == 1 )
    { 
         $message = "Questo account è già stato registrato oppure l' URL non è valido!";
    }
    else
    {
        $mysqli->query("UPDATE Users SET active ='1' WHERE email='$email'") or die($mysqli->error); 
        $result = $mysqli->query("SELECT * FROM Users WHERE email='$email'");
        $user = $result->fetch_assoc();
        $_SESSION['id'] = $user['id'];
        $_SESSION["username"] = $user['username'];
        $message = "Il tuo account è stato attivato!";
    }
    $mysqli->close();
}
else
{
    $message = "I parametri per verificare il tuo account sono invalidi!";
}  
?>

<div class="verify-newpass">
    <h5>Verifica registrazione</h5>
    <div class="message">
        <div class="alert <?=$_SESSION["id"]?'alert-success':'alert-danger'?>" role="alert"><?=$message?></div>
    </div>
    <div class="div-float-right">
        <a class="btn btn-primary" href="http://www.danielemanzi.it/2-socialnetwork" role="button">Entra</a>
    </div>
    <div class="div-float-clear"></div>
</div>






