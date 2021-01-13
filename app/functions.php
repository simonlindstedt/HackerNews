<?php

declare(strict_types=1);

function redirect(string $path)
{
    header("Location: ${path}");
    exit;
}

//Logic for extracting data from DB and storing in functions for later use.

//Check session for a logged in user
function loggedIn(): bool
{
    return isset($_SESSION['user']);
}

//Counts number of posts posted by current id on session
function postsByCurrentUser(int $usrID, object $pdo): array
{
    $stmnt = $pdo->prepare('SELECT count(posts.user_id) AS userPosts
    FROM posts INNER JOIN users ON users.id=posts.user_id 
    where user_id = :id');
    $stmnt->bindParam(':id', $usrID, PDO::PARAM_INT);
    $stmnt->execute();
    $usr = $stmnt->fetch(PDO::FETCH_ASSOC);
    if ($usr) {
        return $usr;
    }
}
//Counts number of upvotes on posts by current session-id
function currentUserUpvoted(int $usrID, object $pdo): array
{
    $stmnt = $pdo->prepare('SELECT count(upvotes.user_id) AS totalUpvotes
    FROM upvotes INNER JOIN users ON users.id=upvotes.user_id 
    where user_id = :id');
    $stmnt->bindParam(':id', $usrID, PDO::PARAM_INT);
    $stmnt->execute();
    $usr = $stmnt->fetch(PDO::FETCH_ASSOC);
    if ($usr) {
        return $usr;
    }
}


//Checks database for a user connected to the current id on the session
function userById(int $usrID, object $pdo): array
{
    $stmnt = $pdo->prepare('SELECT * FROM users WHERE id = :id');
    $stmnt->bindParam(':id', $usrID, PDO::PARAM_INT);
    $stmnt->execute();
    $usr = $stmnt->fetch(PDO::FETCH_ASSOC);
    if (!$stmnt) {
        die(var_dump($pdo->errorInfo()));
    }
    if ($usr) {
        return $usr;
    }
}

//Getting all posts, and pairing with the usernames of posters.
function postsArray(PDO $pdo): array
{
    $stmnt = $pdo->query('SELECT posts.*, users.username, users.avatar FROM posts 
    INNER JOIN users 
    ON posts.user_id = users.id 
    ORDER BY posts.date DESC');
    if (!$stmnt) {
        die(var_dump($pdo->errorInfo()));
    }
    $stmnt->execute();
    $allPosts = $stmnt->fetchAll(PDO::FETCH_ASSOC);

    return $allPosts;
}

//Logic for the login-system
//Searches database for desired email
function emailTaken(string $email, object $pdo): bool
{

    $stmnt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmnt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmnt->execute();

    $email = $stmnt->fetch(PDO::FETCH_ASSOC);

    if ($email) {
        return true;
    }

    return false;
}

//Searches database for desired username
function handleTaken(string $username, object $pdo): bool
{
    $stmnt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmnt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmnt->execute();

    $user = $stmnt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        return true;
    }
    return false;
}


