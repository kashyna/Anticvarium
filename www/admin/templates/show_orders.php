<?php defined ('ISHOP') or die ('Access denied');?>
<div class="content">
<?php //print_arr($all_news)?>	
<?php 
if(isset($_SESSION['answer'])){
    echo $_SESSION['answer']; //выводим результат
    unset($_SESSION['answer']);
}
?>	
    <h2>Новые заказы</h2>
<?php if($new_orders): ?>
<table class="tabl" cellspacing="1">
    <tr>
        <th class="number">№ заказа</th>
        <th class="str_name" style="width:280px;">Покупатель</th>
        <th class="str_sort">Дата оформления заказа</th>
        <th class="str_action">Просмотр</th>
    </tr>
<?php foreach($new_orders as $item):?>
<tr>
    <td><?=$item['order_id']?></td>
    <td class="name_page"><?=$item['name']?></td>
    <td><?=$item['data']?></td>
    <td><a href="?view=show_order&amp;order_id=<?=$item['order_id']?>" class="edit">Просмотреть</a></td>
</tr>
<?php endforeach; ?>
</table> 
<?php else:?>
<div class="error">Необработанных заказов нет</div>  
<?php endif; ?>
</div> <!-- .content -->
</div> <!-- .content-main -->
</div> <!-- .karkas -->
</body>
</html>