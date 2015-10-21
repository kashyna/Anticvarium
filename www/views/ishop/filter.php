<?php defined ('ISHOP') or die ('Access denied');?>

<div class="popular">
    <h1>Выбор по параметрам</h1>
    <?php //print_arr($products); ?>
    <?php if($products['notfound']): //если ничего не найдено ?>
        <?php echo $products['notfound']; ?>
        <?php else: //notfound нет, но масив result_search есть ?>
<?php foreach($products as $product):?>
<!-- Табличный вид продуктов-->
<div class="product-table">
<h2><a href="?view=product&goods_id=<?=$product['goods_id']?>">Фотоаппарат&nbsp;<?=$product['name']?></a></h2>
    <div class="product-table-img-main">
	<div class="product-table-img">
		<a href="?view=product&goods_id=<?=$product['goods_id']?>"><img class="baseimg" src="<?=PRODUCTIMG?><?=$product['img']?>" /></a>
        <div>
        <!-- Icons -->
            <?php if($product['new']) //если элемент массива продуктпод названием лидер возвращает истину
                echo '<img src="'.TEMPLATE. 'img/nav-new.png" alt="новинка" />'; ?>
            <?php if($product['leader'])echo '<img src="'.TEMPLATE.'img/nav-leader.png" alt="лидер продаж" />';?>
            <?php if($product['sale'])echo '<img src="'.TEMPLATE.'img/nav-sale.png" alt="скидки" />';?>
        <!-- Icons -->
        </div>                    
	</div>
    </div>
<a class="more-table" href="?view=product&goods_id=<?=$product['goods_id']?>">подробнее...</a>
<div class="product-table-price">
     <span class="sum"><?=$product['price']?></span>
     <span class="currency">грн.</span>
            <?php if($product['quantity'] != 0):?>
            <a href="?view=addtocard&goods_id=<?=$product['goods_id']?>"><img class="addtocard-index" src="<?=TEMPLATE?>img/buy-index1.png" title="Добавить в корзину" alt="Купить" /></a>
            <?php else:?>
            <a class="disabled" href="#"><img class="addtocard-index" src="<?=TEMPLATE?>img/no-buy1.png" title="Нет в наличии" alt="Нет в наличии" /></a>
            <?php endif;?> 
    </div>       	 
</div>
<?php endforeach; ?>
<?php if($pages_count > 1) pagination($page, $pages_count);?>
<?php endif; ?>
</div>