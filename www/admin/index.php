<?php

// запрет прямого обращения
define('ISHOP', TRUE);

session_start();

//выход админа
if($_GET['do'] == "logout"){
    unset($_SESSION['auth']['admin']);
    unset($_SESSION['auth']['user_id']);
}

//авторизация админа
if(!$_SESSION['auth']['admin']){ //возвращает ложь - такого элемента нет
    //подключаем файл авторизации админа
include $_SERVER['DOCUMENT_ROOT'].'/admin/auth/index.php';//document root вернет путь к корневой директории ishop/www
}


//подключаем конфигурационный файл
require_once '../config.php';

//подключаем файл функ-й из пользоват части
require_once '../functions/functions.php';

//подключаем файл функ-й из административной части
require_once 'functions/functions.php';


//получение количества необработанных заказов
$count_new_orders = count_new_orders();

//удаление картинки
if($_POST['img']){
    $res = del_img();
    exit($res);//вывод на экран для ajax, чтобы он мог им оперировать
}

//валидация и проверка на уникальность логина и email
if($_POST['val']){
    echo access_field();
    //print_arr($_POST);
    exit;
}

//сортировка страниц
if($_POST['sortable']){
    $result = sort_pages($_POST['sortable']);
    if(!$result){
        exit(FALSE);
    }    
    exit(json_encode($result));
}

//сортировка ссылок
if($_POST['sort_link']){    
    
   	//проверяем есть ли идентификатор информера к которому принадлежат ссылки
	if(array_key_exists('parent',$_POST)) {
		$parent = $_POST['parent'];
		unset($_POST['parent']);
	}
	else {
		exit(FALSE);
	}
    
    $result = sort_link($_POST['sort_link'], $parent);
    if(!$result){
        exit(FALSE);
    }
    exit(json_encode($result));
}


//сортировка информеров
if($_POST['sort_inf']){    
    $result = sort_informers($_POST['sort_inf']);
    if(!$result){
        exit(FALSE);
    }
    exit(json_encode($result));
	}

//получение массива каталога
$cat = catalog();

// получение динамичной части шаблона #content
$view = empty($_GET['view']) ? 'pages' : $_GET['view'];

