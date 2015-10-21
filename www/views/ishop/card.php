<?php //defined('ISHOP') or die ('Access denied'); ?> <!--защита от прямого вызова -->
<div id="content-order">
<h2>Оформление заказа</h2>
<?php 
//print_arr($_SESSION['card'][1]);
    if(isset($_SESSION['order']['res'])){
        print_arr ($_SESSION['order']['res']);
    }
?>
    <?php if($_SESSION['card']): //проверка корзины на наличие товаров ?>
	<!--<div id="ajax">-->
    <table id="ajax" class="order-main-table" border="0" cellpadding="0" cellspacing="0">
    	<form method="post" action="">

        <tr>
        	<td class="z-top">&nbsp;&nbsp;&nbsp;&nbsp;наименование</td>
            <td class="z-top" align="center">количество</td>
            <td class="z-top" align="center">стоимость</td>
            <td class="z-top" align="center">&nbsp;</td>
        </tr>
        <?php foreach ($_SESSION['card'] as $key => $value):?>
        <tr>
        	<td class="z-name">
            	<a href="?view=product&amp;goods_id=<?=$key?>"><img src="<?=PRODUCTIMG?><?=$value['img']?>" title="<?=$value['name']?>" /></a>
                <a href="?view=product&amp;goods_id=<?=$key?>" title="Детальный просмотр товара"><?=$value['name']?></a>
            </td>
            <td class="z-kolvo"><input id="id<?=$key?>" class="kolvo" type="text" value="<?=$value['qty']?>" name="" /></td>
            <td class="z-price"><span><?=$value['price']?></span>&nbsp;грн.</td>
            <td class="z-del"><a href="?view=card&delete=<?=$key?>"><img src="<?=TEMPLATE?>img/delete.png" title="Удалить товар из корзины" alt="удалить товар из заказа" /></a></td>
        </tr>
        <?php endforeach; ?>
        <tr>
        	<td class="z-bot">&nbsp;&nbsp;&nbsp;&nbsp;Итого:</td>
        	<td class="z-bot" colspan="3" align="right"><?=$_SESSION['total_quantity']?> шт&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;<?=$_SESSION['total_sum']?>&nbsp;грн.</td>
        </tr>
     </table>
     <!--</div><!-- #ajax-->
     <div class="ship-method">
     	<h4>Способы доставки:</h4>
        <?php foreach($delivery as $item): ?>
       	    <p><input type="radio" name="delivery" value="<?=$item['delivery_id']?>" /><?=$item['name']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><?=$item['delivery_price']?></span></p>
        <?php endforeach;?>
     </div>
     
     <div class="ship-method">
     	<h4>Способы оплаты:</h4>
        <?php foreach($payment as $item): ?>
       	    <p><input type="radio" name="payment" value="<?=$item['payment_id']?>" /><?=$item['title']?></p>
        <?php endforeach;?>
     </div>     
     
     <h3>Информация для доставки:</h3>
     <?php if (!$_SESSION['auth']['user']): //проверка авторизации пользователя ?>
        <table class="order-data" border="0" cellspacing="0" cellpadding="0">
          <tr class="notauth">
            <td class="z-txt"><b>*</b>&nbsp;Фамилия:</td>
            <td class="z-input"><input type="text" name="surname" value="<?=htmlspecialchars($_SESSION['order']['surname'])?>" /></td>
            <td class="z-example">Пример: Иванов</td>
          </tr>
          <tr class="notauth">
            <td class="z-txt"><b>*</b>&nbsp;Имя:</td>
            <td class="z-input"><input type="text" name="name" value="<?=htmlspecialchars($_SESSION['order']['name'])?>" /></td>
            <td class="z-example">Пример: Петр Александрович</td>
          </tr>          
          <tr class="notauth">
            <td class="z-txt"><b>*</b>&nbsp;E-mail:</td>
            <td class="z-input"><input type="text" class="access" data-field="email" id="email" name="email" value="<?=htmlspecialchars($_SESSION['order']['email'])?>" />
                <span></span>
                <span class="info_access"></span>
            </td>
            <td class="z-example">Пример: example@gmail.com</td>
          </tr>
          <tr class="notauth">
            <td class="z-txt"><b>*</b>&nbsp;Телефон:</td>
            <td class="z-input"><input type="text" name="phone" value="<?=htmlspecialchars($_SESSION['order']['phone'])?>" /></td>
            <td class="z-example">Пример: +38 (095) 1212456</td>
          </tr>
          <tr class="notauth">
            <td class="z-txt"><b>*</b>&nbsp;Адрес доставки:</td>
            <td class="z-input"><input type="text" name="address" value="<?=htmlspecialchars($_SESSION['order']['address'])?>"/></td>
            <td class="z-example">Пример: г.Одесса, ул. Матроса Кошки 19/2</td>
          </tr>
          <tr>
            <td class="z-txt" style="vertical-align:top;">&nbsp;&nbsp;&nbsp;Комментарий:</td>
            <td class="z-txtarea"><textarea name="comment"><?=htmlspecialchars($_SESSION['order']['comment'])?></textarea></td>
            <td class="z-example" style="vertical-align:top;">Пример: Позвоните пожалуйста после 6-ти вечера, 
до этого времени я на работе.</td>
          </tr>
        </table>
        <?php else: //если авторзован пользователь ?>
         <table class="order-data" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td class="z-txt" style="vertical-align:top;">Комментарий:</td>
                <td class="z-txtarea"><textarea name="comment"></textarea></td>
                <td class="z-example" style="vertical-align:top;">Пример: Позвоните пожалуйста после 6-ти вечера, 
    до этого времени я на работе.</td>
            </tr>
         </table>        
        <?php endif; ?>
		
		<input type="image" name="order" src="<?=TEMPLATE?>img/order.png" title="Оформить заказ" /> 
		
		<br /><br /><br /><br />
      </form>
    <?php else: //если товаров в корзине нет ?>
        <p class="card_null">Корзина пуста :( </p>
    <?php endif;?>
<?php 
unset ($_SESSION['order']);
?> 
</div>
<div class="load"></div> <!-- крутящееся изображение при удалении -->
<div class="res"></div> <!-- сообщение об изменении -->