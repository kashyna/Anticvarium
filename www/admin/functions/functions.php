<?php defined ('ISHOP') or die ('Access denied');

/*      Очистка входящих данных из админки (фильтрация)      */
function clear_admin($var){
    $var = mysql_real_escape_string($var);
    return $var;
}


/*   Подсвечивание активного пункта меню   */
function active_url($str = 'view=pages'){
   $uri = $_SERVER['QUERY_STRING']; //получаем параметры из адресной строки
    if(!$uri) $uri = "view=pages"; //если параметров нет, то это будет параметр по умолчанию
    $uri = explode("&", $uri); //разбиваем строку по разделителю на массив
    if(preg_match("#page=#", end($uri))) array_pop($uri); //если есть параметр page навигации, то удаляем его
    
    if(in_array($str, $uri)){
        //если в массиве параметров есть строка  - тогда это активный пункт меню
        return "class='nav-activ'";
    }
}
/*   Подсвечивание активного пункта меню   */

/* ===Ресайз картинок=== */
function resize($target, $dest, $wmax, $hmax, $ext){
    /*
    $target - путь к оригинальному файлу
    $dest - путь сохранения обработанного файла
    $wmax - максимальная ширина
    $hmax - максимальная высота
    $ext - расширение файла
    */
    list($w_orig, $h_orig) = getimagesize($target);
    $ratio = $w_orig / $h_orig; // =1 - квадрат, <1 - альбомная, >1 - книжная

    if(($wmax / $hmax) > $ratio){
        $wmax = $hmax * $ratio;
    }else{
        $hmax = $wmax / $ratio;
    }
    
    $img = "";
    // imagecreatefromjpeg | imagecreatefromgif | imagecreatefrompng
    switch($ext){
        case("gif"):
            $img = imagecreatefromgif($target);
            break;
        case("png"):
            $img = imagecreatefrompng($target);
            break;
        default:
            $img = imagecreatefromjpeg($target);    
    }
    $newImg = imagecreatetruecolor($wmax, $hmax); // создаем оболочку для новой картинки
    
    if($ext == "png"){
        imagesavealpha($newImg, true); // сохранение альфа канала
        $transPng = imagecolorallocatealpha($newImg,0,0,0,127); // добавляем прозрачность
        imagefill($newImg, 0, 0, $transPng); // заливка  
    }
    
    imagecopyresampled($newImg, $img, 0, 0, 0, 0, $wmax, $hmax, $w_orig, $h_orig); // копируем и ресайзим изображение
    switch($ext){
        case("gif"):
            imagegif($newImg, $dest);
            break;
        case("png"):
            imagepng($newImg, $dest);
            break;
        default:
            imagejpeg($newImg, $dest);    
    }
    imagedestroy($newImg);
}
/* ===Ресайз картинок=== */



/* ====Каталог - получение массива=== */
function catalog(){
    $query = "SELECT * FROM brands ORDER BY parent_id, brand_name";
    $res = mysql_query($query) or die(mysql_query());
    
    //массив категорий
    $cat = array();
    while($row = mysql_fetch_assoc($res)){
        if(!$row['parent_id']){
            $cat[$row['brand_id']][] = $row['brand_name'];
        }else{
            $cat[$row['parent_id']]['sub'][$row['brand_id']] = $row['brand_name'];
        }
    }
    return $cat;
}
/* ====Каталог - получение массива=== */


   
/*      Страницы меню     */
function pages(){
    $query = "SELECT page_id, title, position FROM page ORDER BY position";
    $res = mysql_query($query) or die(mysql_error());
    
    $pages = array();
    while($row = mysql_fetch_assoc($res)){
        $pages[] = $row; //наполняем массив результатами наешего запроса        
    }
     return $pages;
}


/*        Получение отдельной страницы      */
function get_page($page_id){
    $query = "SELECT * FROM page WHERE page_id = $page_id";
    $res = mysql_query($query) or die(mysql_error());
    
    $page = array();
    $page = mysql_fetch_assoc($res);
    
    return $page;
}   
   
/*        Редактирование страницы       */
function edit_page($page_id){
    //получаем данные из формы
    $title = trim($_POST['title']);
    $keywords = trim($_POST['keywords']);
    $description = trim($_POST['description']);
    $position = (int)$_POST['position'];
    $text = trim($_POST['text']);
    
    //проверяем на пустоту обязательное поле
    if(empty($title)){
        //если поле "название" - пусто
        $_SESSION['edit_page']['res'] = "<div class='error'>Не введено наименование страницы!</div>";
        return false; //для того чтоы редирект отработал на эту же страницу
        
    }else{ //очищаем данные
    $title = clear_admin($title);
    $keywords = clear_admin($_POST['keywords']);
    $description = clear_admin($_POST['description']);
    $text = clear_admin($_POST['text']);  
    
    $query = "UPDATE page SET
                title = '$title',
                position = $position,
                text = '$text'
                    WHERE page_id = $page_id";      
    $res = mysql_query($query) or die(mysql_error());
    
    if(mysql_affected_rows() > 0){
        $_SESSION['answer'] = "<div class='success'>Страница успешно обновлена.</div>";
        return true;
    }else{
        $_SESSION['edit_page']['res'] = "<div class='error'>Произошла ошибка! Либо же Вы ничего не изменили.</div>";
        return false; //для того чтоы редирект отработал на эту же страницу
        }    
    }
}    
 

/*      Добавление страницы         */
function add_page(){
    //получаем данные из формы
    $title = trim($_POST['title']);
    $keywords = trim($_POST['keywords']);
    $description = trim($_POST['description']);
    $position = (int)$_POST['position'];
    $text = trim($_POST['text']);
    
        //проверяем на пустоту обязательное поле
    if(empty($title)){
        //если поле "название" - пусто
        $_SESSION['add_page']['res'] = "<div class='error'>Не введено наименование страницы!</div>";
        //сохраняем уже заполненные поля
        $_SESSION['add_page']['keywords'] = $keywords;
        $_SESSION['add_page']['description'] = $description;
        $_SESSION['add_page']['position'] = $position;
        $_SESSION['add_page']['text'] = $text;
        return false; //для того чтоы редирект отработал на эту же страницу        
    }else{//очищаем данные, чтобы безболезнено попадали в БД ковычки и тд
        $title = clear_admin($title);
        $keywords = clear_admin($_POST['keywords']);
        $description = clear_admin($_POST['description']);
        $text = clear_admin($_POST['text']); 
        
        $query = "INSERT INTO page (title, position, text)
                    VALUES ('$title', $position, '$text')";
        $res = mysql_query($query) or die(mysql_error());
        
        //проверка добавленны ли данные
        if(mysql_affected_rows() > 0){
            $_SESSION['answer'] = "<div class='success'>Страница успешно добавлена.</div>";
            return true;
        }else{
            $_SESSION['add_page']['res'] = "<div class='error'>Ошибка при добавлении страницы!</div>";
            return false; //для того чтоы редирект отработал на эту же страницу
        }  
    }
}   


/*      Удаление страницы       */
function del_page($page_id){
    $query = "DELETE FROM page WHERE page_id = $page_id";
    $res = mysql_query($query) or die(mysql_error());
    
    if(mysql_affected_rows() > 0){
        $_SESSION['answer'] = "<div class='success'>Страница успешно удалена.</div>";
        return true;
    }else{
        $_SESSION['answer'] = "<div class='error'>Ошибка удаления страницы.</div>";
        return false;
    }
} 

/*       Количество новостей       */
function count_news(){
    $query = "SELECT COUNT(news_id) FROM news";
    $res = mysql_query($query) or die(mysql_error());
    
    $count_news = mysql_fetch_row($res);
    return $count_news[0];
}

/*          Архив новостей          */
function get_all_news($start_position, $perpage){
    $query = "SELECT news_id, title, anons, data FROM news ORDER BY data DESC LIMIT $start_position, $perpage";
    $res = mysql_query($query) or die(mysql_error());
    
    $all_news = array();
    while($row = mysql_fetch_assoc($res)){
        $all_news[] = $row;
    }
    return $all_news;
} 

