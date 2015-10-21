<?php

defined('ISHOP') or die('Access denied');

session_start(); //открываем сессию, для корзины

// подключение модели
require_once MODEL;

//подключение библиотеки функций админа
//require_once PATH.'admin/functions/functions.php';

// подключение библиотеки функций
require_once 'functions/functions.php';

// получение массива каталога
$cat = catalog();

//получение массива информеров
$informers = informer();

// получение массива страниц меню
$pages = pages();

//получение названия новостей
$news = get_title_news();

//регистрация
if($_POST['reg']){
   registration();
   redirect(); //для перезагрузки страницы, дабы решить проблему F5 (когда в массиве POST остались данные, и браузер предлагает заново их отправить)
}
//восстановление пароля
if($_POST['fpass']){
   forgot($_POST['email']);
   /*echo $_SESSION['auth']['error'];
   unset($_SESSION['auth']['error']);
   exit; */
   //unset($_SESSION['auth']);
    redirect();
    //print_arr($_SESSION['auth']);
   //exit("ОТВЕТ!");
}

//авторизация
if($_POST['auth']){
   authorization();
   if ($_SESSION['auth']['user']){
    //если пользователь авторизовался
    echo "<p>Добро пожаловать, <span>{$_SESSION['auth']['user']}</span></p>";
    exit; //чтоб скрипт прекратил выполнение, и не доходил до строки подключения шаблона вида
   }else{
    //авторизация неудачна
    echo $_SESSION['auth']['error']; //выводим ответ от сервера, чтобы его подхватил аякс
    unset($_SESSION['auth']);
    exit;
   }
}

//валидация и проверка на уникальность логина и email
if($_POST['val']){
    echo access_field();
    //print_arr($_POST);
    exit;
}

//добавление в корзину - аякс
if($_POST['add_goods']){
    $goods_id = abs((int)$_POST['add_goods']);
    $qty_goods = abs((int)$_POST['qty']);
    addtocard($goods_id, $qty_goods);
                
    $_SESSION['total_sum'] = total_sum($_SESSION['card']); //фун-я будет считать общую сумму, и добавлять атрибуты товара - цену, название
            
    //колво товара и защита от ввода несущ ID товара
    total_quantity();
    echo("<span>{$_SESSION['total_quantity']}</span> на сумму:  <span>{$_SESSION['total_sum']}</span>грн."); 
    exit;  
}

//удаление товаров из корзины аякс
if($_POST['del_goods']){
    $id = abs((int)$_POST['del_goods']); //получаем id товара, кот нужно удалить
        if($id){ //проверка что этот id существует, и он не равен символам и тд,что число
            delete_from_card($id);
            exit(TRUE); 
        }else{
            exit(FALSE); 
        }     
     
}

//переключение вида ajax
/*if($_POST['display_view']){
    
}
*/

//сортировка ajax
if($_POST['sort_id']){
    $id = $_POST['sort_id'];
    
    /////из cat
    $category = abs((int)$_GET['category']);
    $order_p = array( //многомерный ассоциативный массив
                    'pricea' => array('от дешевых к дорогим', 'price ASC'),
                    'priced' => array('от дорогих к дешевым', 'price DESC'),
                    'datea' => array('по дате - с первых', 'date ASC'),
                    'dated' => array('последние добавленные', 'date DESC'),
                    'namea' => array('от А до Я', 'name ASC'), //1й элемент - выводится пользователю, 2й - в БД через модель
                    'named' => array('от Я до А', 'name DESC'),
                    );
    $order_get = clear($_GET['order']); //получаем возможный параметр из адресной строки
    if(array_key_exists($order_get, $order_p)){
        $order = $order_p[$order_get][0];
        $order_db = $order_p[$order_get][1];
    }else{
        //если пользователь ввел что угодно
        //сортируем по умолчанию по 1му элементу массива order_p -по имени
        $order = $order_p['namea'][0];
        $order_db = $order_p['namea'][1];
    }    
    /*  параметры для сортировки    */
    
    //постраничная навигация, параметры
    $perpage = PERPAGE; //кол-во товаров на страницу
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
    
    //хлебные крошки, считаем имя родителя
    $brand_name = brand_name($category);
    $products = products($category, $order_db, $start_position, $perpage);  //получаем массив из модели
    /////из cat
    //exit(json_encode($products));
 /*   foreach($products as $product){
        printf('<h2><a href="?view=product&goods_id=%s">Фотоаппарат&nbsp;%s</a></h2>
        <div class="product-table-img-main">
        	<div class="product-table-img">
        		<a href="?view=product&goods_id=%s"><img src="%s%s" class="baseimg" /></a>
                <div>
                <!-- Icons -->
                    <?php if($product["new"]):?>
                        <img src="%simg/nav-new.png" alt="новинка" />;
                    <?php endif;?>
                    <?php if($product["leader"]):?>
                        <img src="%simg/nav-leader.png" alt="лидер продаж" />;
                    <?php endif;?>
                    <?php if($product["sale"]):?>
                        <img src="%simg/nav-sale.png" alt="скидки" />;
                    <?php endif;?>                    
                <!-- Icons -->
                </div>                    
        	</div> <!-- .product-table-img-->
        </div> <!-- .product-table-img-main-->
		<a class="more-table" href="?view=product&goods_id=%s">подробнее...</a>
        <div class="product-table-price">
             <span class="sum">%s</span>
             <span class="currency">грн.</span>
             <a class="addtocard" href="?view=addtocard&goods_id=%s"><img class="addtocard-index" src="%simg/add-to-card.png" alt="Добавить в корзину" /></a>                        	
        </div>',$product['goods_id'],$product['name'],$product['goods_id'],PRODUCTIMG,$product['img'],TEMPLATE,TEMPLATE,TEMPLATE,$product['goods_id'],$product['price'],$product['goods_id'],TEMPLATE);
    }*/
    foreach($products as $product){
          printf('<h2><a href="?view=product&goods_id=%s">Фотоаппарат&nbsp;%s</a></h2>',$product['goods_id'],$product['name']);  
    }
    exit();
}else{
    
}


