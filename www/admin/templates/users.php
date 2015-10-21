<?php defined ('ISHOP') or die ('Access denied');?>
<div class="content">
<?php //print_arr($users)?>	

<h2>Список пользователей</h2>
 <?php 
if(isset($_SESSION['answer'])){
    echo $_SESSION['answer']; //выводим результат
    unset($_SESSION['answer']);
}
?>
<a href="?view=add_user"><img class="add_some" src="<?=ADMIN_TEMPLATE?>img/add_user.jpg" alt="добавить пользователя" /></a>

<table class="tabl" cellspacing="1">
    <tr>
        <th class="number">№ </th>
        <th class="str_name" style="width:280px;">ФИО</th>
        <th class="str_name" style="width:280px;">Логин</th>
        <th class="str_name" style="width:280px;">E-mail</th>
        <th class="str_sort">Роль</th>
        <th class="str_action">Действие</th>
    </tr>
    <?php $i = 1;?>
    <?php foreach($users as $item): ?>        
    <tr <?php if($item['name_role'] == 'Администратор') echo " class='admin'"?>>
        <td><?=$i?></td>
        <td class="name_page"><?=htmlspecialchars($item['surname'])?>&nbsp;<?=htmlspecialchars($item['name'])?></td>
        <td class="name_page"><?=htmlspecialchars($item['login'])?></td>
        <td class="name_page"><?=htmlspecialchars($item['email'])?></td>
        <td><?=htmlspecialchars($item['name_role'])?></td>
        <td><a href="?view=edit_user&amp;user_id=<?=$item['customer_id']?>" class="edit">редактировать</a> <br /> <br />
        <a href="?view=del_user&amp;user_id=<?=$item['customer_id']?>" class="del">удалить</a></td>
    </tr>
    <?php $i++; ?>
    <?php endforeach; ?>

</table> 
<?php if($pages_count > 1) pagination($page, $pages_count);?>
<a href="?view=add_user"><img class="add_some" src="<?=ADMIN_TEMPLATE?>img/add_user.jpg" alt="добавить пользователя" /></a>

</div> <!-- .content -->
</div> <!-- .content-main -->
</div> <!-- .karkas -->
</body>
</html>