/*      Добавление новости      */
function add_news(){
    //получаем данные из формы
    $title = trim($_POST['title']);
    $keywords = trim($_POST['keywords']);
    $description = trim($_POST['description']);
    $anons = trim($_POST['anons']);
    $text = trim($_POST['text']); 
    
    //проверяем на пустоту обязательное поле
    if(empty($title)){
        //если поле "название" - пусто
        $_SESSION['add_news']['res'] = "<div class='error'>Не введено наименование новости!</div>";
        //сохраняем уже заполненные поля
        $_SESSION['add_news']['keywords'] = $keywords;
        $_SESSION['add_news']['description'] = $description;
        $_SESSION['add_news']['anons'] = $anons;
        $_SESSION['add_news']['text'] = $text;
        return false; //для того чтоы редирект отработал на эту же страницу        
    }else{  //очищаем данные, чтобы безболезнено попадали в БД ковычки и тд
        $title = clear_admin($title);
        $keywords = clear_admin($_POST['keywords']);
        $description = clear_admin($_POST['description']);
        $anons = clear_admin($_POST['anons']); 
        $text = clear_admin($_POST['text']); 
        $data = date("Y-m-d");
        
        $query = "INSERT INTO news (title, data, anons, text)
                    VALUES ('$title', '$data', '$anons', '$text')";
        $res = mysql_query($query) or die(mysql_error());
        
        //проверка добавленны ли данные
        if(mysql_affected_rows() > 0){
            $_SESSION['answer'] = "<div class='success'>Новость успешно добавлена.</div>";
            return true;
        }else{
            $_SESSION['add_news']['res'] = "<div class='error'>Ошибка при добавлении новости!</div>";
            return false; //для того чтоы редирект отработал на эту же страницу
        } 
    }
} 


/*        Получение отдельной новости      */
function get_news($news_id){
    $query = "SELECT * FROM news WHERE news_id = $news_id";
    $res = mysql_query($query) or die(mysql_error());
    
    $news = array();
    $news = mysql_fetch_assoc($res);
    
    return $news;
}


/*        Редактирование новости       */
function edit_news($news_id){
    //получаем данные из формы
    $title = trim($_POST['title']);
    $keywords = trim($_POST['keywords']);
    $description = trim($_POST['description']);
    $date = trim($_POST['date']);
    $anons = trim($_POST['anons']);
    $text = trim($_POST['text']);  
    
    //проверяем на пустоту обязательное поле
    if(empty($title)){
        //если поле "название" - пусто
        $_SESSION['edit_news']['res'] = "<div class='error'>Не введено наименование новости!</div>";
        return false; //для того чтобы редирект отработал на эту же страницу        
    }else{ //очищаем данные
        $title = clear_admin($title);
        $keywords = clear_admin($_POST['keywords']);
        $description = clear_admin($_POST['description']);
        $date = clear_admin($_POST['date']);
        $anons = clear_admin($_POST['anons']); 
        $text = clear_admin($_POST['text']);
        
        $query = "UPDATE news SET
                    title = '$title',
                    data = '$date',
                    anons = '$anons',
                    text = '$text'
                        WHERE news_id = $news_id";      
        $res = mysql_query($query) or die(mysql_error());
        
        if(mysql_affected_rows() > 0){
            $_SESSION['answer'] = "<div class='success'>Новость успешно обновлена.</div>";
            return true;
        }else{
            $_SESSION['edit_news']['res'] = "<div class='error'>Произошла ошибка! Либо же Вы ничего не изменили.</div>";
            return false; //для того чтоы редирект отработал на эту же страницу
        }    
    }
}

/*      Удаление новости       */
function del_news($news_id){
    $query = "DELETE FROM news WHERE news_id = $news_id";
    $res = mysql_query($query) or die(mysql_error());
    
    if(mysql_affected_rows() > 0){
        $_SESSION['answer'] = "<div class='success'>Новость успешно удалена.</div>";
        return true;
    }else{
        $_SESSION['answer'] = "<div class='error'>Ошибка удаления новости.</div>";
        return false;
    }
}

/*		Информеры	- получение массива			*/
function informer(){
	$query = "SELECT * FROM link
				RIGHT JOIN informer ON
					link.parent_informer = informer.informer_id
						ORDER BY informer_position, link_position";
	$res = mysql_query($query) or die(mysql_query());
	$informers = array();
	$name = ''; //флаг имени информера
	while($row = mysql_fetch_assoc($res)){
		if($row['informer_name'] != $name){ //если такого информера в массиве еще нет
		  $informers[$row['informer_id']][] = $row['informer_name']; // добавляем информер в массив
		  $informers[$row['informer_id']]['position'] = $row['informer_position']; //для редактирования и удаления
          $informers[$row['informer_id']]['informer_id'] = $row['informer_id']; //для редактирования и удаления
           
          $name = $row['informer_name']; //значит такой информер в массиве уже есть, и в след раз добавлять его повторно не будем
			}
			if($informers[$row['parent_informer']]) //если у этого информера есть страницы
            $informers[$row['parent_informer']]['sub'][$row['link_id']] = $row['link_name']; //заносим страницы в массив в текущий информер
		}
		return $informers;
	}

/*          Список всех информеров - массив     */
function get_informers(){
    $query = "SELECT * FROM informer";
    $res = mysql_query($query) or die(mysql_error());
    
    $informers = array();
    while($row = mysql_fetch_assoc($res)){
        $informers[] = $row;
    }
    return $informers;
}


/*     Добавление страницы информеров     */
function add_link(){
    //получаем данные из формы
    $link_name = trim($_POST['link_name']);
    $keywords = trim($_POST['keywords']);
    $description = trim($_POST['description']);
    $parent_informer = (int)$_POST['parent_informer'];
    $link_position = (int)$_POST['link_position'];
    $text = trim($_POST['text']);
    
    
    //проверяем на пустоту обязательное поле
    if(empty($link_name)){
        //если поле "название" - пусто
        $_SESSION['add_link']['res'] = "<div class='error'>Не введено наименование страницы!</div>";
        //сохраняем уже заполненные поля
        $_SESSION['add_link']['keywords'] = $keywords;
        $_SESSION['add_link']['description'] = $description;
        $_SESSION['add_link']['parent_informer'] = $parent_informer;
        $_SESSION['add_link']['link_position'] = $link_position;
        $_SESSION['add_link']['text'] = $text;
        return false; //для того чтоы редирект отработал на эту же страницу        
    }else{  //очищаем данные, чтобы безболезнено попадали в БД ковычки и тд
        $link_name = clear_admin($link_name);
        $keywords = clear_admin($_POST['keywords']);
        $description = clear_admin($_POST['description']);
        $text = clear_admin($_POST['text']); 
                
        $query = "INSERT INTO link (link_name, parent_informer, link_position, text)
                    VALUES ('$link_name', $parent_informer, $link_position, '$text')";
        $res = mysql_query($query) or die(mysql_error());
        
        //проверка добавленны ли данные в БД
        if(mysql_affected_rows() > 0){
            $_SESSION['answer'] = "<div class='success'>Страница информера успешно добавлена.</div>";
            return true;
        }else{
            $_SESSION['add_link']['res'] = "<div class='error'>Ошибка при добавлении страницы!</div>";
            return false; //для того чтоы редирект отработал на эту же страницу
        } 
    }
}


/*      Получение данных страницы информера     */
function get_link($link_id){
    $query= "SELECT * FROM link WHERE link_id = $link_id";
    $res = mysql_query($query) or die(mysql_error());
    
    $link = array();
    $link = mysql_fetch_assoc($res);
    
    return $link;
}

