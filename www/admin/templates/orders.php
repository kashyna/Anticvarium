<?php defined ('ISHOP') or die ('Access denied');?>
<div class="content">
<?php //print_arr($all_news)?>	

    <h2>Заказы <span class="small">(необработанные заказы выделены красным)</span></h2>
<?php 
if(isset($_SESSION['answer'])){
    echo $_SESSION['answer']; //выводим результат
    unset($_SESSION['answer']);
}
?>
<?php //print_arr($orders)?>
<?php if($orders): ?>
<table class="tabl" cellspacing="1">
    <tr>
        <th class="number">№ заказа</th>
        <th class="str_name" style="width:280px;">Покупатель</th>
        <th class="str_sort">Дата оформления заказа</th>
        <th class="str_action">Просмотр</th>
    </tr>
<?php foreach($orders as $item):?>
<tr <?php if($item['status'] == 0) echo " class='highlight'"?>>
    <td><?=$item['order_id']?></td>
    <td class="name_page"><?=htmlspecialchars($item['surname'])?>&nbsp;<?=htmlspecialchars($item['name'])?></td>
    <td><?=$item['data']?></td>
    <td><a href="?view=show_order&amp;order_id=<?=$item['order_id']?>" class="edit">Просмотреть</a></td>
</tr>
<?php endforeach; ?>
</table> 
<?php if($pages_count > 1) pagination($page, $pages_count);?>
<?php else:?>
<div class="error">Необработанных заказов нет</div>
<?php endif; ?>

</div> <!-- .content -->
</div> <!-- .content-main -->
</div> <!-- .karkas -->
</body>
</html>