-- MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `recovery_code`;
CREATE TABLE `recovery_code` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Encoded recovery code',
  `deleted` tinyint(1) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL COMMENT 'Date and time in UTC',
  `created_at` datetime NOT NULL COMMENT 'Date and time in UTC',
  PRIMARY KEY (`id`),
  KEY `IDX_2C8D0584A76ED395` (`user_id`),
  CONSTRAINT `FK_2C8D0584A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL COMMENT 'Date and time in UTC',
  `created_at` datetime NOT NULL COMMENT 'Date and time in UTC',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_57698A6A5E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `role` (`id`, `name`, `deleted`, `hidden`, `updated_at`, `created_at`) VALUES
(1,	'guest',	0,	0,	now(),	now()),
(2,	'member',	0,	0,	now(),	now()),
(3,	'admin',	0,	0,	now(),	now()),
(4,	'superadmin',	0,	0,	now(),	now());

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Encoded password',
  `two_factor` tinyint(1) NOT NULL COMMENT '1 if 2FA is enabled',
  `two_factor_secret` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Secret for 2FA validation and authenticator app',
  `deleted` tinyint(1) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL COMMENT 'Date and time in UTC',
  `created_at` datetime NOT NULL COMMENT 'Date and time in UTC',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D6495E237E06` (`name`),
  KEY `IDX_8D93D649D60322AC` (`role_id`),
  CONSTRAINT `FK_8D93D649D60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user` (`id`, `role_id`, `name`, `pass`, `two_factor`, `two_factor_secret`, `deleted`, `hidden`, `updated_at`, `created_at`) VALUES
(1,	2,	'user',	'$2y$11$eVVKcwwsb1UP7RSvdea21OWGJM3cYLBKSoPlAowBa0uQHjkguRB.K',	0,	'',	0,	0,	now(),	now());
