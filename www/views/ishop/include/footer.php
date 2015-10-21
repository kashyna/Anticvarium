<?php defined ('ISHOP') or die ('Access denied');?>

       <div class="footer">
       		<div class="flogo">
            	<a href="/"><img src="<?=TEMPLATE?>img/slogan1.png" alt="Интернет-магазин фототехники" /></a>
				<p>Copyright (c) 2015</p>
            </div>
            <div class="fphone">
                <h2>Телефон:</h2><br />
                <h1>+380951234567</h1>
                <h2>Режим работы:</h2><br/> 
                <p>Будние дни: 8:00-17:00 <br/> 
                Сб, Вс - выходные</p>
            </div>
            <div class="fmenu">
            	<p>Меню:</p>
                <ul>
   	<li><a href="<?=PATH?>">Главная</a></li> 
        <?php if($pages): ?>
            <?php foreach($pages as $item):?>
            <li><a href="?view=page&amp;page_id=<?=$item['page_id']?>"><?=$item['title']?></a></li>
            <?php endforeach; ?>
        <?php endif; ?>        
                </ul>
            </div>
       </div>