/*          Редактирование страницы информера  */
function edit_link($link_id){
    //получаем данные из формы
    $link_name = trim($_POST['link_name']);
    $keywords = trim($_POST['keywords']);
    $description = trim($_POST['description']);
    $parent_informer = (int)$_POST['parent_informer'];
    $link_position = (int)$_POST['link_position'];
    $text = trim($_POST['text']);
    
    //проверяем на пустоту обязательное поле
    if(empty($link_name)){
        //если поле "название" - пусто
        $_SESSION['edit_link']['res'] = "<div class='error'>Не введено наименование страницы!</div>";
        return false; //для того чтоы редирект отработал на эту же страницу        
    }else{  //очищаем данные, чтобы безболезнено попадали в БД ковычки и тд
        $link_name = clear_admin($link_name);
        $keywords = clear_admin($_POST['keywords']);
        $description = clear_admin($_POST['description']);
        $text = clear_admin($_POST['text']); 
        
        $query = "UPDATE link SET
                    link_name = '$link_name',                    
                    parent_informer = $parent_informer,
                    link_position = $link_position,
                    text = '$text'
                        WHERE link_id = $link_id";                         
        $res = mysql_query($query) or die(mysql_error());        
        //проверка добавленны ли данные в БД
        if(mysql_affected_rows() > 0){
            $_SESSION['answer'] = "<div class='success'>Страница информера успешно обновлена.</div>";
            return true;
        }else{
            $_SESSION['edit_link']['res'] = "<div class='error'>Ошибка при обновлении страницы!</div>";
            return false; //для того чтоы редирект отработал на эту же страницу
        } 
    }
}

/*            Удаление страницы информера       */
function del_link($link_id){
    $query = "DELETE FROM link WHERE link_id = $link_id;";
    $res = mysql_query($query) or die(mysql_error());
    
    if(mysql_affected_rows() > 0){
        $_SESSION['answer'] = "<div class='success'>Страница информера успешно удалена.</div>";
    }else{
        $_SESSION['answer'] = "<div class='error'>Ошибка при удалении страницы!</div>";
       // return false; //для того чтоы редирект отработал на эту же страницу
    }
}

/*          Добавление информера            */
function add_informer(){
    //получаем данные из формы
    $informer_name = clear_admin(trim($_POST['informer_name']));
    $informer_position = (int)$_POST['informer_position'];
    
    //проверяем на пустоту поля обязательные к заполнению
    if(empty($informer_name)){
        $_SESSION['add_informer']['res'] = "<div class='error'>Не заполнены обязательные поля!</div>";
        return  false;
    }else{
        $query = "INSERT INTO informer (informer_name, informer_position)
                    VALUES ('$informer_name', $informer_position)";
        $res = mysql_query($query) or die(mysql_error());
        
        //проверка результата запроса
        if(mysql_affected_rows() > 0 ){
           $_SESSION['answer'] = "<div class='success'>Информер успешно добавлен!</div>";
            return true;
        }else{
           $_SESSION['add_informer']['res'] = "<div class='error'>Ошибка при добавлении информера!</div>"; 
            return false;
        }       
    }    
}



/*       Удаление информера       */
function del_informer($informer_id){
    //удаляем страницы информера
    mysql_query("DELETE FROM link WHERE parent_informer = $informer_id");
    
    //удаление информера
    $query = "DELETE FROM informer WHERE informer_id = $informer_id";
    $res = mysql_query($query) or die(mysql_error());
    
    if(mysql_affected_rows() > 0){
        $_SESSION['answer'] = "<div class='success'>Информер успешно удален.</div>";
    }else{
        $_SESSION['answer'] = "<div class='error'>Ошибка при удалении информера!</div>";
    }
}


/*            Получение данных информера         */
function get_informer($informer_id){
    $query = "SELECT * FROM informer WHERE informer_id = $informer_id";
    $res = mysql_query($query) or die(mysql_error());
    
    $informers = array();
    $informers = mysql_fetch_assoc($res);
    return $informers;
}


/*          Редактирование информера            */
function edit_informer($informer_id){
    //получаем данные из формы, заполненные админом
    $informer_name = clear_admin(trim($_POST['informer_name']));
    $informer_position = (int)$_POST['informer_position'];
    
    //проверяем на пустоту поля обязательные к заполнению
    if(empty($informer_name)){
        $_SESSION['edit_informer']['res'] = "<div class='error'>У информера должно быть название!</div>";
        return false;
    }else{
        $query = "UPDATE informer SET
                    informer_name = '$informer_name', 
                    informer_position = $informer_position
                    WHERE informer_id = $informer_id";                    
        $res = mysql_query($query) or die(mysql_error());
        
        //проверка результата запроса
        if(mysql_affected_rows() > 0 ){
           $_SESSION['answer'] = "<div class='success'>Информер успешно обновлен!</div>";
            return true;
        }else{
           $_SESSION['edit_informer']['res'] = "<div class='error'>Ошибка при изменении информера! Либо же Вы ничего не поменяли.</div>"; 
            return false;
        }       
    }
}


/*          Добавление категории        */
function add_brand(){
    $brand_name = clear_admin(trim($_POST['brand_name']));
    $parent_id = (int)$_POST['parent_id'];
    
    if(empty($brand_name)){
        $_SESSION['add_brand']['res'] = "<div class='error'>Не указано наименование категории</div>";
        return false; 
    }else{
        //проверяем нет ли уже такой категории на одном уровне в одном и том же разделе
        $query = "SELECT brand_id FROM brands WHERE brand_name = '$brand_name' AND parent_id = $parent_id";
        $res = mysql_query($query) or die(mysql_error());
        if(mysql_num_rows($res) > 0){ //значит такая категория уже есть
            $_SESSION['add_brand']['res'] = "<div class='error'>Категория с таким названием уже есть</div>";
            return false; 
        }else{
            $query = "INSERT INTO brands (brand_name, parent_id)
                        VALUES ('$brand_name', $parent_id)";
            $res = mysql_query($query) or die(mysql_error());
            
            //проверка результата запроса
            if(mysql_affected_rows() > 0 ){
                $_SESSION['answer'] = "<div class='success'>Категория добавлена!</div>";
                return true;
            }else{
                $_SESSION['add_brand']['res'] = "<div class='error'>Ошибка при добавлении категории! Либо же Вы ничего не поменяли.</div>"; 
                return false;
            }   
        }
    }
}


/*          Редактирование бренда           */
function edit_brand($brand_id){
    $brand_name = clear_admin(trim($_POST['brand_name']));
    $parent_id = (int)$_POST['parent_id'];
    
    if(empty($brand_name)){
        $_SESSION['edit_brand']['res'] = "<div class='error'>Не указано наименование категории</div>";
        return false; 
    }else{
        //проверяем нет ли уже такой категории на одном уровне в одном и том же разделе
        $query = "SELECT brand_id FROM brands WHERE brand_name = '$brand_name' AND parent_id = $parent_id";
        $res = mysql_query($query) or die(mysql_error());
        if(mysql_num_rows($res) > 0){ //значит такая категория уже есть
            $_SESSION['edit_brand']['res'] = "<div class='error'>Категория с таким названием уже есть</div>";
            return false; 
        }else{
            $query = "UPDATE brands SET
                        brand_name = '$brand_name',
                        parent_id = $parent_id
                            WHERE brand_id = $brand_id";
            $res = mysql_query($query) or die(mysql_error());
            
            //проверка результата запроса
            if(mysql_affected_rows() > 0 ){
                $_SESSION['answer'] = "<div class='success'>Категория обновлена!</div>";
                return true;
            }else{
                $_SESSION['edit_brand']['res'] = "<div class='error'>Ошибка при редактировании категории! Либо же Вы ничего не поменяли.</div>"; 
                return false;
            }   
        }
    }    
}

/*      Удаление категории      */
function del_brand($brand_id){
    //считаем количество значений в поле
    $query = "SELECT COUNT(*) FROM brands WHERE parent_id = $brand_id";//проверяем есть ли дочерние категории у этой категории
    $res = mysql_query($query) or die(mysql_error());
    $row = mysql_fetch_row($res);
    
    if($row[0]){
        $_SESSION['answer'] = "<div class='error'>Категория имеет подкатегории, и не может быть удалена. Удалите сначала их.</div>";
    }else{
        mysql_query("DELETE FROM goods WHERE goods_brandid = $brand_id");
        mysql_query("DELETE FROM brands WHERE brand_id = $brand_id");
        $_SESSION['answer'] = "<div class='success'>Категория успешно удалена</div>";        
    }
}