//аякс загрузка товаров
if($_POST['cajax']){
    $cat1 = $_POST['cajax'];
    $eyestoppers = eyestopper($cat1);
    /////
    if(!$eyestoppers){
        echo "FALSE";
        exit(FALSE);
    }
   // $eyestoppers = implode('; ', $eyestoppers);
    //$eyestoppers = json_encode();
    //echo $eyestoppers;
  
  
  /*    $decode = json_decode($eyestoppers, true);  
        echo json_encode($decode);    
    exit();*/
   //exit($eyestoppers);
    exit(json_encode($eyestoppers));
}



//выход
if($_GET['do'] == 'logout'){
    logout();
    redirect();
}

// получение динамичной части шаблона #content
$view = empty($_GET['view']) ? 'leader' : $_GET['view'];

switch($view){
    case('leader'):
    // лидеры продаж
    $eyestoppers = eyestopper('leader');
    break;
    
    case('new'):
    // новинки
    $eyestoppers = eyestopper('new');
    /////
  //  if(!$eyestoppers){
 //       exit(FALSE);
 //   }
    //exit(json_encode($eyestoppers));
    break; 
    
    case('sale'):
    // скидки
    $eyestoppers = eyestopper('sale');
    break; 
    
    case('page'):
        //страница меню
        $page_id = abs((int)$_GET['page_id']);
        $get_page = get_page($page_id);
    break;
    
    case ('news'):
        //новость отдельная
        $news_id = abs((int)$_GET['news_id']);
        $news_text = get_news_text($news_id);
    break;
    
    case('archive'):
        //архив новостей
        
            //постраничная навигация, параметры
    $perpage = 2; //кол-во новостей на страницу
    if(isset($_GET['page'])){
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
    
    case('informer'):
        //текстинформера ссылки
        $informer_id = abs((int)$_GET['informer_id']);
        $text_informer = get_text_informer($informer_id);
    break;
    
    case('cat'):
    // товары
    $category = abs((int)$_GET['category']); //получаем из адресной строки
    
    /*  параметры для сортировки    */
    
    //массив параметров сортировки
    //ключи - то, что передаем GET-параметром
    //значения - то что показ пользователю, и часть SQL запроса, который передаем в модель
    $order_p = array( //многомерный ассоциативный массив
                    'pricea' => array('от дешевых к дорогим', 'price ASC'),
                    'priced' => array('от дорогих к дешевым', 'price DESC'),
                    'datea' => array('по дате - с первых', 'date ASC'),
                    'dated' => array('последние добавленные', 'date DESC'),
                    'namea' => array('от А до Я', 'name ASC'), //1й элемент - выводится пользователю, 2й - в БД через модель
                    'named' => array('от Я до А', 'name DESC'),
                    );
    $order_get = clear($_GET['order']); //получаем возможный параметр из адресной строки
    if(array_key_exists($order_get, $order_p)){
        $order = $order_p[$order_get][0];
        $order_db = $order_p[$order_get][1];
    }else{
        //если пользователь ввел что угодно
        //сортируем по умолчанию по 1му элементу массива order_p -по имени
        $order = $order_p['namea'][0];
        $order_db = $order_p['namea'][1];
    }    
    /*  параметры для сортировки    */
    
    //постраничная навигация, параметры
    $perpage = PERPAGE; //кол-во товаров на страницу
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
    
    //хлебные крошки, считаем имя родителя
    $brand_name = brand_name($category);
    $products = products($category, $order_db, $start_position, $perpage);  //получаем массив из модели
    break;
    
    case('addtocard'):
    // добавление в корзину
        $goods_id = abs((int)$_GET['goods_id']);
        $qty_goods = abs((int)$_GET['qty']);
        addtocard($goods_id, $qty_goods);
        
        $_SESSION['total_sum'] = total_sum($_SESSION['card']); //фун-я будет считать общую сумму, и добавлять атрибуты товара - цену, название
        
        //колво товара и защита от ввода несущ ID товара
        total_quantity();
    redirect();
    break;
    
    case('card'):
        /*корзина*/
        
        //способы доставки/оплаты. получение массива
        $delivery = get_delivery(); // в массив возвращаем результат работы функции, вызываем ее
        $payment = get_payment();
        
        // пересчет товаров
        if(isset($_GET['id'], $_GET['qty'])){
        $goods_id = abs((int)$_GET['id']); //получаем айди товара  
        $qty = abs((int)$_GET['qty']); //количество из адресной строки, в которую передается из ява скрипта
        
        $qty_goods = abs((int)$_GET['qty']);
        $qty = $qty - $_SESSION['card'][$goods_id]['qty'];
        addtocard($goods_id, $qty_goods, $qty);
        
        $_SESSION['total_sum'] = total_sum($_SESSION['card']); //общая сумма заказа
        
        total_quantity(); //колво товара и защита от ввода несущ ID товара
        redirect();
        }
        
        //удаление из корзины
        if(isset($_GET['delete'])){ //то есть кнопка была нажата
            $id = abs((int)$_GET['delete']); //получаем id товара, кот нужно удалить
            if($id){ //проверка что этот id существует, и он не равен символам и тд,что число
                delete_from_card($id);
            }            
           redirect();             
        }    
        
        //координата кнопки, если она есть, значит был клик
        if($_POST['order_x']){ //координата кнопки, если она есть, значит был клик
            add_order();
            redirect();
        }
    break;
    
    case('reg'): 
        //регистрация        
    break;
    
    case('search'):
        //поиск
        $result_search = search();
        
        //постраничная навигация, параметры
        $perpage = 9; //кол-во товаров на страницу
        //получаем номер текущей стр
        if(isset($_GET['page'])){
            $page = (int)$_GET['page'];
            if($page < 1) $page = 1;
        }else{ // пусто в адресной строке нет page
            $page = 1;
        }
        $count_rows = count($result_search); //общее кол-во товаров данной категории
        $pages_count = ceil($count_rows / $perpage); //кол-во страниц, частное от деления. ceil  -округляет
        if(!$pages_count) $pages_count = 1; //проверяем чтоб общее кол-во страниц не было < 1, еслипользователь введет несуществующую категорию. 
                                                //минимум 1 страница должна быть
        if($page > $pages_count) $page = $pages_count; //если пользователь в адресную строку введет число большее чем реальное кол-во страниц
        $start_position = ($page - 1) * $perpage; //начальная позиция вывода товара (для запроса)
        $end_position = $start_position + $perpage; //до какого товара выводить на стр
        
        if($end_position > $count_rows) $end_position = $count_rows; //чтобы цикл не шел дальше, после того как закончатся товары (5шт к примеру)      

    break;
    
    case('filter'):
        //выбор по параметрам
        $startprice = (int)$_GET['startprice'];
        $endprice = (int)$_GET['endprice'];
        $brand = array();
        
        if($_GET['brand']){
            foreach($_GET['brand'] as $value){
                $value = (int)$value;
                $brand[$value] = $value; //$value -хранится id категории              
            }
        }
        if($brand){ //если выбран какой-то бренд
            $category = implode(',', $brand);
        }
        $products = filter($category, $startprice, $endprice); //вызываем функцию выбора товаров
        
    break;
    
    case('product'):
        //отдельный товар
        $goods_id = abs((int)$_GET['goods_id']);
        //проверка на значение что может ввести пользователь
        if($goods_id){ //id не равно 0            
            $goods = get_goods($goods_id);
            $brand_name = brand_name($goods['goods_brandid']); // хлебные крошхи            
        }
    break;
    
    case('cabinet'):
        //личный кабинет
        if ($_SESSION['auth'])
        $user_area = get_user1($_SESSION['auth']['customer_id']);
        $user_orders = get_user_order($_SESSION['auth']['customer_id']);
    break;
    
    case('user_edit'):
        //редактирование своего профиля
        if ($_SESSION['auth'])
        $user_area = get_user1($_SESSION['auth']['customer_id']);//получаем данные этого пользователя
        
  /*    if($_POST['user_edit']){ //когда будет нажата кнопка сохранить
            user_edit($_SESSION['auth']['customer_id']);       
            redirect();
        }*/
      
       if($_POST){ //когда будет нажата кнопка сохранить
            if(user_edit($_SESSION['auth']['customer_id'])) redirect("?view=cabinet");       
            else redirect();
        } 
        
        
    break;
    
    case('user_order'):
        //заказы пользователя в профиле
        $order_id = abs((int)$_GET['order_id']);
        //проверка на значение что может ввести пользователь
        if($order_id){ //id не равно 0            
            $user_order = show_order1($order_id);            
            //проверяем какой это заказ
            if($user_order[0]['status']){
                $state = "обработан";
            }else{
                $state = "необработан";
            }
        }           
    break;
        
    default:
        // если в адресной строке ввели имя не существующего вида
        $view = 'leader';
        $eyestoppers = eyestopper('leader');    
}

/*
if(empty($_GET['view'])){
    $view = 'leader';
}else{
    $view = $_GET['view'];
}
*/

// подключени вида
require_once TEMPLATE.'index.php';