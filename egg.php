<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/egg.js"></script>
    <link rel="stylesheet" href="css/egg.css">
    <title>EGG</title>
  </head>
  <body>
    <!-- 扭蛋機 -->
    <div class="egg_machine">
      <div style="padding-top:105px;">
        <img id="coin" src="img/animation/egg_coin.png">
        <!-- 失敗煙霧 -->
        <div>
          <img id="clude" class="clude1 clude" src="img/animation/egg_cloud1.png">
          <img class="clude2 clude" src="img/animation/egg_cloud2.png">
        </div>
        <div id="egg_machine">
          <div>
            <!-- 扭蛋機內的扭蛋 -->
            <div style="filter:hue-rotate(300deg);background-position: 65% 80%;" class="all_ball"></div>
            <div style="filter:hue-rotate(0deg);background-position: 5% 80%;" class="all_ball"></div>
            <div style="filter:hue-rotate(300deg);background-position: 30% 100%;" class="all_ball"></div>
            <div style="filter:hue-rotate(0deg);background-position: 20% 90%;" class="all_ball"></div>
            <div style="filter:hue-rotate(300deg);background-position: 40% 75%;" class="all_ball"></div>
            <div style="filter:hue-rotate(0deg);background-position: 83% 88%;" class="all_ball"></div>
            <div style="filter:hue-rotate(300deg);background-position: 70% 100%;" class="all_ball"></div>
            <div style="filter:hue-rotate(0deg);background-position: 50% 101%;" class="all_ball"></div>
            <!--扭蛋機結果那顆-->
            <div id="egg_end" class="ball_end"></div>
            <img src="img/animation/egg_machine.png">
          </div>
          <?php
            if (isset($_GET['win']) || isset($_GET['reward']) || isset($_GET['gameId'])){
              $reward = $_GET['reward'];
              $gameId = $_GET['gameId'];
              if ($_GET['win'] == 1){
                echo '<img onclick="button(this, 1, '.$reward.', '.$gameId.');" style="cursor: pointer;margin-top:25px;" src="img/animation/egg_butt1.png">';
              } else {
                echo '<img onclick="button(this, 0, '.$reward.', '.$gameId.');" style="cursor: pointer;margin-top:25px;" src="img/animation/egg_butt1.png">';
              }
            }
          ?>
          <!-- <img onclick="button(this, 1);" style="cursor: pointer;margin-top:25px;" src="img/animation/egg_butt1.png"> -->
        </div>
      </div>
    </div>
  </body>
</html>
