-- Mysql Backup of mdl_gallery_core
-- Date 2018-10-30T15:35:07+01:00
-- Backup by 

DROP TABLE IF EXISTS `gallery_core_gallery`;
CREATE TABLE `gallery_core_gallery` ( 
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
	`default_gallery_image_id` INT UNSIGNED NULL, 
	`order_index` INT UNSIGNED NULL, 
	`online` TINYINT UNSIGNED NULL, 
	`last_mod_date` DATETIME NULL, 
	`last_mod_by` VARCHAR(255) NULL, 
	`created_date` DATETIME NULL, 
	`created_by` VARCHAR(255) NULL, 
	`gallery_group_id` INT UNSIGNED NULL, 
	`password` VARCHAR(255) NULL, 
	`last_mod` DATETIME NULL, 
	`created` DATETIME NULL
	, PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci ;
ALTER TABLE `gallery_core_gallery` ADD INDEX `gallery_core_gallery_index_1` (`default_gallery_image_id`);
ALTER TABLE `gallery_core_gallery` ADD INDEX `gallery_core_gallery_index_2` (`gallery_group_id`);

INSERT INTO `gallery_core_gallery` (`id`, `default_gallery_image_id`, `order_index`, `online`, `last_mod_date`, `last_mod_by`, `created_date`, `created_by`, `gallery_group_id`, `password`, `last_mod`, `created`) 
VALUES ( '1',  NULL,  '10',  '1',  NULL,  NULL,  NULL,  NULL,  NULL,  NULL,  '2018-10-29 16:29:29',  '2018-10-29 16:29:29');

DROP TABLE IF EXISTS `gallery_core_gallery_group`;
CREATE TABLE `gallery_core_gallery_group` ( 
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
	`online` TINYINT UNSIGNED NULL, 
	`lft` INT UNSIGNED NULL, 
	`rgt` INT UNSIGNED NULL
	, PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci ;


DROP TABLE IF EXISTS `gallery_core_gallery_group_t`;
CREATE TABLE `gallery_core_gallery_group_t` ( 
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
	`title` VARCHAR(255) NULL, 
	`path_part` VARCHAR(255) NULL, 
	`intro` VARCHAR(255) NULL, 
	`file_title_image` VARCHAR(255) NULL, 
	`gallery_group_id` INT UNSIGNED NULL, 
	`n2n_locale` VARCHAR(12) NULL
	, PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci ;
ALTER TABLE `gallery_core_gallery_group_t` ADD INDEX `gallery_core_gallery_group_t_index_1` (`gallery_group_id`);


DROP TABLE IF EXISTS `gallery_core_gallery_image`;
CREATE TABLE `gallery_core_gallery_image` ( 
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
	`file_image` VARCHAR(255) NULL, 
	`gallery_id` INT UNSIGNED NULL, 
	`order_index` INT UNSIGNED NULL, 
	`created_date` DATETIME NULL, 
	`created_by` VARCHAR(255) NULL, 
	`last_mod_date` DATETIME NULL, 
	`last_mod_by` VARCHAR(255) NULL, 
	`created` DATETIME NULL, 
	`last_mod` DATETIME NULL
	, PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci ;
ALTER TABLE `gallery_core_gallery_image` ADD INDEX `gallery_core_gallery_image_index_1` (`gallery_id`);

INSERT INTO `gallery_core_gallery_image` (`id`, `file_image`, `gallery_id`, `order_index`, `created_date`, `created_by`, `last_mod_date`, `last_mod_by`, `created`, `last_mod`) 
VALUES ( '1',  'gallery-image/181029/01-2000.jpg',  '1',  '10',  NULL,  NULL,  NULL,  NULL,  '2018-10-29 16:29:55',  '2018-10-30 15:30:06'),
( '2', 'gallery-image/181029/02-2000.jpg', '1', '20', NULL, NULL, NULL, NULL, '2018-10-29 16:29:56', '2018-10-30 15:30:06'),
( '3', 'gallery-image/181029/03-2000.jpg', '1', '30', NULL, NULL, NULL, NULL, '2018-10-29 16:29:56', '2018-10-30 15:30:06'),
( '4', 'gallery-image/181029/04-2000.jpg', '1', '40', NULL, NULL, NULL, NULL, '2018-10-29 16:29:56', '2018-10-30 15:30:06'),
( '5', 'gallery-image/181029/05-2000.jpg', '1', '50', NULL, NULL, NULL, NULL, '2018-10-29 16:29:57', '2018-10-30 15:30:06');

DROP TABLE IF EXISTS `gallery_core_gallery_image_t`;
CREATE TABLE `gallery_core_gallery_image_t` ( 
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
	`title` VARCHAR(255) NULL, 
	`alt_tag` VARCHAR(255) NULL, 
	`description` TEXT NULL, 
	`tags` VARCHAR(255) NULL, 
	`gallery_image_id` INT UNSIGNED NULL, 
	`n2n_locale` VARCHAR(12) NULL
	, PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci ;
ALTER TABLE `gallery_core_gallery_image_t` ADD INDEX `gallery_core_gallery_image_t_index_1` (`gallery_image_id`);

INSERT INTO `gallery_core_gallery_image_t` (`id`, `title`, `alt_tag`, `description`, `tags`, `gallery_image_id`, `n2n_locale`) 
VALUES ( '1',  '01 2000',  NULL,  'Holeradio',  NULL,  '1',  'en'),
( '2', '02 2000', NULL, '02 2000', NULL, '2', 'en'),
( '3', '03 2000', NULL, '03 2000', NULL, '3', 'en'),
( '4', '04 2000', NULL, '04 2000', NULL, '4', 'en'),
( '5', '05 2000', NULL, '05 2000', NULL, '5', 'en'),
( '6', NULL, NULL, NULL, NULL, '1', 'de_CH'),
( '7', NULL, NULL, NULL, NULL, '2', 'de_CH'),
( '8', NULL, NULL, NULL, NULL, '3', 'de_CH'),
( '9', NULL, NULL, NULL, NULL, '4', 'de_CH'),
( '10', 'BLabla', NULL, NULL, NULL, '5', 'de_CH');

DROP TABLE IF EXISTS `gallery_core_gallery_t`;
CREATE TABLE `gallery_core_gallery_t` ( 
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
	`name` VARCHAR(255) NULL, 
	`path_part` VARCHAR(255) NULL, 
	`file_title_image` VARCHAR(255) NULL, 
	`description` TEXT NULL, 
	`gallery_id` INT UNSIGNED NULL, 
	`n2n_locale` VARCHAR(12) NULL
	, PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci ;
ALTER TABLE `gallery_core_gallery_t` ADD INDEX `gallery_core_gallery_t_index_1` (`gallery_id`);

INSERT INTO `gallery_core_gallery_t` (`id`, `name`, `path_part`, `file_title_image`, `description`, `gallery_id`, `n2n_locale`) 
VALUES ( '1',  'holerdio',  'holerdio',  NULL,  'asdf',  '1',  'de_CH');

DROP TABLE IF EXISTS `rocket_content_item`;
CREATE TABLE `rocket_content_item` ( 
	`id` INT NOT NULL AUTO_INCREMENT, 
	`panel` VARCHAR(32) NULL, 
	`order_index` INT NULL
	, PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;


DROP TABLE IF EXISTS `rocket_critmod_save`;
CREATE TABLE `rocket_critmod_save` ( 
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
	`ei_type_path` VARCHAR(255) NOT NULL, 
	`name` VARCHAR(255) NOT NULL, 
	`filter_data_json` TEXT NOT NULL, 
	`sort_data_json` TEXT NULL
	, PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci ;
ALTER TABLE `rocket_critmod_save` ADD UNIQUE INDEX `name` (`name`);
ALTER TABLE `rocket_critmod_save` ADD INDEX `ei_spec_id` (`ei_type_path`);


DROP TABLE IF EXISTS `rocket_custom_grant`;
CREATE TABLE `rocket_custom_grant` ( 
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
	`custom_spec_id` VARCHAR(255) NOT NULL, 
	`rocket_user_group_id` INT UNSIGNED NOT NULL, 
	`full` TINYINT UNSIGNED NOT NULL DEFAULT '1', 
	`access_json` TEXT NOT NULL
	, PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci ;
ALTER TABLE `rocket_custom_grant` ADD UNIQUE INDEX `script_id_user_group_id` (`custom_spec_id`, `rocket_user_group_id`);


DROP TABLE IF EXISTS `rocket_ei_grant`;
CREATE TABLE `rocket_ei_grant` ( 
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
	`ei_type_path` VARCHAR(255) NOT NULL, 
	`rocket_user_group_id` INT UNSIGNED NOT NULL, 
	`full` TINYINT UNSIGNED NOT NULL DEFAULT '1', 
	`access_json` TEXT NOT NULL
	, PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci ;
ALTER TABLE `rocket_ei_grant` ADD UNIQUE INDEX `script_id_user_group_id` (`rocket_user_group_id`, `ei_type_path`);


DROP TABLE IF EXISTS `rocket_ei_grant_privileges`;
CREATE TABLE `rocket_ei_grant_privileges` ( 
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
	`ei_grant_id` INT UNSIGNED NOT NULL, 
	`ei_privilege_json` TEXT NOT NULL, 
	`restricted` TINYINT NOT NULL DEFAULT '0', 
	`restriction_group_json` TEXT NULL
	, PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci ;


DROP TABLE IF EXISTS `rocket_login`;
CREATE TABLE `rocket_login` ( 
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
	`nick` VARCHAR(255) NULL, 
	`wrong_password` VARCHAR(255) NULL, 
	`power` ENUM('superadmin','admin','none') NULL, 
	`successfull` TINYINT UNSIGNED NOT NULL, 
	`ip` VARCHAR(255) NOT NULL DEFAULT '', 
	`date_time` DATETIME NOT NULL
	, PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci ;


DROP TABLE IF EXISTS `rocket_user`;
CREATE TABLE `rocket_user` ( 
	`id` INT NOT NULL AUTO_INCREMENT, 
	`nick` VARCHAR(255) NOT NULL, 
	`firstname` VARCHAR(255) NULL, 
	`lastname` VARCHAR(255) NULL, 
	`email` VARCHAR(255) NULL, 
	`power` ENUM('superadmin','admin','none') NOT NULL DEFAULT 'none', 
	`password` VARCHAR(255) NOT NULL
	, PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci ;
ALTER TABLE `rocket_user` ADD UNIQUE INDEX `nick` (`nick`);

INSERT INTO `rocket_user` (`id`, `nick`, `firstname`, `lastname`, `email`, `power`, `password`) 
VALUES ( '1',  'super',  'Testerich',  'von Testen',  'testerich@von-testen.com',  'superadmin',  '$2a$07$holeradioundholeradioe5FD29ANtu4PChE8W4mZDg.D1eKkBnwq');

DROP TABLE IF EXISTS `rocket_user_access_grant`;
CREATE TABLE `rocket_user_access_grant` ( 
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
	`script_id` VARCHAR(255) NOT NULL, 
	`restricted` TINYINT NOT NULL, 
	`privileges_json` TEXT NOT NULL, 
	`access_json` TEXT NOT NULL, 
	`restriction_json` TEXT NOT NULL, 
	`user_group_id` INT UNSIGNED NOT NULL
	, PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci ;
ALTER TABLE `rocket_user_access_grant` ADD INDEX `user_group_id` (`user_group_id`);


DROP TABLE IF EXISTS `rocket_user_group`;
CREATE TABLE `rocket_user_group` ( 
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
	`name` VARCHAR(64) NOT NULL, 
	`nav_json` TEXT NULL
	, PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci ;


DROP TABLE IF EXISTS `rocket_user_rocket_user_groups`;
CREATE TABLE `rocket_user_rocket_user_groups` ( 
	`rocket_user_id` INT UNSIGNED NOT NULL, 
	`rocket_user_group_id` INT UNSIGNED NOT NULL
	, PRIMARY KEY (`rocket_user_id`, `rocket_user_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci ;


