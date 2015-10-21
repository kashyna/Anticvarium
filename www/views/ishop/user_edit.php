<?php defined('ISHOP') or die ('Access denied'); ?> <!--защита от прямого вызова -->
<div id="content-order">
<h2>Редактирование профиля</h2>
<?php 
//print_arr($_SESSION['auth']);
   if(isset($_SESSION['user_edit']['res'])){
        echo $_SESSION['user_edit']['res'];
        unset ($_SESSION['user_edit']['res']);
    }
?>
    <?php if($_SESSION['auth']): //проверка на авторизацию пользователя ?>
	<table id="user_edit" class="order-main-table" border="0" cellpadding="0" cellspacing="0">
    <form method="POST" action="">
        <tr>
        	<td class="z-top" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;Моя учетная запись</td>
        </tr>

        <tr class="c-tr">
        	<td class="c-title">Фамилия:</td>
            <td class="z-input"><input type="text" name="surname" value="<?=htmlspecialchars($user_area['surname'])?>" /></td>
        </tr>
        <tr class="c-tr">
        	<td class="c-title">Имя:</td>
            <td class="z-input"><input type="text" name="name" value="<?=htmlspecialchars($user_area['name'])?>" /></td>
        </tr>
        <tr class="c-tr">
            <td class="c-title">Адрес:</td>
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
            <td class="c-title">Телефон:</td>
            <td class="z-input"><input type="text" name="phone" value="<?=htmlspecialchars($user_area['phone'])?>" /></td>
        </tr>
        <tr class="c-tr">
            <td class="c-title">E-mail:</td>
            <td class="z-input"><input class="access" type="text" name="email" data-field="email" value="<?=htmlspecialchars($user_area['email'])?>" />
                <span></span><span class="info_access"></span>
            </td>
        </tr>
  
       </table>
    
    <input type="image" src="<?=TEMPLATE?>img/save.png" title="Сохранить изменения" alt="Сохранить изменения" />		
    <br /><br /> 
    </form>
   
    <?php else:?>
    <p class="card_null">Авторизируйтесь! </p>
    <?php endif;?>

<?php 
//unset ($_SESSION['order']);
?> 
</div>