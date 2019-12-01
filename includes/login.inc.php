<?php

if (isset($_POST['login-submit'])){

    require 'dbh.inc.php';

    $mailuid = $_POST['mailuid'];
    $password = $_POST['pwd'];

    if (empty($mailuid) || empty($password)){
        header("location: ../login.php?error=emptyfields");
        exit();
    }
    else {
        $sql = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../login.php?error=sqlerror");
            exit();
        }
        else {

            mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)){
                $pwdCheck = password_verify($password, $row['pwdUsers']);
                if ($pwdCheck == false){
                    header("location: ../login.php?error=wrongpwd");
                    exit();
                }
                else if ($pwdCheck == true){
                    session_start();
                    // $_SESSION['userId'] = $row['idUsers'];
                    $_SESSION['userUid'] = $row['uidUsers'];
                    $_SESSION['userPoints'] = $row['pointsUsers'];

                    $sql = "SELECT * FROM games WHERE gameId=1;";
                    $result = mysqli_query($conn, $sql);
                    $resultCheck = mysqli_num_rows($result);

                    if ($resultCheck > 0){
                        $row = mysqli_fetch_assoc($result);
                        $poolA = $row['poolA'];
                        $poolB = $row['poolB'];
                        $poolSum = $poolA + $poolB;
                        
                        $_SESSION['poolSum'] = $poolSum;
                        $_SESSION['poolA'] = $poolA;
                        $_SESSION['poolB'] = $poolB;
                    }

                    header("location: ../login.php?login=success");
                    exit();
                }
                else {
                    header("location: ../login.php?error=wrongpwd");
                    exit();
                }
            }
            else {
                header("location: ../login.php?error=nouser");
                exit();
            }

        }
    }

}
else {
    header("location: ../login.php");
    exit();
}