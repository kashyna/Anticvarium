<?php defined('ISHOP') or die ('Access denied'); ?> <!--защита от прямого вызова -->
<div id="content-order">
<h2>Детальный просмотр заказа</h2>
<?php 
//print_arr($user_order);
?>
<?php if($_SESSION['auth']): //проверка на авторизацию пользователя ?>
<?php if ($user_order):?>
<h3><b>Заказ № <?=$order_id?> </b><span style="color: #e35a0f; font-size:14px;">(<?=$state?>)</span></h3>
<p>
<table class="tabl" cellspacing="1">
    <tr>
        <th class="number">№ </th>
        <th class="str_name" style="width: 280px;">Наименование товара</th>
        <th class="str_sort">Цена (грн)</th>
        <th class="str_action">Количество</th>
    </tr>
    <?php $i = 1; $total_sum = 0; $total_quantity = 0;?>
    <?php foreach($user_order as $item):?>
    <tr>
        <td><?=$i?></td>
        <td class="name_page"><a href="?view=product&goods_id=<?=$item['goods_id']?>"><?=$item['name']?></a></td>
        <td><?=$item['price']?></td>
        <td><?=$item['quantity']?></td>
    </tr>
    <?php   $i++; 
            $total_sum += $item['price'] * $item['quantity']; 
            $total_quantity += $item['quantity'];?>

    <?php endforeach;?>
</table>

<h3>Общая цена заказа: <b><span style="color: red;"><?=$total_sum?>&nbsp;</span><span style="color: grey; font-size:12px;">грн.</span></b></h3>
<h3>Количество: <span style="color: red;"><?=$total_quantity?>&nbsp;</span><span style="color: grey; font-size:12px;">(шт)</span></h3>
<h3>Дата оформления заказа: <span style="color: #9f3a3a;font-weight:bold;"><?=$item['data']?></h3>
<h3>Способ доставки: <span style="color: #9f3a3a;"><?=$item['sposob']?></h3>
<br /><br /><br />
<?php else:?>
    <p class="card_null">У Вас пока нет заказов.</p>
<?php endif;?>        
</table>
    <?php else:?>
    <p class="card_null">Авторизируйтесь! </p>
    <?php endif;?>

</div>