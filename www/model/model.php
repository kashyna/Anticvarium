<?php
defined('ISHOP') or die('Access denied');

/*			Каталог - получение массива			*/

function catalog(){
	$query = "SELECT * FROM brands ORDER BY parent_id, brand_name";
	$res = mysql_query($query) or die(mysql_query());
	
	//массив категорий
	$cat = array();
	while($row = mysql_fetch_assoc($res)){
		if(!$row['parent_id']){
			$cat[$row['brand_id']][] = $row['brand_name'];
			}else{
				$cat[$row['parent_id']]['sub'][$row['brand_id']] = $row['brand_name'];
				}
		}
	return $cat;
	}
	
/*      Страницы меню     */
function pages(){
    $query = "SELECT page_id, title FROM page ORDER BY position";
    $res = mysql_query($query) or die(mysql_error());
    
    $pages = array();
    while($row = mysql_fetch_assoc($res)){
        $pages[] = $row; //наполняем массив результатами наешего запроса        
    }
     return $pages;

}

/*      Вывод содержимого отдельной страницы меню    */

function get_page($page_id){
    $query = "SELECT title, text FROM page WHERE page_id = $page_id";
    $res = mysql_query($query) or die(mysql_error());
    
    $get_page = array();
    $get_page = mysql_fetch_assoc($res);
    return $get_page;
}


/*       Названия новостей       */
function get_title_news(){
    $query = "SELECT news_id, title, data FROM news ORDER BY data DESC LIMIT 2";
    $res = mysql_query($query) or die(mysql_error());
    
    $news = array();
    while($row = mysql_fetch_assoc($res)){
        $news[] = $row;
    }    
    return $news;
}

/*      Отдельная новость    */
function  get_news_text($news_id){
    $query = "SELECT news.title, news.text, news.data,
                        news_goods.id_goods AS goods_id
                        FROM news
                        LEFT JOIN news_goods ON news.news_id = news_goods.id_news
                            WHERE news.news_id = $news_id";
    //$query = "SELECT title, goods_id, text, data FROM news WHERE news_id = $news_id";
    $res = mysql_query($query) or die(mysql_error());
    
    $news_text = array();
    $news_text = mysql_fetch_assoc($res);
    return $news_text;
}

/*          Архив новостей          */
function get_all_news($start_position, $perpage){
    $query = "SELECT news_id, title, anons, data FROM news ORDER BY data DESC LIMIT $start_position, $perpage";
    $res = mysql_query($query) or die(mysql_error());
    
    $all_news = array();
    while($row = mysql_fetch_assoc($res)){
        $all_news[] = $row;
    }
    return $all_news;
}

/*       Количество новостей       */
function count_news(){
    $query = "SELECT COUNT(news_id) FROM news";
    $res = mysql_query($query) or die(mysql_error());
    
    $count_news = mysql_fetch_row($res);
    return $count_news[0];
}

	
/*		Информеры	- получение массива			*/
function informer(){
	$query = "SELECT * FROM link
				INNER JOIN informer ON
					link.parent_informer = informer.informer_id
						ORDER BY informer_position, link_position";
	$res = mysql_query($query) or die(mysql_query());
	$informers = array();
	$name = ''; //флаг имени информера
	while($row = mysql_fetch_assoc($res)){
		if($row['informer_name'] != $name){ //если такого информера в массиве еще нет
		  $informers[$row['informer_id']][] = $row['informer_name']; // добавляем информер в массив
		  $name = $row['informer_name']; //значит такой информер в массиве уже есть, и в след раз добавлять его повторно не будем
			}
			$informers[$row['parent_informer']]['sub'][$row['link_id']] = $row['link_name']; //заносим страницы в массив в текущий информер
		}
		return $informers;
	}

/*       Информеры - получение текста       */

function get_text_informer($informer_id){
    $query = "SELECT link_id, link_name, text, informer.informer_id, informer.informer_name
                FROM link
                    LEFT JOIN informer ON 
                        informer.informer_id = link.parent_informer
                        WHERE link_id = $informer_id";
    $res = mysql_query($query);
    
    $text_informer = array();
    $text_informer = mysql_fetch_assoc($res);
    return $text_informer;
}


/*            Айстопперы - новинки, лидеры, скидки - массив на выходе                        */
function eyestopper($eyestopper){   //$eyestopper - то что нам потребуется: new, leader или sale
    $query = "SELECT goods_id, name, img, price, quantity FROM goods
                WHERE visible = '1' AND $eyestopper = '1'";  //то есть нужное нам поле (new, leader или sale) должно быть равно '1' в бд
    $res = mysql_query($query) or die(mysql_error()); //отправляем наш запрос в бд
    $eyestoppers = array();
    while($row=mysql_fetch_assoc($res)){
       $eyestoppers[] = $row; //заполняем массив
     /*  echo '<div class="search-result-blocks"><p class="adress-to-search">'.$row['goods_id'].'</p> ',
                  $row['name'].' ',
                  $row['img'].' ',
                  $row['price'].
                  '</div><br>';*/
    }
    return $eyestoppers; //выбираем в цикле товары по нужному критерию, и возвращаем массив данных товаров
     
}

