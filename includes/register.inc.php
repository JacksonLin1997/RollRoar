<?php

if (isset($_POST['signup-submit'])){

    require 'dbh.inc.php';

    $username = $_POST['uid'];
    $email = $_POST['mail'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwd-repeat'];

    // default points of first singed up user
    $points = 1000;

    if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)){
        header("location: ../register.php?error=emptyfields&uid=".$username."&mail=".$email);
        exit();
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)){
        header("location: ../register.php?error=invalidmailuid");
        exit();
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("location: ../register.php?error=invalidmail&uid=".$username);
        exit();
    }
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        header("location: ../register.php?error=invaliduid&mail=".$email);
        exit();
    }
    else if ($password !== $passwordRepeat){
        header("location: ../register.php?error=passwordcheck&uid=".$username."&mail=".$email);
        exit();
    }
    else {

        $sql = "SELECT uidUsers FROM users WHERE uidUsers=?";
        $stmt = mysqli_stmt_init($conn);

        $sql2 = "SELECT emailUsers FROM users WHERE emailUsers=?";
        $stmt2 = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql) || !mysqli_stmt_prepare($stmt2, $sql2)){
            header("location: ../register.php?error=sqlerror");
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);

            mysqli_stmt_bind_param($stmt2, "s", $email);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_store_result($stmt2);
            $resultCheck2 = mysqli_stmt_num_rows($stmt2);
            if ($resultCheck > 0){
                header("location: ../register.php?error=usertaken&mail=".$email);
                exit();
            } elseif ($resultCheck2 > 0){
                header("location: ../register.php?error=emailtaken&uid=".$username);
                exit();
            }
            else {

                date_default_timezone_set("Asia/Taipei");
                $register_time = time();

                $sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers, pointsUsers, last_login) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)){
                    header("location: ../register.php?error=sqlerror");
                    exit();
                }
                else {
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "sssii", $username, $email, $hashedPwd, $points, $register_time);
                    mysqli_stmt_execute($stmt);

                    session_start();
                    $_SESSION['userUid'] = $username;
                    $_SESSION['userPoints'] = $points;

                    header("location: ../index.php?signup=success");
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
else {
    header("location: ../register.php");
    exit();
}