/*========Получение количества товатор для постраничной навигации =========*/
function count_rows($category){
    $query = "(SELECT COUNT(goods_id) as count_rows 
                    FROM goods 
                        WHERE goods_brandid = $category)
                UNION
              (  SELECT COUNT(goods_id) as count_rows  
                    FROM goods 
                        WHERE goods_brandid IN
                    (  SELECT brand_id FROM brands WHERE parent_id = $category
                        ))";
    $res = mysql_query($query) or die(mysql_error());
    
    while($row = mysql_fetch_assoc($res)){
        if($row['count_rows']) $count_rows = $row['count_rows'];
    }
    return $count_rows;
}


/*     Получение названий для хлебных крох     */
function brand_name($category){
    $query= "(SELECT brand_id, brand_name FROM brands 
                WHERE brand_id = (SELECT parent_id FROM brands WHERE brand_id = $category)
                )
                UNION
                    (SELECT brand_id, brand_name FROM brands WHERE brand_id = $category)";//1я часть возвращает id Родителя, 2я - для самостоятельных категорий, у кот нет потомков
    $res = mysql_query($query) or die(mysql_error());
    $brand_name = array();
    while($row = mysql_fetch_assoc($res)){
        $brand_name[] = $row;
    }
    return $brand_name;
}

/*                   Получение массива товаров по категориям                           */
function products($category, $start_position, $perpage){
    $query = "(SELECT goods_id, name, img, anons, price, leader, new, sale, date, visible 
                    FROM goods 
                        WHERE goods_brandid = $category)
                UNION
                (SELECT goods_id, name, img, anons, price, leader, new, sale, date, visible
                    FROM goods 
                        WHERE goods_brandid IN
                    (  
                        SELECT brand_id FROM brands WHERE parent_id = $category
                        )) LIMIT $start_position, $perpage";
                        
    $res = mysql_query($query) or die(mysql_error());
    $products = array();
    while($row=mysql_fetch_assoc($res)){  //пока в переменную роу попадают строки, полученные из бд,
        $products[] = $row;                 //будем заполнять массив
    }
    return $products;
}


/*          Добавление товара           */
function add_product(){
    $name = trim($_POST['name']);
    $price = round(floatval(preg_replace("#,#", ".", $_POST['price'])),2); //заменяем запятую на точку/ floatval - чтобы там были только числа без букв /round - округлит, оставив 2 знака после запятой
    $keywords = trim($_POST['keywords']);
    $description = trim($_POST['description']);
    $goods_brandid = (int)$_POST['category'];
    $anons = trim($_POST['anons']);
    $content = trim($_POST['content']);
    $new = (int)$_POST['new'];
    $leader = (int)$_POST['leader'];
    $sale = (int)$_POST['sale'];
    $visible = (int)$_POST['visible'];
    $date = date("Y-m-d");
    
    if(empty($name)){
        $_SESSION['add_product']['res'] = "<div class='error'>Не введено наименование товара!</div>";
        $_SESSION['add_product']['price'] = $price;
        $_SESSION['add_product']['keywords'] = $keywords;
        $_SESSION['add_product']['description'] = $description;
        $_SESSION['add_product']['anons'] = $anons;
        $_SESSION['add_product']['content'] = $content;
        return false;
    }else{ //очищаем данные
        $name = clear_admin($name);
        $keywords = clear_admin($keywords);
        $description = clear_admin($description);
        $anons = clear_admin($anons);
        $content = clear_admin($content);
        
        $query = "INSERT INTO goods (name, goods_brandid, anons, content, visible, leader, new, sale, price, date)
                    VALUES ('$name', $goods_brandid, '$anons', '$content', '$visible', '$leader', '$new', '$sale', $price, '$date')";
        $res = mysql_query($query) or die(mysql_error());
        
        if(mysql_affected_rows() > 0){ 
            
            //// ЗАГРУЗКА КАРТИНОК ////
            $id = mysql_insert_id(); //id сохраненного товара
            $types = array("image/gif", "image/png", "image/jpeg", "image/pjpeg", "image/x-png"); //массив значений разрешенных к загрузке майнтипов файлов
            
            //проверка загружаемого файла
            if($_FILES['baseimg']['name']){
                $baseimgExt = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES['baseimg']['name'])); //расширение картинки
                $baseimgName = "{$id}.{$baseimgExt}"; //новое имя картинки
                $baseimgTmpName = $_FILES['baseimg']['tmp_name']; //получаем временное имя файлас которым будет загруженна во временную папку
                $baseimgSize = $_FILES['baseimg']['size']; //вес файла
                $baseimgType = $_FILES['baseimg']['type']; //маймтип файла
                $baseimgError = $_FILES['baseimg']['error'];  //если в этом элементе - 0 - все ок, а иначе - ошибка         
            
                $error = ""; //индикатор ошибок
                
                if(!in_array($baseimgType, $types)) $error .= "Допустимые расширения: .gif, .png, .jpeg<br />";
                if($baseimgSize > SIZE) $error .= "Максимальный вес файла - ".(SIZE / 1024)."<br />";
                if($baseimgError) $error .= "Ошибка при загрузке файла. Возможно, файл слишком большой.<br />";
                
                if(!empty($error)) $_SESSION['answer'] = "<div class='error'>Ошибка при загрузке изображения! <br />{$error} </div>";
            
                //если нет ошибок - загружаем картинку
                if(empty($error)){
                    if(@move_uploaded_file($baseimgTmpName, "../userfiles/product_img/tmp/$baseimgName")){ //перемещаем файл
                        resize("../userfiles/product_img/tmp/$baseimgName", "../userfiles/product_img/baseimg/$baseimgName", 120, 485, $baseimgExt);
                        @unlink("../userfiles/product_img/tmp/$baseimgName"); //удаляем картинку из временной папки
                        mysql_query("UPDATE goods SET img = '$baseimgName' WHERE goods_id = $id");
                    }else{
                        $_SESSION['answer'] .= "<div class='error'>Не удалось переместить загруженную картинку. Проверьте права на папки в каталоге ../userfiles/product_img/</div>";
                    }
                }
            }            
            //// ЗАГРУЗКА КАРТИНОК - конец ////
            $_SESSION['answer'] .= "<div class='success'>Товар удачно добавлен!</div>";
            return true;
        }else{
            $_SESSION['add_product']['res'] = "<div class='error'>Ошибка при добавлении!</div>";
            return false;
        }       
    }
}


/*          Получение данных товара    */
function get_product($goods_id){
    $query = "SELECT * FROM goods WHERE goods_id = $goods_id";
    $res = mysql_query($query) or die(mysql_error());
    
    $product = array();
    $product = mysql_fetch_assoc($res);
    return $product;
}




/* ===Удаление картинок=== */
function del_img(){
    //получаем переменные из скрипта из ajax
    $goods_id = (int)$_POST['goods_id'];
    $img = clear_admin($_POST['img']);
    $rel = (int)$_POST['rel'];
    
    if(!$rel){
        // если удаляется базовая картинка
        $query = "UPDATE goods SET img = 'no_image.jpg' WHERE goods_id = $goods_id";
        mysql_query($query);
        if(mysql_affected_rows() > 0){
            return '<input type="file" name="baseimg" />';
        }else{
            return false; 
        }
    }/*else{
        // если удаляется картинка галереи
        $query = "SELECT img_slide FROM goods WHERE goods_id = $goods_id";
        $res = mysql_query($query);
        $row = mysql_fetch_assoc($res);
        // получаем картинки в массив
        $images = explode("|", $row['img_slide']);
        foreach($images as $item){
            // пропускаем удаляемую картинку
            if($item == $img) continue;
            // формируем строку с картинками
            if(!isset($galleryfiles)){
                $galleryfiles = $item;
            }else{
                $galleryfiles .= "|$item";
            }
        }
        mysql_query("UPDATE goods SET img_slide = '$galleryfiles' WHERE goods_id = $goods_id");
        if(mysql_affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }*/
 }       