/*========Получение количества товатор для постраничной навигации =========*/
function count_rows($category){
    $query = "(SELECT COUNT(goods_id) as count_rows 
                    FROM goods 
                        WHERE goods_brandid = $category AND visible='1')
                UNION
              (  SELECT COUNT(goods_id) as count_rows  
                    FROM goods 
                        WHERE goods_brandid IN
                    (  SELECT brand_id FROM brands WHERE parent_id = $category
                        ) 
                        AND visible='1')";
    $res = mysql_query($query) or die(mysql_error());
    
    while($row = mysql_fetch_assoc($res)){
        if($row['count_rows']) $count_rows = $row['count_rows'];
    }
    return $count_rows;
}




/*                   Получение массива товаров по категориям                           */
function products($category, $order_db, $start_position, $perpage){
    $query = "(SELECT goods_id, name, img, anons, price, leader, new, sale, date, quantity 
                    FROM goods 
                        WHERE goods_brandid = $category AND visible='1')
                UNION
                (SELECT goods_id, name, img, anons, price, leader, new, sale, date, quantity
                    FROM goods 
                        WHERE goods_brandid IN
                    (  
                        SELECT brand_id FROM brands WHERE parent_id = $category
                        ) AND visible='1') ORDER BY quantity DESC, $order_db LIMIT $start_position, $perpage";
                        
    $res = mysql_query($query) or die(mysql_error());
    $products = array();
    while($row=mysql_fetch_assoc($res)){  //пока в переменную роу попадают строки, полученные из бд,
        $products[] = $row;                 //будем заполнять массив
    }
    return $products;
}

/*     Получение названий для хлебных крох     */
function brand_name($category){
    $query= "(SELECT brand_id, brand_name FROM brands 
                WHERE brand_id = (SELECT parent_id FROM brands WHERE brand_id = $category)
                )
                UNION
                    (SELECT brand_id, brand_name FROM brands WHERE brand_id = $category)";//1я часть возвращает id Родителя, 2я - для самостоятельных категорий, у кот нет потомков
    $res = mysql_query($query) or die(mysql_error());
    $brand_name = array();
    while($row = mysql_fetch_assoc($res)){
        $brand_name[] = $row;
    }
    return $brand_name;
}

/*      Выбор по параметрам     */
function filter($category, $startprice, $endprice){
    $products = array();
    if($category OR $endprice){ 
        $predicat1 = "visible='1'";
        if($category){
            $predicat1 .= " AND goods_brandid IN($category)";            
            $predicat2 = "UNION 
                            (SELECT goods_id, name, img, price, leader, new, sale, quantity
                            FROM goods
                                WHERE goods_brandid IN
                                (
                                    SELECT brand_id FROM brands WHERE parent_id IN ($category)
                                ) AND visible='1'";
            if($endprice) $predicat2 .= " AND price BETWEEN $startprice AND $endprice";
            $predicat2 .= ")";
        }        
        if($endprice){
            $predicat1 .= " AND price BETWEEN $startprice AND $endprice";
        }
    
        $query = "(SELECT goods_id, name, img, price, leader, new, sale, quantity
                    FROM goods
                        WHERE $predicat1)
                            $predicat2 ORDER BY name";
        $res = mysql_query($query) or die(mysql_error());
        
        //проверяем сколько рядомв вернул результат запроса
        if(mysql_num_rows($res) > 0){
            while($row = mysql_fetch_assoc($res)){
                $products[] = $row; //наполгяем массив
            }
        }else{
            $products['notfound'] = "<div class='error'>К сожалению, по указанным параметрам ничего не найдено</div>"; 
        }
    }else{ //если не получили ни один из параметро выше
       $products['notfound'] = "<div class='error'>Вы не указали параметры для подбора товаров.</div>"; 
    }
    return $products;
}


/*              Сумма добавления в корзину и атрибуты товара                   */
function total_sum($goods){ //параметр - массив гудс
    $total_sum = 0; //сумма в корзине
    $str = implode(',',array_keys($goods)); //implode - преобразует массив в строку, каждый элемент - через запятую. 
                                            //array_keys - возвращает ключи элементов массива
    $query = "SELECT goods_id, name, price, img
                FROM goods
                    WHERE goods_id IN ($str)"; //IN поотому что надо передать много товаров через запятую в виде строки, просто = не подошло бы
                                                // и id в определенном промежутке, чтобы пользователь не добавил свой несущ id    
    $res = mysql_query($query) or die(mysql_error());
    
    while($row = mysql_fetch_assoc($res)){ //будем формировать в цикле оставшиеся атрибуты товара
        $_SESSION['card'][$row['goods_id']]['name'] = $row['name'];
        $_SESSION['card'][$row['goods_id']]['price'] = $row['price'];
        $_SESSION['card'][$row['goods_id']]['img'] = $row['img'];
        $total_sum +=  $_SESSION['card'][$row['goods_id']]['qty'] * $row['price'];  //подсчитываем итоговую сумму                    
    }            
    return $total_sum;
}


