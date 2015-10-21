$(document).ready(function(){

$('.social').hover(
    function(){
        var src = $(this).attr('src').match(/[^\.]+/) + '-active.png';
        $(this).attr('src', src);
    },
    function(){
        var src_old = $(this).attr('src').match(/[^-]+/) + '.png';
        $(this).attr('src', src_old);
    }
);

    /*      color       */
    $('.color').click(function() {
            $('.color').removeClass("color-active");
            $(this).toggleClass('color-active');
    });

   $('.image-img').hover(
        function(){
            $(this).find('.hidden').css({'visibility':'visible'});
        },
        function(){
            $(this).find('.hidden').css({'visibility':'hidden'});
        });



    $(".b-carousel-button-right").click(function(){
        $(".h-carousel-items").animate({left: "-222px"}, 200);
        setTimeout(function () {
            $(".h-carousel-items .b-carousel-block").eq(0).clone().appendTo(".h-carousel-items");
            $(".h-carousel-items .b-carousel-block").eq(0).remove();
            $(".h-carousel-items").css({"left":"0px"});
        }, 300);
    });

    $(".b-carousel-button-left").click(function(){
        $(".h-carousel-items .b-carousel-block").eq(-1).clone().prependTo(".h-carousel-items");
        $(".h-carousel-items").css({"left":"-222px"});
        $(".h-carousel-items").animate({left: "0px"}, 200);
        $(".h-carousel-items .b-carousel-block").eq(-1).remove();
    });


});