<?php
//include("../connection.php"); 
include("/web/htdocs/www.danielemanzi.it/home/2-socialnetwork/connection.php");
//include $_SERVER["DOCUMENT_ROOT"]."/2-socialnetwork/connection.php"; 

$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){   // Processing form data when form is submitted
 
 // USERNAME validation
    if(empty(trim($_POST["username"]))){
        $username_err = "Per favore inserisce un username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM Users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql))
        {
            $stmt->bind_param("s", $username);  // Bind variables to the prepared statement as parameters
            
            $_POST["username"] = $mysqli->escape_string($_POST['username']); // Escape variables to protect against SQL injections
        
            $username = trim($_POST["username"]);  // Set parameters
            
            // Attempt to execute the prepared statement
            if($stmt->execute())
            {
                $stmt->store_result(); // store result
                
                if($stmt->num_rows == 1)
                {
                    $username_err = "Questo username non è libero!";
                } 
            } 
            else
            {
                echo "Oops! Qualcosa è andato storto. Prova più tardi.";
            }
        }
        $stmt->close();  // Close statement
    }    
    

    // EMAIL validation
    if(empty(trim($_POST["email"]))){
        $email_err = "Per favore inserisci un email.";
    } 
    else
    {
        $_POST['email'] = $mysqli->escape_string($_POST['email']);
        $email = trim($_POST["email"]);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL); // Remove all illegal characters from email

        // Validate e-mail
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
             $email_err = $email . " non è un email valida";
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
                        $email_err = "Questa email è già presa.";
                    } 
                } 
                else
                {
                    echo "Oops! Qualcosa è andato storto. Prova più tardi.";
                }
            }
            $stmt->close();  // Close statement    
        }
    }    
    
    
    // PASSWORD validation
    if(empty(trim($_POST['password']))){
        $password_err = "Per favore inserisci una Password.";     
    } elseif(strlen(trim($_POST['password'])) < 6){
        $password_err = "La Password deve avere almeno 6 caratteri.";
    } else{
        $_POST['password'] = $mysqli->escape_string($_POST['password']);
        $password = trim($_POST['password']);
    }
    
    // PASSWORD CONFIRM validation
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = 'Per favore conferma la Password.';     
    } else{
        $_POST['confirm_password'] = $mysqli->escape_string($_POST['confirm_password']);
        $confirm_password = trim($_POST['confirm_password']);
        if($password === $confirm_password)
        {
             $password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
        }
        else
        {
            $confirm_password_err = 'Le due Password non sono uguali.';
        }
    }
    
    
    
    if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) // se non ci sono errori
    {
        $hash = $mysqli->escape_string( md5( rand(0,1000) ) );
        $sql = "INSERT INTO Users (username, email, password, hash) VALUES (?, ?, ?, ?)";  // Prepare an insert statement
         
        if($stmt = $mysqli->prepare($sql))
        {
            $stmt->bind_param("ssss", $username,  $email, $password, $hash); 
 
            if($stmt->execute()){
               
                $_SESSION['active'] = 0; //0 until user activates their account with verify.php
                $_SESSION['logged_in'] = true; // So we know the user has logged in
                $_SESSION['message'] = "Un link di conferma è stato mandato alla tuo indirizzo email $email, per verificare il tuo account
                clicca sul link che trovi nella mail che ti abbiamo inviato!";
                
                // Send registration confirmation link (verify.php)
                $to      = $email;
                $subject = 'Account Verification ( lanazione.it )';
                $message_body = '
                Ciao '.$username.',

                Grazie per esserti registrato!
                
                Per favore clicca su questo link per attivare il tuo account: 
                
                https://www.danielemanzi.it/2-socialnetwork?page=verify&email='.$email.'&hash='.$hash;
               // https://www.danielemanzi.it/2-socialnetwork/index.php?page=verify&email='.$email.'&hash='.$hash;
              //  http://danielemanzidomain-com.stackstaging.com/giornale?page=verify&email='.$email.'&hash='.$hash;  
                

                mail( $to, $subject, $message_body );
                
                echo  $_SESSION['message'];
            } else{
                echo "Qualcosa è andato storto. Per favore prova più tardi.";
            }
        }
        $stmt->close();   // Close statement
    }
    else
    {
        echo "Ci sono i seguenti errori:<br>". $username_err ."<br>". $email_err ."<br>". $password_err ."<br>". $confirm_password_err;
    }
    $mysqli->close(); // Close connection
}
?>

    
    


