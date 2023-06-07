<?php

class Auth
{

    public function isUserLoggedIn() {
        return isset( $_SESSION['user'] ) ? true : false;
    }

    public function login()
    {
        // init the DB class
        $db = new DB();

        $email = $_POST["email"];
        $password = $_POST["password"];

        // 1. make sure all fields are not empty
        if ( empty($email) || empty($password) ) {
            $error = 'All fields are required';
        } else {
            // OOP method
            $user = $db->fetch( 
                "SELECT * FROM users where email = :email", 
                [
                    'email' => $email
                ]
            );

            // make sure the email provided is in the database
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

        // do error checking
        if ( isset( $error ) ) {
            // store the error message in session
            $_SESSION['error'] = $error;
            // redirect the user back to /login
            header("Location: /login");
            exit;
        }
    }

    public function signup()
    {
        // init DB class
        $db = new DB();

        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];

        /* 
            retrieve the user based on the email provided
            to make sure there is no duplication of email in the users table
        */
        // OOP method
        $user = $db->fetch( 
            "SELECT * FROM users where email = :email", 
            [
                'email' => $email
            ]
        );

        // 1. make sure all fields are not empty
        if ( empty( $name ) || empty($email) || empty($password) || empty($confirm_password)  ) {
            $error = 'All fields are required';
        } else if ( $password !== $confirm_password ) {
            // 2. make sure password is match
            $error = 'The password is not match.';
        } else if ( strlen( $password ) < 8 ) {
            // 3. make sure password is at least 8 chars.
            $error = "Your password must be at least 8 characters";
        } else if ( $user ) {
            // 4. make sure email provided is not already exists in the users table
            $error = "The email you inserted has already been used by another user. Please insert another email.";
        }

        // do error checking
        if ( isset( $error ) ) {
            // store the error message in session
            $_SESSION['error'] = $error;
            // redirect the user back to /login
            header("Location: /signup");
            exit;
        }

        // recipe
        $sql = "INSERT INTO users ( `name`, `email`, `password` )
            VALUES (:name, :email, :password)";

        // OOP method
        $db->insert( $sql, [
            'name' => $name,
            'email' => $email,
            'password' => password_hash( $password, PASSWORD_DEFAULT ) // convert user's password to random string
        ] );

        // redirect user back to /
        header("Location: /login");
        exit;
        
    }

    public function logout()
    {
        // remove user session
        unset( $_SESSION['user'] );

        // redirect the user back to /
        header("Location: /");
        exit;
    }
}