/* ===Удаление картинок=== */





/*         моя - Удаление картинок       */
/*function del_img($goods_id){
    $goods_id = (int)$_POST['goods_id'];
    $img = clear_admin($_POST['img']);
    $rel = (int)$_POST['rel'];
    
   // if(!$rel){
        //базовое изображение
        $query = "UPDATE goods SET img = 'no_image.jpg' WHERE goods_id = $goods_id";
        mysql_query($query);
   /*     if(mysql_affected_rows() > 0){
            return '<input type="file" name="baseimg" />';
        }else{ return false; }
   /* }else{
        //изображение галереи
    }*/
//}

   
/*   моя - Редактирование товара         */
/*function edit_product($id){
    $name = trim($_POST['name']);
    $price = round(floatval(preg_replace("#,#", ".", $_POST['price'])),2); //заменяем запятую на точку/ floatval - чтобы там были только числа без букв /round - округлит, оставив 2 знака после запятой
    $keywords = trim($_POST['keywords']);
    $description = trim($_POST['description']);
    $goods_brandid = (int)$_POST['category'];
    $anons = trim($_POST['anons']);
    $content = trim($_POST['content']);
    $new = (int)$_POST['new'];
    $leader = (int)$_POST['leader'];
    $sale = (int)$_POST['sale'];
    $visible = (int)$_POST['visible'];
    
    if(empty($name)){
        $_SESSION['edit_product']['res'] = "<div class='error'>Не введено наименование товара!</div>";
        return false;
    }else{ //очищаем данные
        $name = clear_admin($name);
        $keywords = clear_admin($keywords);
        $description = clear_admin($description);
        $anons = clear_admin($anons);
        $content = clear_admin($content);
        
        $query = "UPDATE goods SET
                    name = '$name',
                    keywords = '$keywords',
                    description = '$description',
                    goods_brandid = $goods_brandid,
                    anons = '$anons',
                    content = '$content',
                    leader = $leader,
                    new = $new,
                    sale = $sale,
                    price = $price,
                    visible = $visible
                    WHERE goods_id = $id";
        $res = mysql_query($query) or die(mysql_error());
        
        if(mysql_affected_rows() > 0){ 
            //////////для загрузки картинки
           $types = array("image/gif", "image/png", "image/jpeg", "image/pjpeg", "image/x-png"); //массив значений разрешенных к загрузке майнтипов файлов   
           /*   базовая картинка    */ 
  /*          if($_FILES['baseimg']['name']){
                $baseimgExt = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES['baseimg']['name'])); //расширение картинки
                $baseimgName = "{$id}.{$baseimgExt}"; //новое имя картинки
                $baseimgTmpName = $_FILES['baseimg']['tmp_name']; //получаем временное имя файлас которым будет загруженна во временную папку
                $baseimgSize = $_FILES['baseimg']['size']; //вес файла
                $baseimgType = $_FILES['baseimg']['type']; //майнтип файла
                $baseimgError = $_FILES['baseimg']['error'];  //если в этом элементе - 0 - все ок, а иначе - ошибка         
            
                $error = ""; //индикатор ошибок
                
                if(!in_array($baseimgType, $types)) $error .= "Допустимые расширения: .gif, .png, .jpeg<br />";
                if($baseimgSize > SIZE) $error .= "Максимальный вес файла - ".(SIZE / 1024)."<br />";
                if($baseimgError) $error .= "Ошибка при загрузке файла.<br />";
                
                if(!empty($error)) $_SESSION['answer'] = "<div class='error'>Ошибка при загрузке изображения! <br />{$error} </div>";
            
                //если нет ошибок
                if(empty($error)){
                    if(@move_uploaded_file($baseimgTmpName, "../userfiles/product_img/tmp/$baseimgName")){
                        resize("../userfiles/product_img/tmp/$baseimgName", "../userfiles/product_img/baseimg/$baseimgName", 120, 185, $baseimgExt);
                        @unlink("../userfiles/product_img/tmp/$baseimgName");
                        mysql_query("UPDATE goods SET img = '$baseimgName' WHERE goods_id = $id");
                    }else{
                        $_SESSION['answer'] .= "<div class='success'>Не удалось переместить загруженную картинку. Проверьте права на папки в каталоге ../userfiles/product_img/</div>";
                    }
                }
            }
            /*   базовая картинка    */            
            ////////////////
 /*           $_SESSION['answer'] .= "<div class='success'>Товар удачно обновлен!</div>";
            return true;//чтобы мы попали в категорию данного товара, а не на редактирование этого товара, для редирект
        }      
    }
 }*/
 
 
 
 
 
 
 /* ===Редактирование товара=== */
function edit_product($id){
    $name = trim($_POST['name']);
    $price = round(floatval(preg_replace("#,#", ".", $_POST['price'])),2);
    $keywords = trim($_POST['keywords']);
    $description = trim($_POST['description']);
    $goods_brandid = (int)$_POST['category'];
    $anons = trim($_POST['anons']);
    $content = trim($_POST['content']);
    $new = (int)$_POST['new'];
    $leader = (int)$_POST['leader'];
    $sale = (int)$_POST['sale'];
    $visible = (int)$_POST['visible'];
    
    if(empty($price)){
        $_SESSION['edit_product']['res'] = "<div class='error'>У товара должна быть цена!</div>";
        return false;
    }
    if(empty($name)){
        $_SESSION['edit_product']['res'] = "<div class='error'>У товара должно быть название</div>";
        return false;
    }else{
        $name = clear_admin($name);
        $keywords = clear_admin($keywords);
        $description = clear_admin($description);
        $anons = clear_admin($anons);
        $content = clear_admin($content);
        
        $query = "UPDATE goods SET
                    name = '$name',                    
                    goods_brandid = $goods_brandid,
                    anons = '$anons',
                    content = '$content',
                    leader = '$leader',
                    new = '$new',
                    sale = '$sale',
                    price = $price,
                    visible = '$visible'
                        WHERE goods_id = $id";
        $res = mysql_query($query) or die(mysql_error());
        /* базовая картинка */
        $types = array("image/gif", "image/png", "image/jpeg", "image/pjpeg", "image/x-png"); // массив допустимых расширений
        if($_FILES['baseimg']['name']){
            $baseimgExt = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES['baseimg']['name'])); // расширение картинки
            $baseimgName = "{$id}.{$baseimgExt}"; // новое имя картинки
            $baseimgTmpName = $_FILES['baseimg']['tmp_name']; // временное имя файла
            $baseimgSize = $_FILES['baseimg']['size']; // вес файла
            $baseimgType = $_FILES['baseimg']['type']; // тип файла
            $baseimgError = $_FILES['baseimg']['error']; // 0 - OK, иначе - ошибка
            
            $error = "";
            if(!in_array($baseimgType, $types)) $error .= "Допустимые расширения - .gif, .jpg, .png <br />";
            if($baseimgSize > SIZE) $error .= "Максимальный вес файла - 1 Мб";
            if($baseimgError) $error .= "Ошибка при загрузке файла. Возможно, файл слишком большой";
            
            if(!empty($error)) $_SESSION['answer'] = "<div class='error'>Ошибка при загрузке картинки товара! <br /> {$error}</div>";
            
            // если нет ошибок
            if(empty($error)){
                if(@move_uploaded_file($baseimgTmpName, "../userfiles/product_img/tmp/$baseimgName")){
                    resize("../userfiles/product_img/tmp/$baseimgName", "../userfiles/product_img/baseimg/$baseimgName", 120, 185, $baseimgExt);
                    @unlink("../userfiles/product_img/tmp/$baseimgName");
                    mysql_query("UPDATE goods SET img = '$baseimgName' WHERE goods_id = $id");
                }else{
                    $_SESSION['answer'] .= "<div class='error'>Не удалось переместить загруженную картинку. Проверьте права на папки в каталоге /userfiles/product_img/</div>";
                }
            }
        }
        /* базовая картинка */
        $_SESSION['answer'] .= "<div class='success'>Товар обновлен</div>";
        return true;
    }
}
/* ===Редактирование товара=== */
 
 
/*     Удаление товара     */
function del_product($goods_id){
    $query = "DELETE FROM goods WHERE goods_id = $goods_id;";
    $res = mysql_query($query) or die(mysql_error());
    
    if(mysql_affected_rows() > 0){
        $_SESSION['answer'] = "<div class='success'>Товар успешно удален.</div>";
    }else{
        $_SESSION['answer'] = "<div class='error'>Ошибка при удалении товара!</div>";
    }
}
/*     Удаление товара     */


