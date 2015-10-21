<?php require_once 'include/header.php' ?>
<!--	<div id="contentwrapper">
		<div id="content">
        <?php //require_once $view. '.php' ?>
		</div>
	</div>

		<?php //require_once 'include/leftbar.php' ?>

		<?php //require_once 'include/rightbar.php' ?>
	   <div class="clr"></div>	
		<?php //require_once 'include/footer.php' ?>  -->


    <div id="contentwrapper">   
    <?php  if (($view != 'card') && ($view != 'cabinet') && ($view != 'user_edit') && ($view != 'user_order')): ?> 
    	<div id="content">        
        <?php  require_once $view. '.php'; ?>
        </div>
    <?php else: include $view. '.php'; ?>
    <?php endif; ?>
    </div>
    
    <?php  if (($view != 'card') && ($view != 'cabinet') && ($view != 'user_edit') && ($view != 'user_order')): ?>
    <?php  require_once 'include/leftbar.php'?>
        
    <?php  require_once 'include/rightbar.php'?>
    <?php  endif; ?>    
       <div class="clr"> </div>
       
    <?php require_once 'include/footer.php'?>
     </div>

</div>
</body>
</html>
