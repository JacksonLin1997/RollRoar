$(".card-img-top").mouseover(function(){
    $(this).css('webkit-filter', 'brightness(.5)');
 }).mouseout(function(){
    $(this).css('webkit-filter', '');
 })
