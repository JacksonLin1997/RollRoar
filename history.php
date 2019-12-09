<?php
    require "includes/dbh.inc.php";
    session_start();
    if (isset($_SESSION['userUid'])){
        $currentUser = $_SESSION['userUid'];
        $sql = "SELECT pointsUsers FROM users WHERE uidUsers='$currentUser'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $_SESSION['userPoints'] = $row['pointsUsers'];
        $currentUserPoint = $_SESSION['userPoints'];
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"><link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'><link rel="stylesheet" href="./history.css">
        <!-- bootstrap cdn -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <!-- icon cdn-->
        <script src="https://kit.fontawesome.com/0920bde990.js" crossorigin="anonymous"></script>
        <!-- title name-->
        <title>活動紀錄</title>
    </head>
    <body>
        <!-- 上方nav -->
        <nav class="navbar sticky-top navbar-expand-lg navbar-dark">
                <button class="navbar-toggler" id="button01" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                </button>
                <button class="navbar-toggler" id="button02" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navleft collapse navbar-collapse" id="navbarTogglerDemo03"">
    
                        <form class="form-inline">
                                <div class="dropdown">
                                    <a class="dropdown-toggle dropbtn" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Language</a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="#">English</a>
                                        <a class="dropdown-item" href="#">繁體中文</a>
                                    </div>
                                </div>
                                <div class="search">
                                    <span class="fas fa-search" style="color:#707070;padding-left: 15px; padding-right:5px;font-size: 22px"></span>
                                    <input type="text" style="border-color: #707070"> 
                                </div>
                            
                        </form>
                </div>
                <a class="navbar-brand mx-auto" href="index.php"> 
                    <img src="img/logo.png" alt="">
                    <h4>說說</h4></a>
                
                <div class="navright collapse navbar-collapse" id="navbarTogglerDemo02">
                    <form class="form-inline">           
                        <img src="img/coin.png"style="padding: 12px">
                        <?php
                            if (isset($currentUserPoint)){
                                echo '<button type="button" class="btn btn-outline-light" style="border-radius: 20pt;">$ '.$currentUserPoint.'</button>';
                            } else {
                                echo '<button type="button" class="btn btn-outline-light" style="border-radius: 20pt;">$ ???</button>';
                            }
                        ?>
                        <img src="img/vote_noti.png"  style="padding: 12px; height:300%;">
                        <div class="dropdown">
                            <img src="img/vote_user.png" class="dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"style="padding: 12px; height:300%; cursor: pointer;">
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                <?php
                                    if (isset($currentUser)){
                                        echo '<a class="dropdown-item" href="#">'.$currentUser.'</a>';
                                        echo '<a class="dropdown-item" href="login.php?status=logout">登出</a>';
                                    } else {
                                        echo '<a class="dropdown-item" href="login.php">登入</a>';
                                    }
                                ?>
                            </div>
                        </div>
                    </form> 
                </div>           
        </nav>
        <!-- 主要內容 -->
        <div class="container">
            <div class="row">
                    <div class="col-1"></div>
                    <div class="col-10">
                            <br><br>
                            <!-- breadcrumb -->
                            <ol class="breadcrumb" style="background-color: transparent;">
                                <li class="breadcrumb-item"><a href="index.php" style="color: black;"><i class="fas fa-chevron-right"></i>&nbsp&nbsp首頁</a></li>
                                <li class="breadcrumb-item active" aria-current="page">活動紀錄</li>
                            </ol>
                            <!-- title -->
                            <div style="padding: 15pt; text-align: center; "> 
                                <h4>活動紀錄</h4>
                                <hr size="8px" width="80%">   
                            </div>
                    </div>  
                    <div class="col-1"></div>
            </div>
            <!-- 多圖排列 -->
            <?php
                $sql = "SELECT gameId, side, amount, time_stamp, reward FROM history WHERE person='$currentUser'";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);

                if ($resultCheck > 0){
                    while ($row = mysqli_fetch_assoc($result)){

                        $gameId = $row['gameId'];

                        $sql2 = "SELECT * FROM games WHERE gameId=$gameId";
                        $result2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($result2);

                        date_default_timezone_set("Asia/Taipei");
                        $timeStamp = date('Y-m-d H:i:s', $row['time_stamp']);

                        echo 
                        '<div class="row" style="margin-bottom: 15pt;">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <div class="card" style="margin: 0pt; margin-left:10%;margin-right:10%; min-height: 200px;">
                                    <div class="card-body row "style="margin:0px;">
                                        <div class="col-md-4" style="padding: 15px">
                                            <div style="overflow: hidden;">
                                                <img src="gallery/'.$row2['imgFullName'].'" style="height: 180px;">
                                                <button type="button" class="btn btn-light card-money" disabled="disabled" style="position: absolute;right:3px;bottom:10px; border-radius: 20px;"><img src="img/coin.png"style="width:20px; height:20px;"> '.$row['amount'].'</button>
                                            </div>
                                        </div>
                                        <div class="col-md-8"style="padding: 15px">
                                            <div>
                                                <h5 class="card-title">'.$row2['gameTitle'];
                                                    if (isset($row['reward'])){
                                                        if ($row['reward'] == 0){
                                                            echo 
                                                            '<button type="button" id="lose" class="btn btn-success" disabled="disabled" style="float: right; border-radius:20pt ;">
                                                                <img src="img/flame.png" style="width:20px; height:20px;">敗 +0
                                                            </button>';
                                                        } else {
                                                            echo 
                                                            '<button type="button" id="win" class="btn btn-success" disabled="disabled" style="float: right; border-radius:20pt ;">
                                                                <img src="img/flame.png" style="width:20px; height:20px;">勝 +'.$row['reward'].'
                                                            </button>';
                                                        }
                                                    } else {
                                                        echo 
                                                        '<button type="button" id="lose" class="btn btn-success" disabled="disabled" style="float: right; border-radius:20pt ;">
                                                            <img src="img/flame.png" style="width:20px; height:20px;">尚未揭曉
                                                        </button>';
                                                    }
                                                echo 
                                                '</h5>
                                                <div class="clock" style="font-size: 9pt; margin-right: 4pt">
                                                        <span class="far fa-clock"style="padding-right: 2px"></span>'.$timeStamp.'</div>
                                                <p class="card-text" style="margin-top: 5px">'.$row2['gameDesc'].'</p>
                                            </div>
                                        </div>     
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                }    
            ?>
            <!-- <div class="row"style="margin-bottom: 15pt;">
                    <div class="col-1"></div>
                    <div class="col-10">
                            <div class="card" style="margin: 0pt; margin-left:10%;margin-right:10%; min-height: 200px;">
                                    <div class="card-body row "style="margin:0px;">
                                        <div class="col-md-4" style="padding: 15px">
                                            <div style="overflow: hidden;">
                                                <img src="img/main_pic1.png" style="height: 180px;">
                                                <button type="button" class="btn btn-light card-money" disabled="disabled" style="position: absolute;right:3px;bottom:10px; border-radius: 20px;"><img src="img/coin.png"style="width:20px; height:20px;"> 1,500</button>
                                            </div>
                                        </div>
                                        <div class="col-md-8"style="padding: 15px">
                                            <div>
                                                <h5 class="card-title">文字標題
                                                    <button type="button" id="lose" class="btn btn-success" disabled="disabled" style="float: right; border-radius:20pt ;">
                                                        <img src="img/flame.png" style="width:20px; height:20px;">敗 -150
                                                    </button>
                                                </h5>
                                                <div class="clock" style="font-size: 9pt; margin-right: 4pt">
                                                        <span class="far fa-clock"style="padding-right: 2px"></span>2019.11.10-2019.11.12</div>
                                                <p class="card-text"style="margin-top: 5px">南方澳大橋為跨越臺灣宜蘭縣蘇澳鎮南方澳漁港的跨港大橋，串聯南方澳環狀路線的重要建設，亦是當地的著名地標。</p>
                                            </div>
                                        </div>     
                                    </div>
                            </div>
                    </div>
            </div> -->
        </div>
    </body>
    <!-- 下方聯絡資料 -->
    <footer class="navbar-static-bottom">
            <div class="navleft">
                    <p class="footer-element">&copy; 2019 CHJB App Name</p>
            </div>
            <div class="navright">
                <form class="form-inline">
                    <p class="footer-element">
                        | &emsp; Contact Us
                    </p>
                    <p class="footer-element">
                        <img src="img/vote_email.png" alt="">  talktalk@gmail.com
                    </p>
                    <p class="footer-element">
                        <img src="img/vote_fb.png" alt="">  說說  talktalk
                    </p>
                </form>
            </div>
    </footer>
</html>