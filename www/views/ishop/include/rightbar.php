<?php defined ('ISHOP') or die ('Access denied');?>

<div id="right-bar">
<div class="right-bar-cont">
	<div class="login">
    	<h2><span>Авторизация</span></h2>
        <div class="authform">
            <?php if(!$_SESSION['auth']['user']): //если не существует такого элемента, то пользователь не авторизован ?>        
        	<form method="post" action="#">
                <label for="login">Логин: </label><br />  <!-- label for для поля с id = login -->
                <input type="text" name="login" id="login"/><br />
                
                <label for="pass">Пароль: </label><br />
                <input type="password" name="pass" id="pass"/><br />                
                
                <input type="submit" name="auth" id="auth" value="Войти" />
                <p class="link"><a href="?view=reg">Регистрация</a></p>
                <p class="link"><a id="forgot-link" href="#">Забыли пароль?</a></p>
            </form>        
                <?php 
                    if(isset($_SESSION['auth']['error']) && ($_SESSION['auth']['error'] == "Новый пароль выслан на Ваш e-mail!")){
                        echo '<div class="success" style="margin:0!important;">' .$_SESSION['auth']['error']. '</div>';
                        unset ($_SESSION['auth']);
                    }elseif(isset($_SESSION['auth']['error'])){
                        echo '<div class="error">' .$_SESSION['auth']['error']. '</div>';
                        unset ($_SESSION['auth']);                        
                    }/*elseif(isset($_SESSION['addtocard']['qty_goods'] )){
                        echo '<div class="error">' .$_SESSION['addtocard']['qty_goods']. '</div>';
                        unset ($_SESSION['addtocard']); 
                    }*/
                ?>
            <?php else: ?>
                <p style="font-size: 14px;">Добро пожаловать, <span><?=htmlspecialchars($_SESSION['auth']['user'])?></span></p>
                <a class="logout" href="?do=logout">Выход</a>
                <a class="input_cabinet" href="?view=cabinet">Личный кабинет</a><br />
            <?php endif; ?>
            <!--<a href="#"><img src="<?=TEMPLATE?>img/login.png" /></a> -->
            <?php /*if(isset($_SESSION['fpass']['error'])){
                        echo '<div class="error">' .$_SESSION['fpass']['error']. '</div>';
                        unset ($_SESSION['fpass']);
                    }*/
             ?>        
        </div><!-- .authform -->
        
        <!-- восстановление пароля -->
 <div id="forgot">
    <form  method="post" action="#">
      <p>
       <label for="email" class="forgot">E-mail регистрации: </label>  <!-- label for для поля с id = login -->
       <input type="text" name="email" id="email"/>
       <input type="submit" name="fpass" id="fpass" value="Выслать пароль" />             
      </p>  
    </form>
    <p class="link"><a id="link" href="#">Вход на сайт</a></p>     
 </div><!--#forgot -->
   <?php /*if(isset($_SESSION['auth']['error'])){
          echo '<div class="error">' .$_SESSION['auth']['error']. '</div>';
          unset ($_SESSION['auth']);
          }*/?>  
        <!-- восстановление пароля -->
    </div>
    
    <div class="shopcart">
   		<h2><span>Корзина</span></h2>
        <div id="card">
            <p>
            <?php if ($_SESSION['total_quantity']):?>
            Товаров в корзине:&nbsp;
             <span id="quantity"><?=$_SESSION['total_quantity']?></span> <br />на сумму:  <span style="font-size: 16px;font-weight:bold;"><?=$_SESSION['total_sum']?></span>&nbsp;грн.
            <a href="?view=card"><img src="<?=TEMPLATE?>img/order.png" alt="Оформить заказ" /></a>
            <?php else: ?>
            Корзина пуста
            <?php endif; ?>
            </p>
        
   <!--     <p>
            У Вас в корзине <br />
            <span>2</span> товар(ов) <br /> на сумму <span>20 000 грн</span>
        </p>
        	<a href="#"><img src="<?=TEMPLATE?>img/order.png" alt="" /></a>
      -->  </div> <!-- #card -->
    
    </div>  <!-- .shopcart -->
    
   <div class="specify-search">
		<h2><span>Поиск по параметрам:</span></h2>
        <div>
       		<form method="get">
            <input type="hidden" name="view" value="filter" /><!--добавим в масив гет элемент вью-->
            <p>Стоимость:</p>
            от <input class="select-price" type="text" name="startprice" value="<?=$startprice?>" />
             до <input class="select-price" type="text" name="endprice" value="<?=$endprice?>" />
            грн <br /><br />
            <p>Производители:</p>
            <?php foreach($cat as $key => $item):?>
                <?php if($item[0]): ?>
                <input type="checkbox" name="brand[]" value="<?=$key?>" id="<?=$key?>" <?php if($key == $brand[$key]) echo "checked" ?> />
                <label for="<?=$key?>"><?=$item[0]?></label><br />
                <?php endif;?>
            <?php endforeach;?>
            <input class="search" type="image" src="<?=TEMPLATE?>img/select.png" />
            </form>
        </div>	
   </div> 
    </div>
    </div>