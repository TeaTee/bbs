-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2019 年 8 月 11 日 19:29
-- サーバのバージョン： 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `BBS`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(144) NOT NULL,
  `imgName` varchar(256) NOT NULL,
  `posted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `message`, `imgName`, `posted_at`, `comment_id`) VALUES
(1, 0, 'こんにちは、花太郎です。', 'abc.jpg', '2019-08-11 02:07:22', 0),
(2, 4, 'こんにちは、山次郎です', '', '2019-08-11 02:14:22', 0),
(3, 0, 'おはようございます', '', '2019-08-11 11:21:14', 0),
(4, 0, '今日ははははははははははははは', '', '2019-08-11 11:46:35', 3),
(5, 0, 'あらま〜', '', '2019-08-11 12:08:00', 0),
(6, 0, 'なんでやねん', '', '2019-08-11 12:23:44', 4),
(7, 0, 'せみんみんみんみんミンミンミンセミん', '2019-08-11_12-25-10_A_cherryBlossom.jpg', '2019-08-11 12:25:10', 5),
(8, 0, 'ありがとう', '', '2019-08-11 19:06:58', 4),
(9, 0, 'どうしたの', '', '2019-08-11 19:07:11', 5),
(10, 0, '今後の課題\r\n・MVCモデル\r\n・オブジェクト指向型プログラム\r\n・人に見せられるコード\r\n・わかりやすい変数・関数\r\n・疲れた〜', '2019-08-11_21-22-06A_cherryBlossom.jpg', '2019-08-11 21:22:06', 9),
(11, 0, '初めまして。\r\n私は「邪馬　二朗（やま　じろう）」と申します。\r\n同じ名前だったので、ついお声がけさせていただきました。\r\nどうぞよろしくお願いいたします。', '2019-08-11_21-24-26A_cherryBlossom.jpg', '2019-08-11 21:24:26', 2),
(12, 0, 'できてないんか〜い', '2019-08-11_21-33-40A_cherryBlossom.jpg', '2019-08-11 21:33:40', 2),
(13, 0, 'こんばんは', '2019-08-11_23-15-08A_cherryBlossom.jpg', '2019-08-11 23:15:08', 5),
(14, 0, '清く正しく美しく', '2019-08-12_01-13-47A_cherryBlossom.jpg', '2019-08-12 01:13:47', 3);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(35) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'abcdefg', 'abcdefg@hijklmn.com', '$2y$10$CgfuZxsp2CrwY1LTQtShL.awG8nDwo9p/6Vp/61a1I/qlDsxHBj6S'),
(2, 'abcdefg', 'abc.def@gmail.com', '$2y$10$/nhu2b83buJLDm1FRMtKTugEjDyE9U/XgRCcb9wE0DHluXrUIRbve'),
(3, '123456', 'asdfghjk@gmail.com', '$2y$10$lqEAD7QAumDhMAuamuwwT.epzWL.s0lUsrQzL2t2hLVVknpkGCgTy'),
(4, 'asdfgh', 'abcdef@gmail.com', '$2y$10$mHUNFCUVy3YZ9a7eIAufMuw/yjmdPTox8Pgub2WlKesnA0mmCyptG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
