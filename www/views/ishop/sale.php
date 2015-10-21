<?php defined ('ISHOP') or die ('Access denied');?>
       	<div class="popular">
            	<h1>РАСПРОДАЖА</h1>
<?php if($eyestoppers):?>
    <?php foreach($eyestoppers as $eyestopper):?>
        <div class="product">
            <a href="?view=product&goods_id=<?=$eyestopper['goods_id']?>"><img class="content-img" src="<?=PRODUCTIMG?><?=$eyestopper['img']?>" alt="" /></a>
            <h2><a href="?view=product&goods_id=<?=$eyestopper['goods_id']?>"><?=$eyestopper['name']?></a></h2>
            <p> <span><?=$eyestopper['price']?></span> грн.</p>
            <?php if($eyestopper['quantity'] != 0):?>
            <a class="button-buy" href="?view=addtocard&goods_id=<?=$eyestopper['goods_id']?>"><img class="addtocard-index" src="<?=TEMPLATE?>img/buy-index.png" title="Добавить в корзину" alt="Купить" /></a>
            <?php else:?>
            <a class="disabled" href="#"><img class="addtocard-index" src="<?=TEMPLATE?>img/no-buy.png" title="Нет в наличии" alt="Нет в наличии" /></a>
            <?php endif;?>
        </div>
    <?php endforeach;?>
    <?php else:?>
        <p>Здесь товаров пока нет</p>
<?php endif;?>
            </div>