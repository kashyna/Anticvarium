<?php

defined('ISHOP') or die ('Access denied');

//домен
	define('PATH', 'http://ishop/'); //если будем переность сайт на другой домен, чтобы нам не пришлось менять в файлах где указан абсолютный путь
	
//модель
	define('MODEL', 'model/model.php');
	
//контроллер
	define('CONTROLLER', 'controller/controller.php');
	
//виды
	define('VIEW', 'views/');
	
//активный шаблон
	define('TEMPLATE', VIEW.'ishop/');
    
//папка, содержащая картинки, не относящиеся к оформлению темы (контент)
    define('PRODUCTIMG', PATH.'userfiles/product_img/baseimg/');

//папка, содержащая картинки, не относящиеся к оформлению темы (контент)
    define('GALLERYIMG', PATH.'userfiles/product_img/');

//максимально допустимый вес загружаемого изображения - 1 Мб
    define('SIZE', 1048576);
	
//сервер БД
	define('HOST', 'localhost');
	
//пользователь
	define('USER', 'ishop_user');

//пароль
	define('PASS', '123');

//имя БД
	define('DB', 'ishop1');
	
//название магазина
	define('TITLE', 'Интернет магазин фотоаппаратов');
    
// мыло админа
define('ADMIN_EMAIL', 'admin@ishop.com');
	
mysql_connect(HOST, USER, PASS) or die('No connect to server');
mysql_select_db(DB) or die('No connect to DB');
mysql_query("SET NAMES 'UTF8'") or die('Cant set charset');


// кол-во товаров на странице
define('PERPAGE', 6);


//папка шаблонов административной части
define('ADMIN_TEMPLATE','templates/');

?>