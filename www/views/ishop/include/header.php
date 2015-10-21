<?php defined ('ISHOP') or die ('Access denied');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?=TEMPLATE?>style.css" />
<link rel="stylesheet" type="text/css" href="<?=TEMPLATE?>css/cloud-zoom.css" />
<!--<link rel="stylesheet" type="text/css" href="<?=PATH?>admin/templates/style.css" />-->
<!--[if lt IE 9]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>  -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>  

<script type="text/javascript" src="<?=TEMPLATE?>js/cloud-zoom.1.0.2.js"></script>
	<script type="text/javascript" src="<?=TEMPLATE?>js/functions.js"></script>  <!-- для строки поиска -->
	<script type="text/javascript" src="<?=TEMPLATE?>js/jquery-1.7.2.min.js"></script> <!-- для аккордиона категорий -->
    <script type="text/javascript" src="<?=TEMPLATE?>js/jquery-ui-1.8.22.custom.min.js"></script> <!-- для аккордиона категорий -->
	<script type="text/javascript" src="<?=TEMPLATE?>js/jquery.cookie.js"></script><!-- для аккордиона категорий -->
	<script type="text/javascript" src="<?=TEMPLATE?>js/workscripts.js"></script><!-- для аккордиона категорий -->
    <script type="text/javascript">var query = "<?=$_SERVER['QUERY_STRING']?>";</script>
<title><?=TITLE?></title>
</head>

<body>
<div class="main">
<div class="header">

    <div class="head-link">
    <span style="display: inline-block; font-size: 11px; text-align:right;">Мы в соц. сетях:<br /></span>
        <a href="https://www.facebook.com/" title="Facebook" target="_blank"><img src="<?=TEMPLATE?>img/icon-fb.png" /></a>
        <a href="https://www.twitter.com/" title="Twitter" target="_blank"><img src="<?=TEMPLATE?>img/icon-twitter.png" /></a>
        <a href="https://youtube.com/" title="Youtube" target="_blank"><img src="<?=TEMPLATE?>img/icon-yt.png" /></a>
        <a href="https://vk.com/" title="Vk" target="_blank"><img src="<?=TEMPLATE?>img/icon-vk.png" /></a>
    </div>
       
       <div class="head">
       	<div class="logo-head">
           <a href="/"><img class="logo" src="<?=TEMPLATE?>img/logo.png" alt="Интернет магазин фототехники"/> </a>
	       <a href="/"><img class="slogan" src="<?=TEMPLATE?>img/slogan1.png" alt=""/></a>
        </div><!-- .logo-head -->
        <div class="menu">
            <ul>
            <li class="menu-item"><a href="<?=PATH?>">Главная</a></li> 
            <?php if($pages): ?>
                <?php foreach($pages as $item):?>
                <li class="menu-item"><a href="?view=page&amp;page_id=<?=$item['page_id']?>"><?=$item['title']?></a></li>
                <?php endforeach; ?>
            <?php endif; ?>
            </ul>
        </div>

        </div><!-- .head -->
    <div class="head-contact">
		<p><strong>Телефон:</strong><br/><span>+380951234567</span></p>
		<p><strong>Режим работы:</strong><br/> Будние дни: 8:00-17:00 <br/> Сб, Вс - выходные</p>
	</div>
    
    <div class="search-head-div">
	<form method="get">
		<ul class="search-head">
            <input type="hidden"  name="view" value="search" /> <!-- скрытое поле с именем view-->
    		<li><input type="text" name="search" id="quickquery" placeholder="Что вы хотите купить?" />
        		<!--<script type="text/javascript">
        		//<![CDATA[
        		placeholderSetup('quickquery');
        		//]]>
        		</script> -->
    		</li>
    		<li><input id="img" type="image" class="search-btn" src="<?=TEMPLATE?>img/btn-search.png" title="Поиск" /></li>
		</ul>
	</form>
    </div>
    
	</div><!-- .header -->