/*          Получение количества необработанных заказов    */
function count_new_orders(){
    $query = "SELECT COUNT(*) AS count FROM `order` WHERE status = '0'";
    $res = mysql_query($query) or die(mysql_error());
    $row = mysql_fetch_assoc($res);
    return $row['count'];

}

/*      Получение необработанных заказы         */
function orders($status, $start_position, $perpage){
    //function orders($status, $start_position, $perpage){
    $query = "SELECT `order`.order_id, `order`.data, `order`.status, memberships.surname, memberships.name
                FROM `order`
                LEFT JOIN memberships
                    ON memberships.customer_id = `order`.customer_id".$status." 
                    ORDER BY data DESC
                    LIMIT $start_position, $perpage";        
   /* $query = "SELECT `order`.order_id, `order`.data, `order`.status, customers.name
                FROM `order`
                LEFT JOIN customers
                    ON customers.customer_id = `order`.customer_id".$status." 
                    ORDER BY data DESC";*/
                //LIMIT $start_position, $perpage";
                
    $res = mysql_query($query) or die(mysql_error());
    $orders = array();
    while($row = mysql_fetch_assoc($res)){
        $orders[] = $row;
    }
    return $orders;
}

/*          Просмотр заказа         */
function show_order($order_id){
    //order_goods: name, price, quantity
    //order: data, comment
    //customers: name, email, phone, address
    //delivery: name
    
    $query = "SELECT order_goods.name, order_goods.price, order_goods.quantity,
                    `order`.data, `order`.comment, `order`.status,
                    memberships.surname, memberships.name AS customer, memberships.email, memberships.phone, memberships.address,
                    delivery.name AS sposob
                    FROM order_goods
            LEFT JOIN `order`
                ON order_goods.order_id = `order`.order_id
            LEFT JOIN memberships
                ON memberships.customer_id = `order`.customer_id
            LEFT JOIN delivery
                ON delivery.delivery_id = `order`.delivery_id
                    WHERE order_goods.order_id = $order_id";
    $res = mysql_query($query) or die(mysql_error());
    $show_order = array();
    while($row = mysql_fetch_assoc($res)){
        $show_order[] = $row;
    }
    return $show_order;
}

/*    Подтверждение заказа    */
function confirm_order($order_id){
    $query = "UPDATE `order` SET status = '1' WHERE order_id = $order_id";
    $res = mysql_query($query) or die(mysql_error());
    if(mysql_affected_rows() > 0){
        return true;
    }else{
        return false;
    }
}

/*      Удаление заказа         */
function del_order($order_id){
    mysql_query("DELETE FROM `order` WHERE order_id = $order_id");
    mysql_query("DELETE FROM order_goods WHERE order_id = $order_id");
    if(mysql_affected_rows() > 0){
        return true;
    }else{
        return false;
    }
}

/*       Количество заказов для постраничной навигации       */
function count_orders($status){
    $query = "SELECT COUNT(order_id) FROM `order`".$status;
    $res = mysql_query($query) or die(mysql_error());
    
    $count_orders = mysql_fetch_row($res);
    return $count_orders[0];
}

/*       Количество пользователей для постраничной навигации       */
function count_users(){
    $query = "SELECT COUNT(login) FROM users";
    //$query = "SELECT COUNT(login) FROM customers";
    $res = mysql_query($query) or die(mysql_error());
    
    $count_users = mysql_fetch_row($res);
    return $count_users[0];
}


/*          Получение списка пользователей          */
function get_users($start_position, $perpage){
    $query = "SELECT memberships.customer_id, memberships.surname, memberships.name, memberships.email, 
                users.login, user_roles.id_role, roles.name_role
                FROM memberships
                LEFT JOIN users
                    ON memberships.customer_id = users.user_id
                LEFT JOIN user_roles
                    ON memberships.customer_id = user_roles.id_user                   
                LEFT JOIN roles
                    ON user_roles.id_role = roles.id_role
                WHERE login IS NOT NULL LIMIT $start_position, $perpage";
    /*$query = "SELECT customer_id, name, email, login, name_role
                FROM customers
                LEFT JOIN roles
                    ON customers.id_role = roles.id_role
                WHERE login IS NOT NULL LIMIT $start_position, $perpage";*/
    $res = mysql_query($query) or die(mysql_error());
    $users = array();
    while($row = mysql_fetch_assoc($res)){
        $users[] = $row;
    }       
    return $users;
}


/*      Получение ролей         */
function get_roles(){
    $query = "SELECT * FROM roles";
    $res = mysql_query($query);
    $roles = array();
    
    while($row = mysql_fetch_assoc($res)){
        $roles[] = $row;
    }
    return $roles;
}

/*     Добавление пользователя          */

