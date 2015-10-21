<?php defined ('ISHOP') or die ('Access denied');?>
      
        <div id="left-bar">
        	<div class="left-bar-cont">
            <h2><span>Каталог товаров</span></h2>
            <div style="background-color: #f5f5f5;"><h3 class="nav-new"><a class="ajax_catNO"  href="?view=new">Новинки</a></h3>
            <h3 class="nav-leader"><a class="ajax_catNO" href="?view=leader">Лидеры</a></h3>
            <h3 class="nav-sale"><a class="ajax_catNO" href="?view=sale">Скидки</a></h3>
            </div>
            
          <!--  <h3 class="nav-new"><div id="ajax_new">Новинки</div></h3>
            <h3 class="nav-leader"><div id="ajax_leader">Лидеры</div></h3>
            <h3 class="nav-sale"><div id="ajax_sale">Скидки</div></h3>  -->
            
        <!--    <div class="left-bar-photo">-->
            <!--		Меню катеорий			-->
            <h4><span>Фототехника</span></h4>
           	  <ul class="nav-catalog" id="accordion">
              	<?php foreach($cat as $key => $item): ?> 
                	<?php if(count($item) > 1): //если это родительская категория, т.е. есть еще что-то помимо род.элемента ?>
                          <h3 style="text-transform: uppercase;"><li><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;<?=$item[0]?></a> </li></h3>
                            <ul>
                        	<li><a <?=active_url1("category=$key")?> href="?view=cat&category=<?=$key?>">&nbsp;&nbsp;Все модели</a></li>
                            <?php foreach($item['sub'] as $key => $sub): ?>
                        	<li><a <?=active_url1("category=$key")?> href="?view=cat&category=<?=$key?>">&nbsp;&nbsp;<?=$sub?></a></li>
                            <?php endforeach; ?>
                            </ul>
                        <?php elseif($item[0]): //если самостоятельная категория ?>
                        	<li style="text-transform: uppercase;"><a <?=active_url1("category=$key")?> href="?view=cat&category=<?=$key?>">&nbsp;&nbsp;&nbsp;&nbsp;<?=$item[0] ?></a></li>
                    <?php endif; ?>
				<?php endforeach; ?>
              
               </ul>
           <!--     </div> -->

        <h4><span>Информация</span></h4>
               
             <!--    Информеры    нач   -->   
             <?php foreach($informers as $informer):?>
                <div class="info">
                    <h3><?=$informer[0]?></h3>
                    <ul>
                        <?php foreach($informer['sub'] as $key => $sub):?>
                        <li><a class="ajax_link" href="?view=informer&informer_id=<?=$key?>"><?=$sub?></a></li>
                        <?php endforeach;?>
                    </ul>
                </div>   <!-- .info  -->
             <?php endforeach;?>               
             
             
       <!--       <div class="info">
                <h3>Доставка:</h3>
                        <ul>
                        	<li><a href="#">Укрпочта</a></li>
                            <li><a href="#">Новая почта</a></li>
                            <li><a href="#">Курьерская служба</a></li>
                            <li><a href="#">Самовывоз</a></li>                                                        
                        </ul>           
             </div>   -->
             <!--    Информеры    кон   -->  
             
             
             
                          <!--    Информеры   нач    -->                  

   <!--           <div class="info">
                <h3>Дополнительная информация:</h3>
                        <ul>
                        	<li><a href="#">Гарантии</a></li>
                            <li><a href="#">Как выбрать зеркальный цифровой фотоаппарат?</a></li>
                            <li><a href="#">Как выбрать любительский цифровой фотоаппарат?</a></li>
                            <li><a href="#">Как выбрать объектив: от сложного к простому и наоборот</a></li>				                            <li><a href="#">Маркировка объективов ведущих производителей</a></li>
                        	<li><a href="#">Ремонт и обслуживание</a></li>
                        	<li><a href="#">Акции и новинки</a></li>
                        </ul>           
             </div>    -->
             <!--    Информеры    кон   -->       
             
             
             
                         
                                         
 
<div class="news">
<h3>Новости:</h3>
    <?php if($news):?>
        <?php foreach($news as $item):?>
            <p>
            	<span><?=$item['data']?></span>
                <a href="?view=news&amp;news_id=<?=$item['news_id']?>"><?=$item['title']?></a>
            </p>                   
        <?php endforeach;?>
        <a href="?view=archive" class="news-archive">Архив новостей</a>  
    <?php else: ?>
        <p>Новостей пока нет.</p>
    <?php endif; ?>
    <!--     <p>
    	<span>24.11.2014</span>
        <a href="#">Новый Canon 500x Pro уже в продаже!</a>
    </p> 

 <a href="#" class="news-archive">Архив новостей</a>
--> 
</div>
             
             
              <div class="bar-contact">                 
                	<h3>Контакты:</h3>
                    <p><strong>Телефон</strong><br />
                    <span>(095) 123-45-78</span></p>
                   	
                    <p><strong>Режим работы:</strong><br />
                    Пн-Пт: 09:00-17:00<br />
                    Сб-Вс: выходные<br /> </p> 
                </div>
                     
                     
            

                
                
          </div>
        </div>