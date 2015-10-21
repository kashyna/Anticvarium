<?php defined ('ISHOP') or die ('Access denied');?>
<div class="content">
<h2>Список категорий</h2>
<?php //print_arr($brand_name)?>	
<?php 
if(isset($_SESSION['answer'])){
    echo $_SESSION['answer']; //выводим результат
    unset($_SESSION['answer']);
}
?>
<a href="?view=add_brand"><img class="add_category" src="<?=ADMIN_TEMPLATE?>img/add_category.jpg" alt="добавить категорию" /></a>
<div class="crumb">
<?php if(count($brand_name) > 1): //тогда подкатегория (зеркальные, ультратонкие) ?>
    <p class="crumb-left"><a href="?view=brands">Фотоаппараты</a>&#8594;
        <a href="?view=cat&category=<?=$brand_name[0]['brand_id']?>"><?=$brand_name[0]['brand_name']?></a> &#8594;
        <span><?=$brand_name[1]['brand_name']?></span>
    </p>
<?php elseif(count($brand_name) == 1 ): //если не дочерняя категория ?>
    <p class="crumb-left"><a href="?view=brands">Фотоаппараты</a>&#8594;
        <span><?=$brand_name[0]['brand_name']?></span>
    </p>
<?php endif;?>    
    <p class="crumb-right"><a href="?view=edit_brand&amp;brand_id=<?=$category?>&amp;parent_id=<?=$brand_name[0]['brand_id']?>" class="edit">изменить категорию</a>&nbsp;  | &nbsp;<a href="?view=del_brand&amp;brand_id=<?=$category?>" class="del">удалить категорию</a>
    </p>        
</div>

<a href="?view=add_product&amp;brand_id=<?=$category?>"><img class="add_some" src="<?=ADMIN_TEMPLATE?>img/add_product.jpg" alt="добавить продукт" /></a>

<?php if($products): //если есть товары в данной категории ?>
<?php 
$col = 3; //количество ячеек в строке
$row = ceil((count($products)/$col)); //кол-во строк
$start = 0; //счетчик товаров
?>
<table class="tabl-cat" cellspacing="1">
<?php for($i = 0; $i < $row; $i++):  //цикл вывода рядов ?>
    <tr>
    <?php for($k = 0; $k < $col; $k++)://колво выводимых товаров, цикл вывода ячеек ?>
      <!-- <div style="margin: 0 5px;">-->
       <td>
            <?php if($products[$start]): //если есть товар ?>
            <h2><?=$products[$start]['name']?></h2>
    <div class="product-table-img">
            <img src="<?=PRODUCTIMG?><?=$products[$start]['img']?>" alt="" />
    </div><!-- .product-table-img-->
            <p><a href="?view=edit_product&amp;goods_id=<?=$products[$start]['goods_id']?>" class="edit">изменить&nbsp; | &nbsp;<a href="?view=del_product&amp;goods_id=<?=$products[$start]['goods_id']?>" class="del">удалить</a></p>
            <?php else: //если нет товара ?>
                &nbsp;
            <?php endif; //перенос внутрь ячейки ?>
            <?php $start++; ?>
       </td>
        
    <?php endfor; ?>
    </tr>
    <?php endfor; //цикл вывода рядов ?>
</table>

<?php else: //если нет товаров ?>
    <p>В данной категории пока нет товаров.</p>
<?php endif; //конец условия - если есть товары в данной категории ?>
<a href="?view=add_product&amp;brand_id=<?=$category?>"><img class="add_some" src="<?=ADMIN_TEMPLATE?>img/add_product.jpg" alt="добавить продукт" /></a>
<?php if($pages_count > 1) pagination($page, $pages_count);?>
</div> <!-- .content -->
</div> <!-- .content-main -->
</div> <!-- .karkas -->

</body>
</html>