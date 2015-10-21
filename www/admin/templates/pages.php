<?php defined ('ISHOP') or die ('Access denied');?>
		<div class="content">
<?php //print_arr($pages)?>	
<?php 
if(isset($_SESSION['answer'])){
    echo $_SESSION['answer']; //выводим результат
    unset($_SESSION['answer']);
    }
?>	
<h2>Список страниц</h2>
    <a href="?view=add_page"><img class="add_some" src="<?=ADMIN_TEMPLATE?>img/add_page.jpg" alt="добавить страницу" /></a>
<table id="sort" class="tabl sort" cellspacing="1">
    <tr class="no_sort">
        <th class="number">№</th>
        <th class="str_name">Название страницы</th>
        <th class="str_sort">Сортировка</th>
        <th class="str_action">Действие</th>
    </tr>
<?php $i = 1;?>
<?php foreach($pages as $item):?>
<tr id="<?=$item['page_id'];?>">
    <td class="position" style="25px"><?=$i?></td>
    <td class="name_page" style="width: 360px;"><?=$item['title']?></td>
    <td class="position" style="width: 80px;"><?=$item['position']?></td>
    <td style="width: 160px;"><a href="?view=edit_page&amp;page_id=<?=$item['page_id']?>" class="edit">изменить</a>&nbsp; | &nbsp;<a href="?view=del_page&amp;page_id=<?=$item['page_id']?>" class="del">удалить</a></td>
</tr>
<?php $i++;?>
<?php endforeach;?>      
    </table>
<a href="?view=add_page"><img class="add_some" src="<?=ADMIN_TEMPLATE?>img/add_page.jpg" alt="добавить страницу" /></a>

</div> <!-- .content -->
<div class="load"></div>
<div class="res"></div>
</div> <!-- .content-main -->
</div> <!-- .karkas -->
</body>
</html>