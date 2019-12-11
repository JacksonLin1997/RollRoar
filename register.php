<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>註冊 Talktalk</title>
  <meta name="viewport" content="width=device-width, initial-scale=1"><link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'><link rel="stylesheet" href="css/register.css">
<!-- partial -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>

<body>

  <nav class="navbar sticky-top navbar-expand-lg navbar-dark">
        <button class="navbar-toggler" id="button01" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
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
                        <!-- <div class="search">
                            <span class="fas fa-search" style="color:#707070;padding-left: 15px; padding-right:5px;font-size: 22px"></span>
                            <input type="text" style="border-color: #707070"> 
                        </div> -->
                    
                </form>
        </div>
        <a class="navbar-brand mx-auto" href="index.php"> 
            <img src="img/logo.png" alt="">
            <h4>說說</h4></a>
        
        <div class="navright collapse navbar-collapse" id="navbarTogglerDemo02">
            <form class="form-inline" style="display: none">           
                <img src="img/coin.png"style="padding: 12px">
                <?php
                    if (isset($_SESSION['userPoints'])){
                        echo '<button type="button" class="btn btn-outline-light" style="border-radius: 20pt;">$ '.$_SESSION['userPoints'].'</button>';
                    } else {
                        echo '<button type="button" class="btn btn-outline-light" style="border-radius: 20pt;">$ ???</button>';
                    }
                ?>
                <img src="img/vote_noti.png"  style="padding: 12px; height:300%;">
                <div class="dropdown">
                    <img src="img/vote_user.png" class="dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"style="padding: 12px; height:300%; cursor: pointer;">
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                        <?php
                            if (isset($_SESSION['userUid'])){
                                echo '<a class="dropdown-item" href="#">'.$_SESSION['userUid'].'</a>';
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
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-1"></div>    
      <div class="col-md-5 pic1">      
        <div class="textpanel">
          <img src="img/logo.png" alt="">
          <h4> 說說!</h4>        
        </div>
      </div>
      <div class="col-md-5 pic2">
          <div class="signup-form">
              <h2 class="form-title">註冊</h2>
              <form action="includes/register.inc.php" method="post">
                  <div class="form-group">
                    <?php
                      if (isset($_GET['error']) && ($_GET['error'] == "invalidmail" || $_GET['error'] == "passwordcheck" || $_GET['error'] == "emailtaken")){
                        echo '<input class="in" type="text" name="uid" id="name" value='.$_GET["uid"].' required/>';
                      } else {
                        echo '<input class="in" type="text" name="uid" id="name" placeholder="使用者名稱" required/>';
                      }

                      if (isset($_GET['error'])){
                        if (($_GET['error'] == "invaliduid") || ($_GET['error'] == "invalidmailuid")){
                          echo '<div class="alert">*使用者名稱格式錯誤</div>';
                        }
                        else if ($_GET['error'] == "usertaken"){
                          echo '<div class="alert">*已有他人使用此名稱</div>';
                        }
                      }
                    ?>
                  </div>
                  <div class="form-group">
                    <?php
                      if (isset($_GET['error']) && ($_GET['error'] == "invaliduid" || $_GET['error'] == "passwordcheck" || $_GET['error'] == "usertaken")){
                        echo '<input class="in" type="email" name="mail" id="email" value='.$_GET["mail"].' required/>';
                      } else {
                        echo '<input class="in" type="email" name="mail" id="email" placeholder="E-mail" required/>';
                      }

                      if (isset($_GET['error'])){
                        if (($_GET['error'] == "invalidmail") || ($_GET['error'] == "invalidmailuid")){
                          echo '<div class="alert">*電子信箱格式錯誤</div>';
                        }
                        else if ($_GET['error'] == "emailtaken"){
                          echo '<div class="alert">已有他人使用此信箱</div>';
                        }
                      }
                    ?>
                  </div>
                  <div class="form-group">
                      <input class="in" type="password" name="pwd" id="pass" placeholder="密碼" required/>
                  </div>
                  <div class="form-group">
                      <input class="in" type="password" name="pwd-repeat" id="re_pass" placeholder="再次輸入密碼" class="in" required/>
                  </div>
                    <?php
                        if (isset($_GET['error'])){
                            if ($_GET['error'] == "passwordcheck"){
                                echo '<div class="alert">*您輸入的密碼不一致</div>';
                            }
                        }
                    ?>
                  <div class="form-group re">
                      <label>
                        <input type="checkbox">記住我
                      </label>
                  </div>
                  <div class="form-group">
                      <button class="btn btn-primary" type="submit" name="signup-submit">註冊</button>
                  </div>
                  <div class="form-group re">
                      我已有帳號!
                      <a href="login.php">登入</a>
                  </div>
              </form>
          </div>


      </div>
      <div class="col-md-1"></div>  
    </div>
  </div>

</body>
</html>