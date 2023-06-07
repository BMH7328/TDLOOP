<?php

    $db = new DB();

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    $user = $db->fetch( 
        "SELECT * FROM users where email = :email", 
        [
            'email' => $email
        ]
    );

    if ( empty( $name ) || empty($email) || empty($password) || empty($confirm_password)  ) {
        $error = 'All fields are required';
    } else if ( $password !== $confirm_password ) {
        $error = 'The password is not match.';
    } else if ( strlen( $password ) < 8 ) {
        $error = "Your password must be at least 8 characters";
    }else if ($user){
        $error = "This email is own by someone, pls try again with another email.";
    } else {

        $sql = "INSERT INTO users ( `name`, `email`, `password` )
            VALUES (:name, :email, :password)";

            $db->insert( $sql, [
                'name' => $name,
                'email' => $email,
                'password' => password_hash( $password, PASSWORD_DEFAULT ) // convert user's password to random string
            ] );

        header("Location: /login");
        exit;
    }   

    if ( isset( $error ) ) {   
        $_SESSION['error'] = $error;
        header("Location: /signup");
        exit;
    }