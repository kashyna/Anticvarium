-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Май 29 2015 г., 23:14
-- Версия сервера: 5.5.25
-- Версия PHP: 5.2.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `ishop1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `brands`
--

CREATE TABLE IF NOT EXISTS `brands` (
  `brand_id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(255) NOT NULL,
  `parent_id` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`brand_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`, `parent_id`) VALUES
(1, 'Canon', 0),
(2, 'Nikon', 0),
(3, 'Fujifilm', 0),
(4, 'Sony', 0),
(5, 'Olympus', 0),
(6, 'Samsung', 0),
(7, 'Ультратонкие', 1),
(8, 'Зеркальные начального уровня', 2),
(9, 'Суперзумы', 1),
(10, 'Зеркальные полнокадровые', 1),
(11, 'Ультратонкие', 4),
(12, 'Зеркальные полнокадровые', 5),
(14, 'Тестовая', 6);

-- --------------------------------------------------------

--
-- Структура таблицы `delivery`
--

CREATE TABLE IF NOT EXISTS `delivery` (
  `delivery_id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `delivery_price` varchar(255) NOT NULL,
  PRIMARY KEY (`delivery_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `delivery`
--

INSERT INTO `delivery` (`delivery_id`, `name`, `delivery_price`) VALUES
(1, 'Укрпочта', 'Бесплатно'),
(2, 'Курьером', '100 грн'),
(3, 'Новая почта', 'Согласно тарифам Новой почты'),
(4, 'Самовывоз', 'Бесплатно'),
(5, 'Другое (по согласованию с менеджером)', '');

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--

CREATE TABLE IF NOT EXISTS `goods` (
  `goods_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL DEFAULT 'no_image.jpg',
  `goods_brandid` tinyint(4) unsigned NOT NULL,
  `anons` text NOT NULL,
  `content` text NOT NULL,
  `visible` enum('0','1') NOT NULL DEFAULT '1',
  `leader` enum('0','1') NOT NULL DEFAULT '0',
  `new` enum('0','1') NOT NULL DEFAULT '0',
  `sale` enum('0','1') NOT NULL DEFAULT '0',
  `price` float NOT NULL,
  `date` date NOT NULL,
  `img_slide` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`goods_id`),
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `name_2` (`name`),
  FULLTEXT KEY `name_3` (`name`),
  FULLTEXT KEY `name_4` (`name`),
  FULLTEXT KEY `ixFullText` (`name`),
  FULLTEXT KEY `name_5` (`name`),
  FULLTEXT KEY `name_6` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`goods_id`, `name`, `quantity`, `keywords`, `description`, `img`, `goods_brandid`, `anons`, `content`, `visible`, `leader`, `new`, `sale`, `price`, `date`, `img_slide`) VALUES
(1, 'NEW Sony Alpha 5100 16-50mm Kit Black', 0, 'ключи', 'Описание', '1.png', 11, '<p>\r\n	Краткое описание товара</p>', '<p>\r\n	Полное описание товара</p>', '1', '0', '1', '0', 12000, '2015-01-25', ''),
(2, 'LEADER Canon EOS 5D Mark III 24-105 kit', 0, 'ключи', 'описание', '2.png', 9, '<p>\r\n	Размер матрицы: 36,0 x 23,9 мм;<br />\r\n	Тип матрицы: КМОП (CMOS);<br />\r\n	Кол-во пикселей, млн.: 22,3;<br />\r\n	Оптический зум: 4x;<br />\r\n	Размер дисплея: 3,2&quot;;<br />\r\n	Съемка видео: FullHD (1920x1080);</p>', '<p>\r\n	Если вы собрались обзавестись хорошим цифровым фотоаппаратом, то советуем вам обратить внимание на новинку от компании Сanon &ndash; функциональную и современную цифровую фотокамеру Canon EOS 5D Mark III 24-105 kit, которая обеспечит вам превосходное качество снимков вне зависимости от условий освещения. Вы сможете снимать качественные фотографии даже после захода солнца, благодаря диапазону чувствительности ISO 100&ndash;25 600 (с возможностью расширения до ISO 102 400).</p>\r\n<p>\r\n	Новинка оснащена 22,3 мегапиксельным CMOS-датчиком изображения и новейшим процессором обработки изображения DIGIC 5+. Автофокусировка представлена 61-точечной системой по широкой зоне. Камера также способна снимать высококачественное видео в формате Full HD со стереозвуком с частотой дискретизации 48 КГц, а стандартный разъем для микрофона 3,5 мм позволит вам использовать микрофоны от другого производителя. С фотокамерой Canon EOS 5D Mark III 24-105 kit* вы сможете начать редактирование фотографий еще в дороге домой &ndash; можно оценивать отснятые изображения по пятибалльной шкале и сравнивать их на дисплее камеры одновременно. Ко всему прочему корпус камеры выполнен из магниевого сплава, который обеспечит нежной и дорогой начинке надежную защиту.</p>', '1', '1', '0', '0', 58999, '2015-01-25', '2_1.png|2_2.png|2_3.png|2_4.png|2_5.png|2_6.png'),
(3, 'SALE Nikon', 0, 'ключи', 'Описание', '3.jpg', 8, '<p>\r\n	лаалла</p>', '<p>\r\n	лалалвдлыал</p>', '1', '0', '0', '1', 25000, '2015-01-25', ''),
(4, 'NEW Canon', 0, 'ключи', 'Описание', '4.jpg', 14, '<p>\r\n	sdf</p>', '<p>\r\n	sdf</p>', '1', '0', '1', '0', 15555, '2015-01-27', ''),
(6, 'Canon EOS 600D Kit 18-55 IS II', 0, 'ключи', 'описание', '6.jpg', 10, '<p>\r\n	Краткое описание товара</p>', '<p>\r\n	Детальное описание</p>', '1', '0', '0', '1', 5000, '2015-01-31', ''),
(7, 'Canon EOS 60D Body', 0, 'ключи', 'описание', '7.jpg', 7, '<p>\r\n	Краткое описание товара</p>', '<p>\r\n	Детальное описание</p>', '1', '0', '1', '1', 20445, '2015-01-31', ''),
(8, 'Canon EOS 600D 18-55 IS II', 0, 'ключи', 'описание', '8.jpg', 9, '<p>\r\n	Краткое описание товара</p>', '<p>\r\n	Детальное описание</p>', '1', '1', '1', '0', 46587, '2015-01-31', ''),
(9, 'Canon EOS 1200D 18-55 DC III Kit', 0, 'ключи', 'описание', 'no_image.jpg', 10, '<p>\r\n	Краткое описание товара</p>', '<p>\r\n	Детальное описание</p>', '1', '0', '0', '1', 12457, '2015-01-31', ''),
(10, 'Canon EOS 700D 18-55mm STM', 0, 'ключи', 'описание', '10.png', 10, '<p>\r\n	Краткое описание товара</p>', '<p>\r\n	Детальное описание</p>', '1', '1', '1', '1', 9442, '2015-01-31', ''),
(11, 'Canon 8', 0, 'ключи', 'описание', '11.jpg', 9, '<p>\r\n	Краткое описание товара</p>', '<p>\r\n	Детальное описание</p>', '1', '1', '1', '1', 36547, '2015-01-31', ''),
(12, 'Canon 9', 0, 'ключи', 'описание', '12.jpg', 7, '<p>\r\n	Краткое описание товара</p>', '<p>\r\n	Детальное описание</p>', '1', '0', '1', '0', 45720, '2015-01-30', ''),
(13, 'Canon EOS 1100D 18-55 IS II kit', 0, 'ключи', 'описание', '13.png', 7, '<p>\r\n	Краткое описание товара</p>', '<p>\r\n	Детальное описание</p>', '1', '1', '0', '0', 66547, '2015-01-31', ''),
(14, 'Canon EOS 1100D 18-55 IS II kit', 0, 'ключи', 'описание', '14.png', 9, '<p>\r\n	Краткое описание товара</p>', '<p>\r\n	Детальное описание</p>', '1', '1', '1', '0', 25780, '2015-01-31', ''),
(15, 'Canon EOS 70D (W) Body', 0, 'ключи', 'описание', '15.jpg', 10, '<p>\r\n	Краткое описание товара</p>', '<p>\r\n	Детальное описание</p>', '1', '1', '0', '0', 85999, '2015-01-31', ''),
(16, 'Canon EOS 6D Body', 0, 'ключи', 'описание', '16.jpg', 10, '<p>\r\n	Краткое описание товара</p>', '<p>\r\n	Детальное описание</p>', '1', '0', '1', '1', 45000, '2015-01-31', ''),
(17, 'Canon EOS 6D (WG) 24-105 kit', 0, 'ключи', 'описание', '17.jpg', 7, '<p>\r\n	Краткое описание товара</p>', '<p>\r\n	Детальное описание</p>', '1', '1', '1', '1', 70445, '2015-01-31', ''),
(18, 'Canon 15', 0, 'ключи', 'описание', '18.png', 9, '<p>\r\n	Краткое описание товара</p>', '<p>\r\n	Детальное описание</p>', '1', '1', '1', '0', 96587, '2015-01-31', ''),
(19, 'Canon EOS 600D Kit 18-135 IS', 0, 'ключи', 'описание', '19.png', 10, '<p>\r\n	Краткое описание товара</p>', '<p>\r\n	Детальное описание</p>', '1', '1', '0', '0', 9457, '2015-01-31', ''),
(20, 'Canon EOS 60D 18-135 IS Kit', 0, 'ключи', 'описание', '20.jpg', 10, '<p>\r\n	Краткое описание товара</p>', '<p>\r\n	Детальное описание</p>', '1', '1', '0', '1', 20000, '2015-01-31', ''),
(21, 'Canon EOS 7D Body', 0, 'ключи', 'описание', '21.png', 9, '<p>\r\n	Краткое описание товара</p>', '<p>\r\n	Детальное описание</p>', '1', '1', '1', '0', 22547, '2015-01-31', ''),
(22, 'Canon EOS 650D EF-S 18-55 IS II Kit', 0, 'ключи', 'описание', '22.png', 7, '<p>\r\n	Краткое описание товара</p>', '<p>\r\n	Детальное описание</p>', '1', '0', '0', '1', 77720, '2015-01-30', ''),
(23, 'Canon 20', 0, 'ключи', 'описание', '23.jpg', 7, '<p>\r\n	Краткое описание товара</p>', '<p>\r\n	Детальное описание</p>', '1', '1', '0', '0', 44007, '2015-01-31', ''),
(24, 'Canon 21', 0, 'ключи', 'описание', '24.png', 9, '<p>\r\n	Краткое описание товара</p>', '<p>\r\n	Детальное описание</p>', '1', '1', '1', '0', 25780, '2015-01-31', ''),
(25, 'Canon EOS 5D Mark III 24-105 kit', 0, 'ключи', 'описание', '25.png', 10, '<p>\r\n	Краткое описание товара</p>', '<p>\r\n	Детальное описание</p>', '1', '1', '0', '1', 10999, '2015-01-31', ''),
(39, 'НОВЫЙ ТОВАР2', 0, '', '', '39.jpg', 3, '', '', '1', '0', '0', '1', 12345.2, '2015-04-19', NULL),
(28, 'Новый', 0, 'ключевики', 'описание теста', '28.jpg', 14, '<p>\r\n	Описание краткоеочень описание краткое</p>', '<p>\r\n	Подробное описание</p>', '1', '0', '1', '0', 12345.2, '2015-02-05', NULL),
(29, 'Новый фотоаппарат', 0, 'ключевики', 'описание', '29.jpg', 14, '<p>\r\n	Краткое описание товара:</p>', '<p>\r\n	Подробное описание товара:</p>', '1', '0', '0', '0', 45022, '2015-02-05', NULL),
(38, 'НОВЫЙ ТОВАР', 0, '', '', 'no_image.jpg', 10, '', '', '1', '0', '1', '0', 11120, '2015-04-19', NULL),
(37, 'НОВЫЙ ТОВАР', 0, '', '', '37.jpg', 9, '', '', '1', '0', '1', '0', 12, '2015-04-19', NULL),
(40, 'NAME', 0, '', '', '40.jpg', 3, '', '', '1', '0', '0', '0', 4564640, '2015-04-19', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `informer`
--

CREATE TABLE IF NOT EXISTS `informer` (
  `informer_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `informer_name` varchar(255) NOT NULL,
  `informer_position` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`informer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `informer`
--

INSERT INTO `informer` (`informer_id`, `informer_name`, `informer_position`) VALUES
(1, 'Способы оплаты', 2),
(2, 'Доставка', 1),
(3, 'Дополнительная информация', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `link`
--

CREATE TABLE IF NOT EXISTS `link` (
  `link_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `link_name` varchar(255) NOT NULL,
  `parent_informer` tinyint(3) unsigned NOT NULL,
  `link_position` tinyint(3) unsigned NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Дамп данных таблицы `link`
--

INSERT INTO `link` (`link_id`, `link_name`, `parent_informer`, `link_position`, `keywords`, `description`, `text`) VALUES
(1, 'Наличный расчет', 1, 2, 'ключевики статьи наличный расчет', 'Описание статьи', '<p>\r\n	Текст</p>\r\n'),
(2, 'Безналичный расчет', 1, 3, 'ключевики статьи пластиковой картой', 'Описание статьи', 'Текст'),
(3, 'Платежной картой Visa/MasterCard', 1, 1, 'Ключевики статьи платежной картой', 'Описание статьи', 'Текст'),
(4, 'Укрпочта', 2, 1, 'ключевики', 'Описание статьи', '<p>\r\n	Текст укрпочта</p>\r\n'),
(5, 'Новая почта', 2, 3, 'Ключевики', 'Описание статьи', 'Текст новая почта'),
(6, 'Курьерская служба', 2, 2, 'ключевики', 'описание статьи', 'Текст курьерская служба'),
(7, 'Самовывоз', 2, 4, 'ключевики', 'описание статьи', 'Текст самовывоз'),
(8, 'Гарантии', 3, 1, 'ключевики', 'описание', 'Текст гарантии'),
(9, 'Как выбрать зеркальный цифровой фотоаппарат?', 3, 2, 'ключевики', 'описание', 'текст Как выбрать зеркальный цифровой фотоаппарат?'),
(12, 'Маркировка объективов ведущих производителей', 3, 5, 'ключевики', 'описание', 'текст Маркировка объективов ведущих производителей'),
(13, 'Ремонт и обслуживание', 3, 6, 'ключевики', 'описание', 'Текст Ремонт и обслуживание');

-- --------------------------------------------------------

--
-- Структура таблицы `memberships`
--

CREATE TABLE IF NOT EXISTS `memberships` (
  `customer_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `surname` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `memberships`
--

INSERT INTO `memberships` (`customer_id`, `surname`, `name`, `email`, `phone`, `address`, `date`) VALUES
(1, 'Петров', 'Иван Александрович', '1@gmail.com', '9379992', 'Киев, ул. Ленина 12/454', '2015-05-03'),
(3, 'Карлеоне', 'Вито', '2@gmail.com', '937-99-92', 'Одесса, ул. Журавель 1/32', '2015-05-04'),
(12, 'Зеленая', 'Зелень', '3@gmail.com', '1234678', 'Донецк, ул. Зеленая 1/4', '2015-05-28'),
(13, 'Фамилия', 'Администратор', 'admin@gmail.com', '789456123', 'Киев, ул. Маршала Жукова 45/56', '0000-00-00'),
(14, 'Гриффиндор', 'Годрик', '4@gmail.com', '9898984', 'Киев, ул. Ленина 12/454', '2015-05-29'),
(15, 'Снегг', 'Северус', '5@gmail.com', '1', 'Хогвартс', '2015-05-29');

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `goods_id` int(10) unsigned NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `anons` text NOT NULL,
  `text` text NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`news_id`, `title`, `goods_id`, `keywords`, `description`, `anons`, `text`, `data`) VALUES
(1, 'Новый Canon 500x Pro уже в продаже!', 0, '', '', '<p>Новый Canon 500x Pro уже в продаже!</p>', 'Новый Canon 500x Pro уже в продаже!Новый Canon 500x Pro уже в продаже!Новый Canon 500x Pro уже в продаже!Новый Canon 500x Pro уже в продаже!Новый Canon 500x Pro уже в продаже!Новый Canon 500x Pro уже в продаже!Новый Canon 500x Pro уже в продаже!Новый Canon 500x Pro уже в продаже!', '2014-11-25'),
(2, 'Каждому, кто приобрел акционный объектив Nikon 2000Kit, в подарок чехол!', 0, '', '', '<p>Каждому, кто приобрел акционный объектив Nikon 2000Kit, в подарок чехол!</p>', 'Каждому, кто приобрел акционный объектив Nikon 2000Kit, в подарок чехол!Каждому, кто приобрел акционный объектив Nikon 2000Kit, в подарок чехол!Каждому, кто приобрел акционный объектив Nikon 2000Kit, в подарок чехол!Каждому, кто приобрел акционный объектив Nikon 2000Kit, в подарок чехол!Каждому, кто приобрел акционный объектив Nikon 2000Kit, в подарок чехол!Каждому, кто приобрел акционный объектив Nikon 2000Kit, в подарок чехол!Каждому, кто приобрел акционный объектив Nikon 2000Kit, в подарок чехол!', '2014-12-03'),
(5, 'Новый Nikon', 0, 'Nikon', 'Nikon1', '<p>\r\n	Новый Nikon Скорее приобретайте по выгодной акционной цене!</p>\r\n', '<p>\r\n	Новый Nikon Скорее приобретайте по выгодной акционной цене!Новый Nikon Скорее приобретайте по выгодной акционной цене!Новый Nikon Скорее приобретайте по выгодной акционной цене!</p>\r\n', '2015-02-03');

-- --------------------------------------------------------

--
-- Структура таблицы `news_goods`
--

CREATE TABLE IF NOT EXISTS `news_goods` (
  `id_news` int(10) unsigned NOT NULL,
  `id_goods` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `news_goods`
--

INSERT INTO `news_goods` (`id_news`, `id_goods`) VALUES
(1, 11),
(2, 19),
(5, 11);

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) unsigned NOT NULL,
  `data` datetime NOT NULL,
  `delivery_id` tinyint(3) unsigned NOT NULL,
  `payment_id` tinyint(11) unsigned NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`order_id`, `customer_id`, `data`, `delivery_id`, `payment_id`, `address`, `status`, `comment`) VALUES
(8, 12, '2015-02-06 16:17:48', 5, 1, '', '0', 'После 14:00'),
(11, 13, '2015-02-08 11:38:59', 4, 2, '', '0', ''),
(10, 1, '2015-02-06 17:04:21', 4, 3, '', '1', ''),
(12, 1, '2015-02-18 23:18:30', 2, 1, '', '1', ''),
(13, 3, '2015-04-29 21:04:57', 2, 2, '', '0', ''),
(14, 12, '2015-05-19 23:00:44', 2, 3, '', '0', '');

-- --------------------------------------------------------

--
-- Структура таблицы `order_goods`
--

CREATE TABLE IF NOT EXISTS `order_goods` (
  `order_goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL,
  `goods_id` int(11) unsigned NOT NULL,
  `quantity` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`order_goods_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `order_goods`
--

INSERT INTO `order_goods` (`order_goods_id`, `order_id`, `goods_id`, `quantity`, `name`, `price`) VALUES
(12, 10, 15, 1, 'Canon 12', 85999),
(14, 12, 6, 1, 'Canon EOS 600D Kit 18-55 IS II', 5000),
(15, 13, 8, 2, 'Canon EOS 600D 18-55 IS II', 46587),
(13, 11, 8, 1, 'Canon 5', 46587),
(9, 8, 29, 2, 'Новый фотоаппарат', 45012),
(16, 13, 2, 2, 'Canon EOS 5D Mark III 24-105 kit', 58999),
(17, 14, 6, 1, 'Canon EOS 600D Kit 18-55 IS II', 5000);

-- --------------------------------------------------------

--
-- Структура таблицы `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `page_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `position` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `page`
--

INSERT INTO `page` (`page_id`, `title`, `keywords`, `description`, `position`, `text`) VALUES
(1, 'Доставка и оплата', 'ключевики "Доставка и оплата"', 'Описание "Доставка и оплата"', 1, '<p>\r\n	Некоторый текст</p>\r\n'),
(2, 'Покупка в кредит', 'ключевики "Покупка в кредит"', 'Описание "Покупка в кредит"', 2, '<p>\r\n	Некоторый текст</p>\r\n'),
(3, 'Помощь', '', '', 4, '<p>\r\n	Некоторый текст</p>\r\n'),
(4, 'Контакты', '', '', 3, '<p>Некоторый текст</p>');

-- --------------------------------------------------------

--
-- Структура таблицы `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `payment_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `payment`
--

INSERT INTO `payment` (`payment_id`, `title`) VALUES
(1, 'Наличный расчет'),
(2, 'Безналичный расчет'),
(3, 'Платежной картой Visa/MasterCard');

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id_role` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name_role` varchar(255) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id_role`, `name_role`) VALUES
(1, 'Клиент'),
(2, 'Администратор');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) unsigned NOT NULL,
  `login` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `login`, `password`) VALUES
(1, 'user1', '202cb962ac59075b964b07152d234b70'),
(3, 'user3', '202cb962ac59075b964b07152d234b70'),
(12, 'user', '202cb962ac59075b964b07152d234b70'),
(13, 'admin', '202cb962ac59075b964b07152d234b70'),
(14, 'user2', '202cb962ac59075b964b07152d234b70'),
(15, 'user4', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Структура таблицы `user_roles`
--

CREATE TABLE IF NOT EXISTS `user_roles` (
  `id_user` int(10) unsigned NOT NULL,
  `id_role` int(2) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_roles`
--

INSERT INTO `user_roles` (`id_user`, `id_role`) VALUES
(1, 1),
(3, 1),
(12, 1),
(13, 2),
(14, 1),
(15, 1);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `memberships` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `memberships` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
