<?php defined ('ISHOP') or die ('Access denied');?>
		<div class="content">
<?php //print_arr($get_product)?>	
<h2>Редактирование товара:</h2>
<?php 
if(isset($_SESSION['edit_product']['res'])){
    echo $_SESSION['edit_product']['res']; //выводим результат
    unset($_SESSION['edit_product']);
}
//print_arr($cat);
?>	

<div id="goods_id" style="display: none;"><?=$get_product['goods_id']?></div>
<!-- скрытый div для ajax загрузки и удаления картинок -->
<form action="" method="post" enctype="multipart/form-data" >
    <table class="add_edit_page" cellspacing="0" cellpadding="0">
        <tr>
            <td class="add-edit-txt">Название товара:</td>
            <td><input class="head-text" type="text" name="name" value="<?=htmlspecialchars($get_product['name'])?>"/></td>
        </tr>
        <tr>
            <td class="add-edit-txt">Цена:</td>
            <td><input class="head-text" type="text" name="price" value="<?=$get_product['price']?>" /></td>
        </tr> 
        <tr>
            <td>Родительская категория</td>
            <td>
                <select class="select-inf" name="category" multiple="" size="10" style="height: auto;">
                    <?php foreach($cat as $key_parent => $item):?>
                    <!--проверяем из какой категории мы сюда пришли-->
                        <?php if(count($item) > 1): //если это родительская категория ?>
                        <option disabled=""><?=$item[0]?></option>
                        <?php $i = 0; ?>
                        <?php foreach($item['sub'] as $key => $sub): // цикл дочерних категорий?>                           
                            <option <?php if($key == $brand_id OR $key_parent == $brand_id AND $i == 0){echo "selected"; $i=1;} ?> value="<?=$key?>">&nbsp;&nbsp;-&nbsp;<?=$sub?></option>  
                        <?php endforeach; //конец цикла дочерних категория?>
                        <?php elseif($item[0]): //если это самостоятельная категория ?>
                            <option <?php if($key_parent == $brand_id) echo"selected" ?> value="<?=$key_parent?>"><?=$item[0]?></option>
                        <?php endif; //конец условия родительская категория ?>                        
                    <?php endforeach; ?>
                <!--<option value="1"></option> -->
                </select>
            </td>
        </tr>

        <tr>
            <td>Фото товара:<br />
            <span class="small">Для удаления изображения кликните по ней</span>
            </td>
            <td class="baseimg"><?=$baseimg?></td>    
        </tr>
        <tr>
            <td>Краткое описание товара:</td>
            <td></td>
        </tr>
        <tr>
             <td colspan="2">
             <textarea id="editor1" class="anons-text" name="anons"><?=htmlspecialchars($get_product['anons'])?></textarea>
<script type="text/javascript">
	CKEDITOR.replace( 'editor1' );
</script>
             </td>
        </tr>
        <tr>
            <td colspan="2">Подробное описание товара:</td>
        </tr>
        <tr>
             <td colspan="2">
             <textarea id="editor2" class="anons-text" name="content"><?=htmlspecialchars($get_product['content'])?></textarea>
<script type="text/javascript">
	CKEDITOR.replace( 'editor2' );
</script>
             </td>
        </tr>
      <!--  <tr>
            <td>Фото галереи:</td>
            <td></td>
        </tr> 
      <tr>
        <td id="btnimg">
            <div><input type="file" name="galleryimg[]" /></div>
        </td>
      </tr>
      <tr>
        <td>
            <input type="button" id="add" value="Добавить поле" />
            <input type="button" id="del" value="Удалить поле" />
        </td>
      </tr>-->
        <tr>
            <td>Отметить как:</td>
            <td>
                <input type="checkbox" name="new" value="1" <?php if($get_product['new']) echo 'checked=""';?> />Новинки<br />
                <input type="checkbox" name="leader" value="1" <?php if($get_product['leader']) echo 'checked=""';?> />Лидеры продаж<br />
                <input type="checkbox" name="sale" value="1" <?php if($get_product['sale']) echo 'checked=""';?> />Скидки<br />
            </td>        
        </tr>
        <tr>
            <td>Отображать:</td>
            <td>
                <input type="radio" name="visible" value="1" <?php if($get_product['visible']) echo 'checked=""'; ?> />Да<br />
                <input type="radio" name="visible" value="0" <?php if(!$get_product['visible']) echo 'checked=""'; ?> />Нет
            </td>        
        </tr>
    </table>
    
    <input type="image" src="<?=ADMIN_TEMPLATE?>img/save_btn.jpg" />
</form>


</div> <!-- .content -->
</div> <!-- .content-main -->
</div> <!-- .karkas -->

<script type="text/javascript">
var id = $("#goods_id").text(); //ID Товара
</script>

</body>
</html>