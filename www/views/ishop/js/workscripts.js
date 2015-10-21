$(document).ready(function(){
    
    /* ===Аккордеон=== */
    var openItem = false;
	if(jQuery.cookie("openItem") && jQuery.cookie("openItem") != 'false'){
		openItem = parseInt(jQuery.cookie("openItem"));//приводим переменную явно к числовому типу
	}	
	jQuery("#accordion").accordion({
		active: openItem, //свойство, открытый пункт
		collapsible: true, //повторный клик по пункту сворачивает его
        autoHeight: false,//отключаем автоматическое определение высоты, чтобы размер определялся не по наиболшему кол-ву подпунктов, и там где 1 пункт отображался также
        header: 'h3' //указываем элемент который является заголовком секции (для IE 7)
	});
	jQuery("#accordion h3").click(function(){ //устанавливаем куку openItem, устанавливаем ей значение (id) открытого пункта меню
		jQuery.cookie("openItem", jQuery("#accordion").accordion("option", "active"));
	});	
	jQuery("#accordion > li").click(function(){
		jQuery.cookie("openItem", null); //разрегестрируем куку
        var link = jQuery(this).find('a').attr('href');//читаем ссылку в родительской категории без потомков
        window.location = link; //переходим по этой ссылке
	});
    /* ===Аккордеон=== */

/*      Поиск - смена картинки        */
$('.search-btn').hover(
    function(){
        var src = $('#img').attr('src').match(/[^\.]+/) + '2.png';
        $('#img').attr('src', src);
    },
    function(){
        var src = $('#img').attr('src').replace('btn-search2.png', 'btn-search.png');
        $('#img').attr('src', src);
    }
);


/*          Подстветка активного пунтка меню            */
var url=document.location.href;
$.each($("menu-item a"),function(){
if(this.href==url){$(this).addClass('menu-active');};
});
/*          Подстветка активного пунтка меню            */


    
/*====Переключатель вида====*/
 
   if($.cookie("display") == null){
        $.cookie("display", "grid");
        //$("#grid").find("img").attr("src", "views/ishop/img/view-table-active.gif");
    }
    
    $(".grid_list").click(function(){
        var display = $(this).attr("id"); // получаем значение переключателя вида
        display = (display == "grid") ? "grid" : "list"; // допустимые значения        
        
        //цвет картинки
        /*if(display == "grid"){
            $("#" + display).find("img").attr("src", "views/ishop/img/view-table-active.gif");
            }else $("#" + display).find("img").attr("src", "views/ishop/img/view-line-active.gif");*/
        
        
        if(display == $.cookie("display")){
            // если значение совпадает с кукой - ничего не делаем
            return false;   
        }else{
            // иначе - установим куку с новым значением вида
            $.cookie("display", display);
            window.location = "?" + query; //чтобы наша серверная часть в cat.php увидела эту куку
            return false;
        }
    });
 
/*=========Переключатель вида AJAX==========*/
  /*  if($.cookie("display") == null){
        $.cookie("display", "grid");
    }
    
    $(".grid_list").click(function(e){
        e.preventDefault();
        var display = $(this).attr("id"); // получаем значение переключателя вида
        display = (display == "grid") ? "grid" : "list"; // допустимые значения
        
        if(display == $.cookie("display")){
            // если значение совпадает с кукой - ничего не делаем
            return false;   
        }else{
            // иначе - установим куку с новым значением вида
            $.cookie("display", display);
            $('.popular').fadeOut(500).load('cat.php .popular');
           /* $.ajax({
            url: './',
            data:{display_view=display},
            type: 'POST',
            success:function(html){
                
            },
            error:function(){
                
            }
        });*/
            
            //window.location = "?" + query; //чтобы наша серверная часть в cat.php увидела эту куку
 /*           return false;
        }
    });
 
/*=========Переключатель вида AJAX==========*/ 
 
/* if($.cookie("display") == null){
            $.cookie("display", "table");
        }
        
        $(".list").click(function(){    
            var display = $(this).attr("id"); //получаем значение переключателя
        //    alert(display); //выводим значение переменной в модальном окне
            display = (display == 'table') ? "table" : "line"; //проверка на допустимые значения
                if(display == $.cookie('display')){
                    //если значение переменной дисплей совпадает со значением куки, то ничего не делаем.
                    //для повторного клика по сетке
                    return false; //отменим переход по ссылке
                    
                }else{
                    //устанавливаем в куку нужное значение - line
                    $.cookie("display", display);//в куку с именем display, кладем значение одноименной переменной display
                    window.location = "?" + query;// обращаемся к объекту виндоу и задаем адрес, кот хранится в переменной query
                    return false;//запрещаем переход по ссылке
                }
            return false; //чтобы не было перехода по ссылке
        });
    
 /*====Переключатель вида====*/    
 
/*      Сортировка       */
$("#param_sort").toggle( //отслежживаем элемент с айди ... и назначаем для него переключатель 
    function(){ //организовываем две фун-и, каждая из них будет выполняться поочередно при клике
        $(".sort-wrap").css({'visibility':'visible'});
    },
    function(){
        $(".sort-wrap").css({'visibility':'hidden'})
    }
); 
/*      Сортировка       */


/*====Сортировка ajax====*/
/*
$(".sort-bot").click(function(e){
    e.preventDefault();
    var id = $(this).attr('id');
    var new_sort = $(this).text(); *///название ссылки по какой сортировке уже сделали
    //alert(new_sort);
    /* $("#fond").css({'display':'block'}); */ //при наведении на сортировку
/*    $("#load").fadeIn(500,function(){  //сначала показать, потом выполнять функцию
        $.ajax({
           url: './',
           data:'sort_id='+id,
           type: 'POST',
           //dataType:'json',
           success:function(html){
                alert(html);
                //var arr = JSON.parse(html);
                $(".product-table").hide().html(html).fadeIn(2000);
                $("#fond").css({'display':'none'});
                $("#load").fadeOut(500);
                $(".sort-wrap").css({'visibility':'hidden'});
                $(".sort-top").hide().html(new_sort + "&nbsp;&#9660;").fadeIn(500);
           },
           error:function(){           
           } 
        });
    });
});
/*====Сортировка ajax====*/
 
 
/*===========Авторизация==============*/

$("#auth").click(function(e){ //отбираем в набор элементы с id auth, и отслеживаем по нему событие клика, и по данному событию выполняем фун-ю
    e.preventDefault();         // е - объект, preventDefault - метод, который запрещает отправку данных из формы, дефолтное поведение
    //получаем значения параметров логин пароль и кнопка $_POST['auth']
    var login = $("#login").val(); //кладем значение соответствующего поля, которое имеет id login, val() -метод, получаем значение поля
    var pass = $("#pass").val();
    var auth =$("#auth").val();
   $.ajax({ //метод аякс
    url: './',      //адрес обработчика куда будут отправлятся данные, указываем текущую стр, так как отдельного обработчика для нее делать не будем, т.е все будет 
                    //приниматься на этой же индкусной стр
    type: 'POST',   //метод передачи данных, пост - потому что в модели мы работаем с пост, и в контролллере вызываем фун-ю если в пост имеются 
                    //необходимые данные
    data: {auth: auth, login: login, pass: pass}, //данные кот будут передаваться. переменная: значение(из переменной)
    success: function(res){ //res - ответ от сервера
                            //параметр саксес. в случае если ответ от сервера успешен, то будет выполнен этот блок
        //alert("Ответ: "+res);
        if (res != 'Поля логин/пароль должны быть заполнены' && res!= 'Не правильное значение логин/пароль'){
            //если пользователь успешно авторизован
            $(".authform").hide().fadeIn(1000).html(res + '<a class="logout" href="?do=logout">Выход</a><a class="input_cabinet" href="?view=cabinet">Личный кабинет</a><br />');
            
            //удаляем поля для заполнения, если пользвоатель авторизовался со стр корзины
            $(".notauth").fadeOut(1000);
            setTimeout(function(){ //удаляем поля с классом notauth, за пол секунды
               $(".notauth").remove(); 
            }, 500);
        }else{
            //пользователь авторизация не прошла удачно
            $(".error").remove(); //удаляем блок, чтоб он не дублировался при повторном вызове, а появлялся новый
            $(".authform").append('<div class="error"></div>');
            $(".error").hide().fadeIn(1000).html(res);
        }
    },
    error: function(){ 
        alert("Error!");
    }    
   });//передаем на сервер с использованием асинхронного запроса
});

//if (view == 'card'){
 //   $("#right-bar").fadeOut(300);
 //   $(".login").fadeIn(500);
//    $(".specify-search").fadeOut(300).remove();
 //   $(".shopcart").fadeOut(300).remove();
//}
/*===========Авторизация==============*/



/*      Восстановление пароля       */
$('#forgot-link').click(function(){
    //e.preventDefault();
    $('.authform').fadeOut(500, function(){
    $('#forgot').fadeIn(500);
   });
   return false; /*отмена дефолтного поведения - перехода по ссылке*/
});
$('#link').click(function(){
   $('#forgot').fadeOut(500, function(){
    $('.authform').fadeIn(500);
   });
   return false;
});
$('#fpass').click(function(e){
    e.preventDefault;
    var email = $('#email').val();
    $('#forgot').fadeOut(1000, function(){
    $('.authform').fadeIn(2000);
   });    
 /*      setTimeout(function(){ 
               $(".success").remove(); 
            }, 5000);
    setTimeout(function(){ 
                $(".error").remove(); 
            }, 5000);*/
});
/*$('#fpass').click(function(e){
    e.preventDefault();
    var email = $('#email').val();
    alert(email);
   $.ajax({ //метод аякс
    url: './',      //адрес обработчика куда будут отправлятся данные, указываем текущую стр, так как отдельного обработчика для нее делать не будем, т.е все будет 
                    //приниматься на этой же индкусной стр
    type: 'POST',   //метод передачи данных, пост - потому что в модели мы работаем с пост, и в контролллере вызываем фун-ю если в пост имеются 
                    //необходимые данные
    cache:false,
    data: {email: email}, //данные кот будут передаваться. переменная: значение(из переменной)
    success: function(html){ //res - ответ от сервера
                            //параметр саксес. в случае если ответ от сервера успешен, то будет выполнен этот блок
        alert("Ответ: "+html);
    },
    error: function(){ 
        alert("Error!");
    }    
   });        
});*/
/*      Восстановление пароля       */


/*     Редактирование профиля пользователя - сообщение об ошибке или нет      */
/*$(".success").show(500).fadeOut(5000).remove();
$(".error").show(500).fadeOut(5000).remove();*/


/*         Регистрация - индикатор надежности пароля     */
/*$("#pass").keyup(function(){
   var pass = $("#pass").val();
   $("#result").text(check(pass)); 
});
function check(pass){
    var protect = 0;
    
    if(pass.length < 8){
        return "слабый";
    }
    
    var small = "";
}
/*         Регистрация - индикатор надежности пароля      */

/*=======Добавление в корзину========*/
$(".addtocard-index").click(function(e){
        e.preventDefault();        
        var goods_id = $(this).parent().attr("href").slice(25);
        var qty = $('.qty').attr("href");
        var qty_start = $("#quantity").val();
        console.log(qty_start);
        var add_goods;
        $.ajax({ //метод аякс
        url: './',   
        type: 'POST',
        data: {add_goods: goods_id, qty: qty},
        success: function(res){
            //console.log('res' + res);            
                $("#card").hide().fadeIn(500).html('<p>Товаров в корзине:<br />' + res + '<a href="?view=card"><img src="views/ishop/img/order.png" alt="Оформить заказ" /></a> </p>');
                //$(".res").text("Изменения сохранены!").stop(true, true).fadeIn(300).fadeOut(2000);
        },
        error: function(){ 
        //alert("Error!");
        $(".res").text("Ошибка!").css({"border":"1px solid red","backgroundColor":"#ffb7b7"}).fadeIn(300).fadeOut(5000);
        }    
        });//передаем на сервер с использованием асинхронного запроса          
});

/*=======Добавление в корзину========*/


/*====Удаление из корзины=====*/
/*$(".order-main-table .z-del").click(function(e){
    //alert("ok");
    e.preventDefault();        
    var goods_id = $(this).find("a").attr("href").slice(18);
    //alert(goods_id);
    var add_goods;
    $.ajax({ //метод аякс
        url: './',   
        type: 'POST',
        data: {del_goods: goods_id},
        success: function(res){
            //плавно скрываем вращающиеся изображение и...
				$(".load").fadeOut(200,function () {
				    if(res) {
				        //Показываем блок с сообщением об успешности выполнения сортировки.
				        $(".res").text("Товар успешно удален из корзины!").stop(true, true).fadeIn(300).fadeOut(2000);                                   
                        //Обновляем таблицу       
                       /* var load_ajax = $(".order-main-table");
                        $(".order-main-table").load(load_ajax); */  
/*                        var ajax = $("#ajax").val();
                         $(".order-main-table").hide().fadeOut(1000).html(ajax);                        
                         /*   $(".order-main-table").empty();
                            $(".order-main-table").load('./views/ishop/card.php #ajax');   */
                            
                            
                    
                    /*    $.ajax({                   
                        url: "./views/ishop/card.php",
                        cache: false,
                            success: function(html){
                            $(".order-main-table").html(html);
                            }                     
                        });*/
                        
/*                        }
						if(!res){
						//если ЛОЖЬ то выводим сообщение о ошибке
							$(".res").text("Ошибка!").css({"border":"1px solid red","backgroundColor":"#ffb7b7"}).fadeIn(300).fadeOut(5000);
						}
                    });
            console.log('res = ' + res);
               },
        error: function(){ 
        alert("Error!");
        }    
    });//передаем на сервер с использованием асинхронного запроса      
});


/*====Удаление из корзины=====*/


/*=======ENTER во время пересчета количества===========*/
   $(".kolvo").keypress(function(e){ //берем элемент с классом kolvo и отслеживаем для него событие keypress
        if(e.which == 13){ //свойство which проверяет код клавиши
            return false; //тем самым прекращаем работу клавиши
            }
    });    
/*=======ENTER во время пересчета количества===========*/


    /* ===Пересчет товаров в корзине=== */
    $(".kolvo").each(function(){
       var qty_start = $(this).val(); // кол-во до изменения
       var qty = $(".qty").attr("href");
       
       $(this).change(function(){
           var qty = $(this).val(); // кол-во перед пересчетом
           var res = confirm("Пересчитать корзину?");
           if(res){
                var id = $(this).attr("id");
                id = id.substr(2);
                if(!parseInt(qty)){
                    qty = qty_start;
                }
                // передаем параметры
                window.location = "?view=card&qty=" + qty + "&id=" + id;
           }else{
                // если отменен пересчет корзины
                $(this).val(qty_start);
           }
       }); 
    });


/*       Уникальность email           */
$(".access").change(function(){
   var $this = $(this);
   var val = $.trim($this.val());
   var dataField = $this.attr('data-field');
   var span = $this.next();
   //var span = $this.parent().next().find(span);
   //span = span.next();
   //console.log(span);
   
   span.removeClass(); //очищаем span от возможных классов
   if(val == ''){ //если то, что ввел пользователь, пусто
        span.addClass('reg-cross');
        span.next().text('Заполните поле');
   }else{ //если не пусто, то подгружаем гифку, пока будет выполняться аякс
        span.addClass('reg-loader');
        //запускаем аякс
    $.ajax({
        url:'./',
        type: 'POST',
        data: {val: val, dataField:dataField},
        success: function(res){
            //console.log(res);
            var result = JSON.parse(res);
            span.removeClass();
            span.next().text(''); //очищаем span от возможного сущ текста в нем
            if(result.answer == 'no'){
                //если свойство answer (св-во потому что формат - json )
                span.addClass('reg-cross');
                span.next().text(result.info); //выводим сообщение
            }else{
                span.addClass('reg-check');
            }
            
            /*if (res == 'no'){
                span.removeClass().addClass('reg-cross');
            }else{
                span.removeClass().addClass('reg-check');
            }*/
        }
    });
   }
});

/*       Уникальность email           */



/*======Пересчет товаров корзины=========*/
/*$(".kolvo").each(function(){ //отбираем в набор элементы с классов колво, и проходимся им в циле each
    var qty_start = $(this).val(); //qty_start - переменная ля получения старого кол-ва товара    
    
    $(this).change(function(){ //обращаемся к текущему эл-ту и отслеживаем событие чендж, по данному событию будем выполнять некую фун-ю
        var qty = $(this).val(); //получаем значние текущего поля и кладем его в переменную, кол-во перед пересчетом
        var res = confirm("Пересчитать количество товаров в корзине?");
        if(res){
            //пересчет корзины
            var id = $(this).attr("id");
            id = id.substr(2); //избавляемся отстроки "id". фун-я возвращает подстроку, указываем с какого элемента
            //проверка введенных данных
            if(!parseInt(qty)){ //если введенное значение НЕ может быть приведено к числу
                  qty = qty_start;
            }
            //передаем параметры
            window.location = "?view=card&qty=" + qty + "&id=" + id;
        }else{
            //если отменен пересчет корзины
            $(this).val(qty_start);
        }        
    });
});   

*/
/*======Пересчет товаров корзины=========*/
 

 
 


    /* ===Клавиша ENTER при пересчете=== */
/*    $(".kolvo").keypress(function(e){
        if(e.which == 13){
            return false;
        }
    });
    /* ===Клавиша ENTER при пересчете=== */
    
    /* ===Пересчет товаров в корзине=== */
 /*   $(".kolvo").each(function(){
       var qty_start = $(this).val(); // кол-во до изменения
       
       $(this).change(function(){
           var qty = $(this).val(); // кол-во перед пересчетом
           var res = confirm("Пересчитать корзину?");
           if(res){
                var id = $(this).attr("id");
                id = id.substr(2);
                if(!parseInt(qty)){
                    qty = qty_start;
                }
                // передаем параметры
                window.location = "?view=card&qty=" + qty + "&id=" + id;
           }else{
                // если отменен пересчет корзины
                $(this).val(qty_start);
           }
       }); 
    });
    /* ===Пересчет товаров в корзине=== */
 
 
/* ===Галерея товаров=== */
var ImgArr, ImgLen;
//Предварительная загрузка
function Preload (url)
{
   if (!ImgArr){
       ImgArr=new Array();
       ImgLen=0;
   }
   ImgArr[ImgLen]=new Image();
   ImgArr[ImgLen].src=url;
   ImgLen++;
}
$('.item_thumbs a').each(function(){
   Preload( $(this).attr('href') );
})


//обвес клика по превью
$('.item_thumbs a').click(function(e){
   e.preventDefault();
   if(!$(this).hasClass('active')){
       var target = $(this).attr('href');

       $('.item_thumbs a').removeClass('active');
       $(this).addClass('active');

       $('.item_img img').fadeOut('fast', function(){
           $(this).attr('src', target).load(function(){
               $(this).fadeIn();
           })
       })
   }
});
$('.item_thumbs a:first').trigger('click');
/* ===Галерея товаров=== */




 
/*     Редактирование профиля пользователя     */
 
/*function show_edit(){
    $('#user_edit').css('display','table');
    $('#user_cab').css('display','none');
} 
function show_cab(){
    $('#user_cab').css('display','table');
    $('#user_edit').css('display','none');
} */
 
////    Переключатель на изменеие профиля ////
/*$("#toggle1").toggle( 
    function(){
        $("#user_edit").css({'display':'table'});
        $("#user_cab").css({'display':'none'});
    },
    function(){
        $("#user_cab").css({'display':'table'});
        $("#user_edit").css({'display':'none'});
    }
);  
*/

/*         Ajax вывод новинки/лидеры/скидки        */
$(".ajax_cat").click(function(e){
        e.preventDefault();        
        var cat = $(this).attr("href").slice(6);
        alert(cat);
        $.ajax({
            type: 'POST',
            url: './',
            data: {cajax:cat},
            error:function(){
                alert("Ошибка!");
            },
            success: function(data){
                //alert(data);
                var data = JSON.parse(data);
                console.log(data);
                //$(".new").html("<p>AJAX</p>" + data);
                //alert(data.goods_id);
               	for(var i = 0; i < data.length; i++){
					var p = "#"+arr[i]['page_id']+ ">.position";
                    console.log(p);
					$(p).text(arr[i]['position']);
				}
						///
        /*        var row = '';
                var i =0;
                for (i in data) {
                    row += '<br>'+data[i].name;
                };*/
                $('.search-result').html(row)                  
            }
   })
    
});
/*         Ajax вывод новинки/лидеры/скидки        */


/*      Капча    */
// функция для генерации случайных чисел в диапазоне от m до n
/*function randomNumber(m,n){
    m = parseInt(m);
    n = parseInt(n);
    return Math.floor( Math.random() * (n - m + 1) ) + m;
};

var aspmA = randomNumber(1,23); // генерируем число
var aspmB = randomNumber(1,23); // генерируем число
var sumAB = aspmA + aspmB;  // вычисляем сумму
document.getElementById('aspm').innerHTML = aspmA + ' + ' + aspmB + ' = ';  // показываем пользователю выражение
document.formName.md5.value = md5(sumAB);  // присваиваем скрытому полю name="md5" контрольную сумму
/*          Капча               */


/*          Md5               */
/*var md5 = function (string) {

        function RotateLeft(lValue, iShiftBits) {
                return (lValue<<iShiftBits) | (lValue>>>(32-iShiftBits));
        }

        function AddUnsigned(lX,lY) {
                var lX4,lY4,lX8,lY8,lResult;
                lX8 = (lX & 0x80000000);
                lY8 = (lY & 0x80000000);
                lX4 = (lX & 0x40000000);
                lY4 = (lY & 0x40000000);
                lResult = (lX & 0x3FFFFFFF)+(lY & 0x3FFFFFFF);
                if (lX4 & lY4) {
                        return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
                }
                if (lX4 | lY4) {
                        if (lResult & 0x40000000) {
                                return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
                        } else {
                                return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
                        }
                } else {
                        return (lResult ^ lX8 ^ lY8);
                }
        }

        function F(x,y,z) { return (x & y) | ((~x) & z); }
        function G(x,y,z) { return (x & z) | (y & (~z)); }
        function H(x,y,z) { return (x ^ y ^ z); }
        function I(x,y,z) { return (y ^ (x | (~z))); }

        function FF(a,b,c,d,x,s,ac) {
                a = AddUnsigned(a, AddUnsigned(AddUnsigned(F(b, c, d), x), ac));
                return AddUnsigned(RotateLeft(a, s), b);
        };

        function GG(a,b,c,d,x,s,ac) {
                a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b, c, d), x), ac));
                return AddUnsigned(RotateLeft(a, s), b);
        };

        function HH(a,b,c,d,x,s,ac) {
                a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b, c, d), x), ac));
                return AddUnsigned(RotateLeft(a, s), b);
        };

        function II(a,b,c,d,x,s,ac) {
                a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b, c, d), x), ac));
                return AddUnsigned(RotateLeft(a, s), b);
        };

        function ConvertToWordArray(string) {
                var lWordCount;
                var lMessageLength = string.length;
                var lNumberOfWords_temp1=lMessageLength + 8;
                var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1 % 64))/64;
                var lNumberOfWords = (lNumberOfWords_temp2+1)*16;
                var lWordArray=Array(lNumberOfWords-1);
                var lBytePosition = 0;
                var lByteCount = 0;
                while ( lByteCount < lMessageLength ) {
                        lWordCount = (lByteCount-(lByteCount % 4))/4;
                        lBytePosition = (lByteCount % 4)*8;
                        lWordArray[lWordCount] = (lWordArray[lWordCount] | (string.charCodeAt(lByteCount)<<lBytePosition));
                        lByteCount++;
                }
                lWordCount = (lByteCount-(lByteCount % 4))/4;
                lBytePosition = (lByteCount % 4)*8;
                lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80<<lBytePosition);
                lWordArray[lNumberOfWords-2] = lMessageLength<<3;
                lWordArray[lNumberOfWords-1] = lMessageLength>>>29;
                return lWordArray;
        };

        function WordToHex(lValue) {
                var WordToHexValue="",WordToHexValue_temp="",lByte,lCount;
                for (lCount = 0;lCount<=3;lCount++) {
                        lByte = (lValue>>>(lCount*8)) & 255;
                        WordToHexValue_temp = "0" + lByte.toString(16);
                        WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2);
                }
                return WordToHexValue;
        };

        function Utf8Encode(string) {
                string = string.replace(/\r\n/g,"\n");
                var utftext = "";

                for (var n = 0; n < string.length; n++) {

                        var c = string.charCodeAt(n);

                        if (c < 128) {
                                utftext += String.fromCharCode;
                        }
                        else if((c > 127) && (c < 2048)) {
                                utftext += String.fromCharCode((c >> 6) | 192);
                                utftext += String.fromCharCode((c & 63) | 128);
                        }
                        else {
                                utftext += String.fromCharCode((c >> 12) | 224);
                                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                                utftext += String.fromCharCode((c & 63) | 128);
                        }

                }

                return utftext;
        };

        var x=Array();
        var k,AA,BB,CC,DD,a,b,c,d;
        var S11=7, S12=12, S13=17, S14=22;
        var S21=5, S22=9 , S23=14, S24=20;
        var S31=4, S32=11, S33=16, S34=23;
        var S41=6, S42=10, S43=15, S44=21;

        string = Utf8Encode(string);

        x = ConvertToWordArray(string);

        a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;

        for (k=0;k<x.length;k+=16) {
                AA=a; BB=b; CC=c; DD=d;
                a=FF(a,b,c,d,x[k+0], S11,0xD76AA478);
                d=FF(d,a,b,c,x[k+1], S12,0xE8C7B756);
                c=FF(c,d,a,b,x[k+2], S13,0x242070DB);
                b=FF(b,c,d,a,x[k+3], S14,0xC1BDCEEE);
                a=FF(a,b,c,d,x[k+4], S11,0xF57C0FAF);
                d=FF(d,a,b,c,x[k+5], S12,0x4787C62A);
                c=FF(c,d,a,b,x[k+6], S13,0xA8304613);
                b=FF(b,c,d,a,x[k+7], S14,0xFD469501);
                a=FF(a,b,c,d,x[k+8], S11,0x698098D8);
                d=FF(d,a,b,c,x[k+9], S12,0x8B44F7AF);
                c=FF(c,d,a,b,x[k+10],S13,0xFFFF5BB1);
                b=FF(b,c,d,a,x[k+11],S14,0x895CD7BE);
                a=FF(a,b,c,d,x[k+12],S11,0x6B901122);
                d=FF(d,a,b,c,x[k+13],S12,0xFD987193);
                c=FF(c,d,a,b,x[k+14],S13,0xA679438E);
                b=FF(b,c,d,a,x[k+15],S14,0x49B40821);
                a=GG(a,b,c,d,x[k+1], S21,0xF61E2562);
                d=GG(d,a,b,c,x[k+6], S22,0xC040B340);
                c=GG(c,d,a,b,x[k+11],S23,0x265E5A51);
                b=GG(b,c,d,a,x[k+0], S24,0xE9B6C7AA);
                a=GG(a,b,c,d,x[k+5], S21,0xD62F105D);
                d=GG(d,a,b,c,x[k+10],S22,0x2441453);
                c=GG(c,d,a,b,x[k+15],S23,0xD8A1E681);
                b=GG(b,c,d,a,x[k+4], S24,0xE7D3FBC8);
                a=GG(a,b,c,d,x[k+9], S21,0x21E1CDE6);
                d=GG(d,a,b,c,x[k+14],S22,0xC33707D6);
                c=GG(c,d,a,b,x[k+3], S23,0xF4D50D87);
                b=GG(b,c,d,a,x[k+8], S24,0x455A14ED);
                a=GG(a,b,c,d,x[k+13],S21,0xA9E3E905);
                d=GG(d,a,b,c,x[k+2], S22,0xFCEFA3F8);
                c=GG(c,d,a,b,x[k+7], S23,0x676F02D9);
                b=GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);
                a=HH(a,b,c,d,x[k+5], S31,0xFFFA3942);
                d=HH(d,a,b,c,x[k+8], S32,0x8771F681);
                c=HH(c,d,a,b,x[k+11],S33,0x6D9D6122);
                b=HH(b,c,d,a,x[k+14],S34,0xFDE5380C);
                a=HH(a,b,c,d,x[k+1], S31,0xA4BEEA44);
                d=HH(d,a,b,c,x[k+4], S32,0x4BDECFA9);
                c=HH(c,d,a,b,x[k+7], S33,0xF6BB4B60);
                b=HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);
                a=HH(a,b,c,d,x[k+13],S31,0x289B7EC6);
                d=HH(d,a,b,c,x[k+0], S32,0xEAA127FA);
                c=HH(c,d,a,b,x[k+3], S33,0xD4EF3085);
                b=HH(b,c,d,a,x[k+6], S34,0x4881D05);
                a=HH(a,b,c,d,x[k+9], S31,0xD9D4D039);
                d=HH(d,a,b,c,x[k+12],S32,0xE6DB99E5);
                c=HH(c,d,a,b,x[k+15],S33,0x1FA27CF8);
                b=HH(b,c,d,a,x[k+2], S34,0xC4AC5665);
                a=II(a,b,c,d,x[k+0], S41,0xF4292244);
                d=II(d,a,b,c,x[k+7], S42,0x432AFF97);
                c=II(c,d,a,b,x[k+14],S43,0xAB9423A7);
                b=II(b,c,d,a,x[k+5], S44,0xFC93A039);
                a=II(a,b,c,d,x[k+12],S41,0x655B59C3);
                d=II(d,a,b,c,x[k+3], S42,0x8F0CCC92);
                c=II(c,d,a,b,x[k+10],S43,0xFFEFF47D);
                b=II(b,c,d,a,x[k+1], S44,0x85845DD1);
                a=II(a,b,c,d,x[k+8], S41,0x6FA87E4F);
                d=II(d,a,b,c,x[k+15],S42,0xFE2CE6E0);
                c=II(c,d,a,b,x[k+6], S43,0xA3014314);
                b=II(b,c,d,a,x[k+13],S44,0x4E0811A1);
                a=II(a,b,c,d,x[k+4], S41,0xF7537E82);
                d=II(d,a,b,c,x[k+11],S42,0xBD3AF235);
                c=II(c,d,a,b,x[k+2], S43,0x2AD7D2BB);
                b=II(b,c,d,a,x[k+9], S44,0xEB86D391);
                a=AddUnsigned(a,AA);
                b=AddUnsigned(b,BB);
                c=AddUnsigned(c,CC);
                d=AddUnsigned(d,DD);
        }

        var temp = WordToHex(a)+WordToHex(b)+WordToHex+WordToHex(d);

        return temp.toLowerCase();
}



/*        Загрузка товаров        */ 
/*$('.ajax_cat').click(function(){
    var href = $(this).attr('href');
    var category = $_GET['view'];
    $.ajax({
        url:'./',
        cache: false,
        type:'POST',
        data:{a:category},
        success:function(res){
            if(res){
               // $(".content").hide().fadeIn(500).html(res); 
               alert("УСПЕХ!");     
            }
        }
        error:function(){
            alert("Error!");
        }
    })
}); */

/*     возвращение параметров uri     */
/*
$.extend({
  getUrlVars: function(){
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
      hash = hashes[i].split('=');
      vars.push(hash[0]);
      vars[hash[0]] = hash[1];
    }
    return vars;
  },
  getUrlVar: function(name){
    return $.getUrlVars()[name];
  }
});

//Получить объект с URL параметрами
var allVars = $.getUrlVars();

// Получит параметр URL по его имени
var byName = $.getUrlVar('view');



function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}
var id = getUrlVars()["view"];  
//alert(id);            */
/*     возвращение параметров uri     */


/*!!!!!!!!!!!$('.ajax_cat').click(function(e){
    e.preventDefault();
    var regV = /[a-z0-9]{2-15}/gi;
    var cat = $(this).attr("href").slice(6);
    //alert(cat);
    $.ajax({
       url:'./',
       cache: false,
       type:'POST',
       data:{cajax:cat},
       success:function(res){
            //alert("Успех: ");
            //то сохраняем этот массив в переменную arr
        var arr = JSON.parse(res);
        var a = arr.length;     !!!!!!!!!*/
       // console.log(arr.length);
        
       // alert(a);
        //document.write("Количество элементов: " + a);
			//в цикле проходимся по массиву и записываем новые значения позиций страниц в соответствующий столбец таблицы
		/*	for(var i = 0; i < arr.length; i++) {
			var p = "#"+arr[i]['goods_id']+ ">.position";
			$(p).text(arr[i]['goods_id']);
			}*/
            //
           //записываем новые значения позиций ссылок в соответствующий столбец таблицы
		/*	for(var i = 0; i < arr.length; i++) {
            var p = ".popular>div#"+cajax+" #"+arr[i]['name']+ " .goods_name";
            //alert(p);
			$(p).text(arr[i]['name']);
            }
            */
          //  $(".product").hide().fadeIn(500).html(res);

//вывод
  /*  var i = 0;*/
  //  console.log("i = ", i);
  //  console.log("a = ", a);
  //  console.log("arr = ", arr[i]['goods_id']);
   // alert(a+'   a;    i:     '+i);
    //alert(arr[1]['goods_id']);
    //var a=arr.length;
   // alert("Первый элемент: "+arr[0]['name'] + "<br />С индексом: " +arr[0]['goods_id'] + "<br />А последний элемент: "+arr[a]['name'] + "<br />С индексом: " +arr[a]['goods_id']);
/*!!!!!!!!!!!
$(".product").html(res);!!!!!!!!!!!!!!!!!*/
/*while(i < a){
    console.log("i = ", i, "arr[id] = ",arr[i]['goods_id']);
            $(".product").hide().fadeIn(500).html(arr);
             i++;
    } 
*/

 /*   while(i <= a){
    console.log("i = ", i, "arr[id] = ",arr[i]['goods_id']);
            $(".product").hide().fadeIn(500).html(
            "<a class='position' href='?view=product&goods_id=" + arr[i]['goods_id'] + "'><img class='content-img' src='http://ishop/userfiles/product_img/baseimg/"+arr[i]['img']+"' alt='картинка' /></a> <h2><a href='?view=product&goods_id="+arr[i]['goods_id']+"'>" + arr[i]['name'] + "</a></h2>"+
            "<p><span>"+arr[i]['price']+"</span> грн.</p>"+
            "<a href='?view=addtocard&goods_id="+arr[i]['goods_id']+"'><img class='buy-index' src='views/ishop/img/buy-index.png' alt='Купить' /></a>");
    i++;
    }  */
    
/*   while(i <= a){
    console.log("i = ", i, "arr[id] = ",arr[i]['goods_id']);
            $(".product").hide().fadeIn(500).html(
                "<a class='position' href='?view=product&goods_id=" + arr[i]['goods_id'] + "'><img class='content-img' src='http://ishop/userfiles/product_img/baseimg/"+arr[i]['img']+"' alt='картинка' /></a> <h2><a href='?view=product&goods_id="+arr[i]['goods_id']+"'>" + arr[i]['name'] + "</a></h2>"+
            "<p><span>"+arr[i]['price']+"</span> грн.</p>"+
            "<a href='?view=addtocard&goods_id="+arr[i]['goods_id']+"'><img class='buy-index' src='views/ishop/img/buy-index.png' alt='Купить' /></a>");
    i++;
    }
*/

/*
for(i = 0; i < a; i++){
    var p = "div#"+arr[i]['goods_id'] +">.position";
     console.log(p);
    $(p).text(arr[i]['goods_id']);
}
*/





  /*   for(var i = 0; i < a; i++){
            $(".product").hide().fadeIn(500).html(
                "<div class='product'><a class='position' href='?view=product&goods_id=" + arr[i]['goods_id'] + "'><img class='content-img' src='"+arr[i]['img']+"' alt='картинка' /></a> <h2><a href='?view=product&goods_id="+arr[i]['goods_id']+"'>" + arr[i]['name'] + "</a></h2>"+
            "<p> <span>"+arr[i]['price']+"</span> грн.</p>"+
            "<a href='?view=addtocard&goods_id="+arr[i]['goods_id']+"'><img class='buy-index' src='img/buy-index.png' alt='Купить' /></a></div>");
         }  */     
/*  !!!!!!!!!!!!!!!!!     },
       error:function(){
        alert("Ошибка");
       } 
    })
});
!!!!!!!!!!!!!!!!!!!!!*/

});