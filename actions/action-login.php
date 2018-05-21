<?php 
include_once("../connection.php"); 
// User login process, checks if user exists and password is correct
$login = $mysqli->escape_string($_POST['email']);
$email = $mysqli->query("SELECT * FROM Users WHERE email='$login'");
$username = $mysqli->query("SELECT * FROM Users WHERE username='$login'");

if ( $email->num_rows == 0 && $username->num_rows == 0 )
{ 
    echo "La tua <strong>username/email</strong> è errata!";
}
else
{ 
    if ( $email->num_rows == 1 ) { $user = $email->fetch_assoc(); } // $user becomes array with user data
    else if ( $username->num_rows == 1 ) { $user = $username->fetch_assoc(); } // $user becomes array with user data
    
    if ( password_verify($_POST['password'], $user['password']) )
    {
        if ( $user['active'] == 0 )
        {
            $email = $user['email'];
            $hash = $user['hash'];
            // PREPARA EMAIL
            $to      = $email;
            $subject = 'Account Verification ( solcialnetwork.it )';
            $message = '
            Ciao '.$username.',

            Grazie per esserti registrato!

            Per favore clicca su questo link per attivare il tuo account: 

            https://www.danielemanzi.it/2-socialnetwork/?log=verify&email='.$email.'&hash='.$hash;   

            $headers = 'From:noreply@danielemanzi.it' . "\r\n"; 

            mail( $to, $subject, $message, $headers );

            echo "Prima di loggarti ti chiediamo di confermare la tua iscrizione.<br>
            Un link di conferma è stato mandato alla tua casella di posta <strong>$email</strong>,<br>
            per verificare il tuo account clicca sul link che trovi nella mail che ti abbiamo inviato!";  
        }
        else
        {   
            $_SESSION['id'] = $user['id']; 
            $_SESSION['otherid'] = $user['id']; // ID DEGLI ALTRI UTENTI - AL MOMENTO SETTATO COME ID PERSONALE
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['ip'] = $user['ip'];
            $_SESSION['active'] = $user['active'];
         
            echo "Accesso eseguito con successo!";
        }
    }
    else 
    {
        echo "Questa <strong>password</strong> è errata, riprova!";
    }
    $email->close();
    $username->close();
}
$mysqli->close();
?>


