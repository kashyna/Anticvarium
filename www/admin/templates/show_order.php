<?php defined ('ISHOP') or die ('Access denied');?>
<div class="content">
<?php //print_arr($all_news)?>	
    <h2>Заказ № <?=$order_id?> <span style="color: #e35a0f;">(<?=$state?>)</span></h2>

<?php if($show_order):?>

<p>
<?php if($show_order[0]['status'] == 0): ?>
<a class="edit" href="?view=orders&amp;confirm=<?=$order_id?>">подтвердить заказ</a> | 
<?php endif;?>
<a class="del" href="?view=orders&del_order=<?=$order_id?>">удалить заказ</a></p> <br /><br />
<?php //print_arr($show_order)?>
<table class="tabl" cellspacing="1">
    <tr>
        <th class="number">№ </th>
        <th class="str_name" style="width: 280px;">Наименование товара</th>
        <th class="str_sort">Цена (грн)</th>
        <th class="str_action">Количество</th>
    </tr>
    <?php $i = 1; $total_sum = 0; $total_quantity = 0;?>
    <?php foreach($show_order as $item):?>
    <tr>
        <td><?=$i?></td>
        <td class="name_page"><?=$item['name']?></td>
        <td><?=$item['price']?></td>
        <td><?=$item['quantity']?></td>
    </tr>
    <?php   $i++; 
            $total_sum += $item['price'] * $item['quantity']; 
            $total_quantity += $item['quantity'];?>

<?php endforeach;?>
</table>

<h2>Общая цена заказа: <span style="color: #e35a0f;"><?=$total_sum?>&nbsp;</span><span style="color: grey; font-size:12px;">грн.</span></h2>
<h2>Количество: <span style="color: #e35a0f;"><?=$total_quantity?>&nbsp;</span><span style="color: grey; font-size:12px;">(шт)</span></h2>
<h2>Дата оформления заказа: <span style="color: #e35a0f;"><?=$item['data']?></h2>
<h2>Способ доставки: <span style="color: #e35a0f;"><?=$item['sposob']?></h2>

<h2>Данные покупателя:</h2>

<table class="tabl" cellspacing="1">
    <tr>
        <th class="number" style="width: 140px;">ФИО </th>
        <th class="str_name" style="width: 200px;">Адрес</th>
        <th class="str_sort">Для связи</th>
        <th class="str_action">Комментарий</th>
    </tr>
    <tr>
        <td><?=htmlspecialchars($item['surname'])?>&nbsp;<?=htmlspecialchars($item['customer'])?></td>
        <td class="name_page"><?=htmlspecialchars($item['address'])?></td>
        <td>E-mail: <?=htmlspecialchars($item['email'])?><br />Телефон: <?=htmlspecialchars($item['phone'])?></td>
        <td style="text-align: left;"><?=htmlspecialchars($item['comment'])?></td>
    </tr>
</table>
<p>
<?php if($show_order[0]['status'] == 0): ?>
<a class="edit" href="?view=orders&amp;confirm=<?=$order_id?>">подтвердить заказ</a> | 
<?php endif;?>
<a class="del" href="?view=orders&del_order=<?=$order_id?>">удалить заказ</a></p> <br /><br />
<?php else:?>
<div class="error">Заказа с таким номером нет.</div>
<?php endif;?>
</div> <!-- .content -->
</div> <!-- .content-main -->
</div> <!-- .karkas -->
</body>
</html>