switch($view){
    case('pages'):
        //страницы
        $pages = pages();
    break;
    
    case('informers'):
        //информеры
        $informers = informer();
    break;
    
    case('add_link'):
        //добавление ссылки страницы информера
        $informer_id = (int)$_GET['informer_id'];
        $informers = get_informers(); //получаем список всех информеров
        
        if($_POST){
            if(add_link()) redirect('?view=informers'); //в случае успеха фун-и
                else redirect(); //иначе на эту же страницу возвращаемся
        }
    break;
    
    case('edit_link'):
        //редактирование страницы информера
        $link_id = (int)$_GET['link_id'];
        $informers = get_informers(); //получаем список всех информеров
        $get_link = get_link($link_id);
        
        if($_POST){
            if(edit_link($link_id)) redirect('?view=informers'); //в случае успеха фун-и
            else redirect(); //иначе на эту же страницу возвращаемся
        }    
    break;
    
    case('del_link'):
        //удаление страницы информера
        $link_id = (int)$_GET['link_id'];
        del_link($link_id);
        redirect();
    break;
    
    case('edit_page'):
        //редактирование страницы
        $page_id = (int)$_GET['page_id'];
        $get_page = get_page($page_id);
        
        if($_POST){//проверяем были ли переданы данные из формы
            if(edit_page($page_id)) redirect('?view=pages'); //если фун-я edit_page вернет истину
            else redirect(); //иначе редирект на эту же стр, откуда пришли
        }
    break;
    
    case('add_page'):
        if($_POST){//проверяем были ли переданы данные из формы
            if(add_page()) redirect('?view=pages'); //если фун-я add_page вернет истину
                else redirect(); //иначе редирект на эту же стр, откуда пришли
        }
    break;
    
    case('del_page'):
        $page_id = (int)$_GET['page_id'];
        del_page($page_id);
        redirect();
    break;
    
    case('news'):
        //новости
                
        //постраничная навигация, параметры
        $perpage = 6; //кол-во новостей на страницу
        if(isset($_GET['page'])){ //есть ли номер страницы в адресной строке
            $page = (int)$_GET['page'];
            if($page < 1) $page = 1;
        }else{ // пусто в адресной строке нет page
            $page = 1;
        }
        $count_rows = count_news(); //общее кол-во новостей
        $pages_count = ceil($count_rows / $perpage); //кол-во страниц, частное от деления. ceil  -округляет
        if(!$pages_count) $pages_count = 1; //проверяем чтоб общее кол-во страниц не было < 1, еслипользователь введет несуществующую категорию. 
                                                //минимум 1 страница должна быть
        if($page > $pages_count) $page = $pages_count; //если пользователь в адресную строку введет число большее чем реальное кол-во страниц
        $start_position = ($page - 1) * $perpage; //начальная позиция вывода товара (для запроса) 
        
        $all_news = get_all_news($start_position, $perpage);
    break;
    
    case('add_news'):
        //добавление новости
        if($_POST){//проверяем были ли переданы данные из формы
            if(add_news()) redirect('?view=news'); //если фун-я add_page вернет истину
                else redirect(); //иначе редирект на эту же стр, откуда пришли
        }
    break;
    
    case('edit_news'):
        //редактирование новости
        $news_id = (int)$_GET['news_id'];
        $get_news = get_news($news_id);
        
        if($_POST){//проверяем были ли переданы данные из формы
            if(edit_news($news_id)) redirect('?view=news'); //если фун-я edit_page вернет истину
            else redirect(); //иначе редирект на эту же стр, откуда пришли
       }
    break;
    
    case('del_news'):
        $news_id = (int)$_GET['news_id'];
        del_news($news_id);
        redirect();
    break;
    
    case('add_informer'):
        //добавление информера
       if($_POST){
        if(add_informer()) redirect('?view=informers');
        else redirect();
       } 
    break;
    
    case('edit_informer'):
        $informer_id = (int)$_GET['informer_id'];
        $get_informer = get_informer($informer_id);
        if($_POST){
             if(edit_informer($informer_id)) redirect('?view=informers');
                else redirect();
        } 
    break;
    
    case('del_informer'):
            //удаление инфо
        $informer_id = (int)$_GET['informer_id'];
        del_informer($informer_id);
        redirect();
    break;
    
    case('brands'):
        //категории товаров        
    break;
    
    case('add_brand'):
        if($_POST){
             if(add_brand()) redirect('?view=brands');
                else redirect();
        } 
    break;
    
    case('edit_brand'):
        $brand_id = (int)$_GET['brand_id'];
        $parent_id = (int)$_GET['parent_id'];
       // $cat_name = $cat[$brand_id][0]; //имя категории
        if($parent_id == $brand_id OR !$parent_id){ //Если родительская или самостоятельная категория
            $cat_name = $cat[$brand_id][0]; //имя категории
        }else{
            //если дочерняя категория
             $cat_name = $cat[$parent_id]['sub'][$brand_id];
        }
        if($_POST){
            if($parent_id AND edit_brand($brand_id)){
                redirect("?view=cat&amp;category=$brand_id");
            }elseif(edit_brand($brand_id)){
                redirect('?view=brands');
            }else redirect();
           /*  if(edit_brand($brand_id)) redirect('?view=brands');
                else redirect();*/
        }
    break;
    
    case('del_brand'):
        //удаление категории
        $brand_id = (int)$_GET['brand_id'];
        del_brand($brand_id);
        redirect();
    break;
    
    case('cat'):
        $category = (int)$_GET['category'];
        
        //постраничная навигация, параметры
        $perpage = 6; //кол-во товаров на страницу
        if(isset($_GET['page'])){
            $page = (int)$_GET['page'];
            if($page < 1) $page = 1;
        }else{ // пусто в адресной строке нет page
            $page = 1;
        }
        $count_rows = count_rows($category); //общее кол-во товаров данной категории
        $pages_count = ceil($count_rows / $perpage); //кол-во страниц, частное от деления. ceil  -округляет
        if(!$pages_count) $pages_count = 1; //проверяем чтоб общее кол-во страниц не было < 1, еслипользователь введет несуществующую категорию. 
                                                //минимум 1 страница должна быть
        if($page > $pages_count) $page = $pages_count; //если пользователь в адресную строку введет число большее чем реальное кол-во страниц
        $start_position = ($page - 1) * $perpage; //начальная позиция вывода товара (для запроса)
        /*постраничная навигация*/
        
        //хлебные крошки, считаем имя родителя
        $brand_name = brand_name($category);
        $products = products($category, $start_position, $perpage);  //получаем массив из модели
            
    break;
    
    case('add_product'):
        $brand_id = (int)$_GET['brand_id'];
        if($_POST){
            if(add_product()) redirect("?view=cat&category=$brand_id");
            else redirect();
        }
    break;
    
    case('edit_product'):
        $goods_id = (int)$_GET['goods_id'];
        $get_product = get_product($goods_id);
        $brand_id = $get_product['goods_brandid'];
        // если есть базовая картинка
        if($get_product['img'] != "no_image.jpg"){
            $baseimg = '<img class="delimg" rel="0" width="48" src="' .PRODUCTIMG.$get_product['img']. '" alt="' .$get_product['img']. '">';
        }else{
            $baseimg = '<input type="file" name="baseimg" />';
        }
        
        // если есть картинки галереи
        $imgslide = "";
        if($get_product['img_slide']){
            $images = explode("|", $get_product['img_slide']);
            foreach($images as $img){
                $imgslide .= "<img class='delimg' rel='1' alt='{$img}' src='" .GALLERYIMG. "thumbs/{$img}'>";
            }
        }
        // если есть картинки галереи
        
        if($_POST){
            if(edit_product($goods_id)) redirect("?view=cat&category=$brand_id");
                else redirect();
        }
    
    
    
 /*       $goods_id = $_GET['goods_id'];
        $get_product = get_product($goods_id);
        $brand_id = $get_product['goods_brandid'];
        //если есть основная картинка
     if($get_product['img'] != "no_image.jpg"){
            $baseimg = '<img class="delimg" rel="0" width="50px" src="' .PRODUCTIMG. 'baseimg/' .$get_product['img']. '"alt="' .$get_product['img']. '">';
        }else{
            $baseimg = '<input type="file" name="baseimg" />';
        }
     if($_POST){
        if(edit_product($goods_id)) redirect("?view=cat&category=$brand_id"); //если функция вернет истину, тогда мы вернемся в категорию данного товара
        else redirect();      
      }         */ 
    break;
    
//////////    
    case('del_product'):
        //удаление категории
        $goods_id = (int)$_GET['goods_id'];
        del_product($goods_id);
        redirect();
    break;
    
    case('del_img'):
        //удаление картинки товара
        $goods_id = (int)$_GET['goods_id'];
        del_img($goods_id);
        redirect();
    break;
//////////////////  

    case('orders'):
        //подтверждение заказа 
        if(isset($_GET['confirm'])){
            $order_id = (int)$_GET['confirm'];
            if(confirm_order($order_id)){
                $_SESSION['answer'] = "<div class='success'>Статус заказ № {$order_id} успешно изменен.</div>";
            }else{
                $_SESSION['answer'] = "<div class='error'>Заказ № {$order_id} не удалось изменить. Возможно, данного заказа нет или он уже подтвержден.</div>";
            }
            redirect("?view=orders&status=0");
        }
        
        //удаление заказа
        if(isset($_GET['del_order'])){
            $order_id = (int)$_GET['del_order'];
            if(del_order($order_id)){
                $_SESSION['answer'] = "<div class='success'>Заказ успешно удален.</div>";
            }else{
                $_SESSION['answer'] = "<div class='error'>Ошбика при удалении. Возможно этот заказ уже был удален ранее.</div>";
            }
            redirect("?view=orders");
        }
        
        //необработанные заказы
        if($_GET['status'] === '0'){
            $status = " WHERE `order`.status = '0'"; //необработанные заказы
        }else{
            $status = null;
        }        
        
        //постраничная навигация, параметры
        $perpage = 5; //кол-во заказов на страницу
        if(isset($_GET['page'])){ //есть ли номер страницы в адресной строке
            $page = (int)$_GET['page'];
            if($page < 1) $page = 1;
        }else{ // пусто в адресной строке нет page
            $page = 1;
        }
        $count_rows = count_orders($status); //общее кол-во заказов
        $pages_count = ceil($count_rows / $perpage); //кол-во страниц, частное от деления. ceil  -округляет
        if(!$pages_count) $pages_count = 1; //проверяем чтоб общее кол-во страниц не было < 1, еслипользователь введет несуществующую категорию. 
                                                //минимум 1 страница должна быть
        if($page > $pages_count) $page = $pages_count; //если пользователь в адресную строку введет число большее чем реальное кол-во страниц
        $start_position = ($page - 1) * $perpage; //начальная позиция вывода заказа (для запроса) 
     
        
        $orders = orders($status, $start_position, $perpage);
        //$orders = orders($status);
    break;
    
    case('show_order'):
        $order_id = (int)$_GET['order_id'];
        $show_order = show_order($order_id);
        
        //проверяем какой это заказ
        if($show_order[0]['status']){
            $state = "обработан";
        }else{
            $state = "необработан";
        }
    break;
    
    case('users'):
        //постраничная навигация, параметры
        $perpage = 5; //кол-во заказов на страницу
        if(isset($_GET['page'])){ //есть ли номер страницы в адресной строке
            $page = (int)$_GET['page'];
            if($page < 1) $page = 1;
        }else{ // пусто в адресной строке нет page
            $page = 1;
        }
        $count_rows = count_users(); //общее кол-во пользователей
        $pages_count = ceil($count_rows / $perpage); //кол-во страниц, частное от деления. ceil  -округляет
        if(!$pages_count) $pages_count = 1; //проверяем чтоб общее кол-во страниц не было < 1, еслипользователь введет несуществующую категорию. 
                                                //минимум 1 страница должна быть
        if($page > $pages_count) $page = $pages_count; //если пользователь в адресную строку введет число большее чем реальное кол-во страниц
        $start_position = ($page - 1) * $perpage; //начальная позиция вывода заказа (для запроса) 
        
        
        $users = get_users($start_position, $perpage);  
    break;
    
    case('add_user'):
        $roles = get_roles(); //список ролей
        if($_POST){
            if(add_user()) redirect("?view=users");
                else redirect(); //вернемся на страницу добавления пользователя
        }
    break;
    
    case('edit_user'):
       $user_id = (int)$_GET['user_id'];
       $get_user = get_user($user_id); //получаем данные этого пользователя
       $roles = get_roles();
       if($_POST){ //когда будет нажата кнопка сохранить
            if(edit_user($user_id, $get_user['login'], $get_user['email'])) redirect("?view=users");       
            else redirect();
            } 
    break;
    
    case('del_user'):
        $user_id = (int)$_GET['user_id'];
        del_user($user_id);
        redirect();
    break;
    
    default:
    // если в адресной строке ввели имя не существующего вида
    $view = 'pages';
    $pages = pages();
}

// подключени вида
//require_once ADMIN_TEMPLATE.'index.php';

//header
include ADMIN_TEMPLATE.'header.php';

//leftbar
include ADMIN_TEMPLATE.'leftbar.php';

//content
include ADMIN_TEMPLATE.$view.'.php';


?>