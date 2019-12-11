<?php

require "dbh.inc.php";
session_start();

$gameId = $_POST['gameId'];

$sql_pool = "SELECT buttonA, buttonB, poolA, poolB FROM games WHERE gameId=$gameId";
$result_pool = mysqli_query($conn, $sql_pool);
$row_pool = mysqli_fetch_assoc($result_pool);
$poolA = $row_pool['poolA'];
$poolB = $row_pool['poolB'];
$poolSum = $poolA + $poolB;

$buttonA = $row_pool['buttonA'];
$buttonB = $row_pool['buttonB'];

$commission = 0.01;

if (isset($_POST['selectGame'])){
    if ($_POST['gameId']){
        $gameId = $_POST['gameId'];
        header("location: ../cms.php?gameId=$gameId");
        exit();
    } else {
        header("location: ../cms.php?error=empty_game");
        exit();
    }
}

if (isset($_POST['gameoverA'])){

    $sql_setReward = "UPDATE history SET reward=0 WHERE gameId=$gameId";
    mysqli_query($conn, $sql_setReward);
    
    $sql = "SELECT person, amount FROM history WHERE gameId=$gameId AND side='$buttonA'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0){
        while ($row = mysqli_fetch_assoc($result)){
            $person = $row['person'];
            $amount = $row['amount'];

            $reward = $poolSum * ($amount/($poolA));
            
            $sql2 = "UPDATE history SET reward=$reward WHERE gameId=$gameId AND person='$person'";
            mysqli_query($conn, $sql2);

            $sql3 = "UPDATE users SET pointsUsers=pointsUsers+$reward WHERE uidUsers='$person'";
            mysqli_query($conn, $sql3);
        }
    }

    header("location: ../cms.php");
    exit();
}
elseif (isset($_POST['gameoverB'])){

    $sql_setReward = "UPDATE history SET reward=0 WHERE gameId=$gameId";
    mysqli_query($conn, $sql_setReward);
    
    $sql = "SELECT person, amount FROM history WHERE gameId=$gameId AND side='$buttonB'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0){
        while ($row = mysqli_fetch_assoc($result)){
            $person = $row['person'];
            $amount = $row['amount'];

            $reward = $poolSum * ($amount/($poolB));
            
            $sql2 = "UPDATE history SET reward=$reward WHERE gameId=$gameId AND person='$person'";
            mysqli_query($conn, $sql2);

            $sql3 = "UPDATE users SET pointsUsers=pointsUsers+$reward WHERE uidUsers='$person'";
            mysqli_query($conn, $sql3);
        }
    }

    header("location: ../cms.php");
    exit();
}
// elseif (isset($_POST['reset_history'])){

//     $sql = "UPDATE games SET poolA=0, poolB=0;
//     UPDATE users SET pointsUsers=1000;
//     TRUNCATE TABLE history;";

//     mysqli_multi_query($conn, $sql);

//     header("location: ../cms.php");
//     exit();
// }
// elseif (isset($_POST['reset_games'])){

//     $sql = "TRUNCATE TABLE games";
//     mysqli_query($conn, $sql);

//     header("location: ../cms.php");
//     exit();
// }
elseif (isset($_POST['add_points'])){

    if (!empty($_POST['user_name'])){
        $user_name = $_POST['user_name'];
        if ($user_name == 'daily_bonus'){
            $sql = "UPDATE users SET pointsUsers=pointsUsers+100";
            mysqli_query($conn, $sql);
            header("location: ../cms.php?error=daily_bonus_success");
            exit();
        } else {
            $sql5 = "SELECT * FROM users WHERE uidUsers='$user_name'";
            $result5 = mysqli_query($conn, $sql5);
            $resultCheck5 = mysqli_num_rows($result5);
            if ($resultCheck5 > 0){
                $sql = "UPDATE users SET pointsUsers=pointsUsers+100 WHERE uidUsers='$user_name'";
                mysqli_query($conn, $sql);
                header("location: ../cms.php?error=add_points_success");
                exit();
            } else {
                header("location: ../cms.php?error=user_not_exist");
                exit();
            }
        }
    } else {
        header("location: ../cms.php?error=empty_username");
        exit();
    }
}
else {
    header("location: ../cms.php");
    exit();
}