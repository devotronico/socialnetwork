<?php   
//echo 'U';

include("../connection.php"); 

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) 
{   
    $email = $mysqli->escape_string($_POST['email']);
    $resultEmail = $mysqli->query("SELECT * FROM Users WHERE email='$email'");
    $resultUser = $mysqli->query("SELECT * FROM Users WHERE username='$email'");
    
    if ( $resultEmail->num_rows == 0 && $resultUser->num_rows == 0 ) // User doesn't exist
    { 
        echo "Questo utente non è registrato!";
    }
    else 
    { 
        if ( $resultEmail->num_rows == 1 ) { $user = $resultEmail->fetch_assoc(); } // $user becomes array with user data
        else if ( $resultUser->num_rows == 1 ) { $user = $resultUser->fetch_assoc(); } // $user becomes array with user data
    
        $email = $user['email'];
        $hash = $user['hash'];
        $username = $user['username'];

        $to      = $email;
        $subject = 'Password Reset Link ( solcialnetwork.it )';
        require_once('email-recoverypass.php');
        $message = email_message( $username, $email, $hash ); 
    
        $headers = 'From:noreply@danielemanzi.it' . "\r\n"; // Set from headers
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        
        if ( mail($to, $subject, $message, $headers) ):
            echo "Ti è stata mandata una mail a <strong>$email</strong> per reimpostare la tua password";
        else:
            echo 'Invio email fallito!';
        endif;

        $resultEmail->close();
        $resultUser->close();
    }
}
$mysqli->close();

?>
