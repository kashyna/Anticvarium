<?php defined ('ISHOP') or die ('Access denied');?>
<?php //print_arr($text_informer)?>
<div class="crumb">
	<a href="<?=PATH?>">Главная</a> &#8594; 
	<?=$text_informer['informer_name']?>&#8594; 
    <span><?=$text_informer['link_name']?></span>
</div>

<div class="content-txt">
    <?php if($text_informer): ?>
        <h1><?=$text_informer['link_name']?></h1>
        <?=$text_informer['text']?>
    <?php else:?> 
        <p>Такой страницы нет.</p>
    <?php endif;?>
</div> <!-- .content-txt -->