<?php defined ('ISHOP') or die ('Access denied');?>
<?php //print_arr($goods);?>
<?php if($goods): //проверяем что есть товар ?>
<div class="crumb">
<?php if(count($brand_name) > 1): //тогда подкатегория (зеркальные, ультратонкие)?>
    <a href="<?=PATH?>">Фотоаппараты</a> &#8594; 
    <a href="?view=cat&amp;category=<?=$brand_name[0]['brand_id']?>"><?=$brand_name[0]['brand_name']?></a> &#8594; 
    <a href="?view=cat&amp;category=<?=$brand_name[1]['brand_id']?>"><?=$brand_name[1]['brand_name']?></a> &#8594;
    <span><?=$goods['name']?></span>
<?php elseif(count($brand_name) == 1 ): //если не дочерняя категория ?>
	<a href="<?=PATH?>">Фотоаппараты</a> &#8594;
	<a href="?view=cat&amp;category=<?=$brand_name[0]['brand_id']?>"></a><?=$brand_name[0]['brand_name']?></a>
    <span><?=$goods['name']?></span>
<?php endif; ?>
</div>  <!-- .crumb -->
<?php //print_arr($brand_name)?>
<div class="catalog-detail">   
    <h1><?=$goods['name']?></h1>
<?php // if($goods['img_slide']):   //если есть картинки галереи ?>
<!-- <div class="item_gallery">
   <div class="item_img">
       <img src="" /> 
   </div> <!-- .item_img -->
<!--   <div class="item_thumbs">
   <?php // foreach($goods['img_slide'] as $item):?>
        <a href="<?=PRODUCTIMG?>photos/<?=$item?>"><img src="<?=PRODUCTIMG?>thumbnails/<?=$item?>" /></a>
   <?php //endforeach;?>
   </div> <!-- .item_thumbs -->
   
<!--
</div> <!-- .item_gallery -->
<?php //endif;?>

<!-- без галереи-->
<a id="zoom1" class="cloud-zoom" href="<?=PRODUCTIMG?>1-big.jpg" rel="zoomWidth:400, zoomHeight:250, adjustX: 10, adjustY:-4"><img class="product-detail" src="<?=PRODUCTIMG?><?=$goods['img']?>"/></a>
<!-- без галереи-->

<div class="brief-descript-product">

	 <div class="product-detail-price">
     <p class="price">цена:</p>
            <span class="sum"><?=$goods['price']?></span>
            <span class="currency">грн.</span> 
            
            <?php if($goods['quantity'] != 0):?>
            <a class="button-buy" href="?view=addtocard&goods_id=<?=$goods['goods_id']?>"><img class="addtocard-index" src="<?=TEMPLATE?>img/buy-index.png" title="Добавить в корзину" alt="Купить" /></a>
            <?php else:?>
            <a class="disabled" href="#"><img class="addtocard-index" src="<?=TEMPLATE?>img/no-buy.png" title="Нет в наличии" alt="Нет в наличии" /></a>
            <?php endif;?>  
          </div>
     <div class="product-detail-about">
     <p><?=$goods['anons']?></p>
	<!--	<p>Размер матрицы: 36,0 x 23,9 мм;<br />
              Тип матрицы: КМОП (CMOS);<br />
              Кол-во пикселей, млн.: 22,3;<br />
              Оптический зум: 4x;<br /> 
              Размер дисплея: 3,2";<br />
              Съемка видео: FullHD (1920x1080);
		</p> -->
     </div>
		<div class="icon-detail">
            <?php if($goods['new']) //если элемент массива продуктпод названием лидер возвращает истину
                    echo '<img src="'.TEMPLATE. 'img/nav-new.png" alt="новинка" />'; ?>
            <?php if($goods['leader']) echo '<img src="'.TEMPLATE.'img/nav-leader.png" alt="лидер продаж" />';?>
            <?php if($goods['sale']) echo '<img src="'.TEMPLATE.'img/nav-sale.png" alt="скидки" />';?>
               
            <!-- <img src="img/nav-new.png" alt="новинка" />
            <img src="img/nav-leader.png" alt="лидер продаж" />
            <img src="img/nav-sale.png" alt="скидки" /> -->
        </div>
    </div>

</div> <!-- .catalog-detail -->




         <div class="clr"></div>
         
         <div class="full-descript-product">
         	<h3>Описание фотоаппарата <?=$goods['name']?></h3>
            <p><?=$goods['content']?></p>
            <!--    <p>Если вы собрались обзавестись хорошим цифровым фотоаппаратом, то советуем вам обратить внимание на новинку от компании Сanon – 
                функциональную и современную цифровую фотокамеру Canon EOS 5D Mark III 24-105 kit*, которая обеспечит вам превосходное качество снимков
                 вне зависимости от условий освещения. Вы сможете снимать качественные фотографии даже после захода солнца, благодаря диапазону чувствительности 
                 ISO 100–25 600 (с возможностью расширения до ISO 102 400).</p>
                <p>Новинка оснащена 22,3 мегапиксельным CMOS-датчиком изображения и новейшим процессором обработки изображения DIGIC 5+. 
                Автофокусировка представлена 61-точечной системой по широкой зоне. Камера также способна снимать высококачественное видео в формате Full HD 
                со стереозвуком с частотой дискретизации 48 КГц, а стандартный разъем для микрофона 3,5 мм позволит вам использовать микрофоны от другого производителя. 
                С фотокамерой Canon EOS 5D Mark III 24-105 kit вы сможете начать редактирование фотографий еще в дороге домой – можно оценивать отснятые 
                изображения по пятибалльной шкале и сравнивать их на дисплее камеры одновременно. Ко всему прочему корпус камеры выполнен из магниевого сплава, 
                который обеспечит нежной и дорогой начинке надежную защиту.</p> -->
         
                	               
     <!--    <div class="tech-character">
			<h3>Технические характеристики</h3>
            <ul>
            	<li><h4>Тип фотокамеры</h4></li>
                <li>Тип фотокамеры:		</li>
            </ul>
            
            <ul>
            	<li><h4>Матрица</h4></li>
                <li>Размер матрицы: 36,0 x 23,9 мм</li>
                <li>Тип матрицы	: КМОП (CMOS)</li>
                <li>Кол-во пикселей, млн.:	22,3</li>
            </ul>
            
            <ul>
            	<li><h4>Объектив</h4></li>
                <li>Оптический зум	4x</li>
                <li>Фокусное расстояние и светосила объектива	24 - 105 мм</li>
                <li>Диафрагма f/1,0 - 4,0</li>
                <li>Диаметр объектива	77 mm</li>
                <li>Модель объектива	Canon EF 24 - 105mm f/4L IS USM</li>
                <li>Возможные используемые объективы	EF</li>
            </ul>
            
            <ul>
            	<li><h4>Фокусировка</h4></li>
                <li>Тип	TTL-CT-SIR с использованием CMOS-датчика</li>
                <li> Автофокус / ручная фокусировка: Есть</li>
            </ul>
            
            <ul>
            	<li><h4>Светочувствительность</h4></li>
                <li> Чувствительность, экв. ISO:	Авто (100-12800), 100-25600 (при шаге 1/3 ступени или целая ступень)<br /> 				                     Чувствительность ISO может быть расширена до L: 50, H1: 51200, H2: 102400</li>
            </ul>

         </div>     -->  
 </div>




<?php else: ?>
    <div class="error">Такого товара нет</div>
<?php endif;?>