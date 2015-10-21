$(document).ready(function(){
    
    /* ===Аккордеон=== */
    var openItem = false;
	if(jQuery.cookie("openItem") && jQuery.cookie("openItem") != 'false'){
		openItem = parseInt(jQuery.cookie("openItem"));
	}	
	jQuery("#accordion").accordion({
		active: openItem,
		collapsible: true,
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
    
    /* ===Переключатель вида=== */
    if($.cookie("display") == null){
        $.cookie("display", "grid");
    }
    
    $(".grid_list").click(function(){
        var display = $(this).attr("id"); // получаем значение переключателя вида
        display = (display == "grid") ? "grid" : "list"; // допустимые значения
        if(display == $.cookie("display")){
            // если значение совпадает с кукой - ничего не делаем
            return false;   
        }else{
            // иначе - установим куку с новым значением вида
            $.cookie("display", display);
            window.location = "?" + query;
            return false;
        }
    });
    /* ===Переключатель вида=== */
    
    /* ===Авторизация=== */
    $("#auth").click(function(e){
        e.preventDefault();
        var login = $("#login").val();
        var pass = $("#pass").val();
        var auth = $("#auth").val();
        $.ajax({
           url: './',
           type: 'POST',
           data: {auth: auth, login: login, pass: pass},
           success: function(res){
                if(res != 'Поля логин/пароль должны быть заполнены!' && res != 'Логин/пароль введены неверно!'){
                    // если пользователь успешно авторизован
                    $(".authform").hide().fadeIn(500).html(res + '<a href="?do=logout">Выход</a>');
                }else{
                    // если авторизация неудачна
                    $(".error").remove();
                    $(".authform").append('<div class="error"></div>');
                    $(".error").hide().fadeIn(500).html(res);
                }
           },
           error: function(){
                alert("Error!");
           }
        });
    });
    /* ===Авторизация=== */
    
    /* ===Клавиша ENTER при пересчете=== */
    $(".kolvo").keypress(function(e){
        if(e.which == 13){
            return false;
        }
    });
    /* ===Клавиша ENTER при пересчете=== */
    
    /* ===Пересчет товаров в корзине=== */
    $(".kolvo").each(function(){
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
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
});