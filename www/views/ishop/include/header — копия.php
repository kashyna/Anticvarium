<?php defined ('ISHOP') or die ('Access denied');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?=TEMPLATE?>style.css" />
<link rel="stylesheet" type="text/css" href="<?=PATH?>admin/templates/style.css" />
<!--[if lt IE 9]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>  
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
	<a href="/"><img class="logo" src="<?=TEMPLATE?>img/logo.png" alt="Интернет магазин фототехники"/> </a>
	<img class="slogan" src="<?=TEMPLATE?>img/slogan.png" alt=""/>
	<div class="head-contact">
		<p><strong>Телефон:</strong><br/><span>+380951234567</span></p>
		<p><strong>Режим работы:</strong><br/> Будние дни: 8:00-17:00 <br/> Сб, Вс - выходные</p>
	</div>

	<form method="get">
		<ul class="search-head">
            <input type="hidden"  name="view" value="search" /> <!-- скрытое поле с именем view-->
    		<li> <input type="text" name="search" id="quickquery" placeholder="Что вы хотите купить?" />
        		<script type="text/javascript">
        		//<![CDATA[
        		placeholderSetup('quickquery');
        		//]]>
        		</script>
    		</li>
    		<li><input type="image" class="search-btn"src="<?=TEMPLATE?>img/btn-search.jpg" /></li>
		</ul>
	</form>
	</div>
    <ul class="menu">
  	<li><a href="<?=PATH?>">Главная</a></li> 
        <?php if($pages): ?>
            <?php foreach($pages as $item):?>
            <li><a href="?view=page&amp;page_id=<?=$item['page_id']?>"><?=$item['title']?></a></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
