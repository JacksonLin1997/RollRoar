<?php
    require "includes/dbh.inc.php";
    session_start();
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- bootstrap cdn -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- title name-->
        <title>主頁</title>
        <link rel="stylesheet" href="index.css">
    </head>

    <body class="background text-type">
        <!-- <div class="container"> -->
            <div class="banner">
                <div class="row upper-nav" style="align-items: center;">
                    <div class="col-sm-1.8">
                        <div class="dropdown">
                            <a class="dropdown-toggle dropbtn" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #edeadb; border-right-style:solid; padding-right:10px; border-width:0.05px; border-right-color: #edeadb;">Language</a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#">English</a>
                                <a class="dropdown-item" href="#">繁體中文</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2.2">
                        <i class="fas fa-search" style="color:#edeadb;padding-left: 15px; padding-right:5px;"></i>
                        <input type="text" style="color:#edeadb; border-radius:10pt; border-block-color: #edeadb; background-color: transparent;"> 
                    </div>
                    <div class="col-sm-4" style="text-align: center; font-size:24px;">
                        <a href="index.php" style="color:#edeadb; text-decoration: none;"><img src="img/logo.png" alt=""> 說說 </a>
                    </div>
                    <div class="col-sm-4">
                        <div style="float: right;">
                            <img src="img/coin.png">
                            <?php
                                if (isset($_SESSION['userPoints'])){
                                    echo '<button type="button" class="btn btn-outline-light" style="border-radius: 20pt;">$ '.$_SESSION['userPoints'].'</button>';
                                } else {
                                    echo '<button type="button" class="btn btn-outline-light" style="border-radius: 20pt;"> ??? </button>';
                                }
                            ?>
                            <a href="#"></a><img src="img/vote_noti.png" style="padding: 12px; height:300%;"></a>
                            <img src="img/vote_user.png" class="dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 12px; height:300%; cursor: pointer;">
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <?php
                                    if (isset($_SESSION['userUid'])){
                                        echo '<a class="dropdown-item" href="#">'.$_SESSION['userUid'].'</a>';
                                        echo '<a class="dropdown-item" href="login.php?status=logout">登出</a>';
                                        echo '<a class="dropdown-item" href="history.php">活動紀錄</a>';
                                    } else {
                                        echo '<a class="dropdown-item" href="login.php">登入</a>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 輪播圖片 -->
            <div class="row">
                <div id="carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carousel" data-slide-to="0" class="active"></li>
                        <!-- <li data-target="#carousel" data-slide-to="1"></li>
                        <li data-target="#carousel" data-slide-to="2"></li>
                        <li data-target="#carousel" data-slide-to="3"></li> -->
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item top_pic active">
                            <img class="d-block w-100" src="img/mvp_bg.jpg" alt="First slide">
                            <div class="carousel-caption d-none d-md-block"></div>
                        </div>
                        <!-- <div class="carousel-item top_pic">
                            <img class="d-block w-100" src="img/main_pic2.png" alt="Second slide">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Second Image</h5>
                                <p>這是第二張圖片</p>
                            </div>
                        </div>
                        <div class="carousel-item top_pic">
                            <img class="d-block w-100" src="img/main_pic3.png" alt="Third slide">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Third Image</h5>
                                <p>這是第三張圖片</p>
                            </div>
                        </div>
                        <div class="carousel-item top_pic">
                            <img class="d-block w-100" src="img/main_pic4.png" alt="Forth slide">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Forth Image</h5>
                                <p>這是第四張圖片</p>
                            </div>
                        </div> -->
                    </div>
                    <!-- <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev" style="color: black;">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a> -->
                </div>
            </div>
            <!-- 各類型圖示 -->
            <div class="container">
                <!-- 我的賭局 -->
                <h4 class="text-type" style="padding-top: 40pt;"><img src="img/main_theme1.png">&nbsp&nbsp我的主題</h4>
                <!-- 多圖輪播 -->
                <div id="carousel_2" class="carousel slide" data-ride="carousel_2">
                    <div class="carousel-inner" >
                        <div class="carousel-item down-item active">
                            <div class="row">
                                <?php
                                    if (isset($_SESSION['userUid'])){
                                        $currentUser = $_SESSION['userUid'];
                                        $sql3 = "SELECT gameId FROM history WHERE person='$currentUser' ORDER BY gameId DESC";
                                        $result3 = mysqli_query($conn, $sql3);
                                        $resultCheck3 = mysqli_num_rows($result3);
                                        if ($resultCheck3 > 0){
                                            while($row3 = mysqli_fetch_assoc($result3)){
                                                $tmpGameId = $row3['gameId'];
                                                $sql = "SELECT * FROM games WHERE gameId=$tmpGameId";
                                                $stmt = mysqli_stmt_init($conn);
                                                if (!mysqli_stmt_prepare($stmt, $sql)){
                                                    echo "SQL statement failed!";
                                                } else {
                                                    mysqli_stmt_execute($stmt);
                                                    $result = mysqli_stmt_get_result($stmt);

                                                    while ($row = mysqli_fetch_assoc($result)){
                                                        echo 
                                                        '<div class="col-md-4" onclick="location.href=\'game.php?gameId='.$row['gameId'].'\'" style="cursor: pointer;">
                                                            <article class="card">
                                                                <img class="card-img-top" src="gallery/'.$row['imgFullName'].'" alt="Card image cap">
                                                                <div class="card-body ">
                                                                    <h5 class="card-title">'.$row['gameTitle'].'</h5>
                                                                    <p class="card-text">'.$row['gameDesc'].'</p>
                                                                    <div class="time-font">
                                                                        <img src="img/main_time.png" alt="">&nbsp'.$row['expire'].'
                                                                    </div>
                                                                    <button type="button" class="btn btn-light" style="border-radius: 20px;"><img src="img/coin.png"> '.($row['poolA']+$row['poolB']).'</button>
                                                                </div>
                                                            </article>
                                                        </div>';
                                                    }
                                                }
                                            }
                                        }
                                    }                              
                                ?>
                                <!-- <div class="col-md-4">                               
                                    <article class="card">
                                        <img class="card-img-top" src="img/main_pic1.png" alt="Card image cap">
                                        <div class="card-body ">
                                            <h5 class="card-title">中華隊加油</h5>
                                            <p class="card-text">中韓大戰誰會贏RRRRRR</p>
                                            <div class="time-font">
                                                <img src="img/main_time.png" alt="">&nbsp2019.11.10-2019.12.25
                                            </div>
                                            <button type="button" class="btn btn-light" style="border-radius: 20px;"><img src="img/coin.png"> 1,500</button>
                                        </div>
                                    </article>
                                </div>                                       
                                <div class="col-md-4">                                        
                                    <article class="card">
                                        <img class="card-img-top" src="img/main_pic2.png" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">砸學校</h5>
                                            <p class="card-text">你好我好大家好</p>
                                            <div class="time-font">
                                                <img src="img/main_time.png" alt="">&nbsp2019.11.10-2019.12.25
                                            </div>
                                            <button type="button" class="btn btn-light" style="border-radius: 20px;"><img src="img/coin.png"> 3,500</button>
                                        </div>
                                    </article>
                                </div>                                        
                                <div class="col-md-4">                                        
                                    <article class="card">
                                        <img class="card-img-top" src="img/main_pic3.png" alt="Card image cap">
                                        <div class="card-body ">
                                            <h5 class="card-title">光年之外</h5>
                                            <p class="card-text">你今天登陸月球了嗎?</p>
                                            <div class="time-font">
                                                <img src="img/main_time.png" alt="">&nbsp2019.11.10-2019.12.25
                                            </div>
                                            <button type="button" class="btn btn-light" style="border-radius: 20px; "><img src="img/coin.png"> 500</button>
                                        </div>
                                    </article>
                                </div> -->
                            </div>
                        </div>
                        <!-- <div class="carousel-item down-item">
                            <div class="row">
                                <div class="col-md-4">                               
                                        <article class="card">
                                            <img class="card-img-top" src="img/main_pic1.png" alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title">中華隊加油</h5>
                                                <p class="card-text">中韓大戰誰會贏RRRRRR</p>
                                                <div class="time-font">
                                                    <img src="img/main_time.png" alt="">&nbsp2019.11.10-2019.12.25
                                                </div>
                                                <button type="button" class="btn btn-light" style="border-radius: 20px;"><img src="img/coin.png"> 1,500</button>
                                            </div>
                                        </article>
                                    </div>                                       
                                    <div class="col-md-4">                                        
                                        <article class="card">
                                            <img class="card-img-top" src="img/main_pic2.png" alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title">砸學校</h5>
                                                <p class="card-text">你好我好大家好</p>
                                                <div class="time-font">
                                                    <img src="img/main_time.png" alt="">&nbsp2019.11.10-2019.12.25
                                                </div>
                                                <button type="button" class="btn btn-light" style="border-radius: 20px;"><img src="img/coin.png"> 3,500</button>
                                            </div>
                                        </article>
                                    </div>                                        
                                    <div class="col-md-4">                                        
                                        <article class="card">
                                            <img class="card-img-top" src="img/main_pic3.png" alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title">光年之外</h5>
                                                <p class="card-text">你今天登陸月球了嗎?</p>
                                                <div class="time-font">
                                                    <img src="img/main_time.png" alt="">&nbsp2019.11.10-2019.12.25
                                                </div>
                                                <button type="button" class="btn btn-light" style="border-radius: 20px;"><img src="img/coin.png"> 500</button>
                                            </div>
                                        </article>
                                    </div>
                            </div>
                        </div> -->
                        <a class="carousel-control-prev down-control" href="#carousel_2" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon dark-arrow-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next down-control" href="#carousel_2" role="button" data-slide="next">
                            <span class="carousel-control-next-icon dark-arrow-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>   
                    </div>
                </div>
                <!-- 熱門主題 -->
                <h4 class="text-type" style="padding-top: 40pt;"><img src="img/main_theme2.png">&nbsp&nbsp熱門主題</h4>
                <!-- 多圖輪播 -->
                <div id="carousel_3" class="carousel slide" data-ride="carousel_3">
                    <div class="carousel-inner" >
                        <div class="carousel-item down-item active">
                            <div class="row">
                                <?php
                                    $sql = "SELECT * FROM games ORDER BY gameOrder DESC";
                                    $stmt = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($stmt, $sql)){
                                        echo "SQL statement failed!";
                                    } else {
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);

                                        while ($row = mysqli_fetch_assoc($result)){
                                            echo 
                                            '<div class="col-md-4" onclick="location.href=\'game.php?gameId='.$row['gameId'].'\'" style="cursor: pointer;">
                                                <article class="card">
                                                    <img class="card-img-top" src="gallery/'.$row['imgFullName'].'" alt="Card image cap">
                                                    <div class="card-body ">
                                                        <h5 class="card-title">'.$row['gameTitle'].'</h5>
                                                        <p class="card-text">'.$row['gameDesc'].'</p>
                                                        <div class="time-font">
                                                            <img src="img/main_time.png" alt="">&nbsp'.$row['expire'].'
                                                        </div>
                                                        <button type="button" class="btn btn-light" style="border-radius: 20px;"><img src="img/coin.png"> '.($row['poolA']+$row['poolB']).'</button>
                                                    </div>
                                                </article>
                                            </div>';
                                        }
                                    }
                                ?>
                                <!-- <div class="col-md-4">                                        
                                    <article class="card">
                                        <img class="card-img-top" src="img/main_pic2.png" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">文字標題</h5>
                                            <p class="card-text">文字內容</p>
                                            <div class="time-font">
                                                <img src="img/main_time.png" alt="">&nbsp2019.11.10-2019.12.25
                                            </div>
                                            <button type="button" class="btn btn-light" style="border-radius: 20px;"><img src="img/coin.png"> 3,500</button>
                                        </div>
                                    </article>
                                </div>                                        
                                <div class="col-md-4">                                        
                                    <article class="card">
                                        <img class="card-img-top" src="img/main_pic3.png" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">文字標題</h5>
                                            <p class="card-text">文字內容</p>
                                            <div class="time-font">
                                                <img src="img/main_time.png" alt="">&nbsp2019.11.10-2019.12.25
                                            </div>
                                            <button type="button" class="btn btn-light" style="border-radius: 20px;"><img src="img/coin.png"> 500</button>
                                        </div>
                                    </article>
                                </div> -->
                            </div>
                        </div>
                        <!-- <div class="carousel-item down-item">
                            <div class="row">
                                <div class="col-md-4">                               
                                    <article class="card">
                                        <img class="card-img-top" src="img/main_pic1.png" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">文字標題</h5>
                                            <p class="card-text">文字內容</p>
                                            <div class="time-font">
                                                <img src="img/main_time.png" alt="">&nbsp2019.11.10-2019.12.25
                                            </div>
                                            <button type="button" class="btn btn-light" style="border-radius: 20px;"><img src="img/coin.png"> 1,500</button>
                                        </div>
                                    </article>
                                </div>                                       
                                <div class="col-md-4">                                        
                                    <article class="card">
                                        <img class="card-img-top" src="img/main_pic2.png" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">文字標題</h5>
                                            <p class="card-text">文字內容</p>
                                            <div class="time-font">
                                                <img src="img/main_time.png" alt="">&nbsp2019.11.10-2019.12.25
                                            </div>
                                            <button type="button" class="btn btn-light" style="border-radius: 20px;"><img src="img/coin.png"> 3,500</button>
                                        </div>
                                    </article>
                                </div>                                        
                                <div class="col-md-4">                                        
                                    <article class="card">
                                        <img class="card-img-top" src="img/main_pic3.png" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">文字標題</h5>
                                            <p class="card-text">文字內容</p>
                                            <div class="time-font">
                                                <img src="img/main_time.png" alt="">&nbsp2019.11.10-2019.12.25
                                            </div>
                                            <button type="button" class="btn btn-light" style="border-radius: 20px;"><img src="img/coin.png"> 500</button>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        </div> -->
                        <a class="carousel-control-prev down-control" href="#carousel_3" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon dark-arrow-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next down-control" href="#carousel_3" role="button" data-slide="next">
                            <span class="carousel-control-next-icon dark-arrow-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>   
                    </div>
                </div>
                <!-- 分類主題 -->
                <div class="row">
                    <h4 class="text-type" style="padding-top: 40pt;"><img src="img/main_theme2.png">&nbsp&nbsp分類主題
                        &nbsp&nbsp&nbsp<button type="button" class="btn btn-dark" style="border-radius: 20px;"><i class="fas fa-sort-amount-down"></i> 排列順序 </button>
                    </h4>
                    
                </div>
                <div>
                    <button type="button" class="btn btn-outline-dark" style="border-radius: 20px;">政治</button>
                    <button type="button" class="btn btn-outline-dark" style="border-radius: 20px;">市場</button>
                    <button type="button" class="btn btn-outline-dark" style="border-radius: 20px;">娛樂</button>
                    <button type="button" class="btn btn-outline-dark" style="border-radius: 20px;">社會</button>
                    <button type="button" class="btn btn-outline-dark" style="border-radius: 20px;">生活風格</button>
                </div>
                <!-- 多圖排列 -->
                <div class="row">
                    <?php
                        $sql = "SELECT * FROM games ORDER BY gameOrder DESC";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)){
                            echo "SQL statement failed!";
                        } else {
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);

                            while ($row = mysqli_fetch_assoc($result)){
                                echo 
                                '<div class="col-md-4" onclick="location.href=\'game.php?gameId='.$row['gameId'].'\'" style="cursor: pointer;">                               
                                    <article class="card">
                                        <img class="card-img-top" src="gallery/'.$row['imgFullName'].'" alt="Card image cap">
                                        <div class="card-body ">
                                            <h5 class="card-title">'.$row['gameTitle'].'</h5>
                                            <p class="card-text">'.$row['gameDesc'].'</p>
                                            <div class="time-font">
                                                <img src="img/main_time.png" alt="">&nbsp'.$row['expire'].'
                                            </div>
                                            <button type="button" class="btn btn-light" style="border-radius: 20px;"><img src="img/coin.png"> '.($row['poolA']+$row['poolB']).'</button>
                                        </div>
                                    </article>
                                </div>';
                            }
                        }
                    ?>
                </div>  
            </div>
            
        <?php
            if (isset($_SESSION['userUid'])){
                if ($_SESSION['userUid'] == "admin"){

                    echo
                    '<div class="gallery-upload">
                        <form action="includes/index.inc.php" method="post" enctype="multipart/form-data">
                            <input type="text" name="filename" placeholder="封面檔名(選填)" style="width: 300px;">
                            <input type="text" name="filetitle" placeholder="賭局標題">
                            <textarea name="filedesc" class="bigger_field" placeholder="賭局描述（ 段落換行之間請使用<br> ）"></textarea>
                            <input type="text" name="fileAsk" placeholder="問句">
                            <div class="both_side">
                                <input type="text" name="button_a" placeholder="A方" style="width: 150px;">
                                <input type="text" name="button_b" placeholder="B方" style="width: 150px;">
                            </div>
                            <input type="text" name="expire" placeholder="下注截止時間" style="width: 250px;"> 格式：2019-12-25 00:00:00
                            <input type="file" name="file">
                            <button type="submit" name="submit">UPLOAD</button>
                            <button type="submit" name="cms">後台</button>
                        </form>
                    </div>';
                }
            }

            if (isset($_GET['upload'])){
                if ($_GET['upload'] == "empty"){
                    echo '<script language="javascript">
                    alert("請填寫完整上傳欄位");
                    </script>';
                }
            }
        ?>

        <footer class="navbar-static-bottom">
            <div class="banner">
                <div class="row">
                    <div class="col-sm-6">
                        <p class="footer-element">&copy; 2019 CHJB App Name</p>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-1.5">
                                <p class="footer-element">
                                    | &emsp; Contact Us
                                </p>
                            </div>
                            <div class="col-sm-2.5">
                                <p class="footer-element">
                                    <img src="img/vote_email.png" alt="">  talktalk@gmail.com
                                </p>
                            </div>
                            <div class="col-sm-1.5">
                                <p class="footer-element">
                                    <img src="img/vote_fb.png" alt="">  說說  talktalk
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <!-- bootstrap cdn -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <!-- icon cdn-->
        <!-- <script src="https://kit.fontawesome.com/0920bde990.js" crossorigin="anonymous"></script> -->

    </body>
    
</html>