<?php defined ('ISHOP') or die ('Access denied');?>
	<div class="content-main">
		<div class="leftBar">
			<ul class="nav-left">
				<li><a href="<?=PATH?>admin/" class="nav-activ">Основные страницы</a></li>
				<li><a href="?view=informers">Информеры</a></li>
				<li><a href="?view=brands">Категории товаров</a></li>                
<!-- Аккордеон -->               
<ul class="nav-catalog" id="accordion">
<?php foreach($cat as $key => $item): ?> 
	<?php if(count($item) > 1): //если это родительская категория, т.е. есть еще что-то помимо род.элемента ?>
        <li class="header_li"><a href="#"><?=$item[0]?></a></li>
        <!-- выводим дочерние категории -->
            <ul>
                <?php foreach($item['sub'] as $key => $sub): ?>
                    <li><a class="nav-active" href="?view=cat&category=<?=$key?>"><?=$sub?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php elseif($item[0]): //если самостоятельная категория ?>
        	<li><a href="?view=cat&category=<?=$key?>"><?=$item[0]?></a></li>
    <?php endif; ?>
<?php endforeach; ?>



<!--    <li class="header_li"><a href="#">Canon</a></li>
        <ul>
            <li><a href="?view=cat&category=1">Все модели</a></li>
        	<li><a href="?view=cat&category=10">Зеркальные полнокадровые</a></li>
        	<li><a href="?view=cat&category=9">Суперзумы</a></li>
        	<li><a href="?view=cat&category=7">Ультратонкие</a></li>
        </ul>
    <li class="header_li"><a href="?view=cat&category=3">Fujifilm</a></li>
    <ul>
            <li><a href="#">Все модели</a></li>
        	<li><a href="#">Зеркальные начального уровня</a></li>
        </ul>
    <li class="header_li"><a href="#">Nikon</a></li>
        <ul>
            <li><a href="#">Все модели</a></li>
        	<li><a href="#">Зеркальные начального уровня</a></li>
        </ul>

    <li class="header_li"><a href="#">Olympus</a> </li>
        <ul>
            <li><a href="?view=cat&category=5">Все модели</a></li>
        	<li><a href="?view=cat&category=12">Зеркальные полнокадровые</a></li>
        </ul>

    <li class="header_li"><a href="?view=cat&category=6">Samsung</a></li>
            <ul>
            <li><a href="#">Все модели</a></li>
        	<li><a href="#">Зеркальные начального уровня</a></li>
            </ul>


    <li class="header_li"><a href="#">Sony</a> </li>
        <ul>
            <li><a href="?view=cat&category=4">Все модели</a></li>
            <li><a href="?view=cat&category=11">Ультратонкие</a></li>
        </ul>  -->
</ul>  
<!-- Аккордеон -->   
                
                
				<li><a href="?view=news">Новости</a></li>
				<li><a href="#">Пользователи</a></li>
			</ul>
		</div> <!-- .leftBar -->