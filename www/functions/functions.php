<?php defined ('ISHOP') or die ('Access denied');
/*=====Распечатка массива=====*/
function print_arr($arr){
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
	}
/*=====Распечатка массива=====*/
/*      Очистка входящих данных  (фильтрация)      */
function clear($var){
    $var = mysql_real_escape_string(strip_tags($var));
    return $var;
}
/*   Подсвечивание активного пункта меню   */
function active_url1($str = 'view=leader'){
   $uri = $_SERVER['QUERY_STRING']; //получаем параметры из адресной строки
    if(!$uri) $uri = "view=leader"; //если параметров нет, то это будет параметр по умолчанию
    $uri = explode("&", $uri); //разбиваем строку по разделителю на массив
    if(preg_match("#page=#", end($uri))) array_pop($uri); //если есть параметр page навигации, то удаляем его
    
    if(in_array($str, $uri)){
        //если в массиве параметров есть строка  - тогда это активный пункт меню
        return "class='nav-activ'";
    }
}
/*   Подсвечивание активного пункта меню   */
/*=====Редирект=====*/
/*function redirect($http = false){ //перенаправляем админа на ту стр откуда он пришел к нам
    if($http) $redirect = $http;
        else  $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    header("Location: $redirect");
    exit;
}*/
function redirect($http = false){
    if($http) $redirect = $http;
        else    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    header("Location: $redirect");
    exit;
}
/*=====Редирект=====*/



/*=====Редирект=====
function redirect(){
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    header("Location: $redirect");
    exit;
}
=====Редирект=====*/


/*====Выход пользователя====*/
function logout(){
    unset($_SESSION['auth']);
}


/*=======Добавление в корзину=======*/
function addtocard($goods_id, $qty_goods, $qty = 1){
    if (isset($_SESSION['card'][$goods_id])){//если в масиве уже есть добавленный товар с таким id. isset - существует
        //if($_SESSION['card'][$goods_id]['qty'] < $qty_goods){
            $_SESSION['card'][$goods_id]['qty'] += $qty; //увеличиваем кол-во данного товара, если нажали повторно
            return $_SESSION['card']; //возвращаем корзину
        //}else{
            //$_SESSION['card']['qty_goods'] = "Количество данного товара не должно превышать текущее.";
            //continue;            
        //}
    }else{
        // если товар впервые кладется в корз
        $_SESSION['card'][$goods_id]['qty'] = $qty;
        return $_SESSION['card']; //возващаем корзину
    }   
}
/*=======Добавление в корзину=======*/


/*=========Суммируем количество + защита от ввода несущ товара =============*/
function total_quantity(){
//кол-во товаров в корзине, защита от ввода несущ id
$_SESSION['total_quantity'] = 0; //корзина изначально пуста, т е колво товаров = 0
 foreach($_SESSION['card'] as $key => $value){
    if(isset($value['price'])){
        //если элемент с индексом "цена" в массиве value существует => суммируем кол-во
        $_SESSION['total_quantity'] += $value['qty'];
    }else{
        //иначе - удаляем этот id из корзины
        unset($_SESSION['card'][$key]);
    }
}    
}
/*=========Суммируем количество=============*/




/*=======Удаление из корзины =========*/
function delete_from_card($id){
    if($_SESSION['card']){
        if(array_key_exists($id, $_SESSION['card'])); //ищем поулченный id в массиве корзины
        $_SESSION['total_quantity'] -= $_SESSION['card'][$id]['qty'];
        $_SESSION['total_sum'] -= $_SESSION['card'][$id]['qty'] * $_SESSION['card'][$id]['price'];
        unset($_SESSION['card'][$id]);
    }
}
/*=======Удаление из корзины =========*/

/*====Постраничная навигация======*/
function pagination($page, $pages_count){
    if($_SERVER['QUERY_STRING']){ //если есть параметры в адресной строке
        foreach($_GET as $key => $value){ //проходимся в цикле по этим параметрам. они хранятся в GET
            //формируем строку параметров, без номера страницы (номер стр передается параметром функции)
            if($key != 'page') $uri .= "{$key}={$value}&amp;";   //заменяем & на его мнемонику - &amp (сущность, представление)                      
        }        
    }   //формирование ссылок
        $back ='';      //назад
        $forward = '';  //вперед
        $startpage = ''; //в начало
        $endpage = '';     //в конец
        $page2left = ''; //вторая стр слева
        $page1left = ''; //первая стр слева
        $page2right = ''; //вторая стр справа
        $page1right = ''; //первая стр справа
                
        
        if($page > 1){ //ссылка назад
            $back = "<a class='i-previous' href='?{$uri}page=" .($page-1). "'title='Предыдущая'>&#8249;</a>";
        } 
        if($page < $pages_count){ //ссылка вперед
            $forward = "<a class='i-next' href='?{$uri}page=" .($page+1). "'title='Следующая'>&#8250;</a>";
        }
        if($page > 3){ //ссылка в начало, на первую страницу
            $startpage = "<a class='i-previous' href='?{$uri}page=1' title='Первая'>&laquo;</a>"; 
        }
        if($page < ($pages_count - 2)){ //ссылка в конец, на последнюю страницу
            $endpage = "<a class='i-next' href='?{$uri}page={$pages_count}'title='Последняя'>&raquo;</a>"; 
        }
        if($page - 2 > 0){ 
            $page2left = "<a href='?{$uri}page=" .($page-2). "'>" .($page-2). "</a>"; 
        }
        if($page - 1 > 0){ 
            $page1left = "<a href='?{$uri}page=" .($page-2). "'>" .($page-1). "</a>"; 
        }
        if($page + 2 <= $pages_count){ 
            $page2right = "<a href='?{$uri}page=" .($page+2). "'>" .($page+2). "</a>"; 
        }
        if($page + 1 <= $pages_count){ 
            $page1right = "<a href='?{$uri}page=" .($page+1). "'>" .($page+1). "</a>"; 
        }
        
        //вывод навигации
        echo  '<div class="pager" align="bottom">' .$startpage.$back.$page2left.$page1left.'<a class="current">'.$page.'</a>'.$page1right.$page2right.$forward.$endpage. '</div>';
    }
/*====Постраничная навигация======*/?>