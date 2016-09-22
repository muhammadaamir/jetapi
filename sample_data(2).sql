-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 09, 2016 at 10:33 PM
-- Server version: 5.6.31-0ubuntu0.15.10.1
-- PHP Version: 5.6.11-1ubuntu3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sample_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `bf_amazon_products`
--

CREATE TABLE IF NOT EXISTS `bf_amazon_products` (
  `item-name` varchar(255) DEFAULT NULL,
  `item-description` text,
  `listing-id` varchar(20) NOT NULL DEFAULT '',
  `seller-sku` varchar(9) NOT NULL DEFAULT '',
  `price` decimal(5,2) DEFAULT NULL,
  `quantity` int(6) DEFAULT NULL,
  `open-date` varchar(23) DEFAULT NULL,
  `image-url` varchar(10) DEFAULT NULL,
  `item-is-marketplace` varchar(1) DEFAULT NULL,
  `product-id-type` int(1) DEFAULT NULL,
  `zshop-shipping-fee` varchar(10) DEFAULT NULL,
  `item-note` varchar(49) DEFAULT NULL,
  `item-condition` int(2) DEFAULT NULL,
  `zshop-category1` bigint(20) DEFAULT NULL,
  `zshop-browse-path` varchar(10) DEFAULT NULL,
  `zshop-storefront-feature` varchar(10) DEFAULT NULL,
  `asin1` varchar(10) DEFAULT NULL,
  `asin2` varchar(10) DEFAULT NULL,
  `asin3` varchar(10) DEFAULT NULL,
  `will-ship-internationally` int(1) DEFAULT NULL,
  `expedited-shipping` varchar(8) DEFAULT NULL,
  `zshop-boldface` varchar(10) DEFAULT NULL,
  `product-id` varchar(13) DEFAULT NULL,
  `bid-for-featured-placement` varchar(10) DEFAULT NULL,
  `add-delete` varchar(10) DEFAULT NULL,
  `pending-quantity` varchar(1) DEFAULT NULL,
  `fulfillment-channel` varchar(9) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `is_upload` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bf_amazon_products`
--

INSERT INTO `bf_amazon_products` (`item-name`, `item-description`, `listing-id`, `seller-sku`, `price`, `quantity`, `open-date`, `image-url`, `item-is-marketplace`, `product-id-type`, `zshop-shipping-fee`, `item-note`, `item-condition`, `zshop-category1`, `zshop-browse-path`, `zshop-storefront-feature`, `asin1`, `asin2`, `asin3`, `will-ship-internationally`, `expedited-shipping`, `zshop-boldface`, `product-id`, `bid-for-featured-placement`, `add-delete`, `pending-quantity`, `fulfillment-channel`, `user_id`, `is_upload`) VALUES
('JustNile 4-Piece Weave Design Placemat Set - Grass Yellow', 'Make meal time a little more stylish while protecting your table with these easy to clean and durable place mats.', '0102P0SORHX', 'CPLM00001', 13.99, 1, '2015-01-01 21:19:59 PST', '', 'y', 3, '', '', 11, 0, '', '', 'B00I3XU1M8', '', '', 1, '', '', '712392452021', '', '', '', 'AMAZON_NA', 1, 1),
('JustNile 4-Piece Multi-Colored Striped Placemat Set - Blue', 'Make meal time a little more stylish while protecting your table with these easy to clean and durable place mats.', '0102P0SOS09', 'CPLM00016', 13.99, 1, '2015-01-01 21:20:00 PST', '', 'y', 3, '', '', 11, 0, '', '', 'B00I3XU376', '', '', 1, '', '', '712392452175', '', '', '', 'AMAZON_NA', 1, 1),
('JustNile 4-Piece Victorian Pattern Placemat Set - Silver', 'Make meal time a little more stylish while protecting your table with these easy to clean and durable place mats.', '0102P0SOTNF', 'CPLM00004', 13.99, 1, '2015-01-01 21:20:03 PST', '', 'y', 3, '', '', 11, 0, '', '', 'B00I3XU5DS', '', '', 1, '', '', '712392452052', '', '', '', 'AMAZON_NA', 1, 1),
('JustNile 4-Piece Thick Striped Placemat Set - Blue', 'Make meal time a little more stylish while protecting your table with these easy to clean and durable place mats.', '0102P0SOTUX', 'CPLM00019', 13.99, 1, '2015-01-01 21:20:03 PST', '', 'y', 3, '', '', 11, 0, '', '', 'B00I3XU5Z6', '', '', 1, '', '', '712392452205', '', '', '', 'AMAZON_NA', 1, 1),
('JustNile 4-Piece Victorian Pattern Placemat Set - Brown', 'Make meal time a little more stylish while protecting your table with these easy to clean and durable place mats.', '0102P0SOUQL', 'CPLM00006', 13.99, 1, '2015-01-01 21:20:04 PST', '', 'y', 3, '', '', 11, 0, '', '', 'B00I3XU6IC', '', '', 1, '', '', '712392452076', '', '', '', 'AMAZON_NA', 1, 1),
('Green Dub Eco-Friendly Biodegradable Wood Fiber Flower/Plant Pot - 5-inch Ear...', 'Being environmentally conscious isn&apos;t just for spotted owl huggers and granola eaters anymore. Going green has become the trend and Green Dub products help bring the green fad into your home. Made out of a wood fiber composite, Green Dub&apos;s products are recycleable, biodegradable, and have a very natural look, feel and smell. PEFC certified wood flour with German technology is used as raw material. This plant/ flower pot measures 5&quot; and is ideal for small plants, flowers and herbs.', '0102P0VTTHX', 'KPLP00001', 13.99, 1, '2015-01-01 22:39:10 PST', '', 'y', 3, '', '', 11, 0, '', '', 'B00ROSJURK', '', '', 1, '', '', '712392456173', '', '', '', 'AMAZON_NA', 1, 1),
('Green Dub Eco-Friendly Biodegradable Wood Fiber Flower/Plant Pot - 5-inch Kin...', 'Being environmentally conscious isn&apos;t just for spotted owl huggers and granola eaters anymore. Going green has become the trend and Green Dub products help bring the green fad into your home. Made out of a wood fiber composite, Green Dub&apos;s products are recycleable, biodegradable, and have a very natural look, feel and smell. PEFC certified wood flour with German technology is used as raw material. This plant/ flower pot measures 5&quot; and is ideal for small plants, flowers and herbs.', '0102P0VTUK9', 'KPLP00002', 13.99, 1, '2015-01-01 22:39:13 PST', '', 'y', 3, '', '', 11, 0, '', '', 'B00ROSJVTC', '', '', 1, '', '', '712392456180', '', '', '', 'AMAZON_NA', 1, 1),
('JustNile Wooden Replica Sailboat Model - 15" X 9" White w/ Blue Stripes', 'There&apos;s something about a sailboat, maybe the symolizing of freedom, fond memories of the beach or their association with that perfectly pleasant day that adds warmth to any home or office. It comes fully assembled (not a DIY kit) and makes a great gift.', '0102P0W9VPR', 'CSBT00001', 19.99, 1, '2015-01-01 22:53:50 PST', '', 'y', 3, '', '', 11, 0, '', '', 'B00KQ5S8C6', '', '', 1, '', '', '712392456883', '', '', '', 'AMAZON_NA', 1, 1),
('JustNile Wooden Replica Sailboat Model - 12" X 8" Navy Blue Sail', 'There&apos;s something about a sailboat, maybe the symolizing of freedom, fond memories of the beach or their association with that perfectly pleasant day that adds warmth to any home or office. It comes fully assembled (not a DIY kit) and makes a great gift.', '0102P0W9WLF', 'CSBT00002', 15.99, 1, '2015-01-01 22:53:52 PST', '', 'y', 3, '', '', 11, 0, '', '', 'B00KQ5T64A', '', '', 1, '', '', '712392456890', '', '', '', 'AMAZON_NA', 1, 1),
('JustNile 4-Piece Ceramic Party Serving Dish Set with Tray - Dark Wood Tray', 'Any seasoned party thrower knows that the details can really make or break the shindig. Don&apos;t forget to put out candy and mints for people to chow down on and this 4 bowl serving set is perfect for that.', '0102P0XCF7R', 'CSVT00005', 29.99, 1, '2015-01-01 23:21:30 PST', '', 'y', 3, '', '', 11, 0, '', '', 'B00KRR1KGE', '', '', 1, '', '', '712392457392', '', '', '', 'AMAZON_NA', 1, 1),
('JustNile 3-Piece Ceramic Party Serving Dish Set with Tray - Dark Wood Tray', 'Any seasoned party thrower knows that the details can really make or break the shindig. Don&apos;t forget to put out candy and mints for people to chow down on and this 3 bowl serving set is perfect for that.', '0102P0XCH39', 'CSVT00003', 25.99, 1, '2015-01-01 23:21:32 PST', '', 'y', 3, '', '', 11, 0, '', '', 'B00KRQYAYE', '', '', 1, '', '', '712392457378', '', '', '', 'AMAZON_NA', 1, 1),
('JustNile Stainless Steel Party Serveware - 2-Tier Dessert/Fruit Platter', 'This stainless steel serving tray makes a nice addition to any kitchen or can be brought out to accent a party''s d?cor. The top plate is 9" in diameter and the bottom plate is 11". Hand wash only.', '0102P0XSABR', 'CSVT00001', 32.99, 1, '2015-01-01 23:28:44 PST', '', 'y', 3, '', '', 11, 0, '', '', 'B00ROSJURK', '', '', 1, '', '', '712392456760', '', '', '', 'AMAZON_NA', 1, 1),
('JustNile 4-Piece Ceramic Party Serving Dish Set with Tray - White Ceramic Tray', 'Any seasoned party thrower knows that the details can really make or break the shindig. Don&apos;t forget to put out candy and mints for people to chow down on and this 5 - piece serving set is perfect for that.', '0102P0XSCD3', 'CSVT00006', 45.99, 1, '2015-01-01 23:28:46 PST', '', 'y', 3, '', '', 11, 0, '', '', 'B00NGGEJ4I', '', '', 1, '', '', '712392458290', '', '', '', 'AMAZON_NA', 1, 1),
('JustNile 71X71" Modern Shower Curtain - Colorful Scribbled Circles', 'Add a splash of color to any bathroom with this vibrant shower curtain. Measures 71&quot; X 71&quot; and is easy to clean. Easy to snap-on with built-in rings.', '0102P0Z35ZL', 'CSHC00031', 18.99, 1, '2015-01-02 00:05:25 PST', '', 'y', 3, '', '', 11, 0, '', '', 'B00OOJ14HG', '', '', 1, '', '', '712392459167', '', '', '', 'AMAZON_NA', 1, 1),
('Green Dub Eco-Friendly Biodegradable Wood Fiber 2-Pack Soap Dish - Oval Earth...', 'Being environmentally conscious isn&apos;t just for spotted owl huggers and granola eaters anymore. Going green has become the trend and Green Dub products help bring the green fad into your home. Made out of a wood fiber composite, Green Dub&apos;s products are recycleable, biodegradable, and have a very natural look, feel and smell. PEFC certified wood flour with German technology is used as raw material. This soap dish is ideal for the bathtub or shower and on the kitchen or bathroom counter top. It measures 5&quot; X 3.5&quot; and has a drainage hole to keep your bar of soap from becoming a pile of messy ooze.', '0102P1049EL', 'KSDH00001', 12.99, 1, '2015-01-02 00:30:48 PST', '', 'y', 3, '', '', 11, 0, '', '', 'B00KILDIA0', '', '', 1, '', '', '712392456197', '', '', '', 'AMAZON_NA', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bf_amazon_products_meta`
--

CREATE TABLE IF NOT EXISTS `bf_amazon_products_meta` (
  `listing-id` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `product_image` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `dimensions` text CHARACTER SET utf8 COLLATE utf8_bin,
  `brand` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `manufacturer` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `features` text CHARACTER SET utf8 COLLATE utf8_bin,
  `listing_status` tinyint(1) NOT NULL DEFAULT '0',
  `is_archived` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bf_amazon_products_meta`
--

INSERT INTO `bf_amazon_products_meta` (`listing-id`, `product_image`, `dimensions`, `brand`, `manufacturer`, `features`, `listing_status`, `is_archived`) VALUES
('0102P0SORHX', 'http://ecx.images-amazon.com/images/I/51K9TsD0bcL._SL75_.jpg', 'a:2:{s:7:"product";a:4:{s:5:"width";d:11.8100000000000004973799150320701301097869873046875;s:6:"height";d:0.08000000000000000166533453693773481063544750213623046875;s:6:"length";d:17.719999999999998863131622783839702606201171875;s:6:"weight";d:0.179999999999999993338661852249060757458209991455078125;}s:7:"package";a:4:{s:5:"width";d:3.399999999999999911182158029987476766109466552734375;s:6:"height";d:2;s:6:"length";d:12.199999999999999289457264239899814128875732421875;s:6:"weight";d:0.84999999999999997779553950749686919152736663818359375;}}', 'JustNile', 'Shinyi', 'a:5:{i:0;s:35:"Set includes 4 identical place mats";i:1;s:9:"12" X 18"";i:2;s:24:"Made of high quality PVC";i:3;s:24:"Perfect for everyday use";i:4;s:13:"Easy to clean";}', 0, 0),
('0102P0SOS09', 'http://ecx.images-amazon.com/images/I/51nKYuNSqfL._SL75_.jpg', 'a:2:{s:7:"product";a:4:{s:5:"width";d:11.8100000000000004973799150320701301097869873046875;s:6:"height";d:0.08000000000000000166533453693773481063544750213623046875;s:6:"length";d:17.719999999999998863131622783839702606201171875;s:6:"weight";d:0.200000000000000011102230246251565404236316680908203125;}s:7:"package";a:4:{s:5:"width";d:2.100000000000000088817841970012523233890533447265625;s:6:"height";d:1.899999999999999911182158029987476766109466552734375;s:6:"length";d:13.300000000000000710542735760100185871124267578125;s:6:"weight";d:0.8000000000000000444089209850062616169452667236328125;}}', 'JustNile', 'Youpin', 'a:5:{i:0;s:35:"Set includes 4 identical place mats";i:1;s:9:"12" X 18"";i:2;s:24:"Made of high quality PVC";i:3;s:24:"Perfect for everyday use";i:4;s:13:"Easy to clean";}', 0, 0),
('0102P0SOTNF', 'http://ecx.images-amazon.com/images/I/51niVIQXazL._SL75_.jpg', 'a:2:{s:7:"product";a:4:{s:5:"width";d:11.8100000000000004973799150320701301097869873046875;s:6:"height";d:0.08000000000000000166533453693773481063544750213623046875;s:6:"length";d:17.719999999999998863131622783839702606201171875;s:6:"weight";d:0.179999999999999993338661852249060757458209991455078125;}s:7:"package";a:4:{s:5:"width";d:2.29999999999999982236431605997495353221893310546875;s:6:"height";d:2;s:6:"length";d:12.199999999999999289457264239899814128875732421875;s:6:"weight";d:0.6999999999999999555910790149937383830547332763671875;}}', 'JustNile', 'Shinyi', 'a:5:{i:0;s:35:"Set includes 4 identical place mats";i:1;s:9:"12" X 18"";i:2;s:24:"Made of high quality PVC";i:3;s:24:"Perfect for everyday use";i:4;s:13:"Easy to clean";}', 0, 0),
('0102P0SOTUX', 'http://ecx.images-amazon.com/images/I/51H8ywmQapL._SL75_.jpg', 'a:2:{s:7:"product";a:4:{s:5:"width";d:11.8100000000000004973799150320701301097869873046875;s:6:"height";d:0.08000000000000000166533453693773481063544750213623046875;s:6:"length";d:17.719999999999998863131622783839702606201171875;s:6:"weight";d:0.179999999999999993338661852249060757458209991455078125;}s:7:"package";a:4:{s:5:"width";d:1.899999999999999911182158029987476766109466552734375;s:6:"height";d:1.600000000000000088817841970012523233890533447265625;s:6:"length";d:12;s:6:"weight";d:0.75;}}', 'JustNile', 'Youpin', 'a:5:{i:0;s:35:"Set includes 4 identical place mats";i:1;s:9:"12" X 18"";i:2;s:24:"Made of high quality PVC";i:3;s:24:"Perfect for everyday use";i:4;s:13:"Easy to clean";}', 0, 0),
('0102P0SOUQL', 'http://ecx.images-amazon.com/images/I/61LTWv8SClL._SL75_.jpg', 'a:2:{s:7:"product";a:4:{s:5:"width";d:11.8100000000000004973799150320701301097869873046875;s:6:"height";d:0.08000000000000000166533453693773481063544750213623046875;s:6:"length";d:17.719999999999998863131622783839702606201171875;s:6:"weight";d:0.179999999999999993338661852249060757458209991455078125;}s:7:"package";a:4:{s:5:"width";d:1.899999999999999911182158029987476766109466552734375;s:6:"height";d:1.6999999999999999555910790149937383830547332763671875;s:6:"length";d:11.9000000000000003552713678800500929355621337890625;s:6:"weight";d:0.75;}}', 'JustNile', 'Shinyi', 'a:5:{i:0;s:35:"Set includes 4 identical place mats";i:1;s:9:"12" X 18"";i:2;s:24:"Made of high quality PVC";i:3;s:24:"Perfect for everyday use";i:4;s:13:"Easy to clean";}', 0, 0),
('0102P0VTTHX', 'http://ecx.images-amazon.com/images/I/417xOXDYjVL._SL75_.jpg', 'a:2:{s:7:"product";a:4:{s:5:"width";d:6.69000000000000039079850466805510222911834716796875;s:6:"height";d:5.5099999999999997868371792719699442386627197265625;s:6:"length";d:6.69000000000000039079850466805510222911834716796875;s:6:"weight";d:0.64000000000000001332267629550187848508358001708984375;}s:7:"package";a:4:{s:5:"width";d:6.69000000000000039079850466805510222911834716796875;s:6:"height";d:6.0999999999999996447286321199499070644378662109375;s:6:"length";d:6.69000000000000039079850466805510222911834716796875;s:6:"weight";d:0.64000000000000001332267629550187848508358001708984375;}}', 'Green Dub', 'APOLLO INDUSTRIAL CO., LTD', 'a:5:{i:0;s:43:"5" pot, perfect for cuttlings and seedlings";i:1;s:97:"Made of natural wood fiber and polypropylene composite that is 100% recycleable and biodegradable";i:2;s:99:"Contains at least 30% wood fiber and no harmful chemical additives. Non-toxic and safe for all use.";i:3;s:46:"Includes bottom tray to collect water and soil";i:4;s:26:"Stackable for easy storage";}', 0, 0),
('0102P0VTUK9', 'http://ecx.images-amazon.com/images/I/41IpgN9mWLL._SL75_.jpg', 'a:2:{s:7:"product";a:4:{s:5:"width";d:6.69000000000000039079850466805510222911834716796875;s:6:"height";d:5.5099999999999997868371792719699442386627197265625;s:6:"length";d:6.69000000000000039079850466805510222911834716796875;s:6:"weight";d:0.64000000000000001332267629550187848508358001708984375;}s:7:"package";a:4:{s:5:"width";d:6.69000000000000039079850466805510222911834716796875;s:6:"height";d:6.0999999999999996447286321199499070644378662109375;s:6:"length";d:6.69000000000000039079850466805510222911834716796875;s:6:"weight";d:0.64000000000000001332267629550187848508358001708984375;}}', 'Green Dub', 'APOLLO INDUSTRIAL CO., LTD', 'a:5:{i:0;s:43:"5" pot, perfect for cuttlings and seedlings";i:1;s:97:"Made of natural wood fiber and polypropylene composite that is 100% recycleable and biodegradable";i:2;s:99:"Contains at least 30% wood fiber and no harmful chemical additives. Non-toxic and safe for all use.";i:3;s:46:"Includes bottom tray to collect water and soil";i:4;s:26:"Stackable for easy storage";}', 0, 0),
('0102P0W9VPR', 'http://ecx.images-amazon.com/images/I/41MCMku58fL._SL75_.jpg', 'a:2:{s:7:"product";a:4:{s:5:"width";d:8.660000000000000142108547152020037174224853515625;s:6:"height";d:1.5700000000000000621724893790087662637233734130859375;s:6:"length";d:14.7599999999999997868371792719699442386627197265625;s:6:"weight";d:0.309999999999999997779553950749686919152736663818359375;}s:7:"package";a:4:{s:5:"width";d:8;s:6:"height";d:2.25;s:6:"length";d:12.5;s:6:"weight";d:0.40000000000000002220446049250313080847263336181640625;}}', 'Snnei', 'Snnei', 'a:4:{i:0;s:43:"Fully assembled, handcrafted sailboat model";i:1;s:29:"Measures 15" high and 9" long";i:2;s:16:"Made out of wood";i:3;s:18:"Makes a great gift";}', 0, 0),
('0102P0W9WLF', 'http://ecx.images-amazon.com/images/I/41TXJ2Y9DhL._SL75_.jpg', 'a:2:{s:7:"product";a:4:{s:5:"width";d:7.87000000000000010658141036401502788066864013671875;s:6:"height";d:2.7599999999999997868371792719699442386627197265625;s:6:"length";d:12.4000000000000003552713678800500929355621337890625;s:6:"weight";d:0.34999999999999997779553950749686919152736663818359375;}s:7:"package";a:4:{s:5:"width";d:9;s:6:"height";d:2.5;s:6:"length";d:16;s:6:"weight";d:0.34999999999999997779553950749686919152736663818359375;}}', 'JustNile', 'Snnei', 'a:4:{i:0;s:43:"Fully assembled, handcrafted sailboat model";i:1;s:29:"Measures 12" high and 8" long";i:2;s:16:"Made out of wood";i:3;s:18:"Makes a great gift";}', 0, 0),
('0102P0XCF7R', 'http://ecx.images-amazon.com/images/I/31L9M1hciCL._SL75_.jpg', 'a:2:{s:7:"product";a:4:{s:5:"width";d:8.07000000000000028421709430404007434844970703125;s:6:"height";d:1.9699999999999999733546474089962430298328399658203125;s:6:"length";d:8.660000000000000142108547152020037174224853515625;s:6:"weight";d:2.310000000000000053290705182007513940334320068359375;}s:7:"package";a:4:{s:5:"width";d:8.9000000000000003552713678800500929355621337890625;s:6:"height";d:3;s:6:"length";d:9.199999999999999289457264239899814128875732421875;s:6:"weight";d:2.5;}}', 'Woliwowa', 'Woliwowa', 'a:5:{i:0;s:64:"5-piece party serving set with 4 small dishes and one large tray";i:1;s:48:"Each bowl is 3.5" X 3.5" and the tray is 9" X 8"";i:2;s:42:"The bowls are ceramic and the tray is wood";i:3;s:35:"Perfect for parties or everyday use";i:4;s:12:"Easy to wash";}', 0, 0),
('0102P0XCH39', 'http://ecx.images-amazon.com/images/I/31Kjg0aHthL._SL75_.jpg', 'a:2:{s:7:"product";a:4:{s:5:"width";d:4.3300000000000000710542735760100185871124267578125;s:6:"height";d:1.9699999999999999733546474089962430298328399658203125;s:6:"length";d:12.9900000000000002131628207280300557613372802734375;s:6:"weight";d:1.8300000000000000710542735760100185871124267578125;}s:7:"package";a:4:{s:5:"width";d:5.5;s:6:"height";d:2.79999999999999982236431605997495353221893310546875;s:6:"length";d:13.5;s:6:"weight";d:1.9499999999999999555910790149937383830547332763671875;}}', 'Woliwowa', 'Woliwowa', 'a:5:{i:0;s:64:"4-piece party serving set with 3 small dishes and one large tray";i:1;s:49:"Each bowl is 3.5" X 3.5" and the tray is 13" long";i:2;s:42:"The bowls are ceramic and the tray is wood";i:3;s:35:"Perfect for parties or everyday use";i:4;s:12:"Easy to wash";}', 0, 0),
('0102P0XSABR', 'http://ecx.images-amazon.com/images/I/41zo5qUUj3L._SL75_.jpg', 'a:2:{s:7:"product";a:4:{s:5:"width";d:10.6300000000000007815970093361102044582366943359375;s:6:"height";d:9.449999999999999289457264239899814128875732421875;s:6:"length";d:10.6300000000000007815970093361102044582366943359375;s:6:"weight";d:2.0099999999999997868371792719699442386627197265625;}s:7:"package";a:4:{s:5:"width";d:10.800000000000000710542735760100185871124267578125;s:6:"height";d:1;s:6:"length";d:10.9000000000000003552713678800500929355621337890625;s:6:"weight";d:2.29999999999999982236431605997495353221893310546875;}}', 'V.Bars', 'V.Bars', 'a:5:{i:0;s:28:"Elegant 2-tier serving plate";i:1;s:39:"Top plate is 9" and bottom plate is 11"";i:2;s:23:"Made of stainless steel";i:3;s:35:"Can be taken apart for easy storage";i:4;s:14:"Hand wash only";}', 0, 0),
('0102P0XSCD3', 'http://ecx.images-amazon.com/images/I/31%2BsLx6E7dL._SL75_.jpg', 'a:2:{s:7:"product";a:4:{s:5:"width";d:10.2400000000000002131628207280300557613372802734375;s:6:"height";d:2.7599999999999997868371792719699442386627197265625;s:6:"length";d:10.2400000000000002131628207280300557613372802734375;s:6:"weight";d:3.75;}s:7:"package";a:4:{s:5:"width";d:10.5999999999999996447286321199499070644378662109375;s:6:"height";d:3.20000000000000017763568394002504646778106689453125;s:6:"length";d:10.9000000000000003552713678800500929355621337890625;s:6:"weight";d:4.0999999999999996447286321199499070644378662109375;}}', 'YHome', 'QingXiTaoCi', 'a:5:{i:0;s:64:"5-piece party serving set with 4 small dishes and one large tray";i:1;s:59:"Each small dish is 4" X 4" and the large plate is 10" X 10"";i:2;s:15:"Made of Ceramic";i:3;s:36:"Perfect for parties and everyday use";i:4;s:12:"Easy to wash";}', 0, 0),
('0102P0Z35ZL', 'http://ecx.images-amazon.com/images/I/41A9rxPnNnL._SL75_.jpg', 'a:2:{s:7:"product";a:4:{s:5:"width";d:70.8700000000000045474735088646411895751953125;s:6:"height";d:0.200000000000000011102230246251565404236316680908203125;s:6:"length";d:70.8700000000000045474735088646411895751953125;s:6:"weight";d:0;}s:7:"package";a:4:{s:5:"width";d:6.5999999999999996447286321199499070644378662109375;s:6:"height";d:2;s:6:"length";d:11;s:6:"weight";d:0.0200000000000000004163336342344337026588618755340576171875;}}', 'JustNile', 'Aspire', 'a:5:{i:0;s:62:"Add some color to shower time with this vibrant shower curtain";i:1;s:32:"Made with high-quality polyester";i:2;s:47:"Includes built-in rings, snap-on to hang easily";i:3;s:33:"Fade-resistant & easy to maintain";i:4;s:18:"Measures 71" X 71"";}', 0, 0),
('0102P1049EL', 'http://ecx.images-amazon.com/images/I/41bhZGLr1hL._SL75_.jpg', 'a:2:{s:7:"product";a:4:{s:5:"width";d:3.54000000000000003552713678800500929355621337890625;s:6:"height";d:0.58999999999999996891375531049561686813831329345703125;s:6:"length";d:5.12000000000000010658141036401502788066864013671875;s:6:"weight";d:0.13000000000000000444089209850062616169452667236328125;}s:7:"package";a:4:{s:5:"width";d:3.600000000000000088817841970012523233890533447265625;s:6:"height";d:1;s:6:"length";d:5.70000000000000017763568394002504646778106689453125;s:6:"weight";d:0.450000000000000011102230246251565404236316680908203125;}}', 'Green Dub', 'APOLLO INDUSTRIAL CO., LTD', 'a:5:{i:0;s:83:"Comes in set of 2 (5" X 3.5" each), perfect for the shower and countertop sink-side";i:1;s:97:"Made of natural wood fiber and polypropylene composite that is 100% recycleable and biodegradable";i:2;s:99:"Contains at least 30% wood fiber and no harmful chemical additives. Non-toxic and safe for all use.";i:3;s:50:"Prevents bars of soap from becoming soggy and soft";i:4;s:13:"Easy to clean";}', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bf_files`
--

CREATE TABLE IF NOT EXISTS `bf_files` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bf_files`
--

INSERT INTO `bf_files` (`id`, `name`, `created_on`) VALUES
(30, '08d3b900399b4101afc74a065f5f0984', '2016-09-08 07:43:11'),
(31, 'b365955f8a754ee8acf52fecf01b31dc', '2016-09-08 07:46:54'),
(32, '72245662b41d4c878b09ed95ed7e8a7c', '2016-09-08 12:59:30'),
(33, 'c4a3049f8d66419fbcb7005ddf1693dd', '2016-09-08 13:01:53'),
(34, '2d1e52b87afc4b26bd94892eceeb6b14', '2016-09-08 13:03:07'),
(35, '6ecd9e5d38cc49cda75a1d48937eee5f', '2016-09-08 13:04:53'),
(36, '50ba84d8c7dc450abd935e7d6579cf3f', '2016-09-08 13:14:15'),
(37, 'd69b8e36df134e28a3976084b43631c6', '2016-09-08 13:28:37'),
(38, '7822b4648ef04e7986f967a3c62dbcbe', '2016-09-08 13:36:33'),
(39, 'bd39d491d3fb45daac3a6d819775ffd1', '2016-09-09 06:38:21'),
(40, '5c6da424257f41cc9d71020115f4e21e', '2016-09-09 06:49:29'),
(41, 'f4df6be53b564bdba670d533b00c5a9e', '2016-09-09 06:53:46'),
(42, 'b5e791b67f38437d9f214778d8b91a9b', '2016-09-09 07:01:59'),
(43, '9c3950f4c6294a1c84f6d7f3a5802618', '2016-09-09 12:16:12'),
(44, '7d909d1acc704644bce67afed896942d', '2016-09-09 12:19:32'),
(45, '0fac32e67cbb48bf9b50dae43e8010f1', '2016-09-09 12:21:58'),
(46, 'cc4a1d13b9514ffaa3ee51151dca9c69', '2016-09-09 12:28:42'),
(47, '2eff34e74f5c4896b0890e905067a7a9', '2016-09-09 12:43:27'),
(48, '267f35dac59c429791a439d374ea187e', '2016-09-09 12:53:37'),
(49, '1709bc9918c14f8bb39bc108643cd9ba', '2016-09-09 13:00:20'),
(50, '2cc6e17168534e27852ba46489c1e86f', '2016-09-09 13:01:21'),
(51, '33425d232cf54aedbf69b19ee74ab3aa', '2016-09-09 17:12:24');

-- --------------------------------------------------------

--
-- Table structure for table `jet_texonomy`
--

CREATE TABLE IF NOT EXISTS `jet_texonomy` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `scope` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `precedence` int(11) NOT NULL,
  `free_text` int(11) NOT NULL,
  `display` int(11) NOT NULL,
  `facet_filter` int(11) NOT NULL,
  `variant` int(11) NOT NULL,
  `range` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `variant_pair` int(11) NOT NULL,
  `merchant_defined` int(11) NOT NULL,
  `retired` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jet_texonomy`
--

INSERT INTO `jet_texonomy` (`id`, `description`, `display_name`, `scope`, `status`, `precedence`, `free_text`, `display`, `facet_filter`, `variant`, `range`, `parent_id`, `variant_pair`, `merchant_defined`, `retired`) VALUES
(0, 'description', 'display_name', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(1, 'Country of Origin', 'Country of Origin', 1, 1, 102, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(3, 'old_Baby Kid Clothing Size', 'Size', 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 0),
(4, 'Material Type', 'Material', 1, 1, 8, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(5, 'Import Designation', 'Import Designation', 1, 1, 100, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(8, 'Product Form', 'Form', 1, 1, 100, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(9, 'ESRB Ratings', 'ESRB Ratings', 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0),
(11, 'Towel Size', 'Type of Towel', 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 0),
(12, 'Sheet Type', 'Bedding Product Type', 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 0),
(13, 'Pillow Size', 'Pillow Size', 1, 1, 4, 0, 0, 1, 1, 0, 0, 0, 1, 0),
(14, 'Light Source Type', 'Light Source', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(15, 'Decor Style', 'Style', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(16, 'Instrument Size', 'Instrument Size', 1, 1, 0, 0, 0, 0, 1, 0, 0, 0, 1, 0),
(17, 'Fixture Finish Type', 'Finish', 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 0),
(18, 'Game Genre', 'Genre', 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0),
(19, 'Book Format', 'Format', 1, 1, 3, 0, 0, 0, 1, 0, 0, 0, 1, 0),
(20, 'Music Format', 'Music Format', 1, 1, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0),
(21, 'Software Format', 'Format', 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 0),
(27, 'Microwave Type', 'Microwave Type', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(28, 'Baby Carrier Type', 'Carrier Type', 1, 1, 2, 0, 0, 1, 1, 0, 0, 0, 1, 0),
(29, 'Breast Pump Type', 'Breast Pump Type', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(30, 'Language', 'Language', 1, 1, 5, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(31, 'Age Range', 'Age Range', 1, 1, 1, 0, 1, 0, 0, 0, 0, 0, 1, 0),
(32, 'Age Group', 'Age Group', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(33, 'Target Audience', 'Target Audience', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(34, 'Gender', 'Gender', 1, 1, 21, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(35, 'Battery Type', 'Battery Type', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(36, 'Health & Beauty Item Form', 'Form', 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0),
(37, 'Health & Beauty Specialty', 'Shop by Feature', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(38, 'Fill Material', 'Fill Material', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(39, 'Media Storage Capacity', 'Storage Capacity', 1, 1, 985, 1, 0, 0, 1, 0, 0, 0, 1, 0),
(41, 'Device Compatibility', 'Device Compatibility', 1, 1, 2, 0, 0, 1, 1, 0, 0, 0, 1, 0),
(44, 'Power Source', 'Power Source', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(45, 'Width', 'Width', 1, 1, 0, 1, 0, 0, 1, 0, 0, 0, 1, 0),
(46, 'Weight or Volume', 'Size', 1, 1, 9, 2, 0, 0, 1, 0, 0, 0, 1, 0),
(47, 'Film Speed', 'Film Speed', 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 0),
(48, 'Film Color', 'Film Color', 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 0),
(51, 'Mirror Style', 'Mirror Style', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(52, 'Drinking Glass Type', 'Glass Type', 1, 1, 2, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(53, 'Camera Lens Type', 'Lens Type', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(54, 'Optical Zoom', 'Optical Zoom', 1, 1, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0),
(55, 'Clock Type', 'Clock Type', 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0),
(56, 'Mattress Type', 'Mattress Type', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(57, 'Knitting Needle Size', 'Knitting Needle Size', 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 0),
(58, 'Crochet Hook Size', 'Crochet Hook Size', 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 0),
(59, 'TV  and Laptop Screen Size', 'Screen Size', 1, 1, 1, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(60, 'Paper Size', 'Paper Size', 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 0),
(63, 'Baby Stage', 'Stage', 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 0),
(64, 'Formula Type', 'Formula Type', 1, 1, 2, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(65, 'Wattage', 'Wattage', 1, 1, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0),
(66, 'Home Theater System Channels', 'Channels', 1, 1, 0, 1, 0, 1, 0, 0, 0, 0, 1, 0),
(67, 'Watts Per Channel', 'Watts Per Channel', 1, 1, 0, 2, 1, 0, 0, 0, 0, 0, 1, 0),
(68, 'Tuner Type', 'Tuner Type', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(69, 'Refrigerator Style', 'Refrigerator Style', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(70, 'Appliance Capacity', 'Capacity', 1, 1, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0),
(72, 'Coverage Unit of Measure', 'Coverage', 1, 1, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0),
(73, 'Fan Type', 'Fan Type', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(74, 'Range Installation Type', 'Range Installation Type', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(75, 'Yarn Fiber', 'Yarn Fiber', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(79, 'Bra Size', 'Bra Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(80, 'Shoe Width', 'Shoe Width', 1, 1, 3, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(81, 'Old Diaper Size', 'Diapers Size', 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(82, 'old_Kids Clothing Size', 'Kids Clothing Size', 1, 1, 0, 0, 0, 0, 1, 0, 0, 0, 1, 0),
(83, 'Kids Shoe Sizes', 'Kids Shoe Sizes', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(84, 'Alpha Women''s Regular Size', 'Women''s Regular Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(85, 'old_Men''s General Regular Size', 'Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(86, 'Men''s Pant Size', 'Men''s Pant Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(87, 'Men''s Dress Shirt Size', 'Men''s Dress Shirt Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(88, 'Product Material', 'Material', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(89, 'Pet Life Stage', 'Life Stage', 1, 1, 90, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(90, 'Sheet Material', 'Material', 1, 1, 2, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(91, 'Bag Style', 'Bag Style', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(93, 'Stone', 'Stone', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(94, 'Hair Color', 'Hair Color', 1, 1, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0),
(95, 'Count Size', 'Count', 1, 1, 0, 2, 1, 0, 1, 0, 0, 0, 1, 0),
(96, '# of Players', '# of Players', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(97, 'Women''s Shoe Size', 'Women''s Shoe Size', 1, 1, 1, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(98, 'Men''s Shoe Size', 'Men''s Shoe Size', 1, 1, 2, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(99, 'Appliance Color Map', 'Appliance Color', 1, 1, 3, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(100, 'Furniture Material', 'Material', 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0),
(101, 'Bird Type', 'Bird Type', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(102, 'Small Animal Type', 'Small Animal Type', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(104, 'Pet Food Special Diet', 'Special Diet', 1, 1, 67, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(105, 'Special Sizes', 'Special Sizes', 1, 1, 90, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(106, 'Kids Shoe Width', 'Kids Shoe Width', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(107, 'Video Format', 'Video Format', 1, 1, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0),
(108, 'MPAA Rating', 'MPAA Rating', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(109, 'Subtitle Language', 'Subtitle Language', 1, 1, 0, 0, 1, 1, 1, 0, 0, 0, 1, 0),
(111, 'Adult Product', 'Adult Product', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(112, 'Movie & TV Genre', 'Genre', 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0),
(113, 'Suit or Sport Coat Size', 'Suit Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(114, 'Generic Size- free text with units', 'Size', 1, 1, 0, 2, 0, 0, 0, 0, 0, 0, 1, 0),
(115, 'Dog Size', 'Dog Size', 1, 1, 99, 2, 0, 0, 0, 0, 0, 0, 1, 0),
(116, 'Generic Sizes (S,M, L, etc)', 'Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(117, 'Flavor', 'Flavor', 1, 1, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0),
(118, 'Fragrance', 'Fragrance', 1, 1, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0),
(119, 'Color', 'Color', 1, 1, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0),
(121, 'Finish', 'Finish', 1, 1, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0),
(122, 'Appliance Color', 'Appliance Color', 1, 1, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0),
(123, 'Length', 'Length', 1, 1, 0, 2, 1, 0, 1, 0, 0, 0, 1, 0),
(124, 'Height', 'Height', 1, 1, 0, 2, 1, 0, 1, 0, 0, 0, 1, 0),
(125, 'Diaper Size', 'Diaper Size', 1, 1, 2, 1, 1, 0, 1, 0, 0, 0, 1, 0),
(126, 'BTU', 'BTUs', 1, 1, 0, 2, 1, 0, 0, 0, 0, 0, 1, 0),
(127, 'Threadcount', 'Threadcount', 1, 1, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0),
(128, 'Megapixels', 'Megapixels', 1, 1, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0),
(129, 'Furniture Finish', 'Furniture Finish', 1, 1, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0),
(130, 'Monitor Type', 'Monitor Type', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(131, 'Service Plan', 'Service Plan', 1, 1, 0, 1, 0, 1, 0, 0, 0, 0, 1, 0),
(132, 'Warranty Plan', 'Warranty Plan', 1, 1, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0),
(133, 'Alpha Women''s General Maternity Size', 'Women''s General Maternity Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(134, 'GPS Feature', 'GPS Feature', 1, 1, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0),
(136, 'Hand Tool Type', 'Hand Tool Type', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(137, 'Power Tool Type', 'Power Tool Type', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(138, 'Hardware Finish Type', 'Hardware Finish Type', 1, 1, 0, 0, 1, 1, 1, 0, 0, 0, 1, 0),
(139, 'Door Entry Side', 'Door Entry Side', 1, 1, 0, 0, 1, 1, 1, 0, 0, 0, 1, 0),
(140, 'Ring Size', 'Ring Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(141, 'Platform', 'Gaming Platform', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(142, 'Bike Wheel Size', 'Bike Wheel Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(143, 'Lens Color', 'Lens Color', 1, 1, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0),
(144, 'Airsoft Gun & Rifle Velocity', 'Airsoft Gun & Rifle Velocity', 1, 1, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0),
(145, 'Baseball Type', 'Baseball Type', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(146, 'Bat Size', 'Bat Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(150, 'Softball Type', 'Softball Type', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(151, 'Team', 'Team', 1, 1, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0),
(152, 'Dimensional Size- built from Length X Width X Height', 'Product Dimensions', 1, 1, 5, 1, 1, 0, 0, 0, 0, 0, 1, 0),
(153, 'Diameter', 'Diameter', 1, 1, 97, 2, 1, 0, 1, 0, 0, 0, 1, 0),
(157, 'Hand Orientation', 'Hand Orientation', 1, 1, 0, 0, 0, 0, 1, 0, 0, 0, 1, 0),
(160, 'Rug Size', 'Rug Size', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(161, 'Rug Material', 'Rug Material', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(163, 'Cookware Material', 'Cookware Material', 1, 1, 2, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(164, 'Contract Type', 'Contract Type', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(165, 'Cell Phone Carrier', 'Carrier', 1, 1, 2, 0, 1, 1, 1, 0, 0, 0, 1, 0),
(166, 'Phone Operating System', 'Phone Operating System', 1, 1, 105, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(167, 'TV Refresh Rate', 'Refresh Rate', 1, 1, 5, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(169, 'Decor Material', 'Material', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(171, 'Make', 'Make', 1, 1, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0),
(172, 'Model', 'Model', 1, 1, 8, 1, 1, 0, 1, 0, 0, 0, 1, 0),
(173, 'Year - Display, Free Text', 'Year', 1, 1, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0),
(174, 'Camera Filter Diameter', 'Camera Filter Diameter', 1, 1, 0, 2, 1, 0, 0, 0, 0, 0, 1, 0),
(177, 'Sleeping Bag Temperature Rating', 'Sleeping Bag Temperature Rating', 1, 1, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0),
(178, 'Brightness', 'Brightness', 1, 1, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0),
(179, 'Tent Capacity', 'Tent Capacity', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(181, 'Wireless Standard', 'Wireless Standard', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(182, 'Transmission Speed', 'Transmission Speed', 1, 1, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0),
(183, 'Processor Speed', 'Processor Speed', 1, 1, 5, 2, 1, 0, 0, 0, 0, 0, 1, 0),
(197, 'Purifier Type', 'Purifier Type', 1, 1, 0, 1, 0, 1, 0, 0, 0, 0, 1, 0),
(209, 'DNU', 'DNU', 1, 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0),
(219, 'Hard Drive Size (OLD)', 'Hard Drive Size', 1, 1, 993, 2, 1, 0, 1, 0, 0, 0, 1, 0),
(225, '# of Pieces', '# of Pieces', 1, 1, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0),
(248, 'Frame Color', 'Frame Color', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(264, 'Numeric Women''s Petite Size', 'Women''s Petite Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(266, 'Dishwasher Installation Type', 'Installation Type', 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 1, 0),
(268, 'Activity', 'Activity', 1, 1, 0, 0, 0, 0, 1, 0, 0, 0, 1, 0),
(269, 'Art Style', 'Art Style', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(270, 'Award Winners', 'Award Winners', 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(271, 'Watch Band Material', 'Watch Band Material', 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0),
(273, 'Kids'' Shoe Size - length only', 'Kids'' Shoe Size', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(275, 'old_Men Size', 'Men Size', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(276, 'old_Kid Size', 'Kid Size', 1, 1, 0, 0, 1, 1, 1, 0, 0, 0, 1, 0),
(282, 'Certifications', 'Certifications', 1, 1, 988, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(283, 'Connector Type', 'Connector Type', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(285, 'Designer', 'Designer', 1, 1, 0, 1, 0, 1, 0, 0, 0, 0, 1, 0),
(286, 'Dietary Needs', 'Dietary Needs', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(287, 'Grade Level', 'Grade Level', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(288, 'Grit Size', 'Grit Size', 1, 1, 0, 0, 1, 1, 1, 0, 0, 0, 1, 0),
(290, 'Hubcap Size', 'Hubcap Size', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(291, 'Inseam', 'Inseam', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(292, 'League', 'League', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(293, 'Lens Mount Compatibility', 'Lens Mount Compatibility', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(295, 'Men''s Regular Waist Size', 'Men''s Waist Size', 1, 1, 5, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(296, 'TV Model Year Facet Filter', 'TV Model Year', 1, 1, 104, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(297, 'Needle Type', 'Needle Type', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(298, 'Occasion', 'Occasion', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(299, 'OEM/Compatible', 'OEM/Compatible', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(300, 'Pattern', 'Pattern', 1, 1, 4, 0, 0, 1, 1, 0, 0, 0, 1, 0),
(301, 'Platform Support', 'Platform Support', 1, 1, 2, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(303, 'RAM Technology', 'RAM Technology', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(306, 'Rim Size', 'Rim Size', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(307, 'Stroller Seating Capacity', 'Seating Capacity', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(308, 'Shoe Style', 'Shoe Style', 1, 1, 4, 0, 1, 0, 0, 0, 0, 0, 1, 0),
(310, 'Skin Type', 'Skin Type', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(311, 'Theme', 'Theme', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(312, 'US States & Regions', 'US States & Regions', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(313, 'Vacuum Cleaner Features', 'Vacuum Cleaner Features', 1, 1, 2, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(314, 'Vehicle Type', 'Vehicle Type', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(317, 'Year - Facet Filter, Value', 'Year', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(2147483647, 'magnification strength', 'Magnification Strength', 1, 1, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'lens width', 'Lens Width', 1, 1, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Optical Drive Type', 'Optical Drive Type', 1, 1, 13, 0, 1, 0, 0, 0, 0, 0, 1, 0),
(2147483647, 'Appliance Max Power Consumption', 'Appliance Max Power Consumption', 1, 1, 0, 2, 1, 0, 0, 0, 0, 0, 1, 0),
(2147483647, 'Alpha Women''s General Size', 'Women''s Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Alpha Women''s General Petite Size', 'Women''s General Petite Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Alpha Women''s General Plus Size', 'Women''s General Plus Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Numeric Women''s Petite Waist Size', 'Women''s Petite Waist Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Alpha Women''s General Tall Size', 'Women''s General Tall Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Numeric Big & Tall Suit Size', 'Big & Tall Suit Size', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(2147483647, 'Alpha Baby Generic Sizes', 'Baby Sizes', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Alpha Big Boy Generic Size', 'Big Boy Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Numeric Big Boy Size', 'Big Boy Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Boys Slim Size', 'Boys Slim Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Boys Husky Size', 'Boys Husky Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Alpha Little Girl Generic Size', 'Little Girl Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Numeric Little Girl Size', 'Little Girl Size', 1, 1, 1, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Alpha Big Girl Generic Size', 'Big Girl Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Numeric Big Girl Size', 'Big Girl Size', 1, 1, 2, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Girls Slim Size', 'Girls Slim Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Girls Plus Size', 'Girls Plus Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Numeric Boys Slim Size', 'Boys Slim Size', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(2147483647, 'Numeric Boys Husky Size', 'Boys Husky Size', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(2147483647, 'Little Girl Generic Size', 'Little Girl Size', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(2147483647, 'Big Girl Generic Size', 'Big Girl Size', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(2147483647, 'Numeric Big Girl Size', 'Big Girl Size', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(2147483647, 'Numeric Girls Slim Size', 'Girls Slim Size', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(2147483647, 'Numeric Girls Plus Size', 'Girls Plus Size', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(2147483647, 'Numeric Toddler Shoe Size', 'Toddler Shoe Size', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(2147483647, 'Numeric Little Kids Shoe Size', 'Little Kids Shoe Size', 1, 1, 3, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(2147483647, 'Numeric Big Kids Shoe Size', 'Big Kids Shoe Size', 1, 1, 4, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(2147483647, 'Men''s General Regular Size', 'Men''s General Regular Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Alpha Little Boy Generic Size', 'Little Boy Generic Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Alpha General Big & Tall Size', 'General Big & Tall Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Numeric Little Boy Size', 'Little Boy Size', 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Instrument Style', 'Style', 1, 1, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Diaper Product Type', 'Diaper Type', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 1, 0),
(2147483647, 'TV Display Type', 'TV Display', 1, 1, 3, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'TV Resolution', 'Resolution', 1, 1, 2, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'TV Model Year', 'Model Year', 1, 1, 8, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'TV Features', 'Features', 1, 1, 4, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'TV Inputs/Outputs', 'Inputs/Outputs', 1, 1, 6, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'TV Supported Internet', 'Supported Internet', 1, 1, 108, 0, 1, 0, 1, 0, 0, 0, 1, 0),
(2147483647, 'Age Use_Display', 'Age Use', 1, 1, 6, 1, 1, 0, 0, 0, 0, 0, 1, 0),
(2147483647, 'Food storage bag FF closure type', 'Closure Type', 1, 1, 1, 0, 1, 1, 0, 0, 0, 0, 1, 0),
(2147483647, 'Food storage bags FF material', 'Material', 1, 1, 5, 0, 0, 1, 0, 0, 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE IF NOT EXISTS `order_detail` (
  `id` int(11) NOT NULL,
  `alt_order_id` varchar(255) NOT NULL,
  `buyer_name` varchar(255) NOT NULL,
  `buyer_phone_number` varchar(255) NOT NULL,
  `customer_reference_order_id` varchar(255) NOT NULL,
  `fulfillment_node` varchar(255) NOT NULL,
  `has_shipments` tinyint(1) NOT NULL,
  `hash_email` varchar(255) NOT NULL,
  `jet_request_directed_cancel` tinyint(1) NOT NULL,
  `merchant_order_id` varchar(255) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `order_detail_request_shipping_method` varchar(255) NOT NULL,
  `order_detail_request_shipping_carrier` varchar(255) NOT NULL,
  `order_detail_request_service_level` varchar(255) NOT NULL,
  `order_detail_request_ship_by` varchar(255) NOT NULL,
  `order_detail_request_delivery_by` varchar(255) NOT NULL,
  `order_placed_date` varchar(255) NOT NULL,
  `order_totals_item_price_item_tax` varchar(255) DEFAULT NULL,
  `order_totals_item_price_item_shipping_cost` float NOT NULL,
  `order_totals_item_price_item_shipping_tax` varchar(255) DEFAULT NULL,
  `order_totals_item_price_base_price` float NOT NULL,
  `order_transmission_date` varchar(255) NOT NULL,
  `reference_order_id` varchar(255) NOT NULL,
  `shipping_to_recipient_name` varchar(255) NOT NULL,
  `shipping_to_recipient_phone_number` varchar(255) NOT NULL,
  `shipping_to_address_address1` varchar(255) NOT NULL,
  `shipping_to_address_address2` varchar(255) NOT NULL,
  `shipping_to_address_city` varchar(255) NOT NULL,
  `shipping_to_address_state` varchar(255) NOT NULL,
  `shipping_to_address_zip_code` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE IF NOT EXISTS `order_item` (
  `id` int(11) NOT NULL,
  `order_item_id` varchar(255) NOT NULL,
  `merchant_sku` varchar(255) NOT NULL,
  `request_order_quantity` int(11) NOT NULL,
  `request_order_cancel_qty` int(11) NOT NULL,
  `item_tax_code` varchar(255) NOT NULL,
  `item_tax` varchar(255) DEFAULT NULL,
  `item_shipping_cost` float NOT NULL,
  `item_shipping_tax` varchar(255) DEFAULT NULL,
  `base_price` float NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bf_amazon_products`
--
ALTER TABLE `bf_amazon_products`
  ADD PRIMARY KEY (`listing-id`);

--
-- Indexes for table `bf_amazon_products_meta`
--
ALTER TABLE `bf_amazon_products_meta`
  ADD PRIMARY KEY (`listing-id`);

--
-- Indexes for table `bf_files`
--
ALTER TABLE `bf_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bf_files`
--
ALTER TABLE `bf_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=76;
--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