function add_user(){
    $error = ''; //флаг проверки заполненности обязательных полей (пустое)
    
    //получаем значения из полей
    $login = trim($_POST['login']); //trim - удаляет лишние проблемы слева и справа от строки
    $password = trim($_POST['password']);
    $surname = trim($_POST['surname']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $id_role = (int)$_POST['id_role'];
    
    //проверка на пустоту поля
    if (empty($login)) $error .= '<li>Не указан логин!</li>';
    if (empty($password)) $error .= '<li>Не указан пароль!</li>';
    if (empty($surname)) $error .= '<li>Не указана фамилия!</li>';
    if (empty($name)) $error .= '<li>Не указано имя!</li>';
    if (empty($email)) $error .= '<li>Не указан e-mail!</li>';
    if (empty($phone)) $error .= '<li>Не указан телефон!</li>';
    if (empty($address)) $error .= '<li>Не указан адрес!</li>';
    
    //проверка на отсутствие ошибок
    if (empty($error)){ //все поля заполнены
        //проверяем нет ли уже этого опльзователя в БД
        //$query = "SELECT customer_id FROM customers WHERE login = '" .clear($login). "' LIMIT 1";
        $query = "SELECT user_id FROM users WHERE login = '" .clear($login). "' LIMIT 1";
        $res = mysql_query($query) or die(mysql_error());
        $row = mysql_num_rows($res); //если есть строка - значит есть пользователь, если получаем 0 - нет
        if($row){
            
            //если row возвращает истину=1, то такой логин уже есть            
            $_SESSION['add_user']['res'] = "<div class='error'>Пользователь с таким логином уже существует. Введите другой.</div>";
            $_SESSION['add_user']['surname'] = $surname;
            $_SESSION['add_user']['name'] = $name;
            $_SESSION['add_user']['email'] = $email;
            $_SESSION['add_user']['phone'] = $phone;
            $_SESSION['add_user']['address'] = $address;
            $_SESSION['add_user']['password'] = $password;
            return false;
        }else{ 
            
            //если такого пользователя нет, то регистрируем его
            $login = clear($login); //эскейпим данные
            $surname = clear($surname);
            $name = clear($name);
            $email = clear($email);
            $phone = clear($phone);
            $address = clear($address);        
            $pass = md5($password); //шифруем значение пароля. возвращает хэш строки - число шестнадцатиричное 32 символа
            
            $query = "INSERT INTO memberships(surname, name, email, phone, address, date)
                        VALUES ('$surname', '$name', '$email', '$phone', '$address', NOW())";
            //$query = "INSERT INTO customers(name, email, login, password, id_role)
            //            VALUES ('$name', '$email', '$login', '$pass', $id_role)";
            $res = mysql_query($query) or die(mysql_error());
            if (mysql_affected_rows() > 0){ // функция проверяет последний выполненный запрос, появились ли изменения после негохотя бы в одной строке
                                            // и возвращает кол-во рядов, затронутых этим запросом. т.е. если колво > 0, то запрос прошел успешно
                //если запись добавлена
                $id = mysql_insert_id();
                $query2 = "INSERT INTO user_roles(id_user, id_role)
                            VALUES ('$id', '$id_role')"; 
                $res = mysql_query($query2) or die(mysql_error());
                
                    if (mysql_affected_rows() > 0){
                        $query3 = "INSERT INTO users(user_id, login, password)
                            VALUES ('$id', '$login', '$pass')";                
                        $res = mysql_query($query3) or die(mysql_error());
                        
                            if (mysql_affected_rows() < 1){
                                $query5 = "DELETE FROM memberships WHERE customer_id = '$id'";
                                mysql_query($query5) or die(mysql_error());
                                $query5 = "DELETE FROM user_roles WHERE id_user = '$id'";
                                mysql_query($query5) or die(mysql_error());                               
                                
                                $_SESSION['add_user']['res'] = "<div class='error'>Ошибка!</div>";
                                //сохранение уже заполненных полей в сессию, чтобы пользователь повторно не вводил их
                                $_SESSION['add_user']['login'] = $login; //элемент в массиве по названию переменных
                                $_SESSION['add_user']['surname'] = $surname;
                                $_SESSION['add_user']['name'] = $name;
                                $_SESSION['add_user']['email'] = $email;
                                $_SESSION['add_user']['phone'] = $phone;
                                $_SESSION['add_user']['address'] = $address;
                                $_SESSION['add_user']['password'] = $password;
                                return false;                                
                            }                    
                    }else{
                        $query4 = "DELETE FROM memberships WHERE customer_id = '$id'";
                        mysql_query($query4) or die(mysql_error());
                        
                        $_SESSION['add_user']['res'] = "<div class='error'>Ошибка!</div>";
                        //сохранение уже заполненных полей в сессию, чтобы пользователь повторно не вводил их
                        $_SESSION['add_user']['login'] = $login; //элемент в массиве по названию переменных
                        $_SESSION['add_user']['surname'] = $surname;
                        $_SESSION['add_user']['name'] = $name;
                        $_SESSION['add_user']['email'] = $email;
                        $_SESSION['add_user']['phone'] = $phone;
                        $_SESSION['add_user']['address'] = $address;
                        $_SESSION['add_user']['password'] = $password;
                        return false;                        
                    }      
                $_SESSION['answer'] = "<div class='success'>Пользователь добавлен!</div>";
                return true;
            }else{
                $_SESSION['add_user']['res'] = "<div class='error'>Ошибка!</div>";
                //сохранение уже заполненных полей в сессию, чтобы пользователь повторно не вводил их
                $_SESSION['add_user']['login'] = $login; //элемент в массиве по названию переменных
                $_SESSION['add_user']['surname'] = $surname;
                $_SESSION['add_user']['name'] = $name;
                $_SESSION['add_user']['email'] = $email;
                $_SESSION['add_user']['phone'] = $phone;
                $_SESSION['add_user']['address'] = $address;
                $_SESSION['add_user']['password'] = $password;
                return false;            
            }
        }
        
    }else{ //не заполнены обязательные поля
        $_SESSION['add_user']['res'] = "<div class='error'>Не заполнены обязательные поля: <ul> $error </ul></div>";
        //сохранение уже заполненных полей в сессию, чтобы пользователь повторно не вводил их
        $_SESSION['add_user']['login'] = $login; //элемент в массиве по названию переменных
        $_SESSION['add_user']['surname'] = $surname;
        $_SESSION['add_user']['name'] = $name;
        $_SESSION['add_user']['email'] = $email;
        $_SESSION['add_user']['phone'] = $phone;
        $_SESSION['add_user']['address'] = $address;
        $_SESSION['add_user']['password'] = $password;
        return false;
    }
}

/*      Получение данных пользователя     */
function get_user($user_id){    
    $query = "SELECT memberships.surname, memberships.name, memberships.email, memberships.phone, memberships.address, users.login, users.password, user_roles.id_role
                FROM memberships
                LEFT JOIN users
                    ON memberships.customer_id = users.user_id
                LEFT JOIN user_roles
                    ON users.user_id = user_roles.id_user                
                    WHERE memberships.customer_id = $user_id";    
    /*$query = "SELECT name, email, phone, address, login, id_role FROM customers
                WHERE customer_id = $user_id";*/
    $res = mysql_query($query);
    $user = array();
    $user = mysql_fetch_assoc($res);
    return $user;
}


/*      Проверка на уникальность логина email           */
function access_field(){   
   $fields = array('login', 'email');
   $val = trim(mysql_real_escape_string($_POST['val']));
   $field = $_POST['dataField'];
   
   if(!in_array($field, $fields)){
    $res = array('answer' => 'no', 'info' => 'Ошибка!');
        return json_encode($res);
   }
   $login = $_POST['val'];
   
   if($field == 'email' && !empty($val)){
    //проверяем на соответствие формату
        if(!preg_match("#^\w+@\w+\.\w+$#i", $val)){
            $res = array('answer' => 'no', 'info' => 'Введенный e-mail не соответствует формату!');
            return json_encode($res);
        }
   }
   
   //проверяем на уникальность
   $query = "SELECT user_id FROM users WHERE login = '$val'";
   $res = mysql_query($query) or die(mysql_error());
   $query = "SELECT customer_id FROM memberships WHERE email = '$val'";
   $res1 = mysql_query($query) or die(mysql_error());
   
   
   if(mysql_num_rows($res)>0 || mysql_num_rows($res1)>0){
        $res = array('answer' => 'no', 'info' => "Выберите другой $field!");
        return json_encode($res);
   }else{
        $res = array('answer' => 'y');
        return json_encode($res);
   }
}
/*      Проверка на уникальность логина email           */

/*      Редактирование пользователя         */
function edit_user($user_id, $user_login, $user_email){   
    
    $error = ''; //флаг проверки заполненности обязательных полей (пустое)    
    $fields = array('login' => 'Логин', 'email' => 'E-mail');
    
    $admin = $_SESSION['auth']['user_id'];
  /*  $admin_email = "SELECT email FROM memberships WHERE customer_id = '$admin'";
    $res = mysql_query($admin_email) or die(mysql_error());
    $admin_email = $res;
        $admin_login = "SELECT login FROM users WHERE user_id = '$admin'";
    $res = mysql_query($admin_email) or die(mysql_error());
    $admin_login = $res;
    echo $admin_email;*/
    
    //получаем значения из полей
    $login = trim($_POST['login']);
    $pass = trim($_POST['pass']);
    $surname = trim($_POST['surname']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    
    //проверка на пустоту поля
    if (empty($login) && $user_id != $_SESSION['auth']['user_id']) $error .= '<li>Не указан логин!</li>';
    if (!empty($login) && $user_id != $_SESSION['auth']['user_id']){
        //уникальность логина
         $query = "SELECT user_id FROM users WHERE login = '" .clear($login). "' LIMIT 1";
         $res = mysql_query($query) or die(mysql_error());
         $row = mysql_num_rows($res);
         if($row && $user_id != $_SESSION['auth']['user_id'] && $login != $user_login){
              $error .= "<li>Пользователь с таким логином уже существует. Введите другой!</li>";
         }
    }
    if (empty($surname)) $error .= '<li>Не указана фамилия!</li>';
    if (empty($name)) $error .= '<li>Не указано имя!</li>';
    if (empty($email)) $error .= '<li>Не указан e-mail!</li>';
    if (!empty($email)){
            if(!preg_match("#^\w+@\w+\.\w+$#i", $email)){
                $error .= "<li>E-mail не соответствует формату!</li>";
            }elseif(clear($email) != $user_email && $user_id != $_SESSION['auth']['user_id']){
                //уникальность email
                $query = "SELECT customer_id FROM memberships WHERE email = '" .clear($email). "' LIMIT 1";
                $res = mysql_query($query) or die(mysql_error());
                $row = mysql_num_rows($res);
                if($row){
                    $error .= "<li>Пользователь с таким e-mail уже существует. Введите другой.</li>";
                }
            }
            
        }        
    if (empty($phone)) $error .= '<li>Не указан контактный телефон!</li>';
    if (empty($address)) $error .= '<li>Не указан адрес!</li>';      
    
    //проверка на отсутствие ошибок    
    if (empty($error)){
                $login = clear($login);
                $surname = clear($surname); 
                $name = clear($name);
                $email = clear($email);
                $phone = clear($phone);
                $address = clear($address);                        
            
            if (!empty($pass)){
                $pass = md5($pass); //шифруем значение пароля. возвращает хэш строки - число шестнадцатиричное 32 символа                
                $query = "UPDATE users SET password = '$pass' WHERE users.user_id = '$user_id'";
                $res = mysql_query($query) or die(mysql_error());
                if (mysql_affected_rows() > 0) { $row_pass = 1;}else{ $row_pass = 0;} //флаг
            }
            
            //логин
            if ($user_id != $_SESSION['auth']['user_id']){
                $query = "UPDATE users SET login = '$login' WHERE user_id = '$user_id'";
                $res = mysql_query($query) or die(mysql_error());
                if (mysql_affected_rows() > 0) { $row_log = 1;}else{ $row_log = 0;} //фла                
            }
            
            $query = "UPDATE memberships SET surname = '$surname',
                                            name = '$name',
                                            email = '$email',
                                            phone = '$phone',
                                            address = '$address'
                        WHERE customer_id = '$user_id'";  
            $res = mysql_query($query) or die(mysql_error());
            if (mysql_affected_rows() < 1 && $row_pass != 1 && $row_log != 1){ // функция проверяет последний выполненный запрос, появились ли изменения после негохотя бы в одной строке
                                            // и возвращает кол-во рядов, затронутых этим запросом. т.е. если колво > 0, то запрос прошел успешно
                $_SESSION['edit_user']['res'] = "<div class='error'>Ошибка, либо же Вы ничего не изменили.</div>";
                return false;                
            }else{
                //если запись добавлена  
                $_SESSION['answer'] = "<div class='success'>Данные успешно обновлены</div>";
                    if($user_id == $_SESSION['auth']['user_id']){ //если мы изменили свое же имя, чтобы оно обновилось в углу страницы
                        $_SESSION['auth']['admin'] = htmlspecialchars($_POST['name']);
                    }                               
                return true;
            }
    }else{ //не заполнены обязательные поля
        $_SESSION['edit_user']['res'] = "<div class='error'>Ошибка изменения: <ul> $error </ul></div>";
    }    
   
  /*      //echo $user_id;
        foreach($_POST as $key => $val){
            if($key == "x" OR $key == "y") continue; //пропускаем эти элементы кнопки
            if($key == "password"){
                $val = trim($val);
                if(!empty($val)){
                    $val = md5($val);
                }else{
                    continue;
                }
            }else{
                $val = clear($val);
            }           
            $data[$key] = $val; 
        }
        //print_arr($data);
        //разбиваем массив на ключи и значения
        $fields = array_keys($data);
        $values = array_values($data);
       
        for($i = 0; $i < count($fields); $i++){
            $str .= "{$fields[$i]} = '{$values[$i]}',";
        }
        $str = substr($str, 0, -1);//обрезаем последнюю запятую
        
        $query = "UPDATE memberships SET surname = '{$data['surname']}',
                                            name = '{$data['name']}',
                                            email = '{$data['email']}',
                                            phone = '{$data['phone']}',
                                            address = '{$data['address']}'
                    WHERE customer_id = $user_id";        
        //$query = "UPDATE customers SET {$str} WHERE customer_id = $user_id";
        
        $res = mysql_query($query);
       // if(mysql_affected_rows() > 0){            
            
            //$query = "UPDATE users SET login = '{$data['login']}' WHERE users.user_id = '$user_id'";
            //$res = mysql_query($query) or die(mysql_error());
            if ($user_id == $_SESSION['auth']['user_id']){
                $data['id_role'] = "2";
            }
            $query = "UPDATE user_roles SET id_role = '{$data['id_role']}' WHERE user_roles.id_user = '$user_id'";
            $res = mysql_query($query) or die(mysql_error());            
            
            $pass = trim($_POST['password']);
            if (!empty($pass)){                
                $pass = md5($pass);
                //$id = $_SESSION['auth']['customer_id'];
                $query = "UPDATE users SET password = '$pass' WHERE users.user_id = '$user_id'";
                $res = mysql_query($query) or die(mysql_error());
            }            
            
            $_SESSION['answer'] = "<div class='success'>Данные успешно обновлены</div>";
            if($user_id == $_SESSION['auth']['user_id']){ //если мы изменили свое же имя, чтобы оно обновилось в углу страницы
                $_SESSION['auth']['admin'] = htmlspecialchars($_POST['name']);
            }
            return true;
       // }else{
          //  $_SESSION['edit_user']['res'] = "<div class='error'>Ошибка, либо же Вы ничего не изменили.</div>";
          //  return false;
        //}*/
    }
    
/*      Удаление пользователя     */
function del_user($user_id){
    if($user_id == $_SESSION['auth']['user_id']){
        $_SESSION['answer'] = "<div class='error'>Вы не можете удалить свой профиль!</div>";
    }else{
        $query = "DELETE FROM memberships WHERE customer_id = $user_id";
        //$query = "DELETE FROM customers WHERE customer_id = $user_id";
        mysql_query($query) or die(mysql_error());
        if(mysql_affected_rows() > 0){
            $_SESSION['answer'] = "<div class='success'>Пользователь успешно удален</div>";
        }else{
            $_SESSION['answer'] = "<div class='error'>Ошибка удаления.</div>";    
        }
    }
}


/*      Сортировка страниц      */
function sort_pages($post){
	$position = 1;
	foreach($post as $item){
		$res = mysql_query("UPDATE page SET position = $position WHERE page_id = $item");
		if(!$res ||(mysql_affected_rows() == -1)) {
			return FALSE;
		}
		$position++;
	}
	
	$result = mysql_query("SELECT page_id, position FROM page");
	if(!$result) {
		return FALSE;
	}
	$row = array();
	for($i = 0;$i < mysql_num_rows($result);$i++) {
		$row[] = mysql_fetch_assoc($result);
	}	
	return $row;    
}

/* ===Сортировка ссылок=== */
function sort_link($post,$parent) {

	$position = 1;
	foreach($post as $item){
		$res = mysql_query("UPDATE `link` SET `link_position`='{$position}' WHERE `link_id`='{$item}' AND `parent_informer` = '{$parent}'") or die(mysql_error());
		if(!$res ||(mysql_affected_rows() == -1)) {
			return FALSE;
		}
		$position++;
	}
	
	$result = mysql_query("SELECT link_id,link_position FROM link WHERE `parent_informer` = '{$parent}' ORDER BY `link_position`");
	if(!$result) {
		return FALSE;
	}
	$row = array();
	for($i = 0;$i < mysql_num_rows($result);$i++) {
		$row[] = mysql_fetch_assoc($result);
	}
	return $row;
}
/* ===Сортировка ссылок=== */

/*          Сортировка информеров           */
function sort_informers($post){
    $position = 1;
    foreach($post as $item){
        $res = mysql_query("UPDATE `informer` SET `informer_position`='{$position}' WHERE `informer_id`='{$item}' ");
		if(!$res ||(mysql_affected_rows() == -1)) {
			return FALSE;
		}
		$position++;
	}
	return TRUE;
}