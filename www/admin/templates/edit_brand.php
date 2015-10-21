<?php defined ('ISHOP') or die ('Access denied');?>
<div class="content">
<?php //print_arr($cat)?>
<h2>Редактирование категории</h2>
<?php 
if(isset($_SESSION['edit_brand']['res'])){
    echo $_SESSION['edit_brand']['res'];
    unset($_SESSION['edit_brand']);
}
?>
<form action="" method="post">
    <table class="add_edit_page" cellspacing="0" cellpadding="0">
        <tr>
            <td class="add_edit_text">Название категории:&nbsp;<span class="star">*</span></td>
            <td><input class="head-text" type="text" name="brand_name" value="<?=$cat_name?>" /></td>
        </tr>
        <tr>
            <td>Родительская категория:</td>
<?php if(!$cat[$brand_id]['sub']): //если нет подкатегории ?>
            <td>
                <select class="select-inf" name="parent_id">
                <option value="0">Самостоятельная категория</option>
                <?php foreach($cat as $key => $value):?>
                    <?php if($value[0] == $cat_name) continue; //значит не будем выводить данную категорию в списке, и перейдем к следующему элементу списка?>
                    
                    <option value="<?=$key?>"><?=$value[0]?></option>
                <?php endforeach;?>
                </select>
            </td>
<?php else: ?>
        <td>Данная категория содержит подкатегории</td>
<?php endif; ?>
        </tr>
    </table>
    <input type="image" src="<?=ADMIN_TEMPLATE?>img/save_btn.jpg" />
</form>


<?php //unset($_SESSION['edit_brand']);?>
</div> <!-- .content -->
</div> <!-- .content-main -->
</div> <!-- .karkas -->
</body>
</html>