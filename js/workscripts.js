$(document).ready(function(){
    /*      Menu        */
    var touch = $('#touch-menu');
    var menu = $('.nav');

    $(touch).on('click', function(e){
        e.preventDefault();
        menu.slideToggle();
    });
   $(window).resize(function(){
        var wid = $(window).width();
        if(wid > 952 && menu.is(':hidden')) {
            menu.removeAttr('style');
        }
    });

    $('.second > div').hover(
        function(){
            var text= $(this).find(".text");
            $(text).css({'display':'block'});
            /*console.log(text);*/
        },
        function(){
            $(this).find(".text").css({'display':'none'});
        });

/*      MORE        */
    var more = $('.more-third');
    var men = $('.third div:nth-child(n+5)');

    $(more).on('click', function(e){
        e.preventDefault();
        men.css({'display':'inline-block'});
       /* more.css({'display':'none'});*/
    });
    $(window).resize(function(){
        var wid = $(window).width();
        if(wid > 952 && men.is(':hidden')) {
            men.removeAttr('style');
        }
    });
});