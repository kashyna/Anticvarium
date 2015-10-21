<?php defined ('ISHOP') or die ('Access denied');?>
<?php //print_arr($_SESSION['auth']);?>
<div class="crumb">
    	<a href="<?=PATH?>">Главная</a> &#8594;
        <a href="?view=archive">Архив новостей</a> &#8594;     	
        <span><?=$news_text['title']?></span>
</div>

<div class="content-txt">
    <?php if($news_text): ?>
        <h1><?=$news_text['title']?>&nbsp;&nbsp;&nbsp;<a href="?view=product&amp;goods_id=<?=$news_text['goods_id']?>" style="color: blue;font-size: 11px;font-style: italic;"
                                                                title="Детальный обзор продукта">просмотреть</a></h1>
        <span class="news_date"><?=$news_text['data']?></span>
        <br /><br />
        <?=$news_text['text']?>
    <?php else:?> 
        <p>Такой новости нет!</p>
    <?php endif;?>
</div> <!-- .content-txt -->