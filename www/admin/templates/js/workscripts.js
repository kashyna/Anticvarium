$(document).ready(function(){

//Аккордеон
    /* ===Аккордеон=== */
    var openItem = false;
	if($.cookie("openItem") && $.cookie("openItem") != 'false'){
		openItem = parseInt($.cookie("openItem"));
	}	
	$("#accordion").accordion({
		active: openItem,
		collapsible: true,
        autoHeight: false,
        header: 'h3'
	});
	$("#accordion h3").click(function(){
		$.cookie("openItem", $("#accordion").accordion("option", "active"));
	});	
	$("#accordion > li").click(function(){
		$.cookie("openItem", null);
        var link = $(this).find('a').attr('href');
        window.location = link;
	});
    /* ===Аккордеон=== */


/*$("#accordion").accordion({
    header: 'li.header_li', //свой-во указывающее какой пункт является родительским
    autoHeight:false,
    collapsible: true,
    active: false
}); */
//Аккордеон    

//удаление
$(".del").click(function(){
    var res = confirm("Подтвердите удаление:");
    if(!res) return false; //отменем переход по ссылке с классом del    
});
//удаление


//информеры, переключатель
$(".toggle").click(function(){
   $(this).parent().next().slideToggle(500);
   
   if($(this).parent().attr("class") == "inf-down"){
        $(this).parent().removeClass("inf-down");
        $(this).parent().addClass("inf-up");
   }else{
        $(this).parent().removeClass("inf-up");
        $(this).parent().addClass("inf-down");
   }
});
//информеры, переключатель


//страницы, сортировка
$('#sort tbody').sortable({
    //стиль для пустого места - куда можно перемещать объект при сортировке.
    //placeholder: "ui-state-default",
    //исключаем элементы, кот не нужно сортировать - название полей таблицы
    items: "tr:not(.no_sort)",
    //перетаскивать только по оси У
    axis: 'y', 
    opacity: 0.5, //параметр (или свойство)
    //чтобы элементы не выходили за этот блок с классом content
    containment: '.content', 
    //окончание перемещения
    stop: function(){
        //получаем массив идентификаторов страниц - в новом порядке, для каждой строки таблицы был добавлен атрибут id
        var id_s = $('#sort tbody').sortable("toArray");
        //показ блока с вращающимся изображением - начало сортировки
        $(".load").fadeIn(300);
        //alert(id_s);
        //метод ajax, для отправки данных без перезагрузки страницы
        $.ajax({
            url: 'index.php', //адрес скрипта, принимающего данные
            type: 'POST', //метод передачи данных
            data: {sortable:id_s}, //sortable - переменная, которая будет передана в файл index.php,
                                    //и ее значение будет равно значению, которое содержится в id_s
            //событие error
            error: function(){
                $(".load").fadeOut(200);
                $('.res').text("Ошибка!").fadeIn(300); 
            },
            //событие success
            success: function(html){
				//плавно скрываем вращающиеся изображение и...
				$(".load").fadeOut(200,function () {
				//проверяем что вернулось нам в качестве ответа, если вернулся массив
				    if(html) {
						///
							//то сохраняем этот массив в переменную arr
							var arr = JSON.parse(html);
							//в цикле проходимся по массиву и записываем новые значения позиций страниц в соответствующий столбец таблицы
							for(var i = 0; i < arr.length; i++) {
								var p = "#"+arr[i]['page_id']+ ">.position";
                                console.log(p);
								$(p).text(arr[i]['position']);
							}
						///
							//Показываем блок с сообщением об успешности выполнения сортировки.
							$(".res").text("Изменения сохранены!").stop(true, true).fadeIn(300).fadeOut(2000);
						}
						if(!html){
						//если ЛОЖЬ то выводим сообщение о ошибке
							$(".res").text("Ошибка!").css({"border":"1px solid red","backgroundColor":"#ffb7b7"}).fadeIn(300).fadeOut(5000);
						}	
					});	
            }
        });
    }
    
});
//запрет выделения
$( "#sort tbody" ).disableSelection();

//страницы, сортировка


//сортировка ссылок - аналогично страницам, только передаем в файл index.php кроме идентификаторов,идентификатор информера к которому принадлежат ссылки
	$(".inf-page tbody").sortable({
		axis: "y",
		opacity: 0.5,
		placeholder: "ui-state-highlight1",
		items: "tr:not(.no_sort)",
		stop: function(){
			// идентификаторы ссылок после перемещения
			var id_s = $(this).sortable("toArray");
			//идентификатор родительского информера
			var parent = $(this).parent().attr('id');
			$(".load").fadeIn(300);
			
			$.ajax({
				url: 'index.php',
				type: 'POST',
				data: {sort_link:id_s,parent:parent},
				error: function(){
					$(".load").fadeOut(200);
					$('.res').text("Ошибка!").fadeIn(300);
				},
				success: function(html){
					$(".load").fadeOut(200,function () {
						if(html) {
							var arr1 = JSON.parse(html);
							for(var i = 0; i < arr1.length; i++) {
                                //записываем новые значения позиций ссылок в соответствующий столбец таблицы
								var p = ".inf-page>table#"+parent+" #"+arr1[i]['link_id']+ " .position";
                                console.log(p);
								$(p).text(arr1[i]['link_position']);
							}
						///
							$(".res").text("Изменения сохранены").stop(true, true).fadeIn(300).fadeOut(2000);
						}
						if(!html){
							$(".res").text("Ошибка").css({"border":"1px solid red","backgroundColor":"#ffb7b7"}).fadeIn(300).fadeOut(5000);
						}
					
					});
					
				}
			
			});
		}
   	});
	//сортировка информеров - аналогично страницам
	$("#sort_inf").sortable({
		axis: "y",
		opacity: 0.5,
		placeholder: "ui-state-highlight2",
		delay: 200,
		stop: function(){
			var id_s = $(this).sortable("toArray");
			$(".load").fadeIn(300);
			
			$.ajax({
				url: 'index.php',
				type: 'POST',
				data: {sort_inf:id_s},
				error: function(){
					$(".load").fadeOut(200);
					$('.res').text("Ошибка!").fadeIn(300);
				},
				success: function(html){
					$(".load").fadeOut(200,function () {
						if(html) {
						///
							$(".res").text("Изменения сохранены!").stop(true, true).fadeIn(300).fadeOut(2000);
						}
						if(!html){
							$(".res").text("Ошибка!").css({"border":"1px solid red","backgroundColor":"#ffb7b7"}).fadeIn(300).fadeOut(5000);
						}
					
					});
					
				}
			
			});
		}	
		
	});
	//сортировка информеров

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

//поля для загрузки картинок галереи
/*var max = 6;
var min = 1;
$("#del").attr("disabled", true); //отбираем в набор элемент с id дел, и для его атрибута устанавливаем значение true
$("#add").click(function(){
    var total = $("input[name='galleryimg[]']").length; //считаем кол-во полей
    if(total < max){
        $("#btnimg").append('<div><input type="file" name="galleryimg[]" /></div>'); //добавляем еще одно поле для загрузки файла
        if(max == total + 1){ //если кол-во полей больше max, то 
            $("#add").attr("disabled", true); //делаем неактивной кнопку "добавить поле"
        }
        $("#del").removeAttr("disabled"); //делаем активной кнопку - удалить поле
    }
});
    $("#del").click(function(){  //удаление последнего поля
       var total = $("input[name='galleryimg[]']").length; //считаем кол-во полей
       if(total > min){
            $("#btnimg div:last-child").remove(); // находим последнее поле и удаляем 
            if(min == total - 1){
                $("#del").attr("disabled", true); //делаем кнопку неактивной, если осталось одно поле
            }//запрещаем удалять последнее поле
            $("#add").removeAttr("disabled");
       }
    });*/
//поля для загрузки картинок галереи
 $(".delimg").on("click", function(){
    var res = confirm("Подтвердите удаление");
    if(!res) return false;
    
    var img = $(this).attr("alt"); //обращаемся к текущей картинке и получаем атрибут alt
    var rel = $(this).attr("rel"); // 0 - базовая картинка, 1 - картинка галереи
    var goods_id = $("#goods_id").text(); // ID товара
    $.ajax({
        url: "./",
        type: "POST",
        data: {img: img, rel: rel, goods_id: goods_id},
        success: function(res){
            if(rel == 0){
                //удалили картинку базовую
                $(".baseimg").fadeOut(500, function(){
                    $(".baseimg").empty().fadeIn(500).html(res);
                });
            }/*
            else{
                //удалили картинку галереи
                $(".slideimg").find("img[alt='" + img + "']").hide(500);
            }*/
        },
        error: function(){
            alert("ERROR");
        }
    }); //конец ajax
    
    });



/*
//удаление картинки
   // удаление картинок
    $(".delimg").on("click", function(){
        var res = confirm("Подтвердите удаление");
        if(!res) return false;
        
        var img = $(this).attr("alt"); // имя картинки
        var rel = $(this).attr("rel"); // 0 - базовая картинка, 1 - картинка галереи
        var goods_id = $("#goods_id").text(); // ID товара
        $.ajax({
            url: "./",
            type: "POST",
            data: {img: img, rel: rel, goods_id: goods_id},
            success: function(res){
                if(rel == 0){
                    // базовая картинка
                    $(".baseimg").fadeOut(500, function(){
                        $(".baseimg").empty().fadeIn(500).html(res);
                    });
                }else{
                    // картинка галереи
                    $(".slideimg").find("img[alt='" + img + "']").hide(500);
                }
            },
            error: function(){
                alert("Error");
            }
        });
    });
    // удаление картинок

*/





// удаление картинок
/*$(".del").click(function(){
    var res = confirm("Подтвердите удаление:");
    if(!res) return false; //отменем переход по ссылке с классом del    
});

$(".delimg").on("click", function(){
    var res = confirm("Подтвердите удаление изображения:");//формируем запрос на подтверждение удаления
    if(!res) return false; //прекратим дальнейшее выполнение скрипта
    
    var img = $(this).attr("alt"); //имя фото
    var rel = $(this).attr("rel"); // 0 -базовая картинка, 1 - картинка галереи
    var goods_id = $("#goods_id").text(); // id товара
  $.ajax({
       url: "./",
       type: "POST",
       data: {img: img, rel: rel, goods_id: goods_id},
       success: function(){
            if(rel == 0){
                //ббазовая картинка
                $(".baseimg").fadeOut(500, function(){
                    $(".baseimg").empty().fadeIn(500).html(res);
                });
            }else{
                //из галереи
            }
       },
       error: function(){
            alert("Error");
       } 
    });
});*/
//удаление картинки
});