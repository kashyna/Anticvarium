<?php defined('ISHOP') or die ('Access denied'); ?> <!--защита от прямого вызова -->
<div id="content-order">
<h2>Личный кабинет</h2>
<?php 
//print_arr($user_orders);
    if(isset($_SESSION['answer'])){
        echo $_SESSION['answer'];
        unset ($_SESSION['answer']);
    }
?>
    <?php if($_SESSION['auth']): //проверка на авторизацию пользователя ?>
	<table id="user_cab" class="order-main-table" cellpadding="0" cellspacing="0">
    <!--	<form method="post" action="">  -->

        <tr >
        	<td class="z-top" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;Моя учетная запись&nbsp;&nbsp;&nbsp;&nbsp;
              <!--  <a href="?view=user_edit" style="
                                            text-decoration:dotted;
                                            color:blue;
                                            font-size: 11px;
                                            font-style: italic;">изменить</a> -->
              <a href="?view=user_edit" id="toggle1"><div title="Редактировать профиль">изменить</div></a>
            </td>
        </tr>

        <tr class="c-tr">
        	<td class="c-title">Фамилия</td>
            <td><?=$user_area['surname']?></td>
        </tr>
        <tr class="c-tr">
        	<td class="c-title">Имя</td>
            <td><?=$user_area['name']?></td>
        </tr>
        <tr class="c-tr">
            <td class="c-title">Адрес</td>
            <td><?=$user_area['address']?></td>
        </tr>
        <tr class="c-tr">
            <td class="c-title">Логин</td>
            <td><?=$user_area['login']?></td>
        </tr>
       <!-- <tr class="c-tr">
            <td class="c-title">Пароль</td>
            <td><?//=$user_area['password']?></td>
        </tr> -->
        <tr class="c-tr">
            <td class="c-title">Телефон</td>
            <td><?=$user_area['phone']?></td>
        </tr>
        <tr class="c-tr">
            <td class="c-title">E-mail</td>
            <td><?=$user_area['email']?></td>
        </tr>
</table>






	<!--<table id="user_edit" class="order-main-table" border="0" cellpadding="0" cellspacing="0">
    <form method="POST" action="">
        <tr>
        	<td class="z-top" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;Моя учетная запись</td>
        </tr>

        <tr class="c-tr">
        	<td class="c-title">Ф.И.О.:<b>*&nbsp;</b></td>
            <td class="z-input"><input type="text" name="name" value="<?=htmlspecialchars($user_area['name'])?>" /></td>
        </tr>
        <tr class="c-tr">
            <td class="c-title">Адрес:<b>*&nbsp;</b></td>
            <td class="z-input"><input type="text" name="address" value="<?=htmlspecialchars($user_area['address'])?>" /></td>
        </tr>
        <tr class="c-tr">
            <td class="c-title" title="Логин изменить невозможно!" >Логин:</td>
            <td class="z-input"><input type="text" name="login" style="color: #9D9D9D !important;" value="<?=htmlspecialchars($user_area['login'])?>" disabled='' title="Логин изменить невозможно!" />
                <p class="z-example">Логин изменить невозможно!</p>
            </td>
        </tr>
        <tr class="c-tr">
            <td class="c-title">Новый пароль:</td>
            <td class="z-input"><input type="password" name="password" value="" />
                <p class="z-example">Если Вы не введете новый пароль, он останется прежним</p>
            </td>
            
        </tr>
        <tr class="c-tr">
            <td class="c-title">Телефон:<b>*&nbsp;</b></td>
            <td class="z-input"><input type="text" name="phone" value="<?=htmlspecialchars($user_area['phone'])?>" /></td>
        </tr>
        <tr class="c-tr">
            <td class="c-title">E-mail:<b>*&nbsp;</b></td>
            <td class="z-input"><input type="text" name="email" value="<?=htmlspecialchars($user_area['email'])?>" /></td>
        </tr>
    <tr><input onclick="show_cab();" type="image" src="<?=TEMPLATE?>img/order.png" title="Сохранить изменения" alt="Сохранить изменения" />		
    <br /><br /> 
    </form>
    </tr>
       </table> -->
    







<table class="order-main-table" border="0" cellpadding="0" cellspacing="0">        
        <tr>
        	<td class="z-top" colspan="100%">&nbsp;&nbsp;&nbsp;&nbsp;Мои заказы</td>
        </tr>
<?php if ($user_orders):?>
        <tr style="width: 70%;">
        	<th >№</th>
            <th >Дата</th>
            <th >Статус</th>
            <th >Действия</th>
        </tr> 
    <?php $i=0;?>
    <?php foreach($user_orders as $item):?>
    <?php $i++;?>
        <tr class="c-tr">
        <?php if($item['order_id'] == $h) continue; ?>
            <td style="text-align: center;"><?=$item['order_id']?>
            <?php $h = $item['order_id']?>
            </td>
            <td style="text-align: center;"><?=$item['data']?></td>
            <td style="text-align: center;"><?php if($item['status'] == "0") echo "<span style='color:red;font-weight:bold;'>необработан</span>"; else echo "<span style='color:green;'>закрыт</span>"; ?></td>
            <td style="text-align: center;"><a href="?view=user_order&order_id=<?=$item['order_id']?>" style="color: blue;">просмотреть</a></td>
        </tr>
    <?php endforeach;?>
<?php else:?>
    <p class="card_null">У Вас пока нет заказов.</p>
<?php endif;?>        
</table>
    <?php else:?>
    <p class="card_null">Авторизируйтесь! </p>
    <?php endif;?>

<?php 
//unset ($_SESSION['order']);
?> 
</div>