-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015 年 10 朁E31 日 10:19
-- サーバのバージョン： 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cats_photo`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `cats`
--

CREATE TABLE IF NOT EXISTS `cats` (
  `cat_id` int(10) NOT NULL,
  `cat_name` varchar(100) NOT NULL,
  `user_id` int(10) NOT NULL,
  `cat_comment` varchar(200) NOT NULL,
  `profile_photo_url` varchar(100) DEFAULT NULL,
  `cat_count_good` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `cats`
--

INSERT INTO `cats` (`cat_id`, `cat_name`, `user_id`, `cat_comment`, `profile_photo_url`, `cat_count_good`) VALUES
(1, 'タロ', 1, 'しっぽが短いオスねこ。最近ちょっとお肉がついてきました！？', 'images/upload/20151031044357m9tcq0jh8o27oajpt3hh2rkr65.jpg', 5),
(2, 'ミー', 1, '毛がふさふさの子猫ちゃん。膝の上がお気に入りです。', 'images/upload/20151031044610m9tcq0jh8o27oajpt3hh2rkr65.jpg', 3),
(3, 'ヒーちゃん', 1, '首輪好きなヒーちゃん。首輪をはずすと若干ご機嫌斜めです。', 'images/upload/20151031045434m9tcq0jh8o27oajpt3hh2rkr65.jpg', 4),
(4, 'フカ', 1, '貫禄があるフカ。たぶんここあたりのボス猫です。', 'images/upload/20151031045037m9tcq0jh8o27oajpt3hh2rkr65.jpg', 15),
(5, 'タム', 1, 'いつも眠そうにしているタム。お年なのでお疲れ気味？', 'images/upload/20151031045200m9tcq0jh8o27oajpt3hh2rkr65.jpg', 1),
(6, 'マロン', 1, '子育て真っ最中。子猫といつも一緒にいます。', 'images/upload/20151031045402m9tcq0jh8o27oajpt3hh2rkr65.jpg', 10),
(7, 'エミル', 1, '美人ねこエミル。籠の中がいちばん落ち着くのかなー', 'images/upload/20151031045747m9tcq0jh8o27oajpt3hh2rkr65.jpg', 20),
(8, 'ムー', 1, 'ムーちゃん。いつもムスッとしていように見えますが、よくよく見ると愛嬌のある顔です。', 'images/upload/20151031091459ap0mqtnour9o3cqncebskbqfk6.jpg', 8);

-- --------------------------------------------------------

--
-- テーブルの構造 `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `photo_id` int(10) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `photo_comment` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `comments`
--

INSERT INTO `comments` (`photo_id`, `nickname`, `photo_comment`) VALUES
(15, 'nick350', 'セクシーショット！'),
(13, 'nick350', 'やっぱり籠の中が一番らしいです！'),
(13, 'ゲストユーザー', 'ゲストのコメント'),
(6, 'ゲストユーザー', '貫禄ありますね！'),
(9, 'ゲストユーザー', '子猫の写真もあげてください！'),
(9, 'nick350', '近々アップしますねー'),
(11, 'ゲストユーザー', '夕日と首輪の色がマッチしてきれいですね。'),
(4, 'ゲストユーザー', 'きゃわいい～'),
(1, 'ゲストユーザー', '少しぐらいお肉がついと方がかわいいですよー！');

-- --------------------------------------------------------

--
-- テーブルの構造 `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `photo_id` int(10) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `url` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `photos`
--

INSERT INTO `photos` (`photo_id`, `cat_id`, `url`) VALUES
(1, 1, 'images/upload/20151031044357m9tcq0jh8o27oajpt3hh2rkr65.jpg'),
(2, 1, 'images/upload/20151031044419m9tcq0jh8o27oajpt3hh2rkr65.jpg'),
(3, 1, 'images/upload/20151031044426m9tcq0jh8o27oajpt3hh2rkr65.jpg'),
(4, 2, 'images/upload/20151031044610m9tcq0jh8o27oajpt3hh2rkr65.jpg'),
(5, 3, 'images/upload/20151031044846m9tcq0jh8o27oajpt3hh2rkr65.jpg'),
(6, 4, 'images/upload/20151031045037m9tcq0jh8o27oajpt3hh2rkr65.jpg'),
(7, 4, 'images/upload/20151031045057m9tcq0jh8o27oajpt3hh2rkr65.jpg'),
(8, 5, 'images/upload/20151031045200m9tcq0jh8o27oajpt3hh2rkr65.jpg'),
(9, 6, 'images/upload/20151031045402m9tcq0jh8o27oajpt3hh2rkr65.jpg'),
(10, 2, 'images/upload/20151031045417m9tcq0jh8o27oajpt3hh2rkr65.jpg'),
(11, 3, 'images/upload/20151031045434m9tcq0jh8o27oajpt3hh2rkr65.jpg'),
(12, 7, 'images/upload/20151031045747m9tcq0jh8o27oajpt3hh2rkr65.jpg'),
(13, 7, 'images/upload/20151031045803m9tcq0jh8o27oajpt3hh2rkr65.jpg'),
(15, 7, 'images/upload/20151031045821m9tcq0jh8o27oajpt3hh2rkr65.jpg'),
(16, 8, 'images/upload/20151031091459ap0mqtnour9o3cqncebskbqfk6.jpg');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `mail` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`user_id`, `nickname`, `mail`, `password`) VALUES
(1, 'nick350', 'godspeed3e1@hotmail.co.jp', '$2y$10$MSFDLtn8jM1HmAw.V.SZsORjRErpj1OxQfDNGP/vHrQAeH.8HTwuq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cats`
--
ALTER TABLE `cats`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`photo_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cats`
--
ALTER TABLE `cats`
  MODIFY `cat_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `photo_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
