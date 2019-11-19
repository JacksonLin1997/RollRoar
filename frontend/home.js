$(document).ready(function(){
    $('.slick').slick({
        dots: true,             //顯示輪播圖片會顯示圓圈
        infinite: true,         //重覆輪播
        slidesToShow:3,         //輪播顯示個數
        slidesToScroll: 3,      //輪播捲動個數
        autoplay: true,         //autoplay : 自動播放
        responsive: [
    
        {
        breakpoint: 1000,
        settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            arrows:false
        }
        },
        {
        breakpoint: 480,
        settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows:false
        }
        }]
    });
  });
