$(document).ready(function(){
    
          	$('.slider').slick({
      		dots: true,
  			infinite: true,
  			slidesToShow: 4,
  			slidesToScroll: 4
		});

    $('#au1').hover(
        function(){
            var asd= $(this).next();
            $('#au1').css({'opacity':'0.7'});
            console.log(asd);
            $("#au11").css({'display':'block'});
        },
        function(){
            $('#au1').css({'opacity':'1'});
            $("#au11").css({'display':'none'});
        });
    $('#au2').hover(
        function(){
            var asd= $(this).next();
            $('#au2').css({'opacity':'0.7'});
            console.log(asd);
            $("#au12").css({'display':'block'});
        },
        function(){
            $('#au2').css({'opacity':'1'});
            $("#au12").css({'display':'none'});
        });


    $('.icon').hover(
        function(){
            $(this).attr('src', 'img/icon1.png');
        },
        function(){
            $(this).attr('src', 'img/icon.png');
        });


    $('.upto').click(function() {
       /* e.preventDefault();*/
        $('body,html').animate({scrollTop:0},800);
    });

    /*  $('.auction').hover(
      function(){
          var auction = jQuery(this).attr(id);
          console.log("auction");
          $(".auction").next().css({'opacity':'0.7'});
          $(".auction-nav").css({'display':'block'});
      },
      function(){
          $(".auction").next().css({'opacity':'1'});
          $(".auction-nav").css({'display':'none'});
      });
  */

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
    
    
    
    $('nav a').on('click', function(e){
    e.preventDefault();
  });
  $('.nav li').hover(function () {
     clearTimeout($.data(this,'timer'));
     $('ul',this).stop(true,true).slideDown(200);
  }, function () {
    $.data(this,'timer', setTimeout($.proxy(function() {
      $('ul',this).stop(true,true).slideUp(200);
    }, this), 100));
  });

  
    /* ===Аккордеон=== */
    var openItem = false;
	if(jQuery.cookie("openItem") && jQuery.cookie("openItem") != 'false'){
		openItem = parseInt(jQuery.cookie("openItem"));
	}	
	jQuery("#accordion").accordion({
		active: openItem, //открытый пункт
		collapsible: true, //повторный клик по пункту сворачивает его
        autoHeight: false,
        header: 'h3'
	});
	jQuery("#accordion h3").click(function(){
		jQuery.cookie("openItem", jQuery("#accordion").accordion("option", "active"));
	});	
	jQuery("#accordion > li").click(function(){
		jQuery.cookie("openItem", null);
        var link = jQuery(this).find('a').attr('href');
        window.location = link;
	});
    /* ===Аккордеон=== */    
    
    
});