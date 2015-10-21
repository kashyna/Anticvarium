<?php defined ('ISHOP') or die ('Access denied');?>
<div class="crumb">
    	<a href="<?=PATH?>">Главная</a> &#8594;
        <span>Архив новостей</span>
</div>

<div class="content-txt">
    <?php if($all_news): ?>
        <?php foreach($all_news as $item):?>
          <h2><a href="?view=news&amp;news_id=<?=$item['news_id']?>"><?=$item['title']?></a></h2>
          <span class="news_date"><?=$item['data']?></span> 
          <br /><br />
          <p><?=$item['anons']?></p>
          <p><a href="?view=news&amp;news_id=<?=$item['news_id']?>">подробнее...</a></p> 
        <?php endforeach;?>
        <?php if($pages_count > 1) pagination($page, $pages_count)?>
    <?php else:?> 
        <p>Новостей пока нет.</p>
    <?php endif;?>
</div> <!-- .content-txt -->