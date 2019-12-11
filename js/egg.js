$(document).ready(function(){
  setInterval(update);
});
var posX=[]; //X座標位移量
var posY=[]; //Y座標位移量
var eggEndFlag=[]; //掉落動畫中求是否掉到最下方
var eggEndNum=0; //扭蛋結束顆數
var eggTime=300 ; //扭蛋轉動動畫時間，預設3秒
var eggStatus=0; //扭蛋動畫狀態(0：沒動作、1：扭蛋轉、2：機器內扭蛋掉下去、3：最終扭蛋出現、4：結尾動畫)
var eggs=[]; //扭蛋機中所有扭蛋
var color=[0,300]; //扭蛋顏色預設值(0：黃色、1：粉色)
var btn;
var btnFlag; //btn開關
//需要後端傳入的變數 - 在下方 "function button" 中讀取
var eggcolor=0; //拿來放你傳入的顏色值(0或1)
var win=0; //判斷輸贏(0：輸、1：贏)
var reward=0;
var gameId=0;
function update(){
  if(eggStatus==0){ //重新開始 - 預設值
    btnFlag=0;
    if(btn){
      btn.style.opacity=1;
      btn.style.cursor='pointer';
      $(eggs[0]).css('background-position','65% 80%');
      $(eggs[1]).css('background-position','5% 80%');
      $(eggs[2]).css('background-position','30% 100%');
      $(eggs[3]).css('background-position','20% 90%');
      $(eggs[4]).css('background-position','40% 75%');
      $(eggs[5]).css('background-position','83% 88%');
      $(eggs[6]).css('background-position','70% 100%');
      $(eggs[7]).css('background-position','50% 101%');
    }
    $('#egg_end').css('opacity','0');
    $('#coin').css('animation','none');
    $('.clude').css('animation','none');
    document.getElementById('egg_machine').style.animation='none';
  }
  else if(eggStatus==1){
    for(var i=0;i<eggs.length;i++){
      posX[i]=posX[i]+Math.random()*4;
      posY[i]=posY[i]+Math.random()*4;
      $(eggs[i]).css('background-position',Math.abs(Math.sin(posX[i]*0.01))*100+'%'+' '+Math.abs(Math.sin(posY[i]*0.01))*100+'%');
    }
    eggTime--;
    if(eggTime == 0){
      eggStatus=2;
      for(var i=0;i<eggs.length;i++){
        posY[i] = Math.abs(Math.sin(posY[i]*0.01))*100;
      }
    }
  }
  else if(eggStatus==2){
    for(var i=0;i<eggs.length;i++){
     if(posY[i]<100){
        posY[i]++*0.5;
        $(eggs[i]).css('background-position',Math.abs(Math.sin(posX[i]*0.01))*100+'%'+' '+posY[i]+'%');
      }
      else if(eggEndFlag[i]==0){eggEndFlag[i]=1;eggEndNum++;}
      if(eggEndNum==eggs.length){
        eggStatus=3;
        posY[0]=-105;
        eggEndNum=0;
        $('#egg_end').css('opacity','1');
        $('#egg_end').css('background-position','center -105px');
      }
    }
  }
  else if(eggStatus==3){
    posY[0]++*0.00001;
    $('#egg_end').css('background-position','center '+posY[0]+'px');
    $('#egg_end').css('filter','hue-rotate('+color[eggcolor]+'deg)'); //獲取顏色
    if(posY[0]>3)eggStatus=4;
  }
  else if(eggStatus==4){
    if(win){
      btn.style.opacity=0;
      btn.style.cursor='default';
      $('#coin').css('animation','coin 1.5s 1 ease-in');
      $('#coin').css('animation-fill-mode','forwards');
      document.getElementById('egg_machine').style.animation = 'fade-out-half 1s 1 ease-out';
      document.getElementById('egg_machine').style.animationFillMode = 'forwards';
      document.getElementById('coin').addEventListener("webkitAnimationEnd", function() {
        //所有動畫結束後的內容(我不知道要放甚麼XD)
        if(eggStatus==4){
          eggStatus=0
          console.log('win');
          alert("恭喜您的下注方獲勝！您在該主題共分到" + reward + "說說幣＾＿＾");
          location.replace("game.php?gameId=" + gameId);
        }
      })
    }
    else{
      btn.style.opacity=0;
      btn.style.cursor='default';
      $(".clude").css('animation','clude 1.2s 1 ease-out');
      $(".clude").css('animation-fill-mode','forwards');
      document.getElementById('egg_machine').style.animation = 'fade-out 0.6s 1 ease-out';
      document.getElementById('egg_machine').style.animationFillMode = 'forwards';
      document.getElementById('clude').addEventListener("webkitAnimationEnd", function() {
        //所有動畫結束後的內容(我不知道要放甚麼XD)
        if(eggStatus==4){
          eggStatus=0;
          console.log('lose');
          alert("很遺憾您的下注方未獲勝...祝您下次好運");
          location.replace("game.php?gameId=" + gameId);
        }
      })
    }
  }
}
function button(b, win_or_lose, r, id){
  btn = b;
  if(!btnFlag){
    btnFlag=1;
    //後端的部分
    eggcolor=1; //扭蛋顏色(0：黃色、1：粉色)
    win=win_or_lose; //判斷有沒有贏(0：輸、1：贏)
    reward = r;
    gameId = id;
    //---------
    btn.src = "img/animation/egg_butt1_click.png";
    setTimeout(function(){btn.src = "img/animation/egg_butt1.png";}, 200);
    eggs = $(btn).parent().find('div').find('.all_ball');
    for(var i=0;i<eggs.length;i++){
      eggEndFlag[i] = 0;
      posX[i]=(Math.floor(Math.random()*100))*(Math.floor(Math.random()*2)*2-1);
      posY[i]=(Math.floor(Math.random()*100))*(Math.floor(Math.random()*2)*2-1);
    }
    eggStatus = 1;
    eggEndNum=0;
    eggTime=300; //扭蛋轉動動畫時間，預設3秒
  }
}
