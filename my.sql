-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-01-16 09:14:07
-- 服务器版本： 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my`
--

-- --------------------------------------------------------

--
-- 表的结构 `area`
--

CREATE TABLE `area` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='地区表';

--
-- 转存表中的数据 `area`
--

INSERT INTO `area` (`id`, `pid`, `name`) VALUES
(1, 0, '台灣'),
(2, 1, '台北市');

-- --------------------------------------------------------

--
-- 表的结构 `goods`
--

CREATE TABLE `goods` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '商品名',
  `price` int(11) NOT NULL DEFAULT '0' COMMENT '价格',
  `discount` float NOT NULL DEFAULT '0' COMMENT '折扣',
  `web` varchar(50) NOT NULL COMMENT '网站',
  `tmp` varchar(30) NOT NULL COMMENT '使用的模板',
  `pay` varchar(30) NOT NULL COMMENT '支付方式',
  `grounding` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0下架1上架',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加日期',
  `px` int(11) NOT NULL COMMENT '像素',
  `content` text COMMENT '详情',
  `img` varchar(255) NOT NULL COMMENT '商品图',
  `sku` varchar(128) NOT NULL,
  `spu` varchar(128) NOT NULL,
  `supplier` varchar(100) NOT NULL COMMENT '供应商',
  `c_web` varchar(120) NOT NULL COMMENT '二级域名',
  `color` varchar(255) NOT NULL COMMENT '颜色与图片json格式',
  `size` varchar(128) NOT NULL COMMENT '尺寸json格式',
  `gift_size` varchar(120) NOT NULL COMMENT 'json赠品尺寸',
  `gift_color` varchar(255) NOT NULL COMMENT 'json赠品颜色与图片'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `goods`
--

INSERT INTO `goods` (`id`, `name`, `price`, `discount`, `web`, `tmp`, `pay`, `grounding`, `addtime`, `px`, `content`, `img`, `sku`, `spu`, `supplier`, `c_web`, `color`, `size`, `gift_size`, `gift_color`) VALUES
(1, '2017新品冬季羽絨棉襖', 2199, 0.5, '', '2', '货到付款', 0, 2017, 22, '<p><img src="/static/upload/image/20171227/1514352800113961.png" title="1514352800113961.png" alt="成功案例化妆品.png"/></p><p><img src="/static/upload/image/20171227/1514353896505795.jpg" title="1514353896505795.jpg"/></p><p><img src="/static/upload/image/20171227/1514353896522922.jpg" title="1514353896522922.jpg"/></p><p><img src="/static/upload/image/20171227/1514353896109644.jpg" title="1514353896109644.jpg"/></p><p><br/></p>', 'http://angeand.com/file/file/d08035346e98adb2.jpg', '124', '', '454', 'my.com', '[{"color":"\\u7ea2\\u8272","img":"\\/static\\/upload\\/image\\/20171227\\\\56e9cf247363061bd096cfa1f2c04981.png"},{"color":"\\u767d\\u8272","img":"http:\\/\\/angeand.com\\/file\\/file\\/a644f8622b8bdc48.jpg"}]', '["m","l","ml"]', '["m","l","ml"]', '[{"color":"red","img":"http:\\/\\/angeand.com\\/file\\/file\\/a644f8622b8bdc48.jpg"},{"color":"\\u767d\\u8272","img":"http:\\/\\/angeand.com\\/file\\/file\\/a644f8622b8bdc48.jpg"}]');

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE `orders` (
  `order_id` mediumint(8) UNSIGNED NOT NULL COMMENT '订单id',
  `order_sn` varchar(20) NOT NULL DEFAULT '' COMMENT '订单编号',
  `order_status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '订单状态',
  `shipping_status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '发货状态',
  `user` varchar(60) NOT NULL DEFAULT '' COMMENT '收货人',
  `area` varchar(11) NOT NULL DEFAULT '' COMMENT '地区',
  `city` varchar(11) NOT NULL COMMENT '市',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `mobile` varchar(60) NOT NULL DEFAULT '' COMMENT '手机',
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT '邮件',
  `pay_name` varchar(120) NOT NULL DEFAULT '' COMMENT '支付方式名称',
  `shipping_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '邮费',
  `total_price` decimal(10,0) DEFAULT '0' COMMENT '订单总价',
  `add_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '下单时间',
  `user_note` varchar(255) NOT NULL DEFAULT '' COMMENT '用户备注',
  `goods_name` varchar(128) NOT NULL COMMENT '商品名',
  `good_id` int(11) NOT NULL COMMENT '商品id',
  `color` varchar(128) NOT NULL COMMENT '颜色',
  `good_num` int(11) NOT NULL COMMENT '数量',
  `good_size` varchar(128) NOT NULL COMMENT '尺寸',
  `gift_id` int(11) NOT NULL COMMENT '赠品id',
  `gift_size` varchar(128) NOT NULL COMMENT '赠品尺寸',
  `gift_color` varchar(128) NOT NULL COMMENT '赠品颜色',
  `gift_num` int(11) NOT NULL COMMENT '赠品数量',
  `sku` varchar(128) NOT NULL,
  `supplier` varchar(128) NOT NULL COMMENT '供应商',
  `c_web` varchar(60) NOT NULL COMMENT '二级域名',
  `ip` varchar(30) DEFAULT NULL,
  `logistics` varchar(50) NOT NULL COMMENT '物流名称',
  `tracking_number` varchar(120) NOT NULL COMMENT '物流单号',
  `money` varchar(30) NOT NULL COMMENT '货币',
  `country_code` varchar(30) NOT NULL COMMENT '国家编号',
  `gift_supplier` varchar(120) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`order_id`, `order_sn`, `order_status`, `shipping_status`, `user`, `area`, `city`, `address`, `mobile`, `email`, `pay_name`, `shipping_price`, `total_price`, `add_time`, `user_note`, `goods_name`, `good_id`, `color`, `good_num`, `good_size`, `gift_id`, `gift_size`, `gift_color`, `gift_num`, `sku`, `supplier`, `c_web`, `ip`, `logistics`, `tracking_number`, `money`, `country_code`, `gift_supplier`) VALUES
(1, '201712221520591279', 0, 0, '历可见', '2', '10055', 's', '01010101', '', '货到付款', '0.00', '2199', 1513927259, '', '2017新品冬季羽絨棉襖', 1, '白色', 1, 'ml', 1, 'ml', '白色', 1, '', '', '', NULL, '', '', '', '', ''),
(2, '201712221732401959', 0, 0, '1235', '2', '10055', 's', '01010101', '', '货到付款', '0.00', '2199', 1513935160, 's', '2017新品冬季羽絨棉襖', 1, '白色', 1, 'l', 1, 'l', '白色', 1, '', '', '', NULL, '', '', '', '', ''),
(3, '201712251511448334', 0, 0, '历可见', '2', '10055', '14534', '01010101', '', '货到付款', '0.00', '2199', 1514185904, '45', '2017新品冬季羽絨棉襖', 1, 'red', 1, 'm', 1, 'm', 'red', 1, '', 'www.baidu.comwww.baidu.comwww.baidu.com', 'www.my.com', NULL, '', '', '', '', ''),
(4, '201712261712472915', 0, 0, '李科坚', '2', '10054', '士大夫撒大哥', '01010101', '', '货到付款', '0.00', '2199', 1514279567, '要两件', '2017新品冬季羽絨棉襖', 1, '白色', 1, 'm', 1, 'm', 'red', 1, '', '', 'www.my.com', NULL, '', '', '', '', ''),
(5, '201712271658171878', 0, 0, 'ww', '2', '10055', 'we', '0101010101', '', '货到付款', '0.00', '2199', 1514365097, '', '222', 33, 'w', 1, 'ml', 33, 'l', 'r', 1, '', '', 'www.my.com', NULL, '', '', '', '', ''),
(6, '201712271720272226', 0, 0, '水電費', '0', '0', '2', '0101010101', '', '货到付款', '0.00', '2199', 1514366427, '', '222', 33, 'red', 1, 'M', 33, 'M', 'r', 1, '', '', 'www.my.com', NULL, '', '', '', '', ''),
(7, '201712271723036613', 0, 0, '水電費', '0', '0', '2', '0101010101', '', '货到付款', '0.00', '2199', 1514366583, '', '222', 33, 'red', 1, 'M', 33, 'M', 'r', 1, '', '', 'www.my.com', NULL, '', '', '', '', ''),
(8, '201712271743027914', 0, 0, '水電費', '0', '0', '2', '0101010101', '', '货到付款', '0.00', '2199', 1514367782, '', '222', 33, 'red', 1, 'M', 33, 'M', 'r', 1, '', '', 'www.my.com', NULL, '', '', '', '', ''),
(9, '201712271743594675', 0, 0, '水電費', '台灣', '台北市', '2', '0101010101', '', '货到付款', '0.00', '2199', 1514367839, '', '222', 33, 'red', 1, 'M', 33, 'M', 'r', 1, '', '', 'www.my.com', NULL, '', '', '', '', ''),
(10, '201712271745457966', 0, 1, '水電費', '台灣', '台北市', '太太太太太', '0101010101', '', '货到付款', '0.00', '2199', 1514367945, '', '222', 33, 'red', 1, 'M', 33, 'M', 'r', 1, '', '', 'www.my.com', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `tmps`
--

CREATE TABLE `tmps` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '销售模式模板名',
  `title` varchar(50) NOT NULL COMMENT '中文名',
  `order_name` varchar(50) NOT NULL COMMENT '下单页面'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='销售模式模板';

--
-- 转存表中的数据 `tmps`
--

INSERT INTO `tmps` (`id`, `name`, `title`, `order_name`) VALUES
(1, 'index', '买一件送一件赠品', 'order'),
(2, 'index2', '两件只要多少', 'order2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_sn` (`order_sn`),
  ADD KEY `add_time` (`add_time`);

--
-- Indexes for table `tmps`
--
ALTER TABLE `tmps`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `area`
--
ALTER TABLE `area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- 使用表AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '订单id', AUTO_INCREMENT=11;
--
-- 使用表AUTO_INCREMENT `tmps`
--
ALTER TABLE `tmps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
