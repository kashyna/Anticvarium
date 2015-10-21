<?php defined ('ISHOP') or die ('Access denied');?>
<div class="popular">
<?php //print_arr($products);?>
<div id="fond"></div>
<div id="load"></div>
    <div class="crumb">
<?php if(count($brand_name) > 1): //тогда подкатегория (зеркальные, ультратонкие)?>
	<a href="<?=PATH?>">Фотоаппараты</a> &#8594;
    <a href="?view=cat&amp;category=<?=$brand_name[0]['brand_id']?>"><?=$brand_name[0]['brand_name']?></a> &#8594; 
	<span><?=$brand_name[1]['brand_name']?></span>
<?php elseif(count($brand_name) == 1 ): //если не дочерняя категория ?>
	<a href="<?=PATH?>">Фотоаппараты</a> &#8594;
	<span><?=$brand_name[0]['brand_name']?></span>
<?php endif;?>
    
    </div>  <!-- .crumb -->
    
    <div class="view-sorting">
        <div class="view"> 
        	Вид:
            <a href="#" id="grid" class="grid_list"><img <?php if(!isset($_COOKIE['display']) OR $_COOKIE['display'] == 'grid'):?> src="<?=TEMPLATE?>img/view-table-active1.gif"
                                                                <?php else:?> 
                                                                src="<?=TEMPLATE?>img/view-table1.gif"
                                                                <?php endif;?>
                                                                title="Табличный вид" alt="Табличный" /></a>
            <a href="#" id="list" class="grid_list"><img <?php if($_COOKIE['display'] == 'list'):?> src="<?=TEMPLATE?>img/view-line-active1.gif"
                                                                <?php else:?> 
                                                                src="<?=TEMPLATE?>img/view-line1.gif"
                                                                <?php endif;?>
                                                                title="Линейный вид" alt="Линейный" /></a>
       </div>
         <div class="sorting"> 
            <span>Сортировать по:&nbsp;</span>
            <a id="param_sort" class="sort-top"><?=$order?>&nbsp;&#9660;</a>
                <div class="sort-wrap">
                    <?php foreach($order_p as $key => $value):?>
                        <?php if($value[0] == $order) continue; //т е пропускаем этот элемент, если он есть ?>
                        <a id="<?=$key?>" href="?view=cat&amp;category=<?=$category?>&amp;order=<?=$key?>&amp;page=<?=$page?>" class="sort-bot"><?=$value[0]?></a>                   
                    <?php endforeach; ?>
                </div>
          <!--  <a href="#" class="sort-top-active">&#9650;цене</a>&nbsp;|&nbsp;
            <a href="#" class="sort-top">&#9650;названию</a>&nbsp;|&nbsp;
            <a href="#" class="sort-bot">&#9660;дате добавления</a> -->
        </div>
    </div> <!-- .view-sorting -->
    <?php //print_arr($order_p)?>
    
<?php if($products):  //если в массиве products что-то есть ?> 
    <?php foreach($products as $product):?>
    <?php if(!isset($_COOKIE['display']) OR $_COOKIE['display'] == 'grid'): //если куки изначально нет, или она имеет значение table, 
                                    //то по умолчанию показываем табличный вид ?>

