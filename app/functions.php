<?php

declare(strict_types=1);

function redirect(string $path){
    header("Location: ${path}");
    exit;
}


//Logic for the login-system

//Searches database for given email
function emailInUse(string $email, object $pdo): bool{

    $stmnt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmnt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmnt->execute();

    $email = $stmnt->fetch(PDO::FETCH_ASSOC);

    if ($email){
        return true;
    }

    return false;
}

//Searches database for given username
function handleInUse(string $username, object $pdo): bool{
    $stmnt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmnt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmnt->execute();

    $user = $stmnt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        return true;
    }

    return false;
}

//Check if session is logged in on a user

function loggedIn(): bool{

    return isset($_SESSION['user']);

}


