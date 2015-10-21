<?php defined ('ISHOP') or die ('Access denied');?>
		<div class="content">
<?php //print_arr($get_page)?>
<h2>Добавление пользователя</h2>
<?php 
if(isset($_SESSION['add_user']['res'])){
    echo $_SESSION['add_user']['res'];
    unset($_SESSION['add_user']['res']);
}
?>
<form action="" method="post">	
<table class="add_edit_page" cellspacing="0" cellpadding="0">
    <tr>
    <td class="add-edit-txt">Фамилия пользователя:&nbsp;<span class="star">*</span></td>
    <td><input class="head-text" type="text" name="surname"  value="<?=htmlspecialchars($_SESSION['add_user']['surname'])?>"/></td>
    </tr>
    <tr>
    <td class="add-edit-txt">Имя пользователя:&nbsp;<span class="star">*</span></td>
    <td><input class="head-text" type="text" name="name"  value="<?=htmlspecialchars($_SESSION['add_user']['name'])?>"/></td>
    </tr>
    <tr>
    <td class="add-edit-txt">Логин пользователя:&nbsp;<span class="star">*</span></td>
    <td><input class="head-text" type="text" name="login" value="<?=htmlspecialchars($_SESSION['add_user']['login'])?>" /></td>
    </tr>
    <tr>
    <td class="add-edit-txt">Пароль пользователя:&nbsp;<span class="star">*</span></td>
    <td><input class="head-text" type="password" name="password"  value="<?=htmlspecialchars($_SESSION['add_user']['password'])?>" /></td>
    </tr>
    <tr>
    <td class="add-edit-txt">E-mail пользователя:&nbsp;<span class="star">*</span></td>
    <td><input class="head-text" type="text" name="email" value="<?=htmlspecialchars($_SESSION['add_user']['email'])?>" /></td>
    </tr>
    <tr>
    <td class="add-edit-txt">Телефон пользователя:&nbsp;<span class="star">*</span></td>
    <td><input class="head-text" type="text" name="phone" value="<?=htmlspecialchars($_SESSION['add_user']['phone'])?>" /></td>
    </tr>
    <tr>
    <td class="add-edit-txt">Адрес пользователя:&nbsp;<span class="star">*</span></td>
    <td><input class="head-text" type="text" name="address" value="<?=htmlspecialchars($_SESSION['add_user']['address'])?>" /></td>
    </tr>
    <tr>
    <td class="add-edit-txt">Роль пользователя:</td>
    <td>
        <?php if($roles):?>
            <select name="id_role">
                <?php foreach($roles as $item):?>
                <option value="<?=$item['id_role']?>"><?=$item['name_role']?></option>
                <?php endforeach; ?>
            </select>
        <?php endif;?>
    </td>
    </tr>
</table>
	
	<input type="image" src="<?=ADMIN_TEMPLATE?>img/save_btn.jpg" /> 

</form>
<?php unset($_SESSION['add_user']); ?>

</div> <!-- .content -->
</div> <!-- .content-main -->
</div> <!-- .karkas -->
</body>
</html>