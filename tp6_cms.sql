-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2025-11-21 20:14:05
-- 服务器版本： 5.7.26
-- PHP 版本： 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `tp6_cms`
--

-- --------------------------------------------------------

--
-- 表的结构 `cms_article`
--

CREATE TABLE `cms_article` (
  `id` int(11) NOT NULL COMMENT '文章ID',
  `cid` int(11) NOT NULL COMMENT '所属分类ID',
  `title` varchar(255) NOT NULL COMMENT '文章标题',
  `cover` varchar(255) DEFAULT '' COMMENT '封面图URL（可选）',
  `content` text NOT NULL COMMENT '文章内容',
  `view` int(11) NOT NULL DEFAULT '0' COMMENT '阅读量',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1已发布，0草稿',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文章表';

--
-- 转存表中的数据 `cms_article`
--

INSERT INTO `cms_article` (`id`, `cid`, `title`, `cover`, `content`, `view`, `status`, `create_time`, `update_time`) VALUES
(1, 1, 'test1', '', 'hahanihao', 0, 1, '2025-11-20 15:07:15', '2025-11-20 15:07:15'),
(2, 1, 'hahanihao', '', '', 0, 1, '2025-11-20 23:57:29', '2025-11-20 23:57:29');

-- --------------------------------------------------------

--
-- 表的结构 `cms_category`
--

CREATE TABLE `cms_category` (
  `id` int(11) NOT NULL COMMENT '分类ID',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父分类ID：0为顶级分类',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序：数字越大越靠前',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1显示，0隐藏',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文章分类表';

--
-- 转存表中的数据 `cms_category`
--

INSERT INTO `cms_category` (`id`, `name`, `pid`, `sort`, `status`, `create_time`, `update_time`) VALUES
(1, '默认分类', 0, 100, 1, '2025-11-19 21:05:47', '2025-11-19 21:05:47'),
(2, '测试分类', 0, 99, 1, '2025-11-21 11:53:03', '2025-11-21 11:53:03');

-- --------------------------------------------------------

--
-- 表的结构 `cms_setting`
--

CREATE TABLE `cms_setting` (
  `id` int(11) NOT NULL COMMENT '设置ID',
  `site_title` varchar(255) NOT NULL DEFAULT '' COMMENT '网站标题',
  `site_desc` text COMMENT '网站描述',
  `site_logo` varchar(255) DEFAULT '' COMMENT '网站Logo URL',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='系统设置表';

--
-- 转存表中的数据 `cms_setting`
--

INSERT INTO `cms_setting` (`id`, `site_title`, `site_desc`, `site_logo`, `update_time`) VALUES
(1, 'TP6 CMS管理系统', '基于ThinkPHP6开发的简易CMS系统', '', '2025-11-19 21:05:47');

-- --------------------------------------------------------

--
-- 表的结构 `cms_user`
--

CREATE TABLE `cms_user` (
  `id` int(11) NOT NULL COMMENT '管理员ID',
  `username` varchar(30) NOT NULL COMMENT '登录用户名',
  `password` varchar(255) NOT NULL COMMENT '加密密码',
  `nickname` varchar(50) NOT NULL COMMENT '昵称',
  `role` tinyint(1) NOT NULL DEFAULT '0' COMMENT '角色：2=前台用户，1=后台管理员',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1正常，0禁用',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='管理员表';

--
-- 转存表中的数据 `cms_user`
--

INSERT INTO `cms_user` (`id`, `username`, `password`, `nickname`, `role`, `status`, `create_time`, `update_time`) VALUES
(1, 'admin', '$2y$10$KVSPrE.sT90LRQH8jlEOb./cY1LhHD8tvT/daND3sJemBcYXWF..C', '超级管理员', 1, 1, '2025-11-19 21:05:47', '2025-11-20 22:55:50'),
(2, 'test1', '$2y$10$b/fkoEzqyu8QnQbxRWYgeOV9Mmo2eg4hAq3FZap/CXJPHR99tyBkG', 'nichen1', 2, 1, '2025-11-20 15:26:32', '2025-11-20 23:47:21');

--
-- 转储表的索引
--

--
-- 表的索引 `cms_article`
--
ALTER TABLE `cms_article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cid` (`cid`);

--
-- 表的索引 `cms_category`
--
ALTER TABLE `cms_category`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cms_setting`
--
ALTER TABLE `cms_setting`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cms_user`
--
ALTER TABLE `cms_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `cms_article`
--
ALTER TABLE `cms_article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章ID', AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `cms_category`
--
ALTER TABLE `cms_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类ID', AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `cms_setting`
--
ALTER TABLE `cms_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '设置ID', AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `cms_user`
--
ALTER TABLE `cms_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员ID', AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
