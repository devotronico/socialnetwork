<?php
include_once("../connection.php"); 


if($_SERVER["REQUEST_METHOD"] == "POST"){   
    
$username = $email = $password = $confirm_password = $message_error = "";
$active = 0;
    
       
    
    // IP ADDRESS
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
    {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    //The value of $ip at this point would look something like: "192.0.34.166"
    $ip = ip2long($ip);
    //The $ip would now look something like: 1073732954
    
        
       
    // USERNAME validation
    if(empty(trim($_POST["username"])))
    {
        $message_error .= "Il campo <strong>username</strong> è vuoto.<br>";
    } 
    else if(!preg_match("/^[A-Za-z0-9\s._-]+$/", $_POST["username"]))  //$username_char_check = "/^[A-Za-z\s._-]+$/";
    {
        $message_error .= "L' <strong>username</strong> che hai inserito non è valida.<br>";  
    }
    else
    {
        $sql = "SELECT id FROM Users WHERE username = ?"; // Prepare a select statement
        
        if($stmt = $mysqli->prepare($sql))
        {
            $stmt->bind_param("s", $username);  // Bind variables to the prepared statement as parameters
            
            $_POST["username"] = $mysqli->escape_string($_POST['username']); // Escape variables to protect against SQL injections
        
            $username = trim($_POST["username"]);  // Set parameters
            
            if($stmt->execute())  // Attempt to execute the prepared statement
            {
                $stmt->store_result(); // store result
                
                if($stmt->num_rows == 1)
                {
                    $message_error .= "L' username <strong>".$username."</strong> è già preso.<br>";
                } 
            } 
            else
            {
                echo "Qualcosa è andato storto. Per favore prova più tardi.";
            }
        }
        $stmt->close();  // Close statement
    }    
    

    // EMAIL validation
    if(empty(trim($_POST["email"]))){
        $message_error .= "Il campo <strong>email</strong> è vuoto.<br>";
    } 
    else
    {
        $_POST['email'] = $mysqli->escape_string($_POST['email']);
        $email = trim($_POST["email"]);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL); // Remove all illegal characters from email

        // Validate e-mail
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
             //$email_err = $email . " non è un email valida";
             $message_error .= "<strong>".$email."</strong> non è un email valida.<br>";
        }
        else
        {
            $sql = "SELECT id FROM Users WHERE email = ?"; // Prepare a select statement

            if($stmt = $mysqli->prepare($sql))
            {
                $stmt->bind_param("s", $email);   // Bind variables to the prepared statement as parameters

                if($stmt->execute())  // Attempt to execute the prepared statement
                { 
                    $stmt->store_result();  // store result
                    
                    if($stmt->num_rows == 1)
                    {          
                        $message_error .= "L' email <strong>".$email."</strong> è già presa.<br>";
                    } 
                } 
                else
                {
                    echo "Qualcosa è andato storto. Per favore prova più tardi.";
                }
            }
            $stmt->close();  // Close statement    
        }
    }    
    
    
    // PASSWORD validation
    if ( empty(trim($_POST['password'])) )
    {
        $message_error .= "Il campo <strong>password</strong> è vuoto.<br>"; 
    } 
    else if ( strlen(trim($_POST['password'])) < PASSWORD_LENGTH )
    {
        $message_error .= "La <strong>password</strong> deve avere almeno ". PASSWORD_LENGTH ." caratteri.<br>";
    } 
    else
    {
        $_POST['password'] = $mysqli->escape_string($_POST['password']);
        $password = trim($_POST['password']);
    }
    
    // PASSWORD CONFIRM validation
    if ( empty(trim($_POST["confirm_password"])) )
    { 
        $message_error .= "Il campo <strong>conferma password</strong> è vuoto.<br>";    
    } 
    else
    {
        $_POST['confirm_password'] = $mysqli->escape_string($_POST['confirm_password']);
        $confirm_password = trim($_POST['confirm_password']);
        if ( $password === $confirm_password )
        {
             $password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
        }
        else
        {
            //$message_error .= 'Le due password non sono uguali.<br>';
            $message_error .= 'La <strong>password</strong> e <strong>conferma password</strong> devono essere uguali.<br>';
        }
    }
    
    
    if ( empty($message_error) ) 
    {
        $hash = $mysqli->escape_string( md5( rand(0,1000) ) );
        //$hash = substr(md5(mt_rand()),0,15);
        $sql = "INSERT INTO Users (username, email, password, ip, hash, active) VALUES (?, ?, ?, ?, ?, ?)";  // Prepare an insert statement
         
        if($stmt = $mysqli->prepare($sql))
        {
            $stmt->bind_param("sssisi", $username, $email, $password, $ip, $hash, $active); 
 
            if($stmt->execute()){                             
                // PREPARA EMAIL
                $to      = $email;
                $subject = 'Account Verification ( solcialnetwork.it )';
             
                              
                require_once('email.php');
                $message = email_message( $username, $email, $hash );             
                                    
                // FUNZIONA
                $headers = 'From:noreply@danielemanzi.it' . "\r\n"; // Set from headers
                $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                
                                                         
                if ( mail($to, $subject, $message, $headers) ):
                    echo "Un link di conferma è stato mandato alla tuo indirizzo email <strong>$email</strong>, per verificare il tuo account
                    clicca sul bottone che trovi nella mail che ti abbiamo inviato!"; 
                else:
                    echo 'Invio email fallito!';
                endif;
            } 
            else
            {
                echo "Qualcosa è andato storto. Per favore prova più tardi.";
            }
        }
        $stmt->close();   // Close statement
    }
    else
    {
        echo "Ci sono i seguenti errori:<br>". $message_error;
    }
    $mysqli->close(); // Close connection
}
?>

    


