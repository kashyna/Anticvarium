<?php defined ('ISHOP') or die ('Access denied');?>
		<div class="content">
<h2>Редактирование пользователя</h2>
<?php //print_arr($_SESSION);
if(isset($_SESSION['edit_user']['res'])){
    echo $_SESSION['edit_user']['res'];
    unset($_SESSION['edit_user']['res']);    
}
//print_arr($get_user);
?>
<form action="" method="post">	
<table class="add_edit_page" cellspacing="0" cellpadding="0">
    <tr>
        <td class="add-edit-txt">Фамилия пользователя:</td>
        <td><input class="head-text" type="text" name="surname" value="<?=htmlspecialchars($get_user['surname'])?>" /></td>
    </tr>
    <tr>
        <td class="add-edit-txt">Имя пользователя:</td>
        <td><input class="head-text" type="text" name="name" value="<?=htmlspecialchars($get_user['name'])?>" /></td>
    </tr>
    <tr>
        <td class="add-edit-txt">Логин пользователя:</td>
        <td>
    <?php if($_SESSION['auth']['user_id'] != $user_id): //если мы зашли на редактирование не своего профиля?>
            <input class="access head-text" type="text" name="login" data-field="login" value="<?=htmlspecialchars($get_user['login'])?>" />
            <span></span><span class="info_access"></span>
    <?php else: //если мы редактируем свой же профиль ?>
             <input class="head-text" type="text" name="login" value="<?=htmlspecialchars($get_user['login'])?>" disabled="" />        
             <span class="small">Изменять собственный логин нельзя!</span>
    <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td class="add-edit-txt">Новый пароль пользователя:</td>
        <td><input class="head-text" type="text" name="password"  /></td>
    </tr>
    <tr>
        <td class="add-edit-txt">Email пользователя:</td>
        <td><input class="head-text access" type="text" name="email" data-field="email" value="<?=htmlspecialchars($get_user['email'])?>" />
        <span></span><span class="info_access"></span>
        </td>
    </tr>
    <tr>
        <td class="add-edit-txt">Телефон пользователя:</td>
        <td><input class="head-text" type="text" name="phone" value="<?=htmlspecialchars($get_user['phone'])?>" /></td>
    </tr>
    <tr>
        <td class="add-edit-txt">Адрес пользователя:</td>
        <td><input class="head-text" type="text" name="address" value="<?=htmlspecialchars($get_user['address'])?>" /></td>
    </tr>
    <?php if($_SESSION['auth']['user_id'] != $user_id): //если мы зашли на редактирование не своего профиля?>
    <tr>
    <td class="add-edit-txt">Роль пользователя:</td>
    <td>
        <?php if($roles):?>
            <select name="id_role">
                <?php foreach($roles as $item):?>
                <option <?php if($item['id_role'] == $get_user['id_role']) echo "selected"?> value="<?=$item['id_role']?>"><?=$item['name_role']?></option>
                <?php endforeach; ?>
            </select>
        <?php endif;?>
    </td>
    </tr>
    <?php endif; ?>
</table>
	
	<input type="image" src="<?=ADMIN_TEMPLATE?>img/save_btn.jpg" /> 

</form>
<?php //unset($_SESSION['edit_user']); ?>
</div> <!-- .content -->
</div> <!-- .content-main -->
</div> <!-- .karkas -->
</body>
</html>