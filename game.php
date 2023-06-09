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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <?php

    if (isset($_GET['gameId'])){
        $gameId = $_GET['gameId'];
    }

    $sql = "SELECT * FROM games WHERE gameId=$gameId";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        echo "SQL statement failed!";
    } else {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        $gameTitle = $row['gameTitle'];
        $gameDesc = $row['gameDesc'];
        $gameAsk = $row['gameAsk'];
        $imgFullName = $row['imgFullName'];

        $buttonA = $row['buttonA'];
        $buttonB = $row['buttonB'];

        $poolA = $row['poolA'];
        $poolB = $row['poolB'];
        $poolSum = $poolA + $poolB;
    }
        
    echo '<title>'.$gameTitle.' | TalkTalk</title>';
    
    ?>

    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/game.css">
</head>
<body>
    
    <div class="header">
        <div class="select_language">
            <a href="#">English</a>
        </div>
        <div class="vertical_line"></div>
        <a href="#"><img src="img/vote_search.png" alt=""></a>
        <input type="text" placeholder="Search...">
        <div class="logo">
            <a href="index.php"><img src="img/logo.png" alt=""> 說說 </a>
        </div>
        <div class="align_right">
            <img src="img/vote_coin.png" alt="">
            <?php
                if (isset($currentUserPoint)){
                    echo '<div class="user_points">'.$currentUserPoint.'</div>';
                } else {
                    echo '<div class="user_points">???</div>';
                }
            ?>
            <a href="#" class="notification"><img src="img/vote_noti.png" alt=""></a>
            <a href="#"><img src="img/vote_user.png" alt=""></a>
        </div>
    </div>

    <div class="subject">
        <?php
            echo 
            '<h1>'.$gameTitle.'</h1>
            <img src="gallery/'.$imgFullName.'" alt="">
            <h3>'.$gameDesc.'</h3>';
        ?>
    </div>

    <div class="voting">
        <div class="main">
            <h2>總獎金</h2>
            <?php
                echo '<div class="pool_total">$ '.$poolSum.'</div>';

                date_default_timezone_set("Asia/Taipei");
                $nowTime = time();
                $expireTime = strtotime($row['expire']);

                $remainTime = $expireTime - $nowTime;
                $remain_minute = floor(($remainTime/60)%60)+1;
                $reamin_hour = floor(($remainTime/3600)%24);
                $remain_day = floor(($remainTime/86400));

                if ($remainTime > 0){
                    echo 
                    '<div class="countdown">
                        <div class="day">'.$remain_day.'
                            <div class="day_text">Day</div>
                        </div>
                        <div class="hour1">'.floor($reamin_hour/10).'
                            <div class="hour_text">Hour</div>
                        </div>
                        <div class="hour2">'.($reamin_hour%10).'</div>
                        <div class="minute1">'.floor($remain_minute/10).'
                            <div class="minute_text">Minute</div>
                        </div>
                        <div class="minute2">'.($remain_minute%10).'</div>
                    </div>';
                } else {
                    echo 
                    '<div class="countdown">
                        <div class="day">0
                            <div class="day_text">Day</div>
                        </div>
                        <div class="hour1">0
                            <div class="hour_text">Hour</div>
                        </div>
                        <div class="hour2">0</div>
                        <div class="minute1">0
                            <div class="minute_text">Minute</div>
                        </div>
                        <div class="minute2">0</div>
                    </div>';
                }
            ?>
        </div>
        <div class="question">
            <div class="align_center">
                <?php
                    echo '<h3>Q: '.$gameAsk.'</h3>';
                ?>
                <hr>
                <div class="chart_wrap">
                    <div class="chart">
                        <?php
                            if ($poolSum == 0){
                                $maxRatio = 0;
                                echo 
                                '<div class="chart1">
                                    <h4>? %</h4>
                                    <img src="img/vote_game1.png" alt="">
                                    <h5>'.$buttonA.'</h5>
                                </div>
                                <div class="chart2">
                                    <h4>? %</h4>
                                    <img src="img/vote_game2.png" alt="">
                                    <h5>'.$buttonB.'</h5>
                                </div>';
                            } else {
                                $poolRatioA = round(($poolA/$poolSum)*100);
                                $poolRatioB = round(($poolB/$poolSum)*100);
                                $maxRatio = max($poolRatioA, $poolRatioB);
                                echo 
                                '<div class="chart1">
                                    <h4>'.$poolRatioA.' %</h4>
                                    <img src="img/vote_game1.png" alt="" style="width: 150px; height: '.(3*$poolRatioA).'px;">
                                    <h5>'.$buttonA.'</h5>
                                </div>
                                <div class="chart2">
                                    <h4>'.$poolRatioB.' %</h4>
                                    <img src="img/vote_game2.png" alt="" style="width: 150px; height: '.(3*$poolRatioB).'px;">
                                    <h5>'.$buttonB.'</h5>
                                </div>';
                            }

                            if ($maxRatio == 0){
                                $gap = 50;
                            } else {
                                $gap = 20 + 80*((100-$maxRatio)/50);
                            }
                        ?>
                    </div>
                </div>
                <?php
                    if (isset($currentUser)){
                        if ($remainTime > 0){
                            $sql = "SELECT person FROM history WHERE person=? AND gameId=$gameId";
                            $stmt = mysqli_stmt_init($conn);
                            if (mysqli_stmt_prepare($stmt, $sql)){
                                mysqli_stmt_bind_param($stmt, "s", $currentUser);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_store_result($stmt);
                                $resultCheck = mysqli_stmt_num_rows($stmt);
                                if ($resultCheck > 0){
                                    echo 
                                    '<div class="vote_button" style="margin-top: '.$gap.'px;">
                                        <img src="img/vote_click.png" alt="">
                                        <div class="vote_text">已下注</div>
                                    </div>';
                                } else {
                                    echo 
                                    '<div class="vote_button" id="myBtn" style="margin-top: '.$gap.'px;">
                                        <img src="img/vote_click.png" alt="">
                                        <div class="vote_text">VOTE</div>
                                    </div>';
                                }
                            }
                        } else {
                            echo 
                            '<div class="vote_button" style="margin-top: '.$gap.'px;">
                                <img src="img/vote_click.png" alt="">
                                <div class="vote_text">已結束</div>
                            </div>';
                        }
                    } else {
                        echo 
                        '<div class="vote_button" onclick="location.href=\'login.php\'" style="margin-top: '.$gap.'px;">
                            <img src="img/vote_click.png" alt="">
                            <div class="vote_text">請先登入</div>
                        </div>';
                    }
                ?>
                <div class="modal" id="myModal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <?php
                            echo '<form name="gamble" action="includes/game.inc.php?gameId='.$gameId.'" method="post">';
                        ?>
                            <input type="text" placeholder="選取金額" name="amount" value='0' readonly>
                            <div class="coin">
                                <input id="coin5" type="button" onclick="gamble.amount.value = eval(gamble.amount.value+='+5')">
                                <input id="coin10" type="button" onclick="gamble.amount.value = eval(gamble.amount.value+='+10')">
                                <input id="coin50" type="button" onclick="gamble.amount.value = eval(gamble.amount.value+='+50')">
                                <input id="coin100" type="button" onclick="gamble.amount.value = eval(gamble.amount.value+='+100')">
                                <input id="coin500" type="button" onclick="gamble.amount.value = eval(gamble.amount.value+='+500')">
                                <input id="coin1000" type="button" onclick="gamble.amount.value = eval(gamble.amount.value+='+1000')">
                                <input id="coin0" type="button" onclick="gamble.amount.value = '0'">
                            </div>
                            <?php
                                if (isset($_GET['points'])){
                                    if ($_GET['points'] == "zero"){
                                        echo '<p>下注金額不得為零</p>';
                                    }
                                    elseif ($_GET['points'] == "not_enough"){
                                        echo '<p>您的剩餘點數不足</p>';
                                    }
                                }
                            ?>
                            <div class="v_button">
                                <div class="win_but1">
                                    <button class="real_but1" name="poolA-submit">
                                        <img src="img/popup_window/window_butt1.png" alt="">
                                        <?php
                                            echo '<div class="but1_text">'.$buttonA.'</div>';
                                        ?>
                                    </button>
                                </div>
                                <div class="win_but2">
                                    <button class="real_but2" name="poolB-submit">
                                        <img src="img/popup_window/window_butt2.png" alt="">
                                        <?php
                                            echo '<div class="but2_text">'.$buttonB.'</div>';
                                        ?>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
            echo '<div class="comment" style="padding-top: '.($gap+100).'px;">';
        ?>
            <div class="section">
                <h1>Message</h1>
                <hr>
                <h2>0 則留言</h2>
                <div class="message">
                    <img src="img/vote_user.png" alt="">
                    <?php
                        if (isset($currentUser)){
                            $sql = "SELECT person FROM history WHERE person=? AND gameId=$gameId";
                            $stmt = mysqli_stmt_init($conn);
                            if (mysqli_stmt_prepare($stmt, $sql)){
                                mysqli_stmt_bind_param($stmt, "s", $currentUser);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_store_result($stmt);
                                $resultCheck = mysqli_stmt_num_rows($stmt);
                                if ($resultCheck > 0){
                                    echo '<input type="text" placeholder="輸入我的留言...">';
                                } else {
                                    echo '<input type="text" placeholder="投票以開啟留言功能！" readonly>';
                                }
                            }
                        } else {
                            echo '<input type="text" placeholder="登入以查看留言版！" readonly>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <img src="img/logo.png" alt="">
        <div class="copyright">
            &copy; 2019 CHJB TalkTalk
        </div>
        <div class="contact">
            <h4>| &emsp; Contact Us</h4>
            <img src="img/vote_email.png" alt="">&ensp;<h5>talktalk@gmail.com</h5>
            <div class="space"></div>
            <img src="img/vote_fb.png" alt="">&ensp;<h6>說說</h6>&nbsp;<h5>TalkTalk</h5>
        </div>
    </div>

    <script>

        var modal = document.getElementById("myModal");
        var btn = document.getElementById("myBtn");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
        modal.style.display = "block";
        }

        span.onclick = function() {
        modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

    </script>

</body>
</html>