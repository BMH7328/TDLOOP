<?php

$db = new DB();

$email = $_POST["email"];
$password = $_POST["password"];

if( empty($email) || empty($password)){
    $error = 'Email and Password is Required';
} else {
    $user = $db->fetch( 
        "SELECT * FROM users where email = :email", 
        [
            'email' => $email
        ]
     );
     if ( empty( $user ) ) {
        $error = "The email provided does not exists";
    } else {
        // make sure password is correct
        if ( password_verify( $password, $user["password"] ) ) {
            // if password is valid, set the user session
            $_SESSION["user"] = $user;

            header("Location: /");
            exit;
        } else {
            // if password is incorrect
            $error = "The password provided is not match";
        }
    }
}

if ( isset( $error ) ) {
    // store the error message in session
    $_SESSION['error'] = $error;
    // redirect the user back to /login
    header("Location: /login");
    exit;
}