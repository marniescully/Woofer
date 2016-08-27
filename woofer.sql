-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Aug 12, 2016 at 02:04 PM
-- Server version: 5.5.51-MariaDB
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `marniesc_p2_marniescully_biz`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `created`, `modified`, `user_id`, `content`) VALUES
(1, 1382562138, 1382562138, 8, 'I can hear Mommy say "Come Buddha!" but sometimes I pretend that I don''t hear her. I feel that I can come when I want to.  Am I right? Who''s with me? '),
(2, 1382562535, 1382562535, 7, 'Once I ate bear poop and then I got parasites. Now Mommy is afraid of bears in the yard. I''m sorry. '),
(3, 1382562600, 1382562600, 9, 'I love eating bathroom garbage! You never know what you''ll find!'),
(4, 1383001475, 1383001475, 8, 'Daddy cleaned the blankets today and now I have to stink ''em up all over again.'),
(5, 1383003321, 1383003321, 8, 'The only thing I don''t eat is lettuce or spinach because I don''t like anything like grass.'),
(6, 1383167683, 1383167683, 7, 'I miss my teeth'),
(7, 1383175336, 1383175336, 7, 'Make sure to look under all blankets before sitting. You never know when I''ll be under there.'),
(8, 1383175388, 1383175388, 7, 'Max gets on my nerves. There, I said it.'),
(9, 1383175436, 1383175436, 7, 'I miss the times when it was just Mommy and Daddy and me. Buddha''s ok when they aren''t around. I like being the only dog ''cause I''m special. '),
(10, 1383445942, 1383445942, 9, 'I eat poop and I''m not sorry. \r\n'),
(13, 1383520552, 1383520552, 9, 'I pooped on the living room floor tonight. Haha!'),
(14, 1383521552, 1383521552, 34, 'I hate these children. They always try to grab me. But I do like butcher bones.'),
(15, 1383521733, 1383521733, 34, 'I really miss the farm where I was born.'),
(16, 1383522229, 1383522229, 34, 'I love spending time with my daddy in the backyard. I always feel extra happy there for some reason.'),
(19, 1383602573, 1383602573, 7, 'When mommy isn''t looking, I like to pee on the dog bed in her office.'),
(23, 1383799610, 1383799610, 44, 'I used to love to poop in the dining room! That got me lots of attention!'),
(24, 1383799642, 1383799642, 44, 'If I scream like a cat, people jump!'),
(25, 1383800056, 1383800056, 45, 'I love to collect hair in my mouth at my gums because it smells so good.'),
(26, 1383811355, 1383811355, 46, 'I peed on a lil girl''s leg at the dog park. '),
(27, 1384825575, 1384825575, 47, 'Test\r\ntest'),
(28, 1384825591, 1384825591, 47, 'test test\r\ntest\r\ntest'),
(29, 1384906739, 1384906739, 9, 'Hope you had a good time woofing Xin!');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `bio` text NOT NULL,
  `age` int(2) NOT NULL,
  `timezone` varchar(255) NOT NULL,
  `avatar` varchar(25) NOT NULL DEFAULT 'DancingSnoopy_sm.jpg',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `created`, `modified`, `token`, `password`, `last_login`, `first_name`, `last_name`, `email`, `location`, `bio`, `age`, `timezone`, `avatar`) VALUES
(7, 1382296785, 1382296785, '9700936d8bc265c70ec580d280fa117dfa59faff', '654f1725958ba4e7e1a032632ada53b38cf24708', 0, 'Pinky', 'Scully', 'pinky@dogmail.com', 'PA', 'I am the oldest and therefore the best of all the dogs. I will be 14 in March. I don''t have many teeth left, but I can still chew a bone.', 13, 'America/New_York', '7.JPG'),
(8, 1382296858, 1382296858, '3e81a14eec180247ffe6685cac836611a2b08dc9', '74ac8dd8948eb73443ac807cd3861fc673492b56', 0, 'Buddha', 'Scully', 'buddha@dogmail.com', 'Poconos, PA', 'I am a little angel. I am turning 12 on November 10th. I have arthritis, but I still get around pretty well. I love toys! Do you?', 11, 'America/New_York', '8.JPG'),
(9, 1382296882, 1382296882, 'd60c7fa8334781a291c4c0ef91a93382037e2c13', 'ac86bf96808cf92b2e6bc80b349341d158b4beb2', 0, 'Max', 'Scully', 'max@dogmail.com', 'PA', 'I am a sweet pug, but I''m naughty. I like to do disgusting things.', 9, 'America/New_York', '9.jpg'),
(34, 1383520834, 1383520834, '33f25b09fb867d89f5995de5348927c5e04034e6', '52758d5d9a6b185cae70d0d18e9182eea1b64a89', 0, 'Charlie', 'Cosme', 'edmon3@hotmail.com', 'Reading, PA', 'I live in a junkyard ', 1, 'America/New_York', '34.JPG'),
(44, 1383784627, 1383784627, 'd14da7d2b4188bc2d63406a4a22162f6573e287e', '854ab9b9d968465c2b67b2f8ff453ea12ff6edfe', 0, 'Andy', 'Anson', 'pugcharlie@verizon.net', 'NE PA', 'I love to spin in circles!', 6, 'America/New_York', '44.jpg'),
(45, 1383787884, 1383787884, 'da472261ad59f041b381fe8974fdc61d2bc02f18', 'b42fce0fc60b9a3f1369805e316f9cc548bc9e32', 0, 'Pugsley', 'Anson', 'pugcharlie@me.com', 'NE PA', 'I live with Andy and I''m a good boy.', 10, 'America/New_York', '45.jpg'),
(46, 1383795541, 1383795541, 'b5767c310f2b03ee8696c65b9d54c2ea82b31f06', '6a18f49ee5901f3bdc0da1318d872cea8449aa48', 0, 'Sally', 'Doggie', 'Sally@dogmail.com', 'NYC ', 'I am a pretty princess', 5, 'America/New_York', '46.jpg'),
(47, 1384825553, 1384825553, 'b222a8bdd795923d8b724a2a7970686f4a0cc377', '28098697728ef76f595ecae3ae493ba1e85aeda0', 0, 'Xin', 'Xin', '123@gmail.com', 'Test 1', 'Test 2', 0, 'America/New_York', '47.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users_users`
--

CREATE TABLE IF NOT EXISTS `users_users` (
  `user_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'follower',
  `user_id_followed` int(11) NOT NULL COMMENT 'followed',
  PRIMARY KEY (`user_user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `users_users`
--

INSERT INTO `users_users` (`user_user_id`, `created`, `user_id`, `user_id_followed`) VALUES
(8, 1382566401, 8, 7),
(9, 1382566402, 8, 9),
(21, 1383459529, 9, 25),
(22, 1383521583, 34, 7),
(23, 1383521588, 34, 8),
(24, 1383521591, 34, 9),
(26, 1383617867, 9, 34),
(27, 1383635955, 9, 37),
(29, 1383726857, 7, 40),
(30, 1383726869, 7, 41),
(31, 1383792257, 7, 8),
(32, 1383794074, 9, 43),
(33, 1383794078, 9, 44),
(34, 1383794082, 9, 45),
(35, 1383799722, 44, 8),
(36, 1383799725, 44, 9),
(37, 1383799731, 44, 7),
(40, 1384906467, 9, 47),
(41, 1387688903, 9, 7);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_users`
--
ALTER TABLE `users_users`
  ADD CONSTRAINT `users_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
