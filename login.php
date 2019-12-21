<?php
  if (isset($_GET['status'])){
    if ($_GET['status'] == "logout"){
      session_start();
      session_unset();
      session_destroy();
    }
  }
?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>登入 TalkTalk</title>
  <meta name="viewport" content="width=device-width, initial-scale=1"><link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'><link rel="stylesheet" href="css/login.css">
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
          <h1>歡迎 說說!</h1>
          <p>"Our mission at TalkTalk is to inspire every person in the world to take a stand and make a difference."</p>
          <p>"Simply make a difference by using our product to showr your stance on the internet."</p>
          <p>"Start discussion, make contribution."</p>
        </div>
      </div>
      <div class="col-md-5 pic2">
        <div class="login-form">
          <h1>Log in</h1>
          <form action="includes/login.inc.php" method="post">
            <div class="form-group1">
              <input class="form-control" name="mailuid" type="text" placeholder="Username OR Email" required="required"/>
              <?php
                  if (isset($_GET['error'])){
                      if ($_GET['error'] == "nouser"){
                          echo 
                          '<div class="alert alert-warning alert-dismissible fade show" style="width:90%; font-size: 8pt; margin: 2px">
                            <strong>警告!</strong> 該使用名稱不存在
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                          </div>'
                          ;
                      }
                  }
              ?> 
            </div>
            <div class="form-group2">
              <input class="form-control" name="pwd" type="password" placeholder="Password" required="required"/>
              <?php
                  if (isset($_GET['error'])){
                      if ($_GET['error'] == "wrongpwd"){
                          echo 
                          '<div class="alert alert-warning alert-dismissible fade show" style="width:90%; font-size: 8pt; margin: 2px">
                            <strong>警告!</strong> 密碼輸入錯誤
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                          </div>'
                          ;
                      }
                  }
              ?> 
            </div>
            <div class="form-group3">
              <button class="btn btn-primary" name="login-submit" type="submit">登入</button>
            </div>
            <div class="clearfix">
              <label class="pull-left checkbox-inline"></label>
              <input type="checkbox"/> 記住我<a class="pull-right" href="#">忘記密碼</a>
            </div>
            <div class="sign-other"> 
              <p>or sign in with</p>
              <div class="signpics">
                <div class="fb"></div>
                <div class="line"></div>
              </div>
            </div>
            <div class="newuser" style="padding-left: 6px">I'm a new user. <a href="register.php">Sign up.</a></div>
          </form>
        </div>
      </div>
      <div class="col-md-1"></div>  
    </div>
  </div>

</body>
</html>