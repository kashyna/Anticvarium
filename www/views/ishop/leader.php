<?php defined ('ISHOP') or die ('Access denied');?>
       	<div class="popular">
       <?php //print_arr($informers);
	     /*print_arr($cat)*/
         //print_arr($eyestoppers);
         //print_arr($_SESSION['card']);
	    ?>
        	<h1>ЛИДЕРЫ ПРОДАЖ</h1>

<?php if($eyestoppers):?>
<?php /*if($_SESSION['addtocard']['qty_goods']){
        echo $_SESSION['addtocard']['qty_goods'];
        unset ($_SESSION['addtocard']['qty_goods']);  
}        */
?>
    <?php foreach($eyestoppers as $eyestopper):?>
        <div id="<?=$eyestopper['goods_id']?>" class="product">
            <a class="position" href="?view=product&goods_id=<?=$eyestopper['goods_id']?>"><img class="content-img" src="<?=PRODUCTIMG?><?=$eyestopper['img']?>" alt="" /></a>
            <h2 class="goods_name"><a href="?view=product&goods_id=<?=$eyestopper['goods_id']?>"><?=$eyestopper['name']?></a></h2>
            <p> <span><?=$eyestopper['price']?></span> грн.</p>
            <?php if($eyestopper['quantity'] != 0):?>
            <a class="button-buy" href="?view=addtocard&goods_id=<?=$eyestopper['goods_id']?>"><img class="addtocard-index" src="<?=TEMPLATE?>img/buy-index1.png" title="Добавить в корзину" alt="Купить" />
            <a href="<?=$eyestopper['quantity']?>" class="qty" hidden=""><?=$eyestopper['quantity']?></a></a>            
            <?php else:?>
            <a class="disabled" href="#"><img class="addtocard-index" src="<?=TEMPLATE?>img/no-buy1.png" title="Нет в наличии" alt="Нет в наличии" /></a>
            <?php endif;?>
        </div>
    <?php endforeach;?>
    <?php else:?>
        <p>Здесь товаров пока нет</p>
<?php endif;?>
       </div>