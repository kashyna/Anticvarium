<?php defined ('ISHOP') or die ('Access denied');?>
<div class="popular">
    <h1>Результаты поиска</h1>
    
    <?php if($result_search['notfound']): //если ничего не найдено ?>
        <?php echo $result_search['notfound']; ?>
        <?php else: //notfound нет, но масив result_search есть ?>
<?php for($i = $start_position; $i < $end_position; $i++): ?>
<!-- Табличный вид продуктов-->
     <div class="product-table">
    	<h2><a href="?view=product&goods_id=<?=$result_search[$i]['goods_id']?>">Фотоаппарат&nbsp;<?=$result_search[$i]['name']?></a></h2>
        <div class="product-table-img-main">
        	<div class="product-table-img">
        		<a href="?view=product&goods_id=<?=$result_search[$i]['goods_id']?>"><img src="<?=PRODUCTIMG?><?=$result_search[$i]['img']?>" class="baseimg" /></a>
                <div>
                <!-- Icons -->
                    <?php if($result_search[$i]['new']) //если элемент массива продуктпод названием лидер возвращает истину
                        echo '<img src="'.TEMPLATE. 'img/nav-new.png" alt="новинка" />'; ?>
                    <?php if($result_search[$i]['leader'])echo '<img src="'.TEMPLATE.'img/nav-leader.png" alt="лидер продаж" />';?>
                    <?php if($result_search[$i]['sale'])echo '<img src="'.TEMPLATE.'img/nav-sale.png" alt="скидки" />';?>
                <!-- Icons -->
                </div>                    
        	</div>
        </div>
		<a class="more-table" href="?view=product&goods_id=<?=$result_search[$i]['goods_id']?>">подробнее...</a>
        <div class="product-table-price">
             <span class="sum"><?=$result_search[$i]['price']?></span>
             <span class="currency">грн.</span>
             <a href="?view=addtocard&goods_id=<?=$result_search[$i]['goods_id']?>"><img class="addtocard-index" src="<?=TEMPLATE?>img/add-to-card.png" alt="Добавить в корзину" /></a>                        	
        </div>       	 
    </div>
<?php endfor; ?>
<?php if($pages_count > 1) pagination($page, $pages_count);?>
<?php endif; ?>
</div>