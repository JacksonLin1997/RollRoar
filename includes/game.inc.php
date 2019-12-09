<?php

require "dbh.inc.php";
session_start();
$currentUser = $_SESSION['userUid'];
$currentUserPoint = $_SESSION['userPoints'];

$timeStamp = time();

$gameId = $_GET['gameId'];

if (isset($_POST['poolA-submit'])){

    $amount = $_POST['amount'];

    if ($amount == 0){
        header("location: ../game.php?gameId=$gameId&points=zero");
        exit();
    }
    elseif ($amount > $currentUserPoint){
        header("location: ../game.php?gameId=$gameId&points=not_enough");
        exit();
    }

    $restPoints = $currentUserPoint - $amount;
    
    $sql = "UPDATE games SET poolA = poolA+? WHERE gameId=$gameId";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        echo "SQL error!";
    } else {
        mysqli_stmt_bind_param($stmt, "i", $amount);
        mysqli_stmt_execute($stmt);
    }

    $sql2 = "UPDATE users SET pointsUsers=$restPoints WHERE uidUsers='$currentUser'";
    mysqli_query($conn, $sql2);

    $sql3 = "SELECT buttonA FROM games WHERE gameId=$gameId";
    $result = mysqli_query($conn, $sql3);
    $row = mysqli_fetch_assoc($result);
    $buttonA = $row['buttonA'];
    
    $sql4 = "INSERT INTO history (gameId, person, side, amount, time_stamp) VALUES ($gameId, '$currentUser', '$buttonA', '$amount', '$timeStamp')";
    mysqli_query($conn, $sql4);

    header("location: ../game.php?gameId=$gameId");
    exit();
}
elseif (isset($_POST['poolB-submit'])){

    $amount = $_POST['amount'];

    if ($amount == 0){
        header("location: ../game.php?gameId=$gameId&points=zero");
        exit();
    }
    elseif ($amount > $currentUserPoint){
        header("location: ../game.php?gameId=$gameId&points=not_enough");
        exit();
    }

    $restPoints = $currentUserPoint - $amount;
    
    $sql = "UPDATE games SET poolB = poolB+? WHERE gameId=$gameId";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        echo "SQL error!";
    } else {
        mysqli_stmt_bind_param($stmt, "i", $amount);
        mysqli_stmt_execute($stmt);
    }

    $sql2 = "UPDATE users SET pointsUsers=$restPoints WHERE uidUsers='$currentUser'";
    mysqli_query($conn, $sql2);

    $sql3 = "SELECT buttonB FROM games WHERE gameId=$gameId";
    $result = mysqli_query($conn, $sql3);
    $row = mysqli_fetch_assoc($result);
    $buttonB = $row['buttonB'];

    $sql4 = "INSERT INTO history (gameId, person, side, amount, time_stamp) VALUES ($gameId, '$currentUser', '$buttonB', '$amount', '$timeStamp')";
    mysqli_query($conn, $sql4);

    header("location: ../game.php?gameId=$gameId");
    exit();
}
else {
    header("location: ../game.php");
    exit();
}