/*      Проверка на уникальность логина email           */
function access_field(){   
   $fields = array('login', 'email');
   $val = trim(mysql_real_escape_string($_POST['val']));
   $field = $_POST['dataField'];
   
   if(!in_array($field, $fields)){
    $res = array('answer' => 'no', 'info' => 'Ошибка!');
        return json_encode($res);
   }
   $login = $_POST['val'];
   
   if($field == 'email' && !empty($val)){
    //проверяем на соответствие формату
        if(!preg_match("#^\w+@\w+\.\w+$#i", $val)){
            $res = array('answer' => 'no', 'info' => 'Введенный e-mail не соответствует формату!');
            return json_encode($res);
        }
   }
   
   //проверяем на уникальность
   $query = "SELECT user_id FROM users WHERE login = '$val'";
   $res = mysql_query($query) or die(mysql_error());
   $query = "SELECT customer_id FROM memberships WHERE email = '$val'";
   $res1 = mysql_query($query) or die(mysql_error());
   
   
   if(mysql_num_rows($res)>0 || mysql_num_rows($res1)>0){
        $res = array('answer' => 'no', 'info' => "Выберите другой $field!");
        return json_encode($res);
   }else{
        $res = array('answer' => 'y');
        return json_encode($res);
   }
 /*  if (mysql_num_rows($res) > 0){
        $res = array('answer' => 'no', 'info' => "Выберите другой '$field!'");
        return json_encode($res);
   }else{
        $res = array('answer' => 'yes');
        return json_encode($res);
   }
   if (mysql_num_rows($res1) > 0){
        $res1 = array('answer' => 'no', 'info' => "Выберите другой '$field!'");
        return json_encode($res1);
   }else{
        $res1 = array('answer' => 'yess', 'info' => "E-mail подходит'");
        return json_encode($res1);
   }*/
}
/*      Проверка на уникальность логина email           */



