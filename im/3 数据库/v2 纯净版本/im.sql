-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2022-01-10 22:49:36
-- 服务器版本： 5.7.34-log
-- PHP 版本： 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `im`
--

-- --------------------------------------------------------

--
-- 表的结构 `txzh_admin`
--

CREATE TABLE `txzh_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '登陆名',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '登陆密码',
  `sex` int(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `phone` varchar(11) DEFAULT NULL COMMENT '手机号',
  `email` varchar(20) DEFAULT NULL COMMENT '邮箱',
  `group_id` int(2) DEFAULT NULL COMMENT '权限角色ID',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `agent_id` int(11) DEFAULT '0' COMMENT '客户标识',
  `agent_name` varchar(255) NOT NULL DEFAULT '' COMMENT '客户(商家)名称'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员表' ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `txzh_admin`
--

INSERT INTO `txzh_admin` (`id`, `username`, `password`, `sex`, `phone`, `email`, `group_id`, `status`, `create_time`, `agent_id`, `agent_name`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 0, '15866669999', '15931238@qq.com', 1, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `txzh_article`
--

CREATE TABLE `txzh_article` (
  `id` int(11) UNSIGNED NOT NULL,
  `article_name` varchar(255) NOT NULL DEFAULT '',
  `article_desc` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `position` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL DEFAULT '0',
  `small_pic` varchar(255) NOT NULL DEFAULT '',
  `sort` smallint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `txzh_article`
--

INSERT INTO `txzh_article` (`id`, `article_name`, `article_desc`, `content`, `status`, `position`, `create_time`, `update_time`, `small_pic`, `sort`) VALUES
(19, '为何现在男人怕女人?', '为何现在男人怕女人?', '&lt;div class=&quot;header&quot; style=&quot;position: fixed; top: 0px; left: 0px; z-index: 9999; margin-bottom: 20px; width: 1000px; height: 60px; background-color: rgb(0, 0, 0); color: rgb(50, 50, 50); font-family: &amp;quot;Century Gothic&amp;quot;, &amp;quot;Microsoft yahei&amp;quot;; font-size: 14px; white-space: normal;&quot;&gt;&lt;div class=&quot;hd-main cf&quot; style=&quot;zoom: 1; margin-right: auto; margin-left: auto; width: 1000px;&quot;&gt;&lt;ul class=&quot;main-nav&quot; style=&quot;list-style-position: initial; list-style-image: initial; float: left;&quot;&gt;&lt;li style=&quot;float: left;&quot;&gt;&lt;a href=&quot;http://undefined&quot; style=&quot;color: rgb(255, 255, 255); display: inline-block; padding: 0px 16px; height: 60px; line-height: 60px; font-size: 16px; font-weight: bold; vertical-align: middle;&quot;&gt;首页&lt;/a&gt;&lt;/li&gt;&lt;li style=&quot;float: left;&quot;&gt;&lt;a href=&quot;http://undefined&quot; target=&quot;_blank&quot; style=&quot;color: rgb(255, 255, 255); display: inline-block; padding: 0px 16px; height: 60px; line-height: 60px; font-size: 16px; font-weight: bold; vertical-align: middle;&quot;&gt;扩展&lt;/a&gt;&lt;/li&gt;&lt;li style=&quot;float: left;&quot;&gt;&lt;a href=&quot;http://undefined&quot; target=&quot;_blank&quot; style=&quot;color: rgb(255, 255, 255); display: inline-block; padding: 0px 16px; height: 60px; line-height: 60px; font-size: 16px; font-weight: bold; vertical-align: middle;&quot;&gt;教程&lt;/a&gt;&lt;/li&gt;&lt;li class=&quot;current&quot; style=&quot;float: left;&quot;&gt;&lt;a href=&quot;http://undefined&quot; style=&quot;color: rgb(255, 255, 255); display: inline-block; padding: 0px 16px; height: 60px; line-height: 60px; font-size: 16px; font-weight: bold; vertical-align: middle; background-color: rgb(101, 101, 101);&quot;&gt;讨论&lt;/a&gt;&lt;/li&gt;&lt;li style=&quot;float: left;&quot;&gt;&lt;a href=&quot;http://undefined&quot; target=&quot;_blank&quot; style=&quot;color: rgb(255, 255, 255); display: inline-block; padding: 0px 16px; height: 60px; line-height: 60px; font-size: 16px; font-weight: bold; vertical-align: middle;&quot;&gt;博客&lt;/a&gt;&lt;/li&gt;&lt;li style=&quot;float: left;&quot;&gt;&lt;a href=&quot;http://undefined&quot; target=&quot;_blank&quot; style=&quot;color: rgb(111, 183, 55); display: inline-block; padding: 0px 16px; height: 60px; line-height: 60px; font-size: 16px; font-weight: bold; vertical-align: middle;&quot;&gt;服务市场&lt;/a&gt;&lt;/li&gt;&lt;li style=&quot;float: left;&quot;&gt;&lt;a href=&quot;http://undefined&quot; target=&quot;_blank&quot; style=&quot;color: rgb(91, 192, 222); display: inline-block; padding: 0px 16px; height: 60px; line-height: 60px; font-size: 16px; font-weight: bold; vertical-align: middle;&quot;&gt;ThinkAPI&lt;/a&gt;&lt;/li&gt;&lt;li style=&quot;float: left;&quot;&gt;&lt;a href=&quot;http://undefined&quot; target=&quot;_blank&quot; style=&quot;color: rgb(255, 255, 255); display: inline-block; padding: 0px 16px; height: 60px; line-height: 60px; font-size: 16px; font-weight: bold; vertical-align: middle;&quot;&gt;导航&lt;/a&gt;&lt;/li&gt;&lt;/ul&gt;&lt;div class=&quot;header-bar&quot; style=&quot;float: right; margin-top: 16px;&quot;&gt;&lt;a class=&quot;search-btn&quot; style=&quot;color: rgb(68, 68, 68); float: left; width: 50px; height: 25px; line-height: 24px; text-align: center; border-left: 1px solid rgb(204, 204, 204); background-color: rgb(245, 245, 245);&quot; href=&quot;http://undefined&quot;&gt;搜索&lt;/a&gt;&lt;div class=&quot;entrance&quot; style=&quot;position: relative; float: right; margin-left: 13px; color: rgb(255, 255, 255); height: 29px;&quot;&gt;&lt;a class=&quot;unlogin&quot; href=&quot;http://undefined&quot; style=&quot;color: rgb(68, 68, 68); display: block; margin-top: 6px;&quot;&gt;&lt;strong class=&quot;unlogin-ic&quot; style=&quot;display: inline-block; width: 24px; height: 24px; vertical-align: middle; background: url(&amp;quot;../img/icon_bg.png&amp;quot;) -100px -50px no-repeat;&quot;&gt;&lt;/strong&gt;&amp;nbsp;&lt;em class=&quot;entr-icon&quot; style=&quot;display: inline-block; margin-left: 5px; width: 0px; height: 0px; vertical-align: middle; border-width: 4px; border-style: solid; border-color: rgb(255, 255, 255) rgb(0, 0, 0) rgb(0, 0, 0); border-image: initial;&quot;&gt;&lt;/em&gt;&lt;/a&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;div class=&quot;main cf&quot; style=&quot;zoom: 1; margin-left: auto; margin-right: auto; padding-top: 70px; width: 1000px; min-height: 500px; color: rgb(50, 50, 50); font-family: &amp;quot;Century Gothic&amp;quot;, &amp;quot;Microsoft yahei&amp;quot;; font-size: 14px; white-space: normal; height: auto !important;&quot;&gt;&lt;div class=&quot;wrapper&quot; style=&quot;float: left; width: 720px;&quot;&gt;&lt;a href=&quot;http://undefined&quot; target=&quot;_blank&quot; style=&quot;color: rgb(68, 68, 68);&quot;&gt;&lt;img src=&quot;https://e.topthink.com/api/item/685/pic&quot; style=&quot;margin: 0px; padding: 0px; width: 720px;&quot;/&gt;&lt;/a&gt;&lt;div class=&quot;box detail-box&quot; style=&quot;margin-bottom: 10px; border: 1px solid rgb(212, 212, 212); position: relative; padding: 15px;&quot;&gt;&lt;div class=&quot;detail-hd&quot; style=&quot;margin-bottom: 10px;&quot;&gt;&lt;div class=&quot;t-head cf&quot; style=&quot;zoom: 1; margin-bottom: 8px; padding-bottom: 5px; border-bottom: 1px solid rgb(212, 212, 212);&quot;&gt;&lt;h2 style=&quot;padding-top: 0px; padding-bottom: 0px; float: left; color: rgb(50, 50, 50); max-width: 500px;&quot;&gt;使用富文本编辑器后如何保存&lt;/h2&gt;&lt;div class=&quot;turn&quot; style=&quot;float: right;&quot;&gt;&lt;a class=&quot;prev&quot; href=&quot;http://undefined&quot; title=&quot;上一篇：非法图像文件！&quot; style=&quot;color: rgb(68, 68, 68); display: inline-block; margin-left: 10px; width: 36px; height: 36px; vertical-align: middle; background: url(&amp;quot;../img/turn.png&amp;quot;) 0px 0px no-repeat;&quot;&gt;&lt;/a&gt;&amp;nbsp;&lt;a class=&quot;dir&quot; href=&quot;http://undefined&quot; title=&quot;返回目录&quot; style=&quot;color: rgb(68, 68, 68); display: inline-block; margin-left: 10px; width: 36px; height: 36px; vertical-align: middle; background: url(&amp;quot;../img/turn.png&amp;quot;) 0px -238px no-repeat;&quot;&gt;&lt;/a&gt;&amp;nbsp;&lt;a class=&quot;next&quot; href=&quot;http://undefined&quot; title=&quot;下一篇：（圣诞问）检查验证码正确的时候出现&quot; style=&quot;color: rgb(68, 68, 68); display: inline-block; margin-left: 10px; width: 36px; height: 36px; vertical-align: middle; background: url(&amp;quot;../img/turn.png&amp;quot;) 0px -48px no-repeat;&quot;&gt;&lt;/a&gt;&lt;/div&gt;&lt;/div&gt;&lt;div class=&quot;t-foot&quot; style=&quot;color: rgb(154, 154, 154);&quot;&gt;&lt;span style=&quot;margin-right: 15px;&quot;&gt;浏览：7915&lt;/span&gt;&amp;nbsp;&lt;span style=&quot;margin-right: 15px;&quot;&gt;发布日期：2015/12/25&lt;/span&gt;&amp;nbsp;&lt;span style=&quot;margin-right: 15px;&quot;&gt;分类：求助交流&lt;/span&gt;&amp;nbsp;&lt;span style=&quot;margin-right: 15px;&quot;&gt;关键字：&amp;nbsp;&lt;a href=&quot;http://undefined&quot; style=&quot;color: rgb(0, 84, 166); margin-right: 5px;&quot;&gt;TP&lt;/a&gt;&amp;nbsp;&lt;a href=&quot;http://undefined&quot; style=&quot;color: rgb(0, 84, 166); margin-right: 5px;&quot;&gt;新手&lt;/a&gt;&amp;nbsp;&lt;a href=&quot;http://undefined&quot; style=&quot;color: rgb(0, 84, 166); margin-right: 5px;&quot;&gt;&lt;/a&gt;&lt;a href=&quot;http://undefined&quot; style=&quot;color: rgb(0, 84, 166); margin-right: 5px;&quot;&gt;MySQL&lt;/a&gt;&lt;/span&gt;&lt;/div&gt;&lt;/div&gt;&lt;div class=&quot;detail-bd&quot; style=&quot;margin-bottom: 10px; line-height: 1.8; font-size: 16px;&quot;&gt;&lt;div class=&quot;thinkad_default_images&quot;&gt;&lt;a href=&quot;http://undefined&quot; title=&quot;阿里云618补贴&quot; target=&quot;_blank&quot; style=&quot;color: rgb(114, 185, 57);&quot;&gt;&lt;img width=&quot;680&quot; height=&quot;&quot; src=&quot;https://e.topthink.com/Uploads/Picture/2020-08-26/5f46705f8a64d.jpg&quot; alt=&quot;阿里云618补贴&quot; style=&quot;margin: 10px 0px; padding: 0px; max-width: 688px;&quot;/&gt;&lt;/a&gt;&lt;/div&gt;&lt;div style=&quot;border-bottom: 1px solid rgb(212, 212, 212); margin: 2px 6px 10px 10px; padding: 8px 6px;&quot;&gt;&lt;strong&gt;社区推荐：&lt;/strong&gt;&amp;nbsp;&lt;a href=&quot;http://undefined&quot; target=&quot;_blank&quot; style=&quot;color: rgb(114, 185, 57);&quot;&gt;Thinkphp+vue开源商城系统，获得《开源中国》2019年最有价值开源项目&lt;/a&gt;&lt;br/&gt;&lt;/div&gt;&lt;a href=&quot;http://undefined&quot; target=&quot;_blank&quot; style=&quot;color: rgb(114, 185, 57);&quot;&gt;&lt;img src=&quot;http://www.thinkphp.cn/Uploads/editor/2015-12-25/567d079b29e24.jpg&quot; style=&quot;margin: 10px 0px; padding: 0px; max-width: 688px;&quot;/&gt;&lt;/a&gt;&lt;br/&gt;用special去掉标签吗？在调用时又如何把格式输出来呢？&lt;div class=&quot;da_word&quot; style=&quot;margin-top: 40px;&quot;&gt;&lt;div style=&quot;border-top: 1px solid rgb(212, 212, 212); margin-top: 10px; padding: 12px 6px;&quot;&gt;&lt;strong&gt;【推广】&lt;/strong&gt;&amp;nbsp;&lt;a href=&quot;http://undefined&quot; target=&quot;_blank&quot; style=&quot;color: rgb(114, 185, 57);&quot;&gt;ThinkPHP官方应用服务市场——生态服务交易及交付平台，交易有保障&lt;/a&gt;&lt;br/&gt;&lt;strong&gt;【推广】&lt;/strong&gt;&amp;nbsp;&lt;a href=&quot;http://undefined&quot; target=&quot;_blank&quot; style=&quot;color: rgb(114, 185, 57);&quot;&gt;云服务器低至0.95折 1核2G ECS云服务器8.1元/月&lt;/a&gt;&lt;br/&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;div class=&quot;aw720&quot; style=&quot;margin-bottom: 10px; overflow: hidden; text-align: center; border: 1px solid rgb(212, 212, 212); width: 718px;&quot;&gt;&lt;div class=&quot;thinkad_default_images&quot;&gt;&lt;a href=&quot;http://undefined&quot; title=&quot;TPShop&quot; target=&quot;_blank&quot; style=&quot;color: rgb(68, 68, 68);&quot;&gt;&lt;img width=&quot;728&quot; height=&quot;90&quot; src=&quot;https://e.topthink.com/Uploads/Picture/2019-08-01/5d4289627ca56.jpg&quot; alt=&quot;TPShop&quot; style=&quot;margin: 0px; padding: 0px; max-width: 100%;&quot;/&gt;&lt;/a&gt;&lt;/div&gt;&lt;/div&gt;&lt;div class=&quot;box best-cmt&quot; id=&quot;hot_review_top&quot; style=&quot;margin-bottom: 10px; border: 1px solid rgb(212, 212, 212);&quot;&gt;&lt;div class=&quot;index-hd&quot; style=&quot;margin-bottom: 5px; padding-right: 10px; padding-left: 50px; height: 40px; line-height: 40px; color: rgb(0, 0, 0); border-bottom: 1px solid rgb(212, 212, 212); background: url(&amp;quot;../img/best.png&amp;quot;) 12px 4px no-repeat rgb(251, 251, 251); font-weight: bold; font-size: 16px;&quot;&gt;最佳答案&lt;/div&gt;&lt;div class=&quot;cmt-box&quot; style=&quot;padding: 15px; font-size: 16px;&quot;&gt;&lt;div class=&quot;cmt-item&quot; style=&quot;position: relative; margin-bottom: 10px; padding-left: 53px; min-height: 53px; line-height: 1.6; border-bottom: 0px;&quot;&gt;&lt;div class=&quot;cmt-item-best&quot;&gt;&lt;/div&gt;&lt;span class=&quot;avatar&quot; style=&quot;display: block; position: absolute; top: 0px; left: 0px; padding: 1px; width: 44px; height: 44px; line-height: 44px; text-align: center; border: 1px solid rgb(212, 212, 212);&quot;&gt;&lt;img src=&quot;http://passport.onethink.cn/Avatar/000/010/29/80/80_80.gif&quot; style=&quot;margin: 0px; padding: 0px; width: 44px;&quot;/&gt;&lt;/span&gt;&lt;div class=&quot;comment-hd&quot;&gt;&lt;span class=&quot;username&quot; style=&quot;margin-right: 10px;&quot;&gt;imdante&lt;/span&gt;&amp;nbsp;&lt;span class=&quot;commment-time&quot; style=&quot;color: rgb(153, 153, 153);&quot;&gt;2015年12月26日&lt;/span&gt;&lt;/div&gt;&lt;div class=&quot;comment-bd&quot; id=&quot;&quot; style=&quot;margin-bottom: 10px;&quot;&gt;&lt;div class=&quot;cmt-txt&quot; style=&quot;margin-bottom: 10px; min-height: 28px;&quot;&gt;模板读取的时候转义一下就行了 需要使用两个函数或是一个函数来转义&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;div id=&quot;tabbar&quot; class=&quot;box tabbar&quot; style=&quot;margin-bottom: 10px; border: 1px solid rgb(212, 212, 212);&quot;&gt;&lt;div class=&quot;tab-nav cf&quot; style=&quot;zoom: 1; height: 40px; line-height: 40px; font-size: 16px; color: rgb(114, 185, 57); border-bottom: 1px solid rgb(212, 212, 212); background-color: rgb(244, 244, 244);&quot;&gt;&lt;span class=&quot;item selected&quot; style=&quot;float: left; padding: 0px 20px; height: 39px; cursor: pointer; border-right: 1px solid rgb(212, 212, 212); margin-top: -1px; color: rgb(51, 51, 51); border-top: 3px solid rgb(114, 185, 57); border-bottom: 0px; border-radius: 5px 5px 0px 0px; background-color: rgb(255, 255, 255);&quot;&gt;评论（&lt;span class=&quot;review-count&quot;&gt;3&lt;/span&gt;）&lt;/span&gt;&lt;span class=&quot;item&quot; style=&quot;float: left; padding: 0px 20px; height: 40px; cursor: pointer; border-right: 1px solid rgb(212, 212, 212);&quot;&gt;相关&lt;/span&gt;&lt;/div&gt;&lt;div id=&quot;tab-wrap&quot; class=&quot;tab-wrap&quot; style=&quot;padding: 10px 20px;&quot;&gt;&lt;div class=&quot;tab-comment item-content&quot; id=&quot;comment&quot;&gt;&lt;div class=&quot;cmt-box&quot; style=&quot;padding-top: 10px; padding-bottom: 20px; font-size: 16px;&quot;&gt;&lt;div class=&quot;cmt-item review_item_list&quot; style=&quot;position: relative; margin-bottom: 10px; padding-left: 53px; min-height: 53px; line-height: 1.6; border-bottom: 1px solid rgb(212, 212, 212);&quot;&gt;&lt;a class=&quot;avatar&quot; href=&quot;http://undefined&quot; target=&quot;_blank&quot; style=&quot;color: rgb(114, 185, 57); display: block; position: absolute; top: 0px; left: 0px; padding: 1px; width: 44px; height: 44px; line-height: 44px; text-align: center; border: 1px solid rgb(212, 212, 212);&quot;&gt;&lt;img src=&quot;http://passport.onethink.cn/Avatar/000/019/96/13/80_80.gif&quot; style=&quot;margin: 0px; padding: 0px; width: 44px;&quot;/&gt;&lt;/a&gt;&lt;div class=&quot;comment-hd cf&quot; style=&quot;zoom: 1;&quot;&gt;&lt;span class=&quot;username&quot; style=&quot;margin-right: 10px; color: rgb(4, 72, 157); font-size: 14px;&quot;&gt;李奕迅&lt;/span&gt;&lt;span class=&quot;commment-time&quot; style=&quot;color: rgb(136, 136, 136); font-size: 14px;&quot;&gt;2015年12月26日&lt;/span&gt;&lt;/div&gt;&lt;div class=&quot;comment-bd&quot; id=&quot;145832&quot; style=&quot;margin-bottom: 10px;&quot;&gt;&lt;div class=&quot;cmt-txt&quot; style=&quot;margin-bottom: 10px; min-height: 28px; line-height: 1.6;&quot;&gt;我们在利用ThinkPHP提交数据的时候，数据库里的数据是含各种html标签的，那么在输出时就可以直接输出嘛。但是，也许你的老师曾经告诉过你，在进行后台数据提交的时候，要过滤掉html标签，如I(&amp;#39;content&amp;#39;,&amp;#39;&amp;#39;,&amp;#39;htmlspecialchars &amp;#39;)这样来操作的。但是经过这样的过滤后，你要是还想直接输出来或是进行截取字符的时候就会遇到很多的麻烦。本人经过多次摸索的实验，得来以下经验，希望分享了可以帮助到大家。&lt;br/&gt;总结：&lt;br/&gt;在运用富文本提交数据时，为了在数据输出时能够正常显示，有以下几种方法：&lt;br/&gt;1、在接收数据时采用如I(&amp;#39;content&amp;#39;,&amp;#39;&amp;#39;,&amp;#39;htmlspecialchars&amp;#39;)则在首页显示并截取数据字符串时，采用&lt;br/&gt;{$m.content|htmlspecialchars_decode|strip_tags|cut_str=###,200,0}&lt;br/&gt;其中，先把以过html转义过的数据“&amp;lt;”恢复成如“&amp;lt;a&amp;gt;”这样的html标签，再用strip_tags函数把所有的html数据都去除后再截取。&lt;br/&gt;包括其中的javascript代码都不会显示，也不会运行。&lt;br/&gt;在详细页中使用{$news.content|htmlspecialchars_decode=###}&lt;br/&gt;则在首页截取后显示的是有alert()代码，但不会显示其前面的&amp;lt;script&amp;gt;&amp;lt;/script&amp;gt;样的字符，同时在详细页中不会显示&amp;lt;script&amp;gt;&amp;lt;/script&amp;gt;&lt;br/&gt;以及其中间的所有代码。其他html标签正常输出转换。&lt;br/&gt;2、在接收数据时采用I(&amp;#39;content&amp;#39;)的形式，则在首页显示并截取数据字符串时，采用&lt;br/&gt;{$m.content|strip_tags|cut_str=###,200,0}&lt;br/&gt;其中，先把直接含html标签的数据利用strip_tags函数进行去除后，再截取字符串输出就可以了。&lt;br/&gt;在详细页中使用{$news.content|htmlspecialchars_decode=###}，则在首页截取后显示的是有alert()代码，并且还会有其前面的&amp;lt;script&amp;gt;&amp;lt;/script&amp;gt;样的字符，&lt;br/&gt;在详细页中，这个会显示javascript所有完整代码，但不会执行。&lt;br/&gt;3、在接收数据时采用I(&amp;#39;content&amp;#39;,&amp;#39;&amp;#39;,&amp;#39;htmlspecialchars&amp;#39;)的形式，则在首页显示并截取数据字符串时采用&lt;br/&gt;{$m.content|htmlspecialchars_decode|strip_tags|cut_str=###,200,0}&lt;br/&gt;在详细显示页时使用{$news.content}显示&lt;br/&gt;则首页截取的字符串正常，详细页中的数据显示也是正常的，完整的javascript代码会显示，但不会执行。&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;div class=&quot;cmt-item review_item_list&quot; style=&quot;position: relative; margin-bottom: 10px; padding-left: 53px; min-height: 53px; line-height: 1.6; border-bottom: 1px solid rgb(212, 212, 212);&quot;&gt;&lt;a class=&quot;avatar&quot; href=&quot;http://undefined&quot; target=&quot;_blank&quot; style=&quot;color: rgb(114, 185, 57); display: block; position: absolute; top: 0px; left: 0px; padding: 1px; width: 44px; height: 44px; line-height: 44px; text-align: center; border: 1px solid rgb(212, 212, 212);&quot;&gt;&lt;img src=&quot;http://passport.onethink.cn/Avatar/000/019/96/13/80_80.gif&quot; style=&quot;margin: 0px; padding: 0px; width: 44px;&quot;/&gt;&lt;/a&gt;&lt;div class=&quot;comment-hd cf&quot; style=&quot;zoom: 1;&quot;&gt;&lt;span class=&quot;username&quot; style=&quot;margin-right: 10px; color: rgb(4, 72, 157); font-size: 14px;&quot;&gt;李奕迅&lt;/span&gt;&lt;span class=&quot;commment-time&quot; style=&quot;color: rgb(136, 136, 136); font-size: 14px;&quot;&gt;2015年12月26日&lt;/span&gt;&lt;/div&gt;&lt;div class=&quot;comment-bd&quot; id=&quot;145826&quot; style=&quot;margin-bottom: 10px;&quot;&gt;&lt;div class=&quot;cmt-txt&quot; style=&quot;margin-bottom: 10px; min-height: 28px; line-height: 1.6;&quot;&gt;应该是使用htmlspecialchars_decode()&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;div class=&quot;cmt-item review_item_list&quot; style=&quot;position: relative; margin-bottom: 10px; padding-left: 53px; min-height: 53px; line-height: 1.6; border-bottom: 1px solid rgb(212, 212, 212);&quot;&gt;&lt;a class=&quot;avatar&quot; href=&quot;http://undefined&quot; target=&quot;_blank&quot; style=&quot;color: rgb(114, 185, 57); display: block; position: absolute; top: 0px; left: 0px; padding: 1px; width: 44px; height: 44px; line-height: 44px; text-align: center; border: 1px solid rgb(212, 212, 212);&quot;&gt;&lt;img src=&quot;http://passport.onethink.cn/Avatar/000/010/29/80/80_80.gif&quot; style=&quot;margin: 0px; padding: 0px; width: 44px;&quot;/&gt;&lt;/a&gt;&lt;div class=&quot;comment-hd cf&quot; style=&quot;zoom: 1;&quot;&gt;&lt;span class=&quot;username&quot; style=&quot;margin-right: 10px; color: rgb(4, 72, 157); font-size: 14px;&quot;&gt;imdante&lt;/span&gt;&lt;span class=&quot;commment-time&quot; style=&quot;color: rgb(136, 136, 136); font-size: 14px;&quot;&gt;2015年12月26日&lt;/span&gt;&lt;/div&gt;&lt;div class=&quot;comment-bd&quot; id=&quot;145804&quot; style=&quot;margin-bottom: 10px;&quot;&gt;&lt;div class=&quot;cmt-txt&quot; style=&quot;margin-bottom: 10px; min-height: 28px; line-height: 1.6;&quot;&gt;模板读取的时候转义一下就行了 需要使用两个函数或是一个函数来转义&lt;/div&gt;&lt;/div&gt;&lt;div class=&quot;cmt-item reply-item&quot; id=&quot;145814&quot; style=&quot;position: relative; margin-bottom: 10px; padding-left: 53px; min-height: 53px; line-height: 1.6; border-bottom: 0px; padding-top: 10px; border-top: 1px dotted rgb(212, 212, 212);&quot;&gt;&lt;a class=&quot;avatar&quot; href=&quot;http://undefined&quot; target=&quot;_blank&quot; style=&quot;color: rgb(114, 185, 57); display: block; position: absolute; top: 10px; left: 0px; padding: 1px; width: 44px; height: 44px; line-height: 44px; text-align: center; border: 1px solid rgb(212, 212, 212);&quot;&gt;&lt;img src=&quot;http://passport.onethink.cn/Avatar/000/019/96/13/80_80.gif&quot; style=&quot;margin: 0px; padding: 0px; width: 44px;&quot;/&gt;&lt;/a&gt;&lt;div class=&quot;comment-hd cf&quot; style=&quot;zoom: 1;&quot;&gt;&lt;a class=&quot;reply-btn&quot; style=&quot;color: rgb(114, 185, 57); float: right;&quot; href=&quot;http://undefined&quot;&gt;回复&lt;em style=&quot;display: inline-block; margin-left: 3px; width: 0px; height: 0px; vertical-align: middle; border-width: 5px 5px 0px; border-style: solid; border-color: rgb(114, 185, 57) rgb(255, 255, 255) rgb(255, 255, 255); border-image: initial;&quot;&gt;&lt;/em&gt;&lt;/a&gt;&lt;span class=&quot;username&quot; style=&quot;margin-right: 10px; color: rgb(4, 72, 157); font-size: 14px;&quot;&gt;李奕迅&lt;/span&gt;&lt;span class=&quot;commment-time&quot; style=&quot;color: rgb(136, 136, 136); font-size: 14px;&quot;&gt;2015年12月26日&lt;/span&gt;&lt;/div&gt;&lt;div class=&quot;comment-bd&quot; style=&quot;margin-bottom: 10px;&quot;&gt;谢谢！&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;div class=&quot;login-tip&quot;&gt;您需要登录后才可以评论&amp;nbsp;&lt;a href=&quot;http://undefined&quot; style=&quot;color: rgb(114, 185, 57);&quot;&gt;登录&lt;/a&gt;&amp;nbsp;|&amp;nbsp;&lt;a href=&quot;http://undefined&quot; style=&quot;color: rgb(114, 185, 57);&quot;&gt;立即注册&lt;/a&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;div class=&quot;thinkad_default_images&quot;&gt;&lt;a href=&quot;http://undefined&quot; title=&quot;官方应用服务市场上线公测——助力生态共赢&quot; target=&quot;_blank&quot; style=&quot;color: rgb(68, 68, 68);&quot;&gt;&lt;img width=&quot;720&quot; height=&quot;89&quot; src=&quot;https://e.topthink.com/Uploads/Picture/2020-05-24/5eca294e34aa8.png&quot; alt=&quot;官方应用服务市场上线公测——助力生态共赢&quot; style=&quot;margin: 0px; padding: 0px;&quot;/&gt;&lt;/a&gt;&lt;a href=&quot;http://undefined&quot; title=&quot;创宇认证优惠&quot; target=&quot;_blank&quot; style=&quot;color: rgb(68, 68, 68);&quot;&gt;&lt;img width=&quot;720&quot; height=&quot;89&quot; src=&quot;https://e.topthink.com/Uploads/Picture/2020-09-07/5f55f447e74ff.png&quot; alt=&quot;创宇认证优惠&quot; style=&quot;margin: 0px; padding: 0px;&quot;/&gt;&lt;/a&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;div class=&quot;sidebar&quot; style=&quot;float: right; width: 270px;&quot;&gt;&lt;div class=&quot;sn-wrap&quot; style=&quot;margin-bottom: 10px; overflow: hidden; border: 1px solid rgb(212, 212, 212);&quot;&gt;&lt;div class=&quot;count-box count-3 cf&quot; style=&quot;zoom: 1; margin-left: -1px; margin-right: -1px;&quot;&gt;&lt;dl class=&quot;count-item c-view &quot; id=&quot;collect&quot; style=&quot;float: left; color: rgb(0, 0, 0); text-align: center; cursor: pointer; border-right: 1px solid rgb(212, 212, 212); width: 89px;&quot;&gt;&lt;dt class=&quot;cit&quot; style=&quot;padding-top: 5px; height: 30px; line-height: 30px;&quot;&gt;&lt;em style=&quot;display: inline-block; margin-right: 5px; width: 16px; height: 16px; vertical-align: -2px; background: url(&amp;quot;../img/icon_bg.png&amp;quot;) 0px -75px no-repeat;&quot;&gt;&lt;/em&gt;收藏&lt;/dt&gt;&lt;dd class=&quot;cib&quot; id=&quot;collect_count&quot; style=&quot;height: 35px; line-height: 35px;&quot;&gt;1&lt;/dd&gt;&lt;/dl&gt;&lt;dl class=&quot;count-item c-like support&quot; style=&quot;float: left; color: rgb(0, 0, 0); text-align: center; cursor: pointer; border-right: 1px solid rgb(212, 212, 212); width: 89px;&quot;&gt;&lt;dt class=&quot;cit&quot; style=&quot;padding-top: 5px; height: 30px; line-height: 30px;&quot;&gt;&lt;em style=&quot;display: inline-block; margin-right: 5px; width: 16px; height: 16px; vertical-align: -2px; background: url(&amp;quot;../img/icon_bg.png&amp;quot;) -50px -75px no-repeat;&quot;&gt;&lt;/em&gt;赞&lt;/dt&gt;&lt;dd class=&quot;cib support_num&quot; style=&quot;height: 35px; line-height: 35px;&quot;&gt;0&lt;/dd&gt;&lt;/dl&gt;&lt;a class=&quot;count-item c-cmt&quot; style=&quot;color: rgb(0, 0, 0); float: left; text-align: center; border-right: 1px solid rgb(212, 212, 212); width: 89px;&quot; href=&quot;http://undefined&quot;&gt;&lt;span class=&quot;cit&quot; style=&quot;display: block; padding-top: 5px; height: 30px; line-height: 30px;&quot;&gt;&lt;em style=&quot;display: inline-block; margin-right: 5px; width: 16px; height: 16px; vertical-align: -2px; background: url(&amp;quot;../img/icon_bg.png&amp;quot;) -150px -75px no-repeat;&quot;&gt;&lt;/em&gt;评论&lt;/span&gt;&lt;span class=&quot;cib review-count&quot; style=&quot;display: block; height: 35px; line-height: 35px;&quot;&gt;3&lt;/span&gt;&lt;/a&gt;&lt;/div&gt;&lt;/div&gt;&lt;div class=&quot;box promulgator&quot; style=&quot;margin-bottom: 10px; border: 1px solid rgb(212, 212, 212); position: relative; padding: 10px 10px 10px 65px; height: 44px; line-height: 1.8; color: rgb(153, 153, 153);&quot;&gt;&lt;div class=&quot;avatar&quot; style=&quot;display: block; position: absolute; top: 10px; left: 10px; padding: 1px; width: 44px; height: 44px; line-height: 44px; text-align: center; border: 1px solid rgb(212, 212, 212);&quot;&gt;&lt;a href=&quot;http://undefined&quot; target=&quot;blank&quot; title=&quot;进入Ta的主页&quot; style=&quot;color: rgb(68, 68, 68);&quot;&gt;&lt;img src=&quot;http://passport.onethink.cn/Avatar/000/019/96/13/80_80.gif&quot; style=&quot;margin: 0px; padding: 0px; width: 44px;&quot;/&gt;&lt;/a&gt;&lt;/div&gt;&lt;div class=&quot;name&quot; style=&quot;color: rgb(51, 51, 51);&quot;&gt;&lt;span class=&quot;send&quot; style=&quot;float: right; width: 22px; height: 22px; line-height: 22px; text-align: center;&quot;&gt;&lt;em class=&quot;icon-send&quot;&gt;&lt;/em&gt;&lt;/span&gt;李奕迅&lt;/div&gt;&lt;span class=&quot;mr&quot; style=&quot;margin-right: 10px;&quot;&gt;积分：169&lt;/span&gt;&amp;nbsp;等级：LV1&lt;/div&gt;&lt;div class=&quot;box da-link&quot; style=&quot;margin-bottom: 10px; border: 1px solid rgb(212, 212, 212); padding: 10px;&quot;&gt;&lt;div class=&quot;thinkad_default_images&quot;&gt;&lt;a href=&quot;http://undefined&quot; title=&quot;ThinkPHP开发者扶持计划&quot; target=&quot;_blank&quot; style=&quot;color: rgb(114, 185, 57);&quot;&gt;&lt;img width=&quot;250&quot; height=&quot;120&quot; src=&quot;https://e.topthink.com/Uploads/Picture/2020-06-24/5ef35197acb98.png&quot; alt=&quot;ThinkPHP开发者扶持计划&quot; style=&quot;margin: 0px; padding: 0px;&quot;/&gt;&lt;/a&gt;&lt;/div&gt;&lt;/div&gt;&lt;div class=&quot;box share&quot; style=&quot;margin-bottom: 10px; border: 1px solid rgb(212, 212, 212); padding: 15px; font-weight: bold; color: rgb(114, 185, 57);&quot;&gt;&lt;a href=&quot;http://undefined&quot; target=&quot;_blank&quot; style=&quot;color: rgb(68, 68, 68);&quot;&gt;&lt;img src=&quot;https://box.kancloud.cn/9974ba3ed3b16b59613ea4819bcbd4b6&quot; style=&quot;margin: 0px; padding: 0px;&quot;/&gt;&lt;/a&gt;&lt;/div&gt;&lt;div class=&quot;a6&quot; style=&quot;margin-bottom: 20px; padding: 6px 9px; width: 250px; text-align: center; overflow: hidden; border: 1px solid rgb(212, 212, 212);&quot;&gt;&lt;div class=&quot;thinkad_default_images&quot;&gt;&lt;a href=&quot;http://undefined&quot; title=&quot;CRMEB&quot; target=&quot;_blank&quot; style=&quot;color: rgb(68, 68, 68);&quot;&gt;&lt;img width=&quot;250&quot; height=&quot;&quot; src=&quot;https://e.topthink.com/Uploads/Picture/2020-07-15/5f0e8a050293b.jpg&quot; alt=&quot;CRMEB&quot; style=&quot;margin: 3px 0px; padding: 0px; width: 250px;&quot;/&gt;&lt;/a&gt;&lt;/div&gt;&lt;/div&gt;&lt;div class=&quot;box ranking hot-rec&quot; style=&quot;margin-bottom: 10px; border: 1px solid rgb(212, 212, 212);&quot;&gt;&lt;div class=&quot;index-hd&quot; style=&quot;margin-bottom: 5px; padding-right: 10px; padding-left: 10px; height: 40px; line-height: 40px; color: rgb(251, 251, 251); border-bottom: 1px solid rgb(212, 212, 212); background-color: rgb(251, 251, 251);&quot;&gt;&lt;div class=&quot;title&quot; style=&quot;float: left;&quot;&gt;&lt;em class=&quot;t-icon&quot; style=&quot;display: inline-block; margin-right: 4px; width: 18px; vertical-align: middle; background: url(&amp;quot;../img/icon_bg.png&amp;quot;) -125px -25px no-repeat; height: 18px;&quot;&gt;&lt;/em&gt;&lt;span style=&quot;font-size: 18px; font-weight: bold; color: rgb(83, 83, 83); vertical-align: middle;&quot;&gt;热点推荐&lt;/span&gt;&lt;/div&gt;&lt;/div&gt;&lt;ul class=&quot;bd ellipsis&quot; style=&quot;margin-top: 10px; margin-right: 15px; margin-left: 15px; list-style-position: initial; list-style-image: initial;&quot;&gt;&lt;li class=&quot;top3&quot; style=&quot;overflow: hidden; text-overflow: ellipsis; white-space: nowrap; height: 42px; line-height: 42px; border-bottom: 1px dashed rgb(212, 212, 212);&quot;&gt;&lt;span style=&quot;display: inline-block; margin-right: 10px; width: 20px; height: 28px; line-height: 20px; font-weight: bold; color: rgb(255, 255, 255); text-align: center; vertical-align: middle; background: url(&amp;quot;../img/bg.png&amp;quot;) -40px -40px no-repeat;&quot;&gt;1&lt;/span&gt;&lt;a title=&quot;比RBAC更好的权限认证方式（Auth类认证）&quot; href=&quot;http://undefined&quot; style=&quot;color: rgb(68, 68, 68);&quot;&gt;比RBAC更好的权限认证方式（Auth类认证）&lt;/a&gt;&lt;/li&gt;&lt;li class=&quot;top3&quot; style=&quot;overflow: hidden; text-overflow: ellipsis; white-space: nowrap; height: 42px; line-height: 42px; border-bottom: 1px dashed rgb(212, 212, 212);&quot;&gt;&lt;span style=&quot;display: inline-block; margin-right: 10px; width: 20px; height: 28px; line-height: 20px; font-weight: bold; color: rgb(255, 255, 255); text-align: center; vertical-align: middle; background: url(&amp;quot;../img/bg.png&amp;quot;) -40px -40px no-repeat;&quot;&gt;2&lt;/span&gt;&lt;a title=&quot;浅谈 PHP 与手机 APP 开发（API 接口开发）&quot; href=&quot;http://undefined&quot; style=&quot;color: rgb(68, 68, 68);&quot;&gt;浅谈 PHP 与手机 APP 开发（API 接口开发）&lt;/a&gt;&lt;/li&gt;&lt;li class=&quot;top3&quot; style=&quot;overflow: hidden; text-overflow: ellipsis; white-space: nowrap; height: 42px; line-height: 42px; border-bottom: 1px dashed rgb(212, 212, 212);&quot;&gt;&lt;span style=&quot;display: inline-block; margin-right: 10px; width: 20px; height: 28px; line-height: 20px; font-weight: bold; color: rgb(255, 255, 255); text-align: center; vertical-align: middle; background: url(&amp;quot;../img/bg.png&amp;quot;) -40px -40px no-repeat;&quot;&gt;3&lt;/span&gt;&lt;a title=&quot;ThinkPHP微信demo实例&quot; href=&quot;http://undefined&quot; style=&quot;color: rgb(68, 68, 68);&quot;&gt;ThinkPHP微信demo实例&lt;/a&gt;&lt;/li&gt;&lt;li style=&quot;overflow: hidden; text-overflow: ellipsis; white-space: nowrap; height: 42px; line-height: 42px; border-bottom: 1px dashed rgb(212, 212, 212);&quot;&gt;&lt;span style=&quot;display: inline-block; margin-right: 10px; width: 20px; height: 20px; line-height: 20px; font-weight: bold; color: rgb(255, 255, 255); text-align: center; vertical-align: middle; background-color: rgb(160, 160, 160);&quot;&gt;4&lt;/span&gt;&lt;a title=&quot;Nginx下实现pathinfo及ThinkPHP的URL Rewrite模式支持&quot; href=&quot;http://undefined&quot; style=&quot;color: rgb(68, 68, 68);&quot;&gt;Nginx下实现pathinfo及ThinkPHP的URL Rewrite模式支持&lt;/a&gt;&lt;/li&gt;&lt;li style=&quot;overflow: hidden; text-overflow: ellipsis; white-space: nowrap; height: 42px; line-height: 42px; border-bottom: 0px;&quot;&gt;&lt;span style=&quot;display: inline-block; margin-right: 10px; width: 20px; height: 20px; line-height: 20px; font-weight: bold; color: rgb(255, 255, 255); text-align: center; vertical-align: middle; background-color: rgb(160, 160, 160);&quot;&gt;5&lt;/span&gt;&lt;a title=&quot;ThinkPHP(RBAC)权限管理系统视频教程(完结^_^)&quot; href=&quot;http://undefined&quot; style=&quot;color: rgb(68, 68, 68);&quot;&gt;ThinkPHP(RBAC)权限管理系统视频教程(完结^_^)&lt;/a&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/div&gt;&lt;div class=&quot;a6&quot; style=&quot;margin-bottom: 20px; padding: 6px 9px; width: 250px; text-align: center; overflow: hidden; border: 1px solid rgb(212, 212, 212);&quot;&gt;&lt;div class=&quot;thinkad_default_images&quot;&gt;&lt;a href=&quot;http://undefined&quot; title=&quot;知道创宇云安全&quot; target=&quot;_blank&quot; style=&quot;color: rgb(68, 68, 68);&quot;&gt;&lt;img width=&quot;250&quot; height=&quot;250&quot; src=&quot;https://e.topthink.com/Uploads/Picture/2020-09-08/5f56eb4b74846.jpg&quot; alt=&quot;知道创宇云安全&quot; style=&quot;margin: 3px 0px; padding: 0px; width: 250px;&quot;/&gt;&lt;/a&gt;&lt;/div&gt;&lt;ins class=&quot;adsbygoogle&quot; style=&quot;display: inline-block; width: 240px; height: 250px;&quot;&gt;&lt;ins id=&quot;aswift_0_expand&quot; style=&quot;display: inline-table; border: none; height: 250px; margin: 0px; padding: 0px; position: relative; visibility: visible; width: 240px; background-color: transparent;&quot;&gt;&lt;ins id=&quot;aswift_0_anchor&quot; style=&quot;display: block; border: none; height: 250px; margin: 0px; padding: 0px; position: relative; visibility: visible; width: 240px; background-color: transparent;&quot;&gt;&lt;iframe frameborder=&quot;0&quot; id=&quot;aswift_0&quot; style=&quot;left: 0px; position: absolute; top: 0px; border-width: 0px; border-style: initial; width: 240px; height: 250px;&quot;&gt;&lt;/iframe&gt;&lt;/ins&gt;&lt;/ins&gt;&lt;/ins&gt;&lt;/div&gt;&lt;div class=&quot;box ranking lupd&quot; style=&quot;margin-bottom: 10px; border: 1px solid rgb(212, 212, 212);&quot;&gt;&lt;div class=&quot;index-hd&quot; style=&quot;margin-bottom: 5px; padding-right: 10px; padding-left: 10px; height: 40px; line-height: 40px; color: rgb(251, 251, 251); border-bottom: 1px solid rgb(212, 212, 212); background-color: rgb(251, 251, 251);&quot;&gt;&lt;div class=&quot;title&quot; style=&quot;float: left;&quot;&gt;&lt;em class=&quot;t-icon&quot; style=&quot;display: inline-block; margin-right: 4px; width: 18px; vertical-align: middle; background: url(&amp;quot;../img/icon_bg.png&amp;quot;) -175px -25px no-repeat; height: 18px;&quot;&gt;&lt;/em&gt;&lt;span style=&quot;font-size: 18px; font-weight: bold; color: rgb(83, 83, 83); vertical-align: middle;&quot;&gt;最新更新&lt;/span&gt;&lt;/div&gt;&lt;/div&gt;&lt;ul class=&quot;bd ellipsis&quot; style=&quot;margin-top: 10px; margin-right: 15px; margin-left: 15px; list-style-position: initial; list-style-image: initial;&quot;&gt;&lt;li class=&quot;top3&quot; style=&quot;overflow: hidden; text-overflow: ellipsis; white-space: nowrap; height: 42px; line-height: 42px; border-bottom: 1px dashed rgb(212, 212, 212);&quot;&gt;&lt;span style=&quot;display: inline-block; margin-right: 10px; width: 20px; height: 28px; line-height: 20px; font-weight: bold; color: rgb(255, 255, 255); text-align: center; vertical-align: middle; background: url(&amp;quot;../img/bg.png&amp;quot;) -40px -40px no-repeat;&quot;&gt;1&lt;/span&gt;&lt;a title=&quot;哪位大神知道这两个包有啥区别分别干什么的&quot; href=&quot;http://undefined&quot; style=&quot;color: rgb(68, 68, 68);&quot;&gt;哪位大神知道这两个包有啥区别分别干什么的&lt;/a&gt;&lt;/li&gt;&lt;li class=&quot;top3&quot; style=&quot;overflow: hidden; text-overflow: ellipsis; white-space: nowrap; height: 42px; line-height: 42px; border-bottom: 1px dashed rgb(212, 212, 212);&quot;&gt;&lt;span style=&quot;display: inline-block; margin-right: 10px; width: 20px; height: 28px; line-height: 20px; font-weight: bold; color: rgb(255, 255, 255); text-align: center; vertical-align: middle; background: url(&amp;quot;../img/bg.png&amp;quot;) -40px -40px no-repeat;&quot;&gt;2&lt;/span&gt;&lt;a title=&quot;require_once引用失败&quot; href=&quot;http://undefined&quot; style=&quot;color: rgb(68, 68, 68);&quot;&gt;require_once引用失败&lt;/a&gt;&lt;/li&gt;&lt;li class=&quot;top3&quot; style=&quot;overflow: hidden; text-overflow: ellipsis; white-space: nowrap; height: 42px; line-height: 42px; border-bottom: 1px dashed rgb(212, 212, 212);&quot;&gt;&lt;span style=&quot;display: inline-block; margin-right: 10px; width: 20px; height: 28px; line-height: 20px; font-weight: bold; color: rgb(255, 255, 255); text-align: center; vertical-align: middle; background: url(&amp;quot;../img/bg.png&amp;quot;) -40px -40px no-repeat;&quot;&gt;3&lt;/span&gt;&lt;a title=&quot;急急急！url生成不能指定域名？？？url生成不能指定域名？？？&quot; href=&quot;http://undefined&quot; style=&quot;color: rgb(68, 68, 68);&quot;&gt;急急急！url生成不能指定域名？？？url生成不能指定域名？？？&lt;/a&gt;&lt;/li&gt;&lt;li style=&quot;overflow: hidden; text-overflow: ellipsis; white-space: nowrap; height: 42px; line-height: 42px; border-bottom: 1px dashed rgb(212, 212, 212);&quot;&gt;&lt;span style=&quot;display: inline-block; margin-right: 10px; width: 20px; height: 20px; line-height: 20px; font-weight: bold; color: rgb(255, 255, 255); text-align: center; vertical-align: middle; background-color: rgb(160, 160, 160);&quot;&gt;4&lt;/span&gt;&lt;a title=&quot;关于thinkphp6 config文件夹下使用config函数的bug&quot; href=&quot;http://undefined&quot; style=&quot;color: rgb(68, 68, 68);&quot;&gt;关于thinkphp6 config文件夹下使用config函数的bug&lt;/a&gt;&lt;/li&gt;&lt;li style=&quot;overflow: hidden; text-overflow: ellipsis; white-space: nowrap; height: 42px; line-height: 42px; border-bottom: 0px;&quot;&gt;&lt;span style=&quot;display: inline-block; margin-right: 10px; width: 20px; height: 20px; line-height: 20px; font-weight: bold; color: rgb(255, 255, 255); text-align: center; vertical-align: middle; background-color: rgb(160, 160, 160);&quot;&gt;5&lt;/span&gt;&lt;a title=&quot;model设置返回字段&quot; href=&quot;http://undefined&quot; style=&quot;color: rgb(68, 68, 68);&quot;&gt;model设置返回字段&lt;/a&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;div class=&quot;footer&quot; style=&quot;margin-top: 20px; min-width: 1000px; border-top-width: 8px; border-top-color: rgb(0, 0, 0); background-color: rgb(52, 57, 60); color: rgb(50, 50, 50); font-family: &amp;quot;Century Gothic&amp;quot;, &amp;quot;Microsoft yahei&amp;quot;; font-size: 14px; text-align: start; white-space: normal;&quot;&gt;&lt;div class=&quot;ft-main cf&quot; style=&quot;zoom: 1; margin-left: auto; margin-right: auto; padding-top: 15px; padding-bottom: 15px; width: 1000px; line-height: 1.8;&quot;&gt;&lt;div class=&quot;ft-col&quot; style=&quot;float: left; padding-right: 20px; margin-right: 25px; height: 196px; background: url(&amp;quot;../img/bottom_solid.png&amp;quot;) right center no-repeat;&quot;&gt;&lt;h3 style=&quot;padding-top: 0px; padding-bottom: 0px; color: rgb(126, 130, 131);&quot;&gt;我们&lt;/h3&gt;&lt;ul style=&quot;list-style-position: initial; list-style-image: initial;&quot;&gt;&lt;li&gt;&lt;a href=&quot;http://undefined&quot; style=&quot;color: rgb(126, 130, 131);&quot;&gt;关于我们&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;http://undefined&quot; style=&quot;color: rgb(126, 130, 131);&quot;&gt;联系我们&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;http://undefined&quot; style=&quot;color: rgb(126, 130, 131);&quot;&gt;捐赠我们&lt;/a&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/div&gt;&lt;div class=&quot;ft-col&quot; style=&quot;float: left; padding-right: 20px; margin-right: 25px; height: 196px; background: url(&amp;quot;../img/bottom_solid.png&amp;quot;) right center no-repeat;&quot;&gt;&lt;h3 style=&quot;padding-top: 0px; padding-bottom: 0px; color: rgb(126, 130, 131);&quot;&gt;合作&lt;/h3&gt;&lt;ul style=&quot;list-style-position: initial; list-style-image: initial;&quot;&gt;&lt;li&gt;&lt;a href=&quot;http://undefined&quot; style=&quot;color: rgb(126, 130, 131);&quot;&gt;友情链接&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;http://undefined&quot; style=&quot;color: rgb(126, 130, 131);&quot;&gt;广告合作&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;http://undefined&quot; style=&quot;color: rgb(126, 130, 131);&quot;&gt;合作伙伴&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;http://undefined&quot; style=&quot;color: rgb(126, 130, 131);&quot;&gt;技术支持&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;http://undefined&quot; style=&quot;color: rgb(126, 130, 131);&quot;&gt;产品服务&lt;/a&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/div&gt;&lt;div class=&quot;ft-col&quot; style=&quot;float: left; padding-right: 20px; margin-right: 25px; height: 196px; background: url(&amp;quot;../img/bottom_solid.png&amp;quot;) right center no-repeat;&quot;&gt;&lt;h3 style=&quot;padding-top: 0px; padding-bottom: 0px; color: rgb(126, 130, 131);&quot;&gt;网站&lt;/h3&gt;&lt;ul style=&quot;list-style-position: initial; list-style-image: initial;&quot;&gt;&lt;li&gt;&lt;a href=&quot;http://undefined&quot; style=&quot;color: rgb(126, 130, 131);&quot;&gt;服务市场&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;http://undefined&quot; style=&quot;color: rgb(126, 130, 131);&quot;&gt;扩展插件&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;http://undefined&quot; style=&quot;color: rgb(126, 130, 131);&quot;&gt;开发资源&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;http://undefined&quot; style=&quot;color: rgb(126, 130, 131);&quot;&gt;教程资源&lt;/a&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/div&gt;&lt;div class=&quot;ft-col&quot; style=&quot;float: left; padding-right: 20px; margin-right: 25px; height: 196px; background: url(&amp;quot;../img/bottom_solid.png&amp;quot;) right center no-repeat;&quot;&gt;&lt;h3 style=&quot;padding-top: 0px; padding-bottom: 0px; color: rgb(126, 130, 131);&quot;&gt;信息&lt;/h3&gt;&lt;ul style=&quot;list-style-position: initial; list-style-image: initial;&quot;&gt;&lt;li&gt;&lt;a href=&quot;http://undefined&quot; style=&quot;color: rgb(126, 130, 131);&quot;&gt;BUG反馈&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;http://undefined&quot; style=&quot;color: rgb(126, 130, 131);&quot;&gt;技术讨论&lt;/a&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/div&gt;&lt;div class=&quot;ft-intro&quot; style=&quot;float: left; padding-right: 20px; width: 574px; color: rgb(126, 130, 131); background: url(&amp;quot;../img/bottom_solid.png&amp;quot;) right center no-repeat;&quot;&gt;&lt;div class=&quot;btm-logo&quot; style=&quot;background: url(&amp;quot;../img/bottom_logo.png&amp;quot;) 480px 105px no-repeat;&quot;&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px;&quot;&gt;ThinkPHP 是一个免费开源的，快速、简单的面向对象的 轻量级PHP开发框架 ，创立于2006年初，遵循Apache2开源协议发布，是为了敏捷WEB应用开发和简化企业应用开发而诞生的。ThinkPHP从诞生以来一直秉承简洁实用的设计原则，在保持出色的性能和至简的代码的同时，也注重易用性。并且拥有众多的原创功能和特性，在社区团队的积极参与下，在易用性、扩展性和性能方面不断优化和改进，已经成长为国内最领先和最具影响力的WEB应用开发框架，众多的典型案例确保可以稳定用于商业以及门户级的开发。&lt;/p&gt;&lt;div class=&quot;copyright&quot; style=&quot;margin-top: 20px; font-weight: bold;&quot;&gt;沪ICP备12007941号-2&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', 1, 0, 1601055213, 0, '/uploads/2020-09-26/20200926/16010552118031.png', 0);
INSERT INTO `txzh_article` (`id`, `article_name`, `article_desc`, `content`, `status`, `position`, `create_time`, `update_time`, `small_pic`, `sort`) VALUES
(20, '这些动作很危险', '这些动作很危险', '&lt;div class=&quot;sec&quot; style=&quot;position: relative; color: rgb(0, 0, 0); font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: medium; white-space: normal; background-color: rgb(0, 0, 0);&quot;&gt;&lt;img src=&quot;https://p3.itc.cn/images01/20200610/637a6d0c8bcb4572bc39387cdbb58ca8.jpeg&quot; class=&quot;bg&quot; style=&quot;display: block; width: 320px;&quot;/&gt;&lt;/div&gt;&lt;p&gt;&lt;img src=&quot;https://p6.itc.cn/images01/20200610/07487d5bb7ff40019e20b9c43f7c8db7.jpeg&quot; style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: medium; white-space: normal; background-color: rgb(0, 0, 0); width: 320px;&quot;/&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: medium; white-space: normal; background-color: rgb(0, 0, 0);&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;img src=&quot;https://p3.itc.cn/images01/20200610/7f3fa11219df4080802974251e8415ae.jpeg&quot; style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: medium; white-space: normal; background-color: rgb(0, 0, 0); width: 320px;&quot;/&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: medium; white-space: normal; background-color: rgb(0, 0, 0);&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;img src=&quot;https://p1.itc.cn/images01/20200610/b5a7a2f5f4eb429eaeb9f160e1accabf.jpeg&quot; style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: medium; white-space: normal; background-color: rgb(0, 0, 0); width: 320px;&quot;/&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: medium; white-space: normal; background-color: rgb(0, 0, 0);&quot;&gt;&lt;/span&gt;&lt;/p&gt;&lt;div style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: medium; white-space: normal; background-color: rgb(0, 0, 0); height: 50px;&quot;&gt;&lt;/div&gt;&lt;p&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;精选留言&lt;/section&gt;&lt;/section&gt;&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;br/&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;&lt;img class=&quot;assistant&quot; src=&quot;http://11.166860.cn/index/001.jpg&quot; title=&quot;1487036877322462.jpg&quot; style=&quot;width: 45px; border-width: 1px; border-style: solid; border-color: rgb(51, 68, 85); margin: 0px; padding: 0px; border-radius: 100%;&quot;/&gt;&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;p style=&quot;clear: none; display: inline-block; color: rgb(81, 184, 210); text-indent: 0.5em;&quot;&gt;赵天&lt;/p&gt;&amp;nbsp;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; margin-left: 5px; clear: none; font-size: 12px; display: inline-block; color: rgb(153, 153, 153);&quot;&gt;17小时前&lt;/p&gt;&amp;nbsp;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; margin-left: 5px; clear: none; font-size: 12px; display: inline-block; color: rgb(153, 153, 153);&quot;&gt;14558&lt;/p&gt;&lt;section&gt;我开始还以为跟别人一样就是忽悠你进去玩 没想到这个女神这个计划公式预测真他奶奶的精准?&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;/section&gt;&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;&lt;img class=&quot;assistant&quot; src=&quot;http://11.166860.cn/index/002.jpg&quot; title=&quot;1487036877322462.jpg&quot; style=&quot;width: 45px; border-width: 1px; border-style: solid; border-color: rgb(51, 68, 85); margin: 0px; padding: 0px; border-radius: 100%;&quot;/&gt;&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;p style=&quot;clear: none; display: inline-block; color: rgb(81, 184, 210); text-indent: 0.5em;&quot;&gt;赵天&lt;/p&gt;&amp;nbsp;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; margin-left: 5px; clear: none; font-size: 12px; display: inline-block; color: rgb(153, 153, 153);&quot;&gt;17小时前&lt;/p&gt;&amp;nbsp;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; margin-left: 5px; clear: none; font-size: 12px; display: inline-block; color: rgb(153, 153, 153);&quot;&gt;14558&lt;/p&gt;&lt;section&gt;谢谢楼主的分享，我上个月跟着达人玩这个赚了三万！小投入大回报，这个月冲五万去！&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;/section&gt;&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;&lt;img class=&quot;assistant&quot; src=&quot;http://11.166860.cn/index/003.jpg&quot; title=&quot;1487036877322462.jpg&quot; style=&quot;width: 45px; border-width: 1px; border-style: solid; border-color: rgb(51, 68, 85); margin: 0px; padding: 0px; border-radius: 100%;&quot;/&gt;&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;p style=&quot;clear: none; display: inline-block; color: rgb(81, 184, 210); text-indent: 0.5em;&quot;&gt;赵天&lt;/p&gt;&amp;nbsp;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; margin-left: 5px; clear: none; font-size: 12px; display: inline-block; color: rgb(153, 153, 153);&quot;&gt;17小时前&lt;/p&gt;&amp;nbsp;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; margin-left: 5px; clear: none; font-size: 12px; display: inline-block; color: rgb(153, 153, 153);&quot;&gt;14558&lt;/p&gt;&lt;section&gt;给您点个赞?本金5千跟着赚了3w6?&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;/section&gt;&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;&lt;img class=&quot;assistant&quot; src=&quot;http://11.166860.cn/index/004.jpg&quot; title=&quot;1487036877322462.jpg&quot; style=&quot;width: 45px; border-width: 1px; border-style: solid; border-color: rgb(51, 68, 85); margin: 0px; padding: 0px; border-radius: 100%;&quot;/&gt;&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;p style=&quot;clear: none; display: inline-block; color: rgb(81, 184, 210); text-indent: 0.5em;&quot;&gt;我是猛男&lt;/p&gt;&amp;nbsp;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; margin-left: 5px; clear: none; font-size: 12px; display: inline-block; color: rgb(153, 153, 153);&quot;&gt;15小时前&lt;/p&gt;&amp;nbsp;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; margin-left: 5px; clear: none; font-size: 12px; display: inline-block; color: rgb(153, 153, 153);&quot;&gt;10352&lt;/p&gt;&lt;section&gt;幸好加了微信，后面找了好久都没找到那个页面，差点错过赚钱的机会，达人好好人，看的准！&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;/section&gt;&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;&lt;img class=&quot;assistant&quot; src=&quot;http://11.166860.cn/index/005.jpg&quot; title=&quot;1487036877322462.jpg&quot; style=&quot;width: 45px; border-width: 1px; border-style: solid; border-color: rgb(51, 68, 85); margin: 0px; padding: 0px; border-radius: 100%;&quot;/&gt;&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;p style=&quot;clear: none; display: inline-block; color: rgb(81, 184, 210); text-indent: 0.5em;&quot;&gt;就这么feel倍爽&lt;/p&gt;&amp;nbsp;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; margin-left: 5px; clear: none; font-size: 12px; display: inline-block; color: rgb(153, 153, 153);&quot;&gt;4小时前&lt;/p&gt;&amp;nbsp;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; margin-left: 5px; clear: none; font-size: 12px; display: inline-block; color: rgb(153, 153, 153);&quot;&gt;7666&lt;/p&gt;&lt;section&gt;玩江苏快3几年输了欠下很多贷款 真心感谢大神把我这几年输的钱都带我赢回来了&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;/section&gt;&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;&lt;img class=&quot;assistant&quot; src=&quot;http://11.166860.cn/index/006.jpg&quot; title=&quot;1487036877322462.jpg&quot; style=&quot;width: 45px; border-width: 1px; border-style: solid; border-color: rgb(51, 68, 85); margin: 0px; padding: 0px; border-radius: 100%;&quot;/&gt;&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;p style=&quot;clear: none; display: inline-block; color: rgb(81, 184, 210); text-indent: 0.5em;&quot;&gt;我是猛男&lt;/p&gt;&amp;nbsp;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; margin-left: 5px; clear: none; font-size: 12px; display: inline-block; color: rgb(153, 153, 153);&quot;&gt;15小时前&lt;/p&gt;&amp;nbsp;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; margin-left: 5px; clear: none; font-size: 12px; display: inline-block; color: rgb(153, 153, 153);&quot;&gt;10352&lt;/p&gt;&lt;section&gt;非常感谢楼主的分享 跟着他们玩了差不多一个月让赚了 我平时上班快一年的工资！&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;/section&gt;&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;&lt;img class=&quot;assistant&quot; src=&quot;http://11.166860.cn/index/007.jpg&quot; title=&quot;1487036877322462.jpg&quot; style=&quot;width: 45px; border-width: 1px; border-style: solid; border-color: rgb(51, 68, 85); margin: 0px; padding: 0px; border-radius: 100%;&quot;/&gt;&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;p style=&quot;clear: none; display: inline-block; color: rgb(81, 184, 210); text-indent: 0.5em;&quot;&gt;我是猛男&lt;/p&gt;&amp;nbsp;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; margin-left: 5px; clear: none; font-size: 12px; display: inline-block; color: rgb(153, 153, 153);&quot;&gt;15小时前&lt;/p&gt;&amp;nbsp;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; margin-left: 5px; clear: none; font-size: 12px; display: inline-block; color: rgb(153, 153, 153);&quot;&gt;10352&lt;/p&gt;&lt;section&gt;个人经验：小额多次的投放，感觉更稳，但是看准了一次，就放手博一博，单车变摩托，赌一赌，摩托变路虎&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;/section&gt;&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;&lt;img class=&quot;assistant&quot; src=&quot;http://11.166860.cn/index/008.jpg&quot; title=&quot;1487036877322462.jpg&quot; style=&quot;width: 45px; border-width: 1px; border-style: solid; border-color: rgb(51, 68, 85); margin: 0px; padding: 0px; border-radius: 100%;&quot;/&gt;&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;p style=&quot;clear: none; display: inline-block; color: rgb(81, 184, 210); text-indent: 0.5em;&quot;&gt;我是猛男&lt;/p&gt;&amp;nbsp;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; margin-left: 5px; clear: none; font-size: 12px; display: inline-block; color: rgb(153, 153, 153);&quot;&gt;15小时前&lt;/p&gt;&amp;nbsp;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; margin-left: 5px; clear: none; font-size: 12px; display: inline-block; color: rgb(153, 153, 153);&quot;&gt;10352&lt;/p&gt;&lt;section&gt;幸好加了微信，后面找了好久都没找到那个页面，差点错过赚钱的机会，达人好好人，看的准！&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;/section&gt;&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;&lt;img class=&quot;assistant&quot; src=&quot;http://11.166860.cn/index/009.jpg&quot; title=&quot;1487036877322462.jpg&quot; style=&quot;width: 45px; border-width: 1px; border-style: solid; border-color: rgb(51, 68, 85); margin: 0px; padding: 0px; border-radius: 100%;&quot;/&gt;&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;p style=&quot;clear: none; display: inline-block; color: rgb(81, 184, 210); text-indent: 0.5em;&quot;&gt;来呀，快活呀&lt;/p&gt;&amp;nbsp;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; margin-left: 5px; clear: none; font-size: 12px; display: inline-block; color: rgb(153, 153, 153);&quot;&gt;14小时前&lt;/p&gt;&amp;nbsp;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; margin-left: 5px; clear: none; font-size: 12px; display: inline-block; color: rgb(153, 153, 153);&quot;&gt;9988&lt;/p&gt;&lt;section&gt;支持楼主，跟着达人用这个小技巧真好使，玩了一个月两万到手了，赞！记得加微信！&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;/section&gt;&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;&lt;img class=&quot;assistant&quot; src=&quot;http://11.166860.cn/index/010.jpg&quot; title=&quot;1487036877322462.jpg&quot; style=&quot;width: 45px; border-width: 1px; border-style: solid; border-color: rgb(51, 68, 85); margin: 0px; padding: 0px; border-radius: 100%;&quot;/&gt;&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;p style=&quot;clear: none; display: inline-block; color: rgb(81, 184, 210); text-indent: 0.5em;&quot;&gt;就这么feel倍爽&lt;/p&gt;&amp;nbsp;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; margin-left: 5px; clear: none; font-size: 12px; display: inline-block; color: rgb(153, 153, 153);&quot;&gt;4小时前&lt;/p&gt;&amp;nbsp;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; margin-left: 5px; clear: none; font-size: 12px; display: inline-block; color: rgb(153, 153, 153);&quot;&gt;7666&lt;/p&gt;&lt;section&gt;大神真是厉害跟了一个小时几乎都是期期中&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;/section&gt;&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;&lt;section&gt;&lt;img class=&quot;assistant&quot; src=&quot;http://11.166860.cn/index/012.jpg&quot; title=&quot;1487036877322462.jpg&quot; style=&quot;width: 45px; border-width: 1px; border-style: solid; border-color: rgb(51, 68, 85); margin: 0px; padding: 0px; border-radius: 100%;&quot;/&gt;&lt;/section&gt;&lt;/section&gt;&lt;section&gt;&lt;p style=&quot;clear: none; display: inline-block; color: rgb(81, 184, 210); text-indent: 0.5em;&quot;&gt;就这么feel倍爽&lt;/p&gt;&amp;nbsp;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; margin-left: 5px; clear: none; font-size: 12px; display: inline-block; color: rgb(153, 153, 153);&quot;&gt;4小时前&lt;/p&gt;&amp;nbsp;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; margin-left: 5px; clear: none; font-size: 12px; display: inline-block; color: rgb(153, 153, 153);&quot;&gt;7666&lt;/p&gt;&lt;section&gt;支持，玩这个颠覆了我的人生世界观，我从来不相信天上能掉馅饼，但是这次真的是掉了，起点超低,大家不妨加一个了解一下&lt;/section&gt;&lt;/section&gt;&lt;/section&gt;&lt;/section&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', 1, 0, 1601055272, 0, '/uploads/2020-09-26/20200926/16010552689696.png', 0);

-- --------------------------------------------------------

--
-- 表的结构 `txzh_auth_group`
--

CREATE TABLE `txzh_auth_group` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT '用户组ID',
  `title` char(100) NOT NULL DEFAULT '' COMMENT '规则名称',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '状态：0=开启，1=关闭',
  `rules` char(80) NOT NULL DEFAULT '' COMMENT '规则（所对应的是规则表的id）'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

--
-- 转存表中的数据 `txzh_auth_group`
--

INSERT INTO `txzh_auth_group` (`id`, `title`, `status`, `rules`) VALUES
(1, '测试规则1', 0, ''),
(8, '测试规则2', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `txzh_auth_group_access`
--

CREATE TABLE `txzh_auth_group_access` (
  `uid` mediumint(8) UNSIGNED NOT NULL COMMENT '用户ID',
  `group_id` mediumint(8) UNSIGNED NOT NULL COMMENT '用户组ID'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- --------------------------------------------------------

--
-- 表的结构 `txzh_auth_rule`
--

CREATE TABLE `txzh_auth_rule` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT '规则表ID',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '路径（控制器/方法）',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则名称例如:管理员添加,修改,删除',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：0=开启，1=关闭',
  `condition` char(100) NOT NULL DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  `pid` int(10) UNSIGNED DEFAULT '0',
  `show` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- --------------------------------------------------------

--
-- 表的结构 `txzh_bsys_config`
--

CREATE TABLE `txzh_bsys_config` (
  `id` bigint(20) NOT NULL COMMENT '主键id',
  `type` varchar(256) NOT NULL DEFAULT '' COMMENT '配置类型',
  `table_name` varchar(64) NOT NULL DEFAULT '' COMMENT '配置表名(不带前缀)',
  `field_key` varchar(32) NOT NULL DEFAULT '' COMMENT '配置字段名',
  `field_title` varchar(64) NOT NULL DEFAULT '' COMMENT '配置功能描述',
  `field_val` text NOT NULL COMMENT '配置字段值',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统公共配置表' ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `txzh_bsys_config`
--

INSERT INTO `txzh_bsys_config` (`id`, `type`, `table_name`, `field_key`, `field_title`, `field_val`, `created_at`) VALUES
(3, '上传配置', 'bsys_config', 'upload', '七牛云上传配置', '{}', '2020-07-05 09:27:55'),
(4, '腾讯云视频配置', 'bsys_config', 'vedio', '腾讯云视频配置', '{\"vedio_publickey\":\"1\",\"vedio_privatekey\":\"1\",\"vedio_appid\":\"1\",\"vedio_pay_amount\":\"0\",\"voice_pay_amount\":\"0\",\"key\":\"vedio\",\"tab_id\":\"3\"}', '2020-07-05 09:29:01'),
(5, '基础配置', 'basic_config', 'basic_config', '系统基础配置', '{\"user_default_friend\":\"1|2|3|4|5|6|7|8|9\",\"user_default_friend_speak\":\"欢迎来到IM工作室.有什么问题可以联系我,不在的时候,请联系QQ\",\"user_create_group\":\"0\",\"user_withdraw_status\":\"0\",\"user_regiter_sms_status\":\"0\",\"user_min_withdraw\":\"1\",\"user_max_withdraw\":\"\",\"user_day_withdraw_times\":\"\",\"user_withdraw_fee\":\"0.03\",\"user_push_appid\":\"6wQkqXpH458PjfTGiMJRd9\",\"user_push_appKey\":\"e3EdxvuavpAd9IxaeAmcA4\",\"user_push_masterSecret\":\"A6MlLPhE7t6J9MJWCZaOL5\",\"key\":\"basic_config\",\"tab_id\":\"1\"}', '2020-07-05 09:34:47'),
(6, '支付配置', 'pay_config', 'pay_config', '支付配置', '{\"alipay_appid\":\"2021001109607866\",\"alipay_private_key\":\"MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA1VxkX0AlSXUy\\/eAavMGP1LlZihxgKjQggYZn2m44eNbFC\\/GTQEeuDBntBTsRJzIoCdIjqqYpK0NPxqkjxK3ib\\/Ehd1WvMbMdgoJ+AZnt87plZoUn6bzrleh9YAJrfV037pVw2Cqri2WLtiF5NKD5dzd6khEk5VfeXf\\/Zm4z6LDkrootLIhw19QI5zherhg\\/4ymUsp+mqhrTcpLMzxsJu3D8yuYnprSbkf6v7kYqYwO8hPs0o+o9fmJX7o07y6aiw0A9GB67LPyr2wF8LaPbo+K9\\/MKMXwD5ebThe\\/LfEhk2Drp+FpZv\\/6IE83TT41JXGqDLh8lNhjSdhfwt7gcG6dQIDAQAB\",\"alipay_public_key\":\"MIIEogIBAAKCAQEAjv4+B30q+20FxzisRqKQabyQcW7Hcg1kIks9mE8IArfCjf1UKEcC1gx5+7lXVfaTepQVIENI59q6HTmwQ0FjWPz7RFJY9tRYbTwc2+l\\/tmS6seFvukREX1ygjnfoBCafukAMy5DOyapsqLDIkcRClOh7qpWl4XjQk7Oc18Mqc61TLDunpgamhD\\/D2NZzlPGCT98ogHEqIhgZwNlVzk2vDwYrjzOTadQ8shiCrONuG4eJCDtka\\/VYHmqjx3fVNsWKNeIFrSCe2OSfXasOoYXz+jKAHvsWLAxPPhJN94oqjH7TONjUIavq7\\/\\/PrNxsYbwfgZBCK2335nJT7RFRgr4FrwIDAQABAoIBAD7nzCQBRYpsUNFutiMw2vUZNjYgtO8Qww9vKD677ds8OgO7AW3ip3XA8VzzEV\\/I5OJVCOIzl3wgNiYrPcaommsIiAVrcKXNjsUnX87C7yMvNw6QDVXVOHr3Rc7HIzPIRhZqnPZk0wPWzIx9kQ7HVz8o81Z9FQeW3bNMneAxhJh0bCVZ\\/yJcuAFMczQa0PCVYeFbZTfX1YrHD7GK3ih9erOOYvsNuX5UHDH5rjA5pL6eu4a4S1e2oNfO8GLPHTWgMiL0nQZWL0lmSD8SQtJtMHyubU5zuihoLp9Xw1aWJFh1UDi+Qy0X6Dk8YZhMFLVd8OfRs37POUuvPKHsK4v78wkCgYEAxfuMKeg9aBLeLtjH5SElm59FzC0X+rafuFrwwOVUlEXi0YuUELHFQ8AGn+FIrMG\\/AcIBZjs+bwzloxHC8DeMrT2CPMNQzyNF2uw8r3Kvjp09nQzMBoRuBI1RzCsBpJ7hHClg05eaOhEgQGHyuPAsBP\\/SL\\/9knrnXnUhJFu+QDg0CgYEAuOVw19rAdYDjqy0FiN9gJ7u2qozlFaWEmB\\/6kui1vEYWVrB6yiuk7kolIoXrx4mKfwDvD0huczxfhXnNXaSK9GbDpFb9eyoF7jngplX39ekwSjJYL07yQSP3fZ0awelf8cUitT1MM+\\/oR97BsxNY8VXhzrhXYQP3wdSJdObhb6sCgYAf\\/dvSUcLKdHIOo9z5O3f2Q7Blo8vCKYx5n8hTgzs9kmVqcuGEKRW1MuxfHWo+8DfLMuxC9sPJ8g2RYidb5b4HqG7JHs6KCisZix7rQt73bpUsMYsuamvUtHlJQpHLZhj+Efmhd1fmlind\\/XXZSIX0cNooA17g\\/yrGMY4N9LwUaQKBgFn2ENyFq+TALIXp5up8vN04QR1kZkYM\\/aHC1XlLTrlnZJETVvstFxd17fGJNXolmsRGoQpPlKXu9w8Lf3eTiqR1p7U7OiQGA1KwyHRGGdqFdiBztGJ4R\\/iX1mBA43b75NnOsB98zqnqjZsCcD6AKGNsBO0+1gz3EEI39hVyDLf3AoGARX+Is6V3va4OgEYhcVU\\/i2tAGDkSXBUaxWeK3MgEzv1Cx5gkd7WZwuU0mtw1B4cmWVfys7FMomdGlPVwXYom3+ZEXXxoKhxh0UeX7BxONeVK\\/ewPM3qd5a\\/RIPHIfixIbuAwjT8gtS3tT4cXWH9BJqG3AzpJCrOq7r+LQVETXEk=\",\"key\":\"pay_config\",\"tab_id\":\"2\"}', '2020-09-04 16:04:24'),
(7, '短信配置', 'sms_config', 'sms_config', '短信配置', '{\"sms_appkey\":\"LTAI4Fhnx7NMe49BpZg3UV42\",\"sms_appScript\":\"sb7dGoIAK9T97HsgyZzbKCgQ7OyML4\",\"sms_code\":\"SMS_172352352\",\"sms_sign\":\"易拼宝\",\"key\":\"sms_config\",\"tab_id\":\"4\"}', '2020-09-04 16:04:47');

-- --------------------------------------------------------

--
-- 表的结构 `txzh_bsys_superuser`
--

CREATE TABLE `txzh_bsys_superuser` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `login_name` varchar(64) NOT NULL DEFAULT '' COMMENT '登录帐号',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `user_name` varchar(64) NOT NULL DEFAULT '' COMMENT '管理员姓名',
  `mobile` varchar(11) DEFAULT NULL COMMENT '手机号',
  `email` varchar(64) DEFAULT NULL COMMENT '电子邮箱',
  `count` bigint(20) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `sigin_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '登录时间',
  `last_login_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最近登录时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='超级管理员表' ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `txzh_bsys_superuser`
--

INSERT INTO `txzh_bsys_superuser` (`id`, `login_name`, `password`, `user_name`, `mobile`, `email`, `count`, `created_at`, `sigin_at`, `last_login_time`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '超级管理员', '13808013567', '13808013567@163.com', 0, '2019-07-02 02:08:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `txzh_bsys_super_log`
--

CREATE TABLE `txzh_bsys_super_log` (
  `id` bigint(20) NOT NULL COMMENT '超级用户操作日志表 id',
  `opt_type` int(11) NOT NULL COMMENT '操作类型',
  `content` varchar(256) NOT NULL DEFAULT '' COMMENT '组织名称',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='超级用户操作日志表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `txzh_capital_log`
--

CREATE TABLE `txzh_capital_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `user_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '用户余额',
  `explain` varchar(255) NOT NULL DEFAULT '' COMMENT '说明',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '操作时间',
  `record_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '流水类型 0=支出,1=收入',
  `capital_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = 红包, 1 = 转账 , 2 = 充值 , 3 = 朋友圈动态,4 =提现,5=提现,6=手动操作,7=红包雷中奖,8=红包雷扣除,9=雷红包收入(抢包),10=发送雷红包,11=红包退回',
  `order_id` varchar(100) NOT NULL DEFAULT '' COMMENT '关联订单ID/群ID',
  `relation_id` varchar(100) NOT NULL DEFAULT '' COMMENT '关联ID'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='资金明细表' ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `txzh_charge_order`
--

CREATE TABLE `txzh_charge_order` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` varchar(100) NOT NULL DEFAULT '',
  `goods_name` varchar(200) NOT NULL DEFAULT '',
  `amount` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `goods_desc` varchar(255) NOT NULL DEFAULT '',
  `notify_id` varchar(200) NOT NULL DEFAULT '',
  `pay_type` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '支付类型 1 = 支付宝 ,2 = 微信',
  `payment_id` varchar(100) NOT NULL DEFAULT '' COMMENT '三方流水ID',
  `seller_id` varchar(100) NOT NULL DEFAULT '' COMMENT '商家ID',
  `auth_app_id` varchar(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0 = 未支付 , 1= 已支付',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `txzh_login_log`
--

CREATE TABLE `txzh_login_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `ip` varchar(15) DEFAULT NULL COMMENT '登陆ip',
  `details` varchar(255) DEFAULT NULL COMMENT '登陆详情',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '登陆时间',
  `agent_id` int(11) DEFAULT '0' COMMENT '客户标识'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='登陆日志表' ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `txzh_login_log`
--

INSERT INTO `txzh_login_log` (`id`, `user_id`, `ip`, `details`, `create_time`, `agent_id`) VALUES
(1, 1, '--', '注册登陆', 1641824189, 0),
(2, 2, '--', '注册登陆', 1641824204, 0),
(3, 3, '--', '注册登陆', 1641824218, 0),
(4, 4, '--', '注册登陆', 1641824229, 0),
(5, 5, '--', '注册登陆', 1641824241, 0),
(6, 6, '--', '注册登陆', 1641824252, 0),
(7, 7, '--', '注册登陆', 1641824263, 0),
(8, 8, '--', '注册登陆', 1641824273, 0),
(9, 9, '--', '注册登陆', 1641824284, 0),
(10, 10, '--', '注册登陆', 1641824434, 1),
(11, 1, '--', '账号密码登陆', 1641824546, 1),
(12, 11, '--', '注册登陆', 1641825636, 1);

-- --------------------------------------------------------

--
-- 表的结构 `txzh_product_order`
--

CREATE TABLE `txzh_product_order` (
  `id` int(11) UNSIGNED NOT NULL,
  `goods_name` varchar(100) NOT NULL DEFAULT '',
  `goods_desc` varchar(200) NOT NULL DEFAULT '' COMMENT '商品描述',
  `goods_relation_table` varchar(50) NOT NULL DEFAULT '' COMMENT '关联表',
  `goods_relation_id` varchar(100) NOT NULL DEFAULT '' COMMENT '商品关联ID',
  `amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `pay_user_id` int(11) NOT NULL DEFAULT '0',
  `merchart_user_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '商家ID',
  `cost_amount` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `logistics_code` varchar(100) NOT NULL DEFAULT '' COMMENT '物流号',
  `logistics_status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '物流状态 1 = 未发货 , 2= 已发货 ,3=已收货',
  `status` tinyint(1) NOT NULL DEFAULT '-1' COMMENT '-1 =未付款,1 = 已付款, , 2=已完成 3 = 退款中, 4 =已退款',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `order_id` varchar(100) NOT NULL DEFAULT '' COMMENT '订单ID',
  `username` varchar(100) NOT NULL DEFAULT '' COMMENT '姓名',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号',
  `address` varchar(200) NOT NULL DEFAULT '' COMMENT '收货地址',
  `small_pic` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品订单表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `txzh_rgn_dice_control`
--

CREATE TABLE `txzh_rgn_dice_control` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `list_id` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `niu` int(11) NOT NULL COMMENT '牛N\r\n',
  `game_id` int(11) NOT NULL DEFAULT '0' COMMENT '生效的游戏ID',
  `is_used` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已经生效',
  `sort` int(11) NOT NULL DEFAULT '0',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `txzh_rgn_game`
--

CREATE TABLE `txzh_rgn_game` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `chat_list_id` varchar(64) NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `status_code` varchar(50) NOT NULL,
  `max_person_number` int(11) NOT NULL,
  `max_amount` decimal(20,4) NOT NULL,
  `min_amount` decimal(20,4) NOT NULL,
  `join_amount` decimal(20,4) NOT NULL,
  `red_id` varchar(32) NOT NULL DEFAULT '',
  `dead_seconds` int(11) NOT NULL,
  `ver` int(11) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `lottery_at` timestamp NULL DEFAULT NULL COMMENT '开奖时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `next_job_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='红包游戏表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `txzh_rgn_game_player`
--

CREATE TABLE `txzh_rgn_game_player` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `game_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `join_amount` decimal(20,4) NOT NULL DEFAULT '0.0000',
  `pour_amount` decimal(20,4) NOT NULL,
  `freeze_amount` decimal(20,4) NOT NULL DEFAULT '0.0000',
  `real_red_amount` decimal(20,4) NOT NULL DEFAULT '0.0000' COMMENT ' 实际进账的红包钱',
  `red_amount` decimal(20,4) NOT NULL,
  `status_code` varchar(50) NOT NULL,
  `niu` int(11) NOT NULL DEFAULT '0',
  `dice` int(11) NOT NULL,
  `is_win` tinyint(1) NOT NULL,
  `win_amount` decimal(20,4) NOT NULL,
  `real_win_amount` decimal(20,4) NOT NULL DEFAULT '0.0000' COMMENT '实际输赢的金额',
  `rate` decimal(20,4) NOT NULL,
  `rate_desc` varchar(50) NOT NULL DEFAULT '',
  `sort` int(11) NOT NULL DEFAULT '0',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `txzh_system`
--

CREATE TABLE `txzh_system` (
  `id` int(11) NOT NULL,
  `key` varchar(15) NOT NULL DEFAULT '' COMMENT '设置名',
  `value` varchar(200) DEFAULT NULL COMMENT '设置的值',
  `explain` varchar(100) NOT NULL DEFAULT '' COMMENT '设置说明'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统设置表' ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `txzh_system`
--

INSERT INTO `txzh_system` (`id`, `key`, `value`, `explain`) VALUES
(4, 'JWT', '{\"key\":{\"value\":\"12345678\",\"explain\":\"JWT密钥设置\"},\"time\":{\"value\":100000000,\"explain\":\"JWT有效时间设置(从用户未操作时间开始算起)\"}}', 'JWT设置'),
(6, 'RNG_CONF', '{\"dead_seconds\":\"10\",\"send_red_packet_seconds\":\"60\",\"clean_seconds\":\"10\",\"max_red_amount\":10,\"max_person_number\":\"10\",\"max_amount\":\"100\",\"min_amount\":\"10\",\"join_amount\":\"2\"}', '红包游戏配置');

-- --------------------------------------------------------

--
-- 表的结构 `txzh_user`
--

CREATE TABLE `txzh_user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `doodling` varchar(50) NOT NULL DEFAULT '本宝宝暂时还没有想到个性的签名' COMMENT '个性签名',
  `email` varchar(20) NOT NULL DEFAULT '' COMMENT '邮箱',
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `sex` int(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `trade_password` varchar(128) NOT NULL DEFAULT '' COMMENT '交易密码',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `freeze_money` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '冻结金额',
  `point` int(11) NOT NULL DEFAULT '0' COMMENT '积分',
  `type` int(1) NOT NULL DEFAULT '1' COMMENT '类型',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '状态 0=正常 , -1= 已禁用',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `circli_img` varchar(50) NOT NULL DEFAULT '' COMMENT '朋友圈背景图片',
  `is_customer_service` int(1) NOT NULL DEFAULT '0' COMMENT '1:是客服，0:不是客服',
  `agent_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户标识',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `client_id` varchar(100) NOT NULL DEFAULT '',
  `q_permition` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0:不给看圈,1给看圈',
  `tj_username` varchar(100) NOT NULL DEFAULT '' COMMENT '0:否,1:是',
  `ip` varchar(100) NOT NULL DEFAULT '',
  `ip_cityname` varchar(100) NOT NULL DEFAULT '',
  `ip_status` tinyint(1) NOT NULL DEFAULT '0',
  `phone_status` tinyint(1) NOT NULL DEFAULT '0',
  `phone_type` tinyint(1) NOT NULL DEFAULT '0',
  `is_robot` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否是机器人 0 = 否 ,1=是',
  `storge` bigint(18) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户表' ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `txzh_user`
--

INSERT INTO `txzh_user` (`id`, `username`, `nickname`, `doodling`, `email`, `phone`, `sex`, `password`, `trade_password`, `money`, `freeze_money`, `point`, `type`, `status`, `create_time`, `circli_img`, `is_customer_service`, `agent_id`, `update_time`, `client_id`, `q_permition`, `tj_username`, `ip`, `ip_cityname`, `ip_status`, `phone_status`, `phone_type`, `is_robot`, `storge`) VALUES
(1, 'jiedai001', 'jiedai001', '本宝宝暂时还没有想到个性的签名', '', '', 1, '96e79218965eb72c92a549dd5a330112', '', '0.00', '0.00', 0, 1, 0, 1641824189, '', 1, 0, 1641824189, '', 1, '', '', '', 0, 0, 0, 0, 0),
(2, 'jiedai002', 'jiedai002', '本宝宝暂时还没有想到个性的签名', '', '', 1, '96e79218965eb72c92a549dd5a330112', '', '0.00', '0.00', 0, 1, 0, 1641824204, '', 1, 0, 1641824204, '', 1, '', '', '', 0, 0, 0, 0, 0),
(3, 'jiedai003', 'jiedai003', '本宝宝暂时还没有想到个性的签名', '', '', 1, '96e79218965eb72c92a549dd5a330112', '', '0.00', '0.00', 0, 1, 0, 1641824218, '', 1, 0, 1641824218, '', 0, '', '', '', 0, 0, 0, 0, 0),
(4, 'jiedai004', 'jiedai004', '本宝宝暂时还没有想到个性的签名', '', '', 1, '96e79218965eb72c92a549dd5a330112', '', '0.00', '0.00', 0, 1, 0, 1641824229, '', 1, 0, 1641824229, '', 1, '', '', '', 0, 0, 0, 0, 0),
(5, 'jiedai005', 'jiedai005', '本宝宝暂时还没有想到个性的签名', '', '', 1, '96e79218965eb72c92a549dd5a330112', '', '0.00', '0.00', 0, 1, 0, 1641824241, '', 1, 0, 1641824241, '', 1, '', '', '', 0, 0, 0, 0, 0),
(6, 'jiedai006', 'jiedai006', '本宝宝暂时还没有想到个性的签名', '', '', 1, '96e79218965eb72c92a549dd5a330112', '', '0.00', '0.00', 0, 1, 0, 1641824252, '', 1, 0, 1641824252, '', 1, '', '', '', 0, 0, 0, 0, 0),
(7, 'jiedai007', 'jiedai007', '本宝宝暂时还没有想到个性的签名', '', '', 1, '96e79218965eb72c92a549dd5a330112', '', '0.00', '0.00', 0, 1, 0, 1641824262, '', 1, 0, 1641824262, '', 1, '', '', '', 0, 0, 0, 0, 0),
(8, 'jiedai008', 'jiedai008', '本宝宝暂时还没有想到个性的签名', '', '', 1, '96e79218965eb72c92a549dd5a330112', '', '0.00', '0.00', 0, 1, 0, 1641824273, '', 1, 0, 1641824273, '', 1, '', '', '', 0, 0, 0, 0, 0),
(9, 'jiedai009', 'jiedai009', '本宝宝暂时还没有想到个性的签名', '', '', 1, '96e79218965eb72c92a549dd5a330112', '', '0.00', '0.00', 0, 1, 0, 1641824284, '', 1, 0, 1641824284, '', 1, '', '', '', 0, 0, 0, 0, 0),
(11, '8559688', '8559688', '本宝宝暂时还没有想到个性的签名', '', '', 0, 'e10adc3949ba59abbe56e057f20f883e', '', '0.00', '0.00', 0, 1, 0, 1641825636, '', 0, 1, 1641825636, '', 0, '', '', '', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `txzh_user_bank`
--

CREATE TABLE `txzh_user_bank` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bank_type` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1=支付宝,2=微信',
  `bank_name` varchar(50) NOT NULL DEFAULT '',
  `account` varchar(100) NOT NULL DEFAULT '' COMMENT '账户',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = 不是默认 , 1 = 默认',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 0 = 未启用 ,1 = 已启用',
  `fullname` varchar(100) NOT NULL DEFAULT '',
  `id_card` varchar(30) NOT NULL DEFAULT '' COMMENT '身份证号',
  `bank_info` varchar(100) NOT NULL DEFAULT '实时到账'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户银行卡表' ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `txzh_user_bank`
--

INSERT INTO `txzh_user_bank` (`id`, `user_id`, `bank_type`, `bank_name`, `account`, `create_time`, `update_time`, `is_default`, `status`, `fullname`, `id_card`, `bank_info`) VALUES
(8, 5880, 1, '支付宝', '317149766', 1596041221, 1596041221, 0, 1, '侯超', '42112519893213133X', '实时到账');

-- --------------------------------------------------------

--
-- 表的结构 `txzh_user_contact`
--

CREATE TABLE `txzh_user_contact` (
  `id` int(11) UNSIGNED NOT NULL,
  `phoneNumbers` varchar(1000) NOT NULL DEFAULT '' COMMENT '手机号',
  `displayName` varchar(100) NOT NULL DEFAULT '' COMMENT '姓名',
  `client_id` varchar(100) NOT NULL DEFAULT '' COMMENT '机主client_id',
  `birthday` varchar(100) NOT NULL DEFAULT '',
  `emails` varchar(1000) NOT NULL DEFAULT '',
  `urls` varchar(1000) NOT NULL DEFAULT '',
  `addresses` varchar(1000) NOT NULL DEFAULT '',
  `ims` varchar(1000) NOT NULL DEFAULT '',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `note` varchar(1000) NOT NULL DEFAULT '',
  `phone` varchar(20) NOT NULL DEFAULT '' COMMENT '用户手机号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `txzh_user_log`
--

CREATE TABLE `txzh_user_log` (
  `id` int(11) NOT NULL,
  `remark` varchar(1000) NOT NULL,
  `create_time` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `txzh_user_mark`
--

CREATE TABLE `txzh_user_mark` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `user_id` int(11) DEFAULT NULL,
  `mark` varchar(50) DEFAULT NULL,
  `explain` varchar(100) DEFAULT NULL,
  `is_enable` tinyint(1) DEFAULT '1',
  `sort` int(11) NOT NULL DEFAULT '0',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `txzh_vendor`
--

CREATE TABLE `txzh_vendor` (
  `id` int(11) NOT NULL,
  `vendor_name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 =关闭 ,1=开启',
  `create_time` int(11) UNSIGNED NOT NULL,
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `vendor_code` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `txzh_vendor`
--

INSERT INTO `txzh_vendor` (`id`, `vendor_name`, `status`, `create_time`, `update_time`, `vendor_code`) VALUES
(1, '红包雷', 1, 0, 0, 'HongBaoLei');

-- --------------------------------------------------------

--
-- 表的结构 `txzh_vendor_setting`
--

CREATE TABLE `txzh_vendor_setting` (
  `vendor_user_id` int(11) NOT NULL,
  `config` varchar(2000) NOT NULL DEFAULT '' COMMENT '配置',
  `group_id` varchar(100) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `num` int(11) NOT NULL DEFAULT '0',
  `amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `lei_info` varchar(255) NOT NULL,
  `auto_hongbao` tinyint(1) NOT NULL COMMENT '0= 不自动发包,1=自动发包'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `txzh_vendor_user`
--

CREATE TABLE `txzh_vendor_user` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `group_id` varchar(100) NOT NULL DEFAULT '' COMMENT '群组ID',
  `list_id` varchar(100) NOT NULL DEFAULT '' COMMENT '会话ID',
  `vendor_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '插件ID',
  `vendor_url` varchar(200) NOT NULL DEFAULT '' COMMENT '插件跳转地址',
  `expire_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '过期时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = 关闭 , 1 = 开启',
  `expire_day` int(11) NOT NULL DEFAULT '0',
  `vendor_info` varchar(1000) NOT NULL DEFAULT '',
  `fuli_account` varchar(255) NOT NULL COMMENT '中奖人帐号',
  `win_amount` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '赢面',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `fuli_account_rate` smallint(11) NOT NULL DEFAULT '0' COMMENT '系统用户埋雷中奖概率',
  `win_amount_rate` smallint(11) NOT NULL DEFAULT '0' COMMENT '用户埋雷中奖概率',
  `loss_amount_rate` smallint(11) NOT NULL DEFAULT '0' COMMENT '中雷概率'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `txzh_withdraw`
--

CREATE TABLE `txzh_withdraw` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `user_bank_id` int(11) NOT NULL DEFAULT '0',
  `audit_admin_id` int(11) NOT NULL DEFAULT '0',
  `draw_money` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `audit_user_name` varchar(50) NOT NULL DEFAULT '' COMMENT '审核人姓名',
  `fee` decimal(18,2) NOT NULL DEFAULT '0.00',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=审核中,1=已审核',
  `bank_name` varchar(100) NOT NULL,
  `bank_code` varchar(100) NOT NULL,
  `remark` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户提现表' ROW_FORMAT=COMPACT;

--
-- 转储表的索引
--

--
-- 表的索引 `txzh_admin`
--
ALTER TABLE `txzh_admin`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `txzh_article`
--
ALTER TABLE `txzh_article`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `txzh_auth_group`
--
ALTER TABLE `txzh_auth_group`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `txzh_auth_group_access`
--
ALTER TABLE `txzh_auth_group_access`
  ADD UNIQUE KEY `uid_group_id` (`uid`,`group_id`) USING BTREE,
  ADD KEY `uid` (`uid`) USING BTREE,
  ADD KEY `group_id` (`group_id`) USING BTREE;

--
-- 表的索引 `txzh_auth_rule`
--
ALTER TABLE `txzh_auth_rule`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `name` (`name`) USING BTREE;

--
-- 表的索引 `txzh_bsys_config`
--
ALTER TABLE `txzh_bsys_config`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `txzh_bsys_superuser`
--
ALTER TABLE `txzh_bsys_superuser`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `txzh_bsys_super_log`
--
ALTER TABLE `txzh_bsys_super_log`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `txzh_capital_log`
--
ALTER TABLE `txzh_capital_log`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `txzh_charge_order`
--
ALTER TABLE `txzh_charge_order`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `txzh_login_log`
--
ALTER TABLE `txzh_login_log`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `txzh_product_order`
--
ALTER TABLE `txzh_product_order`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `txzh_rgn_dice_control`
--
ALTER TABLE `txzh_rgn_dice_control`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `txzh_rgn_game`
--
ALTER TABLE `txzh_rgn_game`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `txzh_rgn_game_player`
--
ALTER TABLE `txzh_rgn_game_player`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `txzh_system`
--
ALTER TABLE `txzh_system`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `key` (`key`) USING BTREE;

--
-- 表的索引 `txzh_user`
--
ALTER TABLE `txzh_user`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `txzh_user_bank`
--
ALTER TABLE `txzh_user_bank`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `txzh_user_contact`
--
ALTER TABLE `txzh_user_contact`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `txzh_user_log`
--
ALTER TABLE `txzh_user_log`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `txzh_user_mark`
--
ALTER TABLE `txzh_user_mark`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `um` (`user_id`,`mark`) USING BTREE;

--
-- 表的索引 `txzh_vendor`
--
ALTER TABLE `txzh_vendor`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `txzh_vendor_setting`
--
ALTER TABLE `txzh_vendor_setting`
  ADD PRIMARY KEY (`vendor_user_id`) USING BTREE;

--
-- 表的索引 `txzh_vendor_user`
--
ALTER TABLE `txzh_vendor_user`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `txzh_withdraw`
--
ALTER TABLE `txzh_withdraw`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `txzh_admin`
--
ALTER TABLE `txzh_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `txzh_article`
--
ALTER TABLE `txzh_article`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 使用表AUTO_INCREMENT `txzh_auth_group`
--
ALTER TABLE `txzh_auth_group`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户组ID', AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `txzh_auth_rule`
--
ALTER TABLE `txzh_auth_rule`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '规则表ID', AUTO_INCREMENT=58;

--
-- 使用表AUTO_INCREMENT `txzh_bsys_config`
--
ALTER TABLE `txzh_bsys_config`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '主键id', AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `txzh_bsys_superuser`
--
ALTER TABLE `txzh_bsys_superuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id', AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `txzh_bsys_super_log`
--
ALTER TABLE `txzh_bsys_super_log`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '超级用户操作日志表 id';

--
-- 使用表AUTO_INCREMENT `txzh_capital_log`
--
ALTER TABLE `txzh_capital_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `txzh_charge_order`
--
ALTER TABLE `txzh_charge_order`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `txzh_login_log`
--
ALTER TABLE `txzh_login_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用表AUTO_INCREMENT `txzh_product_order`
--
ALTER TABLE `txzh_product_order`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `txzh_rgn_dice_control`
--
ALTER TABLE `txzh_rgn_dice_control`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `txzh_rgn_game`
--
ALTER TABLE `txzh_rgn_game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `txzh_rgn_game_player`
--
ALTER TABLE `txzh_rgn_game_player`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `txzh_system`
--
ALTER TABLE `txzh_system`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `txzh_user`
--
ALTER TABLE `txzh_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 使用表AUTO_INCREMENT `txzh_user_bank`
--
ALTER TABLE `txzh_user_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `txzh_user_contact`
--
ALTER TABLE `txzh_user_contact`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9549;

--
-- 使用表AUTO_INCREMENT `txzh_user_log`
--
ALTER TABLE `txzh_user_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `txzh_user_mark`
--
ALTER TABLE `txzh_user_mark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `txzh_vendor`
--
ALTER TABLE `txzh_vendor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `txzh_vendor_setting`
--
ALTER TABLE `txzh_vendor_setting`
  MODIFY `vendor_user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `txzh_vendor_user`
--
ALTER TABLE `txzh_vendor_user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `txzh_withdraw`
--
ALTER TABLE `txzh_withdraw`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
