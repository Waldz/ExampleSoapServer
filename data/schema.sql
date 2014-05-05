CREATE TABLE IF NOT EXISTS `soap_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_time` decimal(15,3) NOT NULL,
  `duration` decimal(10,3) DEFAULT NULL,
  `endpoint` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `request` longtext COLLATE utf8_unicode_ci NOT NULL,
  `response` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `endpoint` (`endpoint`),
  KEY `create_time` (`create_time`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;