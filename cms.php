<?php
    require "includes/dbh.inc.php";
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<br>

<nav>
    <a href="home.php">回首頁</a>
</nav>

<br>

<?php

$sql = "SELECT * FROM history ORDER BY gameId, side";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);

if ($resultCheck > 0){

    echo '<table border="1">

        <tr>
            <td>賭局編號</td>
            <td>使用者</td>
            <td>項目</td>
            <td>投注金額</td>
            <td>時間</td>
            <td>結果</td>
        </tr>';

    while ($row = mysqli_fetch_assoc($result)){

        echo '<tr>';
        
        foreach ($row as $key => $value){
            if ($key == 'id'){
                continue;
            }
            elseif ($key == 'time_stamp'){
                date_default_timezone_set("Asia/Taipei");
                $timeStamp = date("Y-m-d H:i:s", $value);
                echo '<td>'.$timeStamp.'</td>';
            }
            else {
                echo '<td>'.$value.'</td>';
            }
        }

        echo '</tr>';
    }
    echo '</table>';
}

?>

<br>

<form action="includes/reward.inc.php" method="post">

    <?php

    if (isset($_GET['gameId'])){

        $gameId = $_GET['gameId'];

        $sql = "SELECT * FROM games WHERE gameId=$gameId";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0){
            echo '<select name="gameId">';
            while ($row = mysqli_fetch_assoc($result)){
                echo '<option value="'.$row['gameId'].'">('.$row['gameId'].') '.$row['gameTitle'].'</option>';
            }
            echo '</select>';
        }

        echo '<button type="submit" name="selectGame">select</button>';
        
        $sql2 = "SELECT buttonA, buttonB FROM games WHERE gameId=$gameId";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        echo '<button type="submit" name="gameoverA">'.$row2['buttonA'].'</button>
            <button type="submit" name="gameoverB">'.$row2['buttonB'].'</button>';
    } else {

        if (isset($_GET['error'])){
            echo '<script language="javascript">
            alert("請挑選預結算之賭局");
            </script>';
        }

        $sql = "SELECT * FROM games";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0){
            echo '<select name="gameId">';
            echo '<option value="0">- 賭局名稱 -</option>';
            while ($row = mysqli_fetch_assoc($result)){
                echo '<option value="'.$row['gameId'].'">('.$row['gameId'].') '.$row['gameTitle'].'</option>';
            }
            echo '</select>';
        }

        echo '<button type="submit" name="selectGame">select</button>';
    }

    ?>

    <br><br>

    <button type="submit" name="reset_history">RESET history</button>
    <button type="submit" name="reset_games">RESET games</button>
</form>

</body>
</html>