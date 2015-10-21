<?php 

define('ISHOP', TRUE);//определяем константу, чтобы мы могли читать файл конфигурации, т к там запрет прямого подключения, если не определена константа ishop

session_start();
include $_SERVER['DOCUMENT_ROOT'].'/config.php';

if($_SESSION['auth']['admin']){ //если уже авторизованный админ обратился к entr.php
    header("Location: ../");
    exit;
}

//обработчик
if($_POST){
    $login = trim(mysql_real_escape_string($_POST['user']));
    $pass = trim($_POST['pass']);
    $query = "SELECT memberships.customer_id, memberships.name, users.password, user_roles.id_role 
                FROM memberships 
                    LEFT JOIN users
                        ON memberships.customer_id = users.user_id
                    LEFT JOIN user_roles
                        ON users.user_id = user_roles.id_user
                WHERE users.login = '$login' 
                AND user_roles.id_role = 2 LIMIT 1";
    /*$query = "SELECT customer_id, name, password FROM customers WHERE login = '$login' 
                AND id_role = 2 LIMIT 1";*/
    $res = mysql_query($query) or die(mysql_error()); //вернем результат запроса
    $row = mysql_fetch_assoc($res); //получаем массив данных
    if($row['password'] == md5($pass)){
        $_SESSION['auth']['admin'] = htmlspecialchars($row['name']);
        $_SESSION['auth']['user_id'] = $row['customer_id']; //чтотбы мы могли редактировать админа
        header("Location: ../");
        exit;
    }else{
        $_SESSION['res'] = '<div class="error">Не верные значения логин/пароль!</div>';
        header("Location: {$_SERVER['PHP_SELF']}"); //переходим на эту же страницу
        exit;
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../<?=ADMIN_TEMPLATE?>style.css" />
<title>Вход в админку</title>
</head>

<body>
<div class="karkas">
<div class="head">
    <a href="#"><img src="../<?=ADMIN_TEMPLATE?>img/logo.png" /></a>
	<a href="#"><img src="../<?=ADMIN_TEMPLATE?>img/slogan1.png" /></a>


	<p>Вход в админку</p>
</div>
    <div class="enter">
<?php 
if(isset($_SESSION['res'])){
    echo $_SESSION['res'];
    unset($_SESSION['res']);
}
?>
    <form method="post" action="">
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>Username:</td>
            <td><input type="text" name="user" /></td>
          </tr>
          <tr>
            <td>Password:</td>
            <td><input type="password" name="pass" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="image" src="../<?=ADMIN_TEMPLATE?>img/enter_btn.jpg" name="submit" /></td>
          </tr>
        </table>      
    </form>
    </div><!-- .enter-->
</div>
</body>
</html>
