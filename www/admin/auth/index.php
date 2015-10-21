<?php 

define('ISHOP', TRUE);//определяем константу, чтобы мы могли читать файл конфигурации, т к там запрет прямого подключения, если не определена константа ishop

session_start();

include $_SERVER['DOCUMENT_ROOT'].'/config.php'; //documwnt_root возвращает адрес ishop/www
if(!$_SESSION['auth']['admin']){ //возвращает ложь - такого элемента нет
    header("Location: " .PATH. "admin/auth/enter.php");
    exit; //если нет авторизации адмиистратора, сразу редирект на ту же страницу
            //и не выполнялся дальнейший код в индекс.пчп
} else{
    header("Location: " .PATH. "admin/");
    exit;
}
?>