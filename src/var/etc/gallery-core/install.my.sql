CREATE TABLE IF NOT EXISTS `gallery_core_gallery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `default_gallery_image_id` int(10) unsigned DEFAULT NULL,
  `order_index` int(10) unsigned DEFAULT NULL,
  `online` tinyint(3) unsigned DEFAULT NULL,
  `last_mod_date` datetime DEFAULT NULL,
  `last_mod_by` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `gallery_group_id` int(10) unsigned DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `last_mod` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_core_gallery_index_1` (`default_gallery_image_id`),
  KEY `gallery_core_gallery_index_2` (`gallery_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `gallery_core_gallery_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `default_image` varchar(255) DEFAULT '0',
  `online` tinyint(3) unsigned DEFAULT NULL,
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `gallery_core_gallery_group_t` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `path_part` varchar(255) DEFAULT NULL,
  `intro` varchar(255) DEFAULT NULL,
  `file_title_image` varchar(255) DEFAULT NULL,
  `gallery_group_id` int(10) unsigned DEFAULT NULL,
  `n2n_locale` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_core_gallery_group_t_index_1` (`gallery_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `gallery_core_gallery_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_image` varchar(255) DEFAULT NULL,
  `gallery_id` int(10) unsigned DEFAULT NULL,
  `order_index` int(10) unsigned DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_mod_date` datetime DEFAULT NULL,
  `last_mod_by` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `last_mod` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_core_gallery_image_index_1` (`gallery_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `gallery_core_gallery_image_t` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `alt_tag` varchar(255) DEFAULT NULL,
  `description` text,
  `tags` varchar(255) DEFAULT NULL,
  `gallery_image_id` int(10) unsigned DEFAULT NULL,
  `n2n_locale` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_core_gallery_image_t_index_1` (`gallery_image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `gallery_core_gallery_t` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `path_part` varchar(255) DEFAULT NULL,
  `file_title_image` varchar(255) DEFAULT NULL,
  `description` text,
  `gallery_id` int(10) unsigned DEFAULT NULL,
  `n2n_locale` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_core_gallery_t_index_1` (`gallery_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
