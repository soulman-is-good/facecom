SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT=0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `activation_key` varchar(45) NOT NULL,
  `status` tinyint(1) unsigned DEFAULT '0',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Login table' AUTO_INCREMENT=2 ;

CREATE TABLE IF NOT EXISTS `advert_stack` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'пользователь-овнер',
  `type` int(11) NOT NULL COMMENT 'тип содержимого, 1-опрос',
  `content_id` int(11) NOT NULL COMMENT 'ссылка на содержимое',
  `date_added` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='LIFO-стэк для рекламы и опросов' AUTO_INCREMENT=11 ;

CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `create_date` int(11) NOT NULL,
  `update_date` int(11) NOT NULL,
  `current_photo` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;

CREATE TABLE IF NOT EXISTS `apps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caption` varchar(255) NOT NULL,
  `users` int(11) NOT NULL DEFAULT '0',
  `tn` varchar(255) NOT NULL DEFAULT '.jpg',
  `desc` text NOT NULL,
  `address` varchar(255) NOT NULL DEFAULT '.swf',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=99 ;

CREATE TABLE IF NOT EXISTS `bookmarks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '1-photo, 2-video, 3-entries, 4-people, 5-companies, 6-products',
  `content_id` int(11) NOT NULL,
  `added` int(11) NOT NULL COMMENT 'date added',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(256) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS `city` (
  `city_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(11) unsigned NOT NULL DEFAULT '0',
  `region_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`city_id`),
  KEY `country_id` (`country_id`),
  KEY `region_id` (`region_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15789521 ;

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tbl` varchar(20) NOT NULL,
  `text` mediumtext,
  `timestamp` int(11) DEFAULT NULL,
  `item_id` int(11) unsigned NOT NULL,
  `author_id` int(11) unsigned DEFAULT NULL,
  `owner_id` int(11) unsigned DEFAULT NULL,
  `likes` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='comments table' AUTO_INCREMENT=33 ;
DROP TRIGGER IF EXISTS `comment_likes_delete`;
DELIMITER //
CREATE TRIGGER `comment_likes_delete` BEFORE DELETE ON `comments`
 FOR EACH ROW BEGIN 
DELETE FROM `likes` WHERE `tbl`='comments' AND `item_id`=OLD.`id`;
END
//
DELIMITER ;

CREATE TABLE IF NOT EXISTS `country` (
  `country_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`country_id`),
  KEY `city_id` (`city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='ВАЖНО - не создавать страну с id 1' AUTO_INCREMENT=7716094 ;

CREATE TABLE IF NOT EXISTS `coupon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `discount_id` int(10) unsigned NOT NULL,
  `text` varchar(512) NOT NULL,
  `percent` int(10) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cost` varchar(64) DEFAULT NULL,
  `price` decimal(9,2) unsigned NOT NULL,
  `limit` int(10) unsigned DEFAULT NULL,
  `limit_per_user` int(10) unsigned DEFAULT NULL,
  `created_at` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `discount_id` (`discount_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

CREATE TABLE IF NOT EXISTS `coupon_bought` (
  `user_id` int(10) unsigned NOT NULL,
  `coupon_id` int(10) unsigned NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`coupon_id`),
  KEY `coupon_id` (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `currency` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

CREATE TABLE IF NOT EXISTS `cv_counters` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cv_id` int(10) NOT NULL,
  `all_counts` int(10) NOT NULL,
  `new_counts` int(10) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS `cv_employment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_empl` int(10) NOT NULL,
  `empl_descr` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

CREATE TABLE IF NOT EXISTS `cv_prof_field` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_prof_field` int(10) NOT NULL,
  `prof_description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_prof_field` (`id_prof_field`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

CREATE TABLE IF NOT EXISTS `discount` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `office_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `text` varchar(512) NOT NULL,
  `rules` text NOT NULL,
  `starts_at` int(10) unsigned NOT NULL,
  `ends_at` int(10) unsigned NOT NULL,
  `images` varchar(1024) NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `category_id` (`office_id`),
  KEY `office_id` (`office_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

CREATE TABLE IF NOT EXISTS `discount_category` (
  `discount_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`discount_id`,`category_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `discount_range` (
  `discount_id` int(10) unsigned NOT NULL,
  `city_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`discount_id`,`city_id`),
  KEY `city_id` (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `faculty` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT 'Faculty name',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Faculties' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `filemarks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_id` varchar(50) NOT NULL,
  `lat` varchar(64) NOT NULL COMMENT 'Lat',
  `long` varchar(64) NOT NULL,
  `zoom` varchar(16) DEFAULT '12' COMMENT 'map zoom',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `file_id` (`file_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

CREATE TABLE IF NOT EXISTS `files` (
  `id` varchar(50) NOT NULL,
  `extension` varchar(10) NOT NULL,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `images` (
  `id` varchar(50) NOT NULL,
  `extension` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `interviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'идентификатор',
  `owner` int(11) NOT NULL COMMENT 'id владельца',
  `name` varchar(255) NOT NULL COMMENT 'имя (предположительно уникальное для каждого пользователя)',
  `title` varchar(255) NOT NULL COMMENT 'Заголовок, который увидит юзер',
  `status` int(11) NOT NULL COMMENT 'текущий статус, 1-запущен, 0-остановлен, 2-черновик',
  `questions` text NOT NULL COMMENT 'тут сериализованная структура вопросов и ответов',
  `targeting` text NOT NULL COMMENT 'Сериализованная структура критериев аудитории',
  `price` int(11) NOT NULL COMMENT 'цена одного вопроса',
  `limit` int(11) NOT NULL DEFAULT '-1' COMMENT 'лимит по средствам, выделяемым на опрос, -1 - безлимит',
  `spent` int(11) NOT NULL DEFAULT '0' COMMENT 'потрачено',
  `crt` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'CRT',
  `shows` int(11) NOT NULL DEFAULT '0' COMMENT 'количество показов',
  `activity_log` text NOT NULL COMMENT 'сериализованная структура активности опроса (с какого по какое работал, может еще что)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Пока абстрактная таблица для опросов' AUTO_INCREMENT=7 ;

CREATE TABLE IF NOT EXISTS `interview_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `interview_id` int(11) NOT NULL,
  `question` int(11) NOT NULL,
  `answer` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `interview_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interview_id` int(11) NOT NULL,
  `question` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `answers` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `office_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `description` text NOT NULL,
  `price` decimal(11,2) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`office_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS `items_category` (
  `item_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`item_id`,`category_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `prof_area_id` int(11) unsigned NOT NULL,
  `currency_id` int(11) unsigned NOT NULL,
  `salary` int(11) unsigned NOT NULL,
  `experience_id` int(11) unsigned NOT NULL,
  `region_id` int(11) unsigned NOT NULL,
  `date` int(11) NOT NULL,
  `office_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `prof_area_id` (`prof_area_id`),
  KEY `experience_id` (`experience_id`),
  KEY `region_id` (`region_id`),
  KEY `currency_id` (`currency_id`),
  KEY `office_id` (`office_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

CREATE TABLE IF NOT EXISTS `jobstates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT 'Job name',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='General Job states table' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `jobs_employment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS `jobs_employment_relations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `job_id` int(10) unsigned NOT NULL,
  `employment_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `job_id` (`job_id`),
  KEY `employment_id` (`employment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

CREATE TABLE IF NOT EXISTS `jobs_experience` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `priority` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS `jobs_prof_area` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS `language` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `abbr` varchar(16) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `abbr` (`abbr`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Language description table' AUTO_INCREMENT=4 ;

CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tbl` varchar(20) NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

CREATE TABLE IF NOT EXISTS `office` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `avatar` varchar(50) DEFAULT NULL,
  `background` varchar(50) DEFAULT NULL,
  `bgposition` varchar(16) DEFAULT NULL,
  `about` text,
  `city_id` int(10) unsigned DEFAULT NULL,
  `address` varchar(1024) DEFAULT NULL,
  `contacts` text,
  `website` varchar(255) DEFAULT NULL,
  `lat` varchar(50) DEFAULT NULL,
  `long` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `city_id` (`city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Office table' AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `album_id` int(11) unsigned NOT NULL,
  `file` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `upload_date` int(11) NOT NULL,
  `place_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `album_id` (`album_id`),
  KEY `place_id` (`place_id`),
  KEY `file` (`file`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

CREATE TABLE IF NOT EXISTS `placemarks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `lat` varchar(64) NOT NULL COMMENT 'Lat',
  `long` varchar(64) NOT NULL,
  `zoom` varchar(16) DEFAULT '12' COMMENT 'map zoom',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_idx` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Placemark table' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned DEFAULT NULL COMMENT 'id расшаренного поста',
  `post_type` varchar(20) DEFAULT NULL,
  `author_type` varchar(20) DEFAULT NULL,
  `owner_type` varchar(20) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `creation_date` int(11) NOT NULL,
  `content` mediumtext NOT NULL,
  `multimedia` text,
  `status` int(1) NOT NULL DEFAULT '1',
  `likes` int(11) unsigned NOT NULL DEFAULT '0',
  `shares` int(11) unsigned NOT NULL DEFAULT '0',
  `hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=92 ;
DROP TRIGGER IF EXISTS `post_comments_delete`;
DELIMITER //
CREATE TRIGGER `post_comments_delete` BEFORE DELETE ON `posts`
 FOR EACH ROW BEGIN 
DELETE FROM `comments` WHERE `tbl`='posts' AND `item_id`=OLD.`id`;
DELETE FROM `likes` WHERE `tbl`='posts' AND `item_id`=OLD.`id`;
END
//
DELIMITER ;

CREATE TABLE IF NOT EXISTS `posts_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `posts_id` int(10) unsigned NOT NULL,
  `filename` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `type` varchar(20) NOT NULL,
  `upload_date` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_id` (`posts_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

CREATE TABLE IF NOT EXISTS `posts_old` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shared` int(11) NOT NULL DEFAULT '0',
  `content` text,
  `status` tinyint(1) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `author_id` int(11) unsigned NOT NULL,
  `owner_id` int(11) NOT NULL,
  `master_id` int(11) NOT NULL DEFAULT '0',
  `likes` int(11) NOT NULL,
  `shares` int(11) NOT NULL,
  `unique_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_hash` (`unique_hash`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Posts table' AUTO_INCREMENT=234 ;

CREATE TABLE IF NOT EXISTS `sys_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

CREATE TABLE IF NOT EXISTS `temporary_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `md5file` varchar(255) DEFAULT NULL COMMENT 'MD5 file hash',
  `filename` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `upload_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=115 ;

CREATE TABLE IF NOT EXISTS `translation` (
  `message` varbinary(255) NOT NULL,
  `translation` varchar(255) NOT NULL,
  `language` varchar(5) NOT NULL,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`message`,`language`,`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `university` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT 'University title',
  `place_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `place_idfx_idx` (`place_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Universities table' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `activation_key` varchar(45) NOT NULL,
  `role` varchar(16) NOT NULL DEFAULT 'user',
  `status` tinyint(1) unsigned DEFAULT '0',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Login table' AUTO_INCREMENT=16 ;

CREATE TABLE IF NOT EXISTS `user_apps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `app_id` int(11) NOT NULL,
  `added` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_apps_ibfk_1` (`app_id`),
  KEY `user_apps_ibfk_2` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

CREATE TABLE IF NOT EXISTS `user_cvs` (
  `cv_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `cv_avatar` varchar(255) DEFAULT NULL,
  `desire_position` varchar(255) NOT NULL,
  `professional_field` int(10) NOT NULL,
  `salary` int(10) NOT NULL,
  `employment` int(10) NOT NULL,
  `creation_date` datetime NOT NULL,
  `last_edited_date` datetime NOT NULL,
  KEY `cv_id` (`cv_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS `user_friends` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `friend_id` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'is confirmed',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`friend_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='User friends table' AUTO_INCREMENT=21 ;

CREATE TABLE IF NOT EXISTS `user_profile` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `city_id` int(10) unsigned NOT NULL,
  `avatar` varchar(255) DEFAULT NULL COMMENT 'User avatar',
  `background` varchar(255) DEFAULT NULL COMMENT 'User background picture',
  `address` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL COMMENT 'Imya',
  `second_name` varchar(255) NOT NULL COMMENT 'Familiya',
  `third_name` varchar(255) NOT NULL COMMENT 'Otchestvo',
  `birth_date` int(10) unsigned NOT NULL,
  `languages` varchar(128) DEFAULT NULL,
  `family` tinyint(1) NOT NULL COMMENT 'Semeynoe polozhenie',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `activities` text COMMENT 'Deyatelnost',
  `interests` text COMMENT 'Interesi',
  `music` text COMMENT 'Lubimaya musica',
  `quotes` text COMMENT 'Lubimiye citati',
  `about` text COMMENT 'O sebe',
  PRIMARY KEY (`id`,`user_id`),
  KEY `user_id` (`user_id`),
  KEY `city_id` (`city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='User profile' AUTO_INCREMENT=16 ;

CREATE TABLE IF NOT EXISTS `user_school` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `year_from` int(4) unsigned NOT NULL,
  `year_till` int(4) unsigned NOT NULL,
  `class_title` varchar(255) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='User''s schools' AUTO_INCREMENT=7 ;

CREATE TABLE IF NOT EXISTS `user_stat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `user_agent` varchar(45) DEFAULT NULL,
  `created_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User table statistics' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `user_university` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL COMMENT 'University title',
  `faculty` varchar(255) NOT NULL,
  `year_from` int(4) unsigned NOT NULL,
  `year_till` int(4) unsigned NOT NULL,
  `form` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'study form 0-daily',
  `state` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'grade',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `userfk_idx` (`user_id`),
  KEY `univerfk_idx` (`title`),
  KEY `facility_idx` (`faculty`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='User''s univercities' AUTO_INCREMENT=4 ;

CREATE TABLE IF NOT EXISTS `user_work` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `work` varchar(255) NOT NULL COMMENT 'work name',
  `state` varchar(255) NOT NULL COMMENT 'job state',
  `city_id` int(10) unsigned DEFAULT NULL COMMENT 'city name',
  `year_from` int(4) unsigned NOT NULL,
  `year_till` int(4) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `userfk_idx1` (`user_id`),
  KEY `workfk_idx1` (`work`),
  KEY `statefk_idx1` (`state`),
  KEY `placekf_idx1` (`city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='User''s works' AUTO_INCREMENT=9 ;

CREATE TABLE IF NOT EXISTS `videos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `upload_date` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

CREATE TABLE IF NOT EXISTS `workplaces` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT 'work place organization name',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Working places for users.' AUTO_INCREMENT=1 ;


ALTER TABLE `albums`
  ADD CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `city`
  ADD CONSTRAINT `city_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `coupon`
  ADD CONSTRAINT `coupon_ibfk_1` FOREIGN KEY (`discount_id`) REFERENCES `discount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `coupon_bought`
  ADD CONSTRAINT `coupon_bought_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `coupon_bought_ibfk_2` FOREIGN KEY (`coupon_id`) REFERENCES `coupon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `discount`
  ADD CONSTRAINT `discount_ibfk_3` FOREIGN KEY (`office_id`) REFERENCES `office` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `discount_category`
  ADD CONSTRAINT `discount_category_ibfk_1` FOREIGN KEY (`discount_id`) REFERENCES `discount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `discount_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `discount_range`
  ADD CONSTRAINT `discount_range_ibfk_1` FOREIGN KEY (`discount_id`) REFERENCES `discount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `discount_range_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `items_category`
  ADD CONSTRAINT `items_category_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`prof_area_id`) REFERENCES `jobs_prof_area` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jobs_ibfk_2` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jobs_ibfk_3` FOREIGN KEY (`office_id`) REFERENCES `office` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `jobs_employment_relations`
  ADD CONSTRAINT `jobs_employment_relations_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jobs_employment_relations_ibfk_2` FOREIGN KEY (`employment_id`) REFERENCES `jobs_employment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `office`
  ADD CONSTRAINT `office_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `office_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `photos_ibfk_2` FOREIGN KEY (`file`) REFERENCES `files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `placemarks`
  ADD CONSTRAINT `user_idx` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `posts_files`
  ADD CONSTRAINT `posts_files_ibfk_1` FOREIGN KEY (`posts_id`) REFERENCES `posts_old` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `posts_old`
  ADD CONSTRAINT `author_id` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `university`
  ADD CONSTRAINT `place_idfx` FOREIGN KEY (`place_id`) REFERENCES `placemarks` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `user_apps`
  ADD CONSTRAINT `user_apps_ibfk_1` FOREIGN KEY (`app_id`) REFERENCES `apps` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `user_friends`
  ADD CONSTRAINT `user_friends_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_profile_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`);

ALTER TABLE `user_school`
  ADD CONSTRAINT `user_school_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `user_stat`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `user_university`
  ADD CONSTRAINT `user_university_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `user_work`
  ADD CONSTRAINT `userfk1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_work_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`);

ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