/*        Регистрация        */
function registration(){
    $error = ''; //флаг проверки заполненности обязательных полей (пустое)
    
    $fields = array('login' => 'Логин', 'email' => 'E-mail');
    
    //получаем значения из полей
    $login = trim($_POST['login']); //trim - удаляет лишние проблемы слева и справа от строки
    $pass = trim($_POST['pass']);
    $pass2 = trim($_POST['pass2']);
    $surname = trim($_POST['surname']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    
    //проверка на пустоту поля
    if (empty($login)) $error .= '<li>Не указан логин!</li>';
    if (empty($pass)) $error .= '<li>Не указан пароль!</li>';
    if (empty($surname)) $error .= '<li>Не указана фамилия!</li>';
    if (empty($name)) $error .= '<li>Не указано имя!</li>';
    if (empty($email)) $error .= '<li>Не указан e-mail!</li>';
    if(!empty($email)){
        //echo $email;
            if(!preg_match("#^\w+@\w+\.\w+$#i", $email)){
                $error .= "<li>E-mail не соответствует формату!</li>";
            }
        }
    if (empty($phone)) $error .= '<li>Не указан контактный телефон!</li>';
    if (empty($address)) $error .= '<li>Не указан адрес!</li>';
    if ($pass != $pass2) $error .= '<li>Пароли не совпадают!</li>';    
    
    //проверка на отсутствие ошибок
    //уникальность
    if (empty($error)){ //все поля заполнены
        //проверяем нет ли уже этого опльзователя в БД
        //$query = "SELECT customer_id FROM customers WHERE login = '" .clear($login). "' LIMIT 1";
        $query = "SELECT user_id FROM users WHERE login = '" .clear($login). "' LIMIT 1";
        $res = mysql_query($query) or die(mysql_error());
        $row = mysql_num_rows($res); //если есть строка - значит есть пользователь, если получаем 0 - нет
        
        $query = "SELECT customer_id FROM memberships WHERE email = '" .clear($email). "' LIMIT 1";
        $res = mysql_query($query) or die(mysql_error());
        $row1 = mysql_num_rows($res);
        if($row || $row1){
            
            //если row возвращает истину=1, то такой логин уже есть
            if($row) $_SESSION['reg']['res'] .= "<div class='error'>Пользователь с таким логином уже существует. Введите другой.</div>";
            if($row1) $_SESSION['reg']['res'] .= "<div class='error'>Пользователь с таким e-mail уже существует. Введите другой.</div>";
            //$_SESSION['reg']['res'] = "<div class='error'>Пользователь с таким логином уже существует. Введите другой.</div>";
            $_SESSION['reg']['surname'] = $surname;
            $_SESSION['reg']['name'] = $name;
            //$_SESSION['reg']['email'] = $email;
            $_SESSION['reg']['phone'] = $phone;
            $_SESSION['reg']['address'] = $address;
            
        }else{
            
            //если такого пользователя нет, то регистрируем его
                $login = clear($login); //эскейпим данные
                //!!!!!добавила фамилию
                $surname = clear($surname); 
                $name = clear($name);
                $email = clear($email);
                $phone = clear($phone);
                $address = clear($address);                        
            
            $pass = md5($pass); //шифруем значение пароля. возвращает хэш строки - число шестнадцатиричное 32 символа
            //$query = "INSERT INTO customers(name, email, phone, address, login, password)
              //          VALUES ('$name', '$email', '$phone', '$address', '$login', '$pass')";
            $query = "INSERT INTO memberships(surname, name, email, phone, address, date)
                        VALUES ('$surname', '$name', '$email', '$phone', '$address', NOW())";
           
            $res = mysql_query($query) or die(mysql_error());
            if (mysql_affected_rows() > 0){ // функция проверяет последний выполненный запрос, появились ли изменения после негохотя бы в одной строке
                                            // и возвращает кол-во рядов, затронутых этим запросом. т.е. если колво > 0, то запрос прошел успешно
                //если запись добавлена            
                $_SESSION['reg']['answer'] = "<div class='success'>Регистрация прошла успешно</div>";
                $_SESSION['auth']['user'] = $_POST['name'];
                $_SESSION['auth']['customer_id'] = mysql_insert_id(); //получаем id нового пользователя. фун-я возвращает id последней записи
                $_SESSION['auth']['email'] = $email;
                
                $id = $_SESSION['auth']['customer_id'];
                $query2 = "INSERT INTO user_roles(id_user)
                            VALUES ('$id')";          
                $query3 = "INSERT INTO users(user_id, login, password)
                            VALUES ('$id', '$login', '$pass')";
                $res = mysql_query($query2) or die(mysql_error());
                $res = mysql_query($query3) or die(mysql_error());
                    if (mysql_affected_rows() < 1){
                        //ошибка
                        $_SESSION['reg']['res'] = "<div class='error'>Ошибка!</div>";
                        //сохранение уже заполненных полей в сессию, чтобы пользователь повторно не вводил их
                        $_SESSION['reg']['login'] = $login; //элемент в массиве по названию переменных
                        $_SESSION['reg']['surname'] = $surname;
                        $_SESSION['reg']['name'] = $name;
                        $_SESSION['reg']['email'] = $email;
                        $_SESSION['reg']['phone'] = $phone;
                        $_SESSION['reg']['address'] = $address;
                    }
            }else{
                $_SESSION['reg']['res'] = "<div class='error'>Ошибка!</div>";
                //сохранение уже заполненных полей в сессию, чтобы пользователь повторно не вводил их
                $_SESSION['reg']['login'] = $login; //элемент в массиве по названию переменных
                $_SESSION['reg']['surname'] = $surname;
                $_SESSION['reg']['name'] = $name;
                $_SESSION['reg']['email'] = $email;
                $_SESSION['reg']['phone'] = $phone;
                $_SESSION['reg']['address'] = $address;
            }
        }
        
    }else{ //не заполнены обязательные поля
        $_SESSION['reg']['res'] = "<div class='error'>Ошибка регистрации: <ul> $error </ul></div>";
        //сохранение уже заполненных полей в сессию, чтобы пользователь повторно не вводил их
        $_SESSION['reg']['login'] = $login; //элемент в массиве по названию переменных
        $_SESSION['reg']['surname'] = $surname;
        $_SESSION['reg']['name'] = $name;
        $_SESSION['reg']['email'] = $email;
        $_SESSION['reg']['phone'] = $phone;
        $_SESSION['reg']['address'] = $address;
    }
}



/*          Авторизация                */

function authorization(){
    $login = mysql_real_escape_string(trim($_POST['login']));
    $pass = trim($_POST['pass']);
    
    if(empty($login) OR empty($pass)){
        //то есть пользователь ничего не ввел, поля пусты
        $_SESSION['auth']['error'] = "Поля логин/пароль должны быть заполнены";          
    }else{
        //если получены логин и пароль
        $pass = md5($pass);
        
        $query = "SELECT memberships.customer_id, memberships.name, memberships.email,
                           users.login FROM memberships         
                            LEFT JOIN users 
                            ON memberships.customer_id = users.user_id                    
                            WHERE users.login = '$login' AND users.password = '$pass' LIMIT 1";
        //$query = "SELECT customer_id, name, email FROM customers WHERE login = '$login' AND password = '$pass' LIMIT 1";
        $res = mysql_query($query)or die(mysql_error());
        if(mysql_num_rows($res) == 1){
            //если запрос вытащил одну строку, т е авторизация успешна
            $row = mysql_fetch_row($res);
            $_SESSION['auth']['customer_id'] = $row[0]; // в $_SESSION['auth']['user'] попадет имя из поля name
            $_SESSION['auth']['user'] = $row[1];
            $_SESSION['auth']['email'] = $row[2];
        }else{
            //не верен логин и/или пароль
            $_SESSION['auth']['error'] = "Не правильное значение логин/пароль";   
        }
    }
}

/*     Восстановление пароля         */
function forgot($email){
    $email = mysql_real_escape_string(trim($email));    
    if(empty($email)){
        $_SESSION['auth']['error'] = "Поле e-mail не заполнено";
        return false;   
    }else{

// Символы, которые будут использоваться в пароле
$chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP"; 
// Количество символов в пароле. 
$max=5; 
// Определяем количество символов в $chars 
$size=StrLen($chars)-1; 
// Определяем пустую переменную, в которую и будем записывать символы. 
$password=null; 
// Создаём пароль. 
    while($max--) 
    $password.=$chars[rand(0,$size)];
    }
$pass = md5($password);
$query = "SELECT customer_id FROM memberships
            WHERE email = '$email' LIMIT 1";
$res = mysql_query($query) or die(mysql_error());
//echo mysql_num_rows($res);

if(mysql_num_rows($res) < 1){
//нет такого email
    $_SESSION['auth']['error'] = "Проверьте правильность введенного<br />e-mail";
}else{   
//если запрос вытащил одну строку, т е такой email есть
    $row = mysql_fetch_array($res);
    $id = $row['customer_id'];
    $query = "UPDATE users SET password = '$pass'
            WHERE user_id = '$id'";
    $res = mysql_query($query) or die(mysql_error());

    //+проверка
    if(mysql_affected_rows() > 0){
        //mail(to, subject, body, header) - кому, тема, тело письма, кодировка
        //тема письма
        $subject = "Изменение пароля";
        //формируем заголовки
        $headers .= "Content-type: text/plain; charset=utf-8/r/n";
        $headers .= "From: ".strtoupper($_SERVER['SERVER_NAME'])."\r\n";
        //Тело письма
        $mail_body = "Ваш пароль изменен!\r\nНовый пароль: $password
                        \r\n\r\nОбязательно поменяйте свой пароль в личном кабинете! \r\n";
        // отправка письма
        mail($email, $subject, $mail_body, $headers);
    
        $_SESSION['auth']['error'] = 'Новый пароль выслан на Ваш<br />e-mail!';
    }else{
        $_SESSION['auth']['error'] = "Ошибка!";
    }  
    }

/*
$row = mysql_fetch_array($res);
$id = $row['customer_id'];
//echo $id + "<br />";
//echo $password;
$query = "UPDATE users SET password = '$pass'
            WHERE user_id = '$id'";
$res = mysql_query($query) or die(mysql_error());

//+проверка

    //mail(to, subject, body, header) - кому, тема, тело письма, кодировка
    //тема письма
    $subject = "Изменение пароля";
    //формируем заголовки
    $headers .= "Content-type: text/plain; charset=utf-8/r/n";
    $headers .= "From: Ishop";
    //Тело письма
    $mail_body = "Ваш пароль изменен!\r\nНовый пароль: $password
                    \r\n\r\nОбязательно поменяйте свой пароль в личном кабинете! \r\n";
    // отправка письма
    mail($email, $subject, $mail_body, $headers);

$_SESSION['auth']['res'] = 'Новый пароль выслан на Ваш e-mail!';
*/
}
/*     Восстановление пароля         */

/*=====Способы доставки======*/
function get_delivery(){ 
        $query = "SELECT * FROM delivery";
        $res = mysql_query($query);
        
        $delivery = array();
        while($row = mysql_fetch_assoc($res)){
            $delivery[] = $row;
        }        
        return $delivery;
}

/*=====Способы оплаты======*/
function get_payment(){ 
        $query = "SELECT * FROM payment";
        $res = mysql_query($query);
        
        $payment = array();
        while($row = mysql_fetch_assoc($res)){
            $payment[] = $row;
        }        
        return $payment;
}

/*=====Добавление заказа=======*/
function add_order(){ //принимать данные из формы, брабатывать их, проверять заполнины ли все обязательные данные
                        //соответствующим образом реагировать
    //получаем общие данные для всех (и авториз-ых и новых пользователей)
    $delivery_id = (int)$_POST['delivery'];
    if (!$delivery_id) $delivery_id = 1;
    $payment_id = (int)$_POST['payment'];
    if (!$payment_id) $payment_id = 1;    
    $comment = trim($_POST['comment']);
    
    if($_SESSION['auth']['user']) $customer_id = $_SESSION['auth']['customer_id']; //получаем id авторизованного пользователя
    
    if(!$_SESSION['auth']['user']){ //если пользователь новый, гость
        $error = ''; //флаг проверки заполненности обязательных полей (пустое)
        
        //получаем значения из полей
        $surname = trim($_POST['surname']);
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        
        //проверка на пустоту поля
        if (empty($surname)) $error .= '<li>Не указана фамилия!</li>';
        if (empty($name)) $error .= '<li>Не указано имя!</li>';
        if (empty($email)) $error .= '<li>Не указан e-mail!</li>';
        if (empty($phone)) $error .= '<li>Не указан контактный телефон!</li>';
        if (empty($address)) $error .= '<li>Не указан адрес!</li>';
        
        if (empty($error)){ //значит все поля заполнены
            //добавляем гостя в заказчики (но без данных авторизации - логин/пароль)
            $customer_id = add_customer($surname, $name, $email, $phone, $address);
            if (!$customer_id) return false; //если id не вернулся, возникла ошибка при добавлении гостя в заказчики, то прекращаем выполнение 
        
        }else{
        //не заполнены обяз поля
            $_SESSION['order']['res'] = "<div class='error'>Не заполнены обязательные поля: <ul> $error </ul></div>";
            //сохранение уже заполненных полей в сессию, чтобы пользователь повторно не вводил их
            $_SESSION['order']['surname'] = $surname;
            $_SESSION['order']['name'] = $name; //элемент в массиве по названию переменных
            $_SESSION['order']['email'] = $email;
            $_SESSION['order']['phone'] = $phone;
            $_SESSION['order']['address'] = $address;
            $_SESSION['order']['comment'] = $comment;
            return false; //чтобы далее не срабатывала функция save order, поскольку есть ошибки
        }
    } 
    $_SESSION['order']['email'] = $email; //получаем еьфл пользователя
    save_order($customer_id, $delivery_id, $payment_id, $comment);  
}
/*======Добавление заказчика - гостя ======*/
function add_customer($surname, $name, $email, $phone, $address){
        $surname = clear($_POST['surname']);
        $name = clear($_POST['name']);
        $email = clear($_POST['email']);
        $phone = clear($_POST['phone']);
        $address = clear($_POST['address']);
    $query = "INSERT INTO customers (surname, name, email, phone, address)
                VALUES ('$surname', '$name', '$email', '$phone', '$address')";
    $res = mysql_query($query);
    if(mysql_affected_rows() > 0){
        //если гость добавлен втаблицу заказчиков, то получаем id
        return mysql_insert_id(); //возвращаем его id
    }else{
        // в случае ошибки при добавлении в заказчики
        $_SESSION['order']['res'] = "<div class='error'>Произошла ошибка при регистрации заказа</div>";
        //сохранение уже заполненных полей в сессию, чтобы пользователь повторно не вводил их
        $_SESSION['order']['surname'] = $surname;
        $_SESSION['order']['name'] = $name; //элемент в массиве по названию переменных
        $_SESSION['order']['email'] = $email;
        $_SESSION['order']['phone'] = $phone;
        $_SESSION['order']['address'] = $address;
        $_SESSION['order']['comment'] = $comment;
        return false; //чтобы далее не срабатывала функция save order, поскольку есть ошибки
    }
}
/*===== Передача заказа в БД =======*/
function save_order($customer_id, $delivery_id, $payment_id, $comment){
 $comment = clear($comment);
 $query = "INSERT INTO `order` (customer_id, data, delivery_id, payment_id, comment)
                VALUES ($customer_id, NOW(), $delivery_id, '$payment_id', '$comment')";
    mysql_query($query) or die(mysql_error()); //в переменную не сохраняем, т к результат запроса нам не потребуется
    if(mysql_affected_rows() == -1){ //фун-я возвращает колво измененных строк в результате последнего запроса
        // если не получилось сохранить заказ то удаляем гостя-заказчика из таблицы
        mysql_query("DELETE FROM customers 
                        WHERE customer_id = $customer_id
                        AND login = ''");
        return false; //далее выполнение прекращается                
    }
    $order_id = mysql_insert_id();//id последнего вставленного запороса
                                //id сохраненного заказа
    
    //для отправления в запросе в таблицу заказыннй товар
    foreach ($_SESSION['card'] as $goods_id => $value){
        $val .= "($order_id, $goods_id, {$value['qty']}, '{$value['name']}', {$value['price']}),";       
    }
    $val = substr($val, 0, -1); //удаляем последнюю запятую
    
    //заполняем таблицу заказ товар
    $query = "INSERT INTO order_goods (order_id, goods_id, quantity, name, price)
                VALUES $val";
    mysql_query($query) or die(mysql_error());
    if (mysql_affected_rows() == -1){
        //если не выгрузился заказ, то удаляем его (order) и заказчика-гостя (customers) тоже
        mysql_query("DELETE FROM `order` WHERE order_id = $order_id");
        mysql_query("DELETE FROM customers 
                        WHERE customer_id = $customer_id
                        AND login = ''");
        return false;
    }else{
        //количество товара
        $i=0;
        foreach ($_SESSION['card'] as $goods_id => $value){
            $query = "SELECT quantity FROM goods WHERE goods_id = '$goods_id' LIMIT 1";
            $res = mysql_query($query) or die(mysql_error());
            $row = mysql_fetch_array($res);
            $qty = $row['quantity'];
            //echo $qty;            
            $qty = $qty - $value['qty'];
            //echo $qty; 
            $query = "UPDATE goods SET quantity = '$qty'
                        WHERE goods_id = '$goods_id'";                
            mysql_query($query) or die(mysql_error());                
        }        
    }
    
    if($_SESSION['auth']['email']) $email = $_SESSION['auth']['email']; // если пользователь авторизован
        else $email = $_SESSION['order']['email']; // если работаем с гостем
    mail_order($order_id,$email);
    
    //если заказ прошел удачно, то удаляем корзину
    unset($_SESSION['card']);
    unset($_SESSION['total_sum']);
    unset($_SESSION['total_quantity']);
    $_SESSION['order']['res'] = "<div class='success'>Ваш заказ проведен успешно! Ожидайте звонка менеджера.</div>";
    return true;
}


/*===== Отправка email  =======*/
function mail_order($order_id, $email){
    //mail(to, subject, body, header) - кому, тема, тело письма, кодировка
    //тема письма
    $subject = "Заказ в интернет-магазине";
    //формируем заголовки
    $headers .= "Content-type: text/plain; charset=utf-8/r/n";
    $headers .= "From: Ishop";
    //Тело письма
    $mail_body = "Спасибо за заказ!\r\nНомер Вашего заказа: $order_id
                    \r\n\r\nЗаказанные товары: \r\n";
    //получаем атрибуты товаров
    foreach($_SESSION['card'] as $goods_id => $value){
        $mail_body .= "Наименование: {$value['name']}, Стоимость: {$value['price']}, Количество: {$value['price']} шт.\r\n";
    }
    $mail_body .= "\r\n\r\nИтого: {$_SESSION['total_quantity']} на сумму: {$_SESSION['total_sum']}";    

    // отправка писем
    mail($email, $subject, $mail_body, $headers);
    mail(ADMIN_EMAIL, $subject, $mail_body, $headers);
}

/*======= Поиск ========*/
function search(){
    $search = clear($_GET['search']); //обрабатываем значение из шлобального массива
    //использовать будем полностекстовый поиск. добавим в бд полнотекстовый индекс
    $result_search = array(); //результат поиска
    
    if(mb_strlen($search, 'UTF-8') < 4){ //mb_strlen считает колво элементов строки. используемфун-ю семейства мультибайтовых mb, так как наша кодировка - ютф8 -мультибайтовая
        $result_search['notfound'] = "<div class='error'>Поисковый запрос должен содержать не менее 4х символов</div>";
    }else{
        $query = "SELECT goods_id, name, img, price, leader, new, sale,
                    MATCH(name) AGAINST('{$search}*' IN NATURAL LANGUAGE MODE) AS score
                    FROM goods
                        WHERE MATCH(name) AGAINST('{$search}*' IN BOOLEAN MODE)  AND visible = '1'
                        ORDER BY score DESC"; 
                         // * -модификатор, какие угодно символы могут идти после нашего слова, мы их найдем
                         //IN BOOLEAN MODE - режим полностектсового поиска - логически. есть еще естесственного языка                                                        
         $res = mysql_query($query) or die(mysql_error);
         
         if(mysql_num_rows($res) > 0){
            while($row_search = mysql_fetch_assoc($res)){
                $result_search[] = $row_search;
            }
         }else{
            $result_search['notfound'] = "<div class='error'>К сожалению, по Вашему запросу ничего не найдено.</div>";
         }
    }
    //print_arr ($result_search);
    return $result_search;
}

/*       Отдельный товар       */
function get_goods($goods_id){
    $query = "SELECT * FROM goods WHERE goods_id = $goods_id AND visible = '1'";
    $res = mysql_query($query);
    
    $goods = array();
    $goods = mysql_fetch_assoc($res);//возвращает асоциативный массив результата запроса   
    
    if($goods['img_slide']){ //элемент массива гудс шьп слайд есть, т е загружены картинки галереи
        $goods['img_slide'] = explode("|", $goods['img_slide']); //разбивает строки на подстроки        
    }
    return $goods;
}


/*      Получение данных пользователя     */
function get_user1($user_id){
    $query = "SELECT memberships.surname, memberships.name, memberships.email, memberships.phone, memberships.address, users.login, users.password
                FROM memberships
                LEFT JOIN users
                    ON memberships.customer_id = users.user_id
                    WHERE memberships.customer_id = $user_id";    
    
    /*"SELECT customers.name, customers.email, customers.phone, customers.address, customers.login, customers.password,
                    `order`.order_id, `order`.data, `order`.delivery_id, `order`.status, `order`.comment,
                     order_goods.goods_id, order_goods.quantity, order_goods.name AS title, order_goods.price
                 FROM customers
                 LEFT JOIN `order`
                    ON customers.customer_id = `order`.customer_id
                 LEFT JOIN order_goods
                        ON order_goods.order_id = `order`.order_id
                    WHERE customers.customer_id = $user_id";     */               
    $res = mysql_query($query) or die(mysql_error());
    $user = array();
    $user = mysql_fetch_assoc($res);
    return $user;
}


/*         Сохранение изменений редактирования профиля пользователя         */

function user_edit($user_id){
    $error = ''; //флаг проверки заполненности обязательных полей (пустое)    
    $fields = array('login' => 'Логин', 'email' => 'E-mail');
 
    //получаем значения из полей
    $id = $_SESSION['auth']['customer_id'];
    $pass = trim($_POST['pass']);
    $surname = trim($_POST['surname']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    
    //проверка на пустоту поля
    if (empty($surname)) $error .= '<li>Не указана фамилия!</li>';
    if (empty($name)) $error .= '<li>Не указано имя!</li>';
    if (empty($email)) $error .= '<li>Не указан e-mail!</li>';
    if (!empty($email)){
            if(!preg_match("#^\w+@\w+\.\w+$#i", $email)){
                $error .= "<li>E-mail не соответствует формату!</li>";
            }elseif(clear($email) != $_SESSION['auth']['email']){
                //уникальность
                $query = "SELECT customer_id FROM memberships WHERE email = '" .clear($email). "' LIMIT 1";
                $res = mysql_query($query) or die(mysql_error());
                $row = mysql_num_rows($res);
                if($row){
                    $error .= "<li>Пользователь с таким e-mail уже существует. Введите другой.</li>";
                }
            }
            
        }        
    if (empty($phone)) $error .= '<li>Не указан контактный телефон!</li>';
    if (empty($address)) $error .= '<li>Не указан адрес!</li>';    
    
    //проверка на отсутствие ошибок    
    if (empty($error)){          
                $surname = clear($surname); 
                $name = clear($name);
                $email = clear($email);
                $phone = clear($phone);
                $address = clear($address);                        
            
            if (!empty($pass)){
                $pass = md5($pass); //шифруем значение пароля. возвращает хэш строки - число шестнадцатиричное 32 символа                
                $query = "UPDATE users SET password = '$pass' WHERE users.user_id = '$id'";
                $res = mysql_query($query) or die(mysql_error());
                if (mysql_affected_rows() > 0) { $row_pass = 1;}else{ $row_pass = 0;} //флаг
            }

            $query = "UPDATE memberships SET surname = '$surname',
                                            name = '$name',
                                            email = '$email',
                                            phone = '$phone',
                                            address = '$address'
                        WHERE customer_id = '$id'";  
            $res = mysql_query($query) or die(mysql_error());
            if (mysql_affected_rows() < 1 && $row_pass != 1){ // функция проверяет последний выполненный запрос, появились ли изменения после негохотя бы в одной строке
                                            // и возвращает кол-во рядов, затронутых этим запросом. т.е. если колво > 0, то запрос прошел успешно
                $_SESSION['user_edit']['res'] = "<div class='error'>Ошибка, либо же Вы ничего не изменили.</div>";
                return false;                
            }else{
                //если запись добавлена  
                $_SESSION['answer'] = "<div class='success'>Данные успешно обновлены</div>";
                $_SESSION['auth']['user'] = htmlspecialchars($_POST['name']); 
                $_SESSION['auth']['email'] = htmlspecialchars($_POST['email']);               
                return true;
            }
    }else{ //не заполнены обязательные поля
        $_SESSION['user_edit']['res'] = "<div class='error'>Ошибка регистрации: <ul> $error </ul></div>";
    }
}



/*      Получение данных о заказах пользователя         */
function get_user_order($user_id){
     $query = "SELECT `order`.order_id, `order`.data, `order`.delivery_id, `order`.status, `order`.comment,
                     order_goods.goods_id, order_goods.quantity, order_goods.name AS title, order_goods.price
                 FROM `order`
                 LEFT JOIN order_goods
                        ON `order`.order_id = order_goods.order_id
                    WHERE `order`.customer_id = $user_id"; 
    $res = mysql_query($query) or die(mysql_error());
    $user = array();
    while($row = mysql_fetch_assoc($res)){
        $user[] = $row;
    }    
    return $user;              
}


/*          Данные о необходимом заказе            */
function show_order1($order_id){
    //order_goods: name, price, quantity
    //order: data, comment
    //customers: name, email, phone, address
    //delivery: name
    
    $query = "SELECT order_goods.goods_id, order_goods.name, order_goods.price, order_goods.quantity,
                    `order`.data, `order`.comment, `order`.status,
                    memberships.name AS customer, memberships.email, memberships.phone, memberships.address,
                    delivery.name AS sposob
                    FROM order_goods
            LEFT JOIN `order`
                ON order_goods.order_id = `order`.order_id
            LEFT JOIN memberships
                ON memberships.customer_id = `order`.customer_id
            LEFT JOIN delivery
                ON delivery.delivery_id = `order`.delivery_id
                    WHERE order_goods.order_id = $order_id";
    $res = mysql_query($query) or die(mysql_error());
    $show_order = array();
    while($row = mysql_fetch_assoc($res)){
        $show_order[] = $row;
    }
    return $show_order;
}