<!-- Табличный вид продуктов-->
<div class="product_ajax">
     <div class="product-table">
    	<h2><a href="?view=product&goods_id=<?=$product['goods_id']?>">Фотоаппарат&nbsp;<?=$product['name']?></a></h2>
        <div class="product-table-img-main">
        	<div class="product-table-img">
        		<a href="?view=product&goods_id=<?=$product['goods_id']?>"><img src="<?=PRODUCTIMG?><?=$product['img']?>" class="baseimg" /></a>
                <div>
                <!-- Icons -->
                    <?php if($product['new']) //если элемент массива продуктпод названием лидер возвращает истину
                        echo '<img src="'.TEMPLATE. 'img/nav-new.png" alt="новинка" />'; ?>
                    <?php if($product['leader'])echo '<img src="'.TEMPLATE.'img/nav-leader.png" alt="лидер продаж" />';?>
                    <?php if($product['sale'])echo '<img src="'.TEMPLATE.'img/nav-sale.png" alt="скидки" />';?>
                <!-- Icons -->
                </div>                    
        	</div> <!-- .product-table-img-->
        </div> <!-- .product-table-img-main-->
		<a class="more-table" href="?view=product&goods_id=<?=$product['goods_id']?>">подробнее...</a>
        <div class="product-table-price">
             <span class="sum"><?=$product['price']?></span>
             <span class="currency">грн.</span>
             
            <?php if($product['quantity'] != 0):?>
            <a class="addtocard" href="?view=addtocard&goods_id=<?=$product['goods_id']?>"><img class="addtocard-index" src="<?=TEMPLATE?>img/buy-index1.png" title="Добавить в корзину" alt="Купить" /></a>
            <?php else:?>
            <a class="disabled" href="#"><img class="addtocard-index" src="<?=TEMPLATE?>img/no-buy1.png" title="Нет в наличии" alt="Нет в наличии" /></a>
            <?php endif;?>             
      </div>       	 
    </div>
    </div>
<?php else: //если $свитч - ложь, равен 0, либо не установлен ?>    
<!-- Линейный вид продуктов-->  
<div class="product_ajax">  
 <div class="product-line">
	<div class="product-line-img">
    	<a href="?view=product&goods_id=<?=$product['goods_id']?>"><img src="<?=PRODUCTIMG?><?=$product['img']?>" /></a>
    </div>   
 <table id='tab-line-product'>
    	<tr>
        <td colspan="100%" >
    		<div class="product-line-header">
    			<a href="?view=product&goods_id=<?=$product['goods_id']?>">Фотоаппарат&nbsp;<?=$product['name']?></a>
            </div>
        </td>
        </tr>
        <tr>
        	<td>
            <div class="product-line-about">
                <p><?=$product['anons']?></p>
    		</div>
            </td>
        	
            <td>
            <div class="product-line-price">
                <span class="sum"><?=$product['price']?></span>
                <span class="currency">грн.</span>                      	
            <?php if($product['quantity'] != 0):?>
            <a href="?view=addtocard&goods_id=<?=$product['goods_id']?>"><img class="addtocard-index" src="<?=TEMPLATE?>img/buy-index.png" title="Добавить в корзину" alt="Купить" /></a>
            <?php else:?>
            <a class="disabled" href="#"><img class="addtocard-index" src="<?=TEMPLATE?>img/no-buy.png" title="Нет в наличии" alt="Нет в наличии" /></a>
            <?php endif;?>                    
                    <div>
                <!-- Icons -->
                    <?php if($product['new']) //если элемент массива продуктпод названием лидер возвращает истину
                        echo '<img src="'.TEMPLATE. 'img/nav-new.png" alt="новинка" />'; ?>
                    <?php if($product['leader'])echo '<img src="'.TEMPLATE.'img/nav-leader.png" alt="лидер продаж" />';?>
                    <?php if($product['sale'])echo '<img src="'.TEMPLATE.'img/nav-sale.png" alt="скидки" />';?>
                <!-- Icons -->
                    </div>
    		</div>
            </td>
        </tr>
        <tr>
			<td colspan=100%>
            <p class="more"><a href="?view=product&goods_id=<?=$product['goods_id']?>">подробнее...</a></p>
        	</td>
        </tr>
   </table>   
</div>
</div>
<?php endif;//конец условия, вид вывода товаров (табл, лин) ?>
<?php endforeach; ?>
<div class="clr"></div> <!-- убираем float стили, чтобы страницы не обтекали токары-->
<?php if($pages_count > 1) pagination($page, $pages_count);?>
<?php else: //конец условия прохода по products ?>
    <p> Здесь товаров пока нет</p>
<?php endif; ?>
<a name="nav"></a>
<div class="res"></div>
</div> <!-- .popular -->