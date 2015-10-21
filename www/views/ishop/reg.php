<body>
<div id="contentwrapper">
<div id="content-order">
<?php //print_arr($_SESSION)?>
<?php if($_SESSION['reg']['answer'] != "<div class='success'>Регистрация прошла успешно</div>"):?>
<h2>РЕГИСТРАЦИЯ</h2>
    <?php if(!$_SESSION['auth']['customer_id']):?>
    <p style="color: red;font-size:11px; font-size:12px;margin:0 0 0 15px;">* Обязательно для заполнения</p>
   	<form method="POST" action="#">
        <table class="order-data" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="z-txt"><b>*&nbsp;</b>Логин:</td>
            <td class="z-input"><input class="access" type="text" data-field="login" name="login" id="login" value="<?=htmlspecialchars($_SESSION['reg']['login'])?>" />
            <span></span>
            <span class="info_access"></span>
            </td>                        
            <td class="z-example">Пример: ivan451</td>
          </tr>
          <tr>
            <td class="z-txt"><b>*&nbsp;</b>Пароль:</td>
            <td class="z-input"><input id="pass" type="password" name="pass" />
                <span id="result"></span>
            </td>
            <td class="z-example">Пароль должен содержать не менее 6 символов</td>
          </tr>
          <tr>
            <td class="z-txt"><b>*&nbsp;</b>Повторите пароль:</td>
            <td class="z-input"><input type="password" name="pass2" /></td>
            <td class="z-example">Пароль должен содержать не менее 6 символов</td>
          </tr>
          <tr>
            <td class="z-txt"><b>*&nbsp;</b>Фамилия:</td>
            <td class="z-input"><input type="text" name="surname" value="<?=htmlspecialchars($_SESSION['reg']['surname'])?>" /></td>
            <td class="z-example">Пример: Иванов</td>
          </tr>
          <tr>
            <td class="z-txt"><b>*&nbsp;</b>Имя:</td>
            <td class="z-input"><input type="text" name="name" value="<?=htmlspecialchars($_SESSION['reg']['name'])?>" /></td>
            <td class="z-example">Пример: Петр Александрович</td>
          </tr>
          <tr>
            <td class="z-txt"><b>*&nbsp;</b>E-mail:</td>
            <td class="z-input"><input class="access" type="text" name="email" data-field="email" id="email" value="<?=htmlspecialchars($_SESSION['reg']['email'])?>" />
            <span></span><span class="info_access"></span></td>
            <td class="z-example">Пример: example@gmail.com</td>
          </tr>
          <tr>
            <td class="z-txt"><b>*&nbsp;</b>Телефон:</td>
            <td class="z-input"><input type="text" name="phone" value="<?=htmlspecialchars($_SESSION['reg']['phone'])?>"/></td>
            <td class="z-example">Пример: +38 (095) 1212456</td>
          </tr>
          <tr>
            <td class="z-txt"><b>*&nbsp;</b>Адрес доставки:</td>
            <td class="z-input"><input type="text" name="address" value="<?=htmlspecialchars($_SESSION['reg']['address'])?>"/></td>
            <td class="z-example">Пример: г.Одесса, ул. Матроса Кошки 19/2</td>
          </tr>
          <tr>
            <td class="z-txt" style="vertical-align:top;">Комментарий:</td>
            <td class="z-txtarea"><textarea></textarea></td>
            <td class="z-example" style="vertical-align:top;">Пример: Позвоните пожалуйста после 6-ти вечера, 
до этого времени я на работе.</td>
          </tr>
 <!--         <tr>
          <td class="z-txt"><img src="capcha.php" alt="" /></td>
          <td class="z-input"><input name="md5"/></td>
          </tr>  -->
        </table>
		
		<input style="padding: 3px;margin:0 30%;" type="submit" name="reg" value="Зарегистрироваться" /> 
		
		<br /><br /><br /><br />
	</form>
    <?php else:?>
    <p>Вы уже зарегистрированы.</p>
    <?php endif;?>
    <?php else:?>
    <?php echo "<br />".$_SESSION['reg']['answer'];?>
    <?php endif;?>
    <?php unset($_SESSION['reg']['answer']);?>
    <?php 
        if(isset($_SESSION['reg']['res'])){
            echo $_SESSION['reg']['res'];
            unset($_SESSION['reg']); //после обновления проподало сообщение об ошибке, либо в начале оно не появлялось
        }
    ?>
    
</div>
</div>

   
     
</body>
</html>
