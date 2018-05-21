<?php
include("../connection.php"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

    if(empty(trim($_POST['newpassword'])))
    {
        echo "Il campo <strong>password</strong> è vuoto.";
        exit;
    }
    else if(strlen(trim($_POST['newpassword'])) < PASSWORD_LENGTH)
    {
        echo "La <strong>password</strong> deve avere almeno ". PASSWORD_LENGTH ." caratteri.";
        exit;
    }
    else
    {
        $_POST['newpassword'] = $mysqli->escape_string($_POST['newpassword']);
        $_POST['confirmpassword'] = $mysqli->escape_string($_POST['confirmpassword']);
        $new_password = trim($_POST['newpassword']);
        $confirmpassword = trim($_POST['confirmpassword']);
    }
    
    if ( $new_password == $confirmpassword )  
    { 
        $new_password = trim($_POST['newpassword']);
        $password = password_hash($new_password, PASSWORD_DEFAULT);
        
        $email = $mysqli->escape_string($_GET['email']);
        $hash = $mysqli->escape_string($_GET['hash']);
        
        $sql = "UPDATE Users SET password='$password' WHERE email='$email' AND hash='$hash'";
                 
        if ( $mysqli->query($sql) )
        {
            echo "Hai reimpostato una nuova password!";
        } 
    }
    else
    {
        echo 'La <strong>password</strong> e <strong>conferma password</strong> devono essere uguali.<br>';
